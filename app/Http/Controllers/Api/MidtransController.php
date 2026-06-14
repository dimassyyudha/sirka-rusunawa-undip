<?php

// namespace App\Http\Controllers\Api;

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendPaymentMailJob;
use App\Jobs\SendPaymentWhatsappJob;
use App\Mail\PaymentSuccessMail;
use App\Models\PaymentTransaction;
use App\Services\WhatsappService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use Twilio\Rest\Client;

class MidtransController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PAYMENT PAGE
    |--------------------------------------------------------------------------
    */

    public function show(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
            'order_hash' => 'required|string',
        ]);

        $transaction = PaymentTransaction::with([
            'invoice',
            'Reservation.room.floor.building',
            'Reservation.user',
        ])
            ->where('order_id', $request->order_id)
            ->where('order_hash', $request->order_hash)
            ->firstOrFail();

        $Reservation = $transaction->Reservation;
        $invoice = $transaction->invoice;

        if (!$Reservation || $Reservation->user_id !== auth()->id()) {
            abort(403);
        }

        if (
            $Reservation->status === 'pending' &&
            $transaction->expired_at &&
            now()->greaterThan($transaction->expired_at)
        ) {

            DB::transaction(function () use ($Reservation, $invoice, $transaction) {

                $Reservation->update([
                    'status' => 'expired',
                ]);

                $invoice?->update([
                    'status' => 'expired',
                ]);

                $transaction->update([
                    'transaction_status' => 'expire',
                ]);
            });

            $Reservation->refresh();
            $invoice?->refresh();
            $transaction->refresh();
        }

        if ($Reservation->status === 'expired') {

            return view('pages.Reservation.success', [
                'Reservation' => $Reservation,
                'invoice' => $invoice,
                'transaction' => $transaction,
            ]);
        }

        if (in_array($Reservation->status, [
            'paid',
            'active',
            'completed',
            'cancelled',
        ])) {

            return redirect()
                ->route('mahasiswa.reservasi')
                ->with('error', 'Pembayaran sudah tidak tersedia.');
        }

        $this->setMidtransConfig();

        if (!$transaction->snap_token) {

            $snapToken = Snap::getSnapToken([
                'transaction_details' => [
                    'order_id' => $transaction->order_id,
                    'gross_amount' => (int) $transaction->gross_amount,
                ],

                'customer_details' => [
                    'first_name' => $Reservation->guest_name,
                    'email' => $Reservation->contact_email,
                    'phone' => $Reservation->contact_phone,
                ],

                'item_details' => [
                    [
                        'id' => $Reservation->Reservation_code,
                        'price' => (int) $transaction->gross_amount,
                        'quantity' => 1,
                        'name' => 'Reservation Kamar ' . ($Reservation->room?->kode_kamar ?? '-'),
                    ],
                ],

                'expiry' => [
                    'unit' => 'minute',
                    'duration' => 15,
                ],
            ]);

            $transaction->update([
                'snap_token' => $snapToken,
            ]);
        } else {
            $snapToken = $transaction->snap_token;
        }

        return view('pages.Reservation.payment', [
            'Reservation' => $Reservation,
            'invoice' => $invoice,
            'transaction' => $transaction,
            'snapToken' => $snapToken,
            'midtransClientKey' => config('midtrans.client_key'),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SUCCESS REDIRECT
    |--------------------------------------------------------------------------
    */

    public function success(Request $request)
    {
        $orderId = $request->query('order_id');

        if (!$orderId) {
            abort(404);
        }

        $transaction = PaymentTransaction::with([
            'Reservation',
            'invoice',
        ])
            ->where('order_id', $orderId)
            ->firstOrFail();

        if (!$transaction->Reservation || $transaction->Reservation->user_id !== auth()->id()) {
            abort(403);
        }

        $this->setMidtransConfig();

        try {

            $status = Transaction::status($transaction->order_id);

            $transactionStatus = $status->transaction_status ?? null;
            $paymentType = $status->payment_type ?? null;

            if (in_array($transactionStatus, ['settlement', 'capture'])) {

                $this->markAsPaid(
                    $transaction,
                    $paymentType,
                    (array) $status
                );
            } elseif ($transactionStatus === 'pending') {

                $this->markAsPending(
                    $transaction,
                    $paymentType,
                    (array) $status
                );
            } elseif (in_array($transactionStatus, [
                'deny',
                'cancel',
                'expire',
                'failure'
            ])) {

                $this->markAsFailed(
                    $transaction,
                    $transactionStatus,
                    $paymentType,
                    (array) $status
                );
            }
        } catch (\Throwable $e) {

            $this->markAsPaid($transaction);
        }

        return redirect()->route('Reservation.success.page', [
            'order_id' => $transaction->order_id,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SUCCESS PAGE
    |--------------------------------------------------------------------------
    */

    public function successPage(Request $request)
    {
        $orderId = $request->query('order_id');

        if (!$orderId) {
            abort(404);
        }

        $transaction = PaymentTransaction::with([
            'invoice',
            'Reservation.room.floor.building',
            'Reservation.user',
        ])
            ->where('order_id', $orderId)
            ->firstOrFail();

        $Reservation = $transaction->Reservation;
        $invoice = $transaction->invoice;

        if (!$Reservation || $Reservation->user_id !== auth()->id()) {
            abort(403);
        }

        return view('pages.Reservation.success', [
            'transaction' => $transaction,
            'Reservation' => $Reservation,
            'invoice' => $invoice,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | MIDTRANS CALLBACK
    |--------------------------------------------------------------------------
    */

    public function callback(Request $request)
    {
        // \Log::info('MIDTRANS CALLBACK MASUK');
        // \Log::info($request->all());

        // return response()->json([
        //     'message' => 'OK'
        // ]);
        $serverKey = config('midtrans.server_key');

        $hashedKey = hash(
            'sha512',
            $request->order_id .
                $request->status_code .
                $request->gross_amount .
                $serverKey
        );

        if ($hashedKey !== $request->signature_key) {
            return response()->json([
                'message' => 'Invalid signature key',
            ], 403);
        }

        $transaction = PaymentTransaction::with([
            'Reservation',
            'invoice',
        ])
            ->where('order_id', $request->order_id)
            ->first();

        if (!$transaction) {
            return response()->json([
                'message' => 'Transaction not found',
            ], 404);
        }

        $transactionStatus = $request->transaction_status;
        $paymentType = $request->payment_type;

        DB::transaction(function () use (
            $transaction,
            $transactionStatus,
            $paymentType,
            $request
        ) {

            if (in_array($transactionStatus, ['capture', 'settlement'])) {

                $this->markAsPaid(
                    $transaction,
                    $paymentType,
                    $request->all()
                );
            } elseif ($transactionStatus === 'pending') {

                $this->markAsPending(
                    $transaction,
                    $paymentType,
                    $request->all()
                );
            } elseif ($transactionStatus === 'expire') {

                $this->markAsExpired(
                    $transaction,
                    $paymentType,
                    $request->all()
                );
            } elseif (in_array($transactionStatus, [
                'deny',
                'cancel',
                'failure'
            ])) {

                $this->markAsFailed(
                    $transaction,
                    $transactionStatus,
                    $paymentType,
                    $request->all()
                );
            }
        });

        return response()->json([
            'message' => 'OK',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS HANDLER
    |--------------------------------------------------------------------------
    */

    private function markAsPaid(
        PaymentTransaction $transaction,
        ?string $paymentType = null,
        array $rawResponse = []
    ): void {

        DB::transaction(function () use (
            $transaction,
            $paymentType,
            $rawResponse
        ) {
            $transaction = PaymentTransaction::where(
                'id',
                $transaction->id
            )
                ->lockForUpdate()
                ->first();

            if ($transaction->transaction_status === 'settlement') {
                return;
            }

            $transaction->Reservation?->update([
                'status' => 'paid',
            ]);

            $transaction->invoice?->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            $transaction->update([
                'payment_type' => $paymentType,
                'transaction_status' => 'settlement',
                'paid_at' => now(),
                'raw_response' => $rawResponse,
            ]);
        });

        try {

            $email = $transaction->Reservation?->contact_email;

            if ($email) {

                Mail::to($email)
                    ->send(
                        new PaymentSuccessMail($transaction)
                    );
            }
        } catch (\Throwable $e) {

            \Log::error('Gagal kirim email pembayaran', [
                'order_id' => $transaction->order_id,
                'error' => $e->getMessage(),
            ]);
        }

        // $message =
        //     "✅ *PEMBAYARAN RUSUNAWA UNIVERSITAS DIPONEGORO BERHASIL DITERIMA*\n\n" .

        //     "Kepada Yth. *{$transaction->Reservation->guest_name}*,\n\n" .

        //     "Kami informasikan bahwa pembayaran Rusunawa Universitas Diponegoro telah berhasil diterima dan tercatat pada sistem.\n\n" .

        //     "━━━━━━━━━━━━━━━━━━\n" .
        //     "*DETAIL PEMBAYARAN*\n" .
        //     "━━━━━━━━━━━━━━━━━━\n\n" .

        //     "* Nomor Invoice : " . ($transaction->invoice?->invoice_number ?? '-') . "\n" .
        //     "* Kode Reservasi : {$transaction->Reservation->reservation_code}\n" .
        //     "* Nama Mahasiswa : {$transaction->Reservation->guest_name}\n" .
        //     "* NIM : {$transaction->Reservation->guest_nim}\n" .
        //     "* Fakultas : {$transaction->Reservation->guest_faculty}\n" .
        //     "* Program Studi : {$transaction->Reservation->guest_major}\n" .
        //     "* Gedung : " . ($transaction->Reservation->room?->floor?->building?->name ?? '-') . "\n" .
        //     "* Nomor Kamar : " . ($transaction->Reservation->room?->kode_kamar ?? '-') . "\n" .
        //     "* Metode Pembayaran : " . strtoupper($paymentType ?? '-') . "\n" .
        //     "* Tanggal Pembayaran : " . now()->timezone('Asia/Jakarta')->format('d-m-Y H:i:s') . " WIB\n" .
        //     "* Total Pembayaran : Rp " . number_format($transaction->gross_amount, 0, ',', '.') . "\n" .
        //     "* Status Pembayaran : LUNAS\n\n" .

        //     "Pembayaran Anda telah berhasil diterima dan saat ini sedang menunggu proses verifikasi administrasi oleh pengelola Rusunawa Universitas Diponegoro.\n\n" .

        //     "━━━━━━━━━━━━━━━━━━\n" .
        //     "*INFORMASI PENTING*\n" .
        //     "━━━━━━━━━━━━━━━━━━\n\n" .

        //     "1. Simpan pesan ini sebagai bukti pembayaran resmi.\n" .
        //     "2. Nomor Invoice dan Kode Reservasi digunakan untuk proses administrasi.\n" .
        //     "3. Status reservasi akan diperbarui setelah proses verifikasi admin selesai.\n" .
        //     "4. Informasi lebih lanjut dapat dilihat melalui sistem SIRKA Rusunawa.\n\n" .

        //     "Hormat kami,\n\n" .

        //     "*Unit Usaha Rusunawa Universitas Diponegoro*\n" .
        //     "*SIRKA - Sistem Informasi Rusunawa UNDIP*\n\n" .

        //     "*Pesan ini dikirim secara otomatis oleh sistem. Mohon tidak membalas pesan ini.*";

        SendPaymentMailJob::dispatch(
            $transaction->id
        );

        SendPaymentWhatsappJob::dispatch(
            $transaction->id
        );
    }

    private function markAsPending(
        PaymentTransaction $transaction,
        ?string $paymentType = null,
        array $rawResponse = []
    ): void {

        $transaction->invoice?->update([
            'status' => 'pending',
        ]);

        $transaction->update([
            'payment_type' => $paymentType,
            'transaction_status' => 'pending',
            'raw_response' => $rawResponse,
        ]);
    }

    private function markAsFailed(
        PaymentTransaction $transaction,
        string $status,
        ?string $paymentType = null,
        array $rawResponse = []
    ): void {

        $ReservationStatus = $status === 'expire'
            ? 'expired'
            : 'cancelled';

        $invoiceStatus = $status === 'expire'
            ? 'expired'
            : 'failed';

        $transaction->Reservation?->update([
            'status' => $ReservationStatus,
        ]);

        $transaction->invoice?->update([
            'status' => $invoiceStatus,
        ]);

        $transaction->update([
            'payment_type' => $paymentType,
            'transaction_status' => $status,
            'raw_response' => $rawResponse,
        ]);
    }

    private function markAsExpired(
        PaymentTransaction $transaction,
        ?string $paymentType = null,
        array $rawResponse = []
    ): void {

        $transaction->Reservation?->update([
            'status' => 'expired',
        ]);

        $transaction->invoice?->update([
            'status' => 'expired',
        ]);

        $transaction->update([
            'payment_type' => $paymentType,
            'transaction_status' => 'expire',
            'raw_response' => $rawResponse,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | MIDTRANS CONFIG
    |--------------------------------------------------------------------------
    */

    private function setMidtransConfig(): void
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = (bool) config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }
}
