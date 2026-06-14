<?php

namespace App\Http\Controllers;

use App\Jobs\ExpirePendingReservationJob;
use App\Models\Reservation;
use App\Models\Invoice;
use App\Models\PaymentTransaction;
use App\Models\Room;
use App\Models\StudentProfile;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    private function calculateDurationMonth(): int
    {
        // $month = now()->month;
        $month = 1;

        if ($month <= 6) {
            $duration = 7 - $month;
        } else {
            $duration = 13 - $month;
        }

        if ($duration < 3) {
            throw new \Exception(
                'Periode reservasi semester ini sudah ditutup. Minimal masa hunian adalah 3 bulan.'
            );
        }

        return $duration;
    }
    public function index()
    {
        $reservations = Reservation::with([
            'room.floor.building',
            'previousRoom.floor.building',
        ])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('pages.mahasiswa.reservasi.index', compact('reservations'));
    }

    public function create(Room $room)
    {
        if (!auth()->check()) {
            return redirect()
                ->guest(route('login'))
                ->with('error', 'Silakan login terlebih dahulu untuk melakukan Reservation kamar.');
        }

        if (auth()->user()->role === 'admin') {
            abort(403, 'Admin tidak dapat melakukan Reservation.');
        }

        $user = auth()->user();
        $profile = $user->studentProfile;

        if ($profile && $profile->room_id !== null && $profile->status_mahasiswa === 'penghuni') {
            return redirect()->back()
                ->with('Reservation_alert', true)
                ->with('Reservation_alert_icon', 'warning')
                ->with('Reservation_alert_title', 'Kamu Sudah Memiliki Kamar')
                ->with('Reservation_alert_message', 'Kamu sudah memiliki kamar aktif, sehingga tidak dapat melakukan Reservation kamar baru.')
                ->with('Reservation_alert_url', route('mahasiswa.kamar-saya'))
                ->with('Reservation_alert_button', 'Lihat Kamar Saya');
        }

        $activeReservation = Reservation::query()
            ->where('user_id', auth()->id())

            ->whereNotIn('status', [
                'expired',
                'cancelled',
                'rejected',
                'completed',
            ])
            ->latest()

            ->first();

        if ($activeReservation) {
            return redirect()->back()
                ->with('Reservation_alert', true)
                ->with('Reservation_alert_icon', 'warning')
                ->with('Reservation_alert_title', 'Masih Ada Reservation Aktif')
                ->with('Reservation_alert_message', 'Kamu masih memiliki Reservation aktif atau pembayaran yang belum diselesaikan.')
                ->with('Reservation_alert_url', route('mahasiswa.reservasi'))
                ->with('Reservation_alert_button', 'Lihat Reservasi');
        }

        $room->load(['floor.building', 'photos']);

        $occupied = (int) ($room->occupied ?? 0);

        $room->load(['floor.building', 'photos']);

        $user = auth()->user();
        $userGender = strtolower(auth()->user()->gender);

        $buildingGender = strtolower(
            $room->floor?->building?->gender_type
        );

        if (!$this->genderMatches($userGender, $buildingGender)) {

            return redirect()
                ->route('cari-kamar.show', $room)
                ->with(
                    'error',
                    $buildingGender === 'putra'
                        ? 'Kamar ini hanya tersedia untuk mahasiswa laki-laki.'
                        : 'Kamar ini hanya tersedia untuk mahasiswa perempuan.'
                );
        }

        $capacity = $room->floor->room_capacity ?? 2;

        $slots = $capacity - ($room->occupied ?? 0);

        if ($slots <= 0) {

            return redirect()
                ->route('cari-kamar.show', $room)
                ->with('error', 'Kamar sudah penuh.');
        }

        $activeReservationSlot = Reservation::where('room_id', $room->id)
            ->whereIn('status', ['pending', 'paid', 'approved', 'active'])
            ->sum('slot_used');

        $usedSlot = $occupied + $activeReservationSlot;

        $monthlyPrice = (int) ($room->floor?->monthly_price ?? 0);

        $canPrivate = $usedSlot === 0;
        $canShared = $usedSlot < $capacity;

        if (!$canPrivate && !$canShared) {
            return redirect()->back()
                ->with('Reservation_alert', true)
                ->with('Reservation_alert_icon', 'error')
                ->with('Reservation_alert_title', 'Kamar Penuh')
                ->with('Reservation_alert_message', 'Kamar ini sudah penuh dan tidak dapat diReservation.')
                ->with('Reservation_alert_url', route('cari-kamar.index'))
                ->with('Reservation_alert_button', 'Reservasi Kamar Lain');
        }

        $privatePricePerMonth = $monthlyPrice;
        $sharedPricePerMonth = $capacity > 0 ? ceil($monthlyPrice / $capacity) : $monthlyPrice;

        try {

            $durationMonth = $this->calculateDurationMonth();
        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }

        $startDate = now()->startOfDay();

        $endDate = $startDate->copy()->addMonths($durationMonth);

        $totalPrice = $monthlyPrice * $durationMonth;


        $oldReservationData = session('reservation_review_data', []);
        return view('pages.Reservation.create', compact(
            'room',
            'capacity',
            'occupied',
            'usedSlot',
            'monthlyPrice',
            'canPrivate',
            'canShared',
            'privatePricePerMonth',
            'sharedPricePerMonth',
            'durationMonth',
            'oldReservationData',
            'startDate',
            'endDate',
            'totalPrice',
        ));
    }



    // public function review(Request $request, Room $room)
    // {
    //     $request->validate([
    //         'profile_photo_file' => 'required|file|mimes:jpg,jpeg,png|max:2048',
    //         'ktm_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
    //         'stnk_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    //     ]);

    //     $data = $request->except([
    //         'profile_photo_file',
    //         'ktm_file',
    //         'stnk_file',
    //     ]);

    //     $data['profile_photo_path'] = $request
    //         ->file('profile_photo_file')
    //         ->store('temp/profile', 'public');

    //     $data['ktm_path'] = $request
    //         ->file('ktm_file')
    //         ->store('temp/ktm', 'public');

    //     if ($request->hasFile('stnk_file')) {
    //         $data['stnk_path'] = $request
    //             ->file('stnk_file')
    //             ->store('temp/stnk', 'public');
    //     }

    //     session([
    //         'reservation_review_data' => $data
    //     ]);

    //     return redirect()->route(
    //         'reservation.review.page',
    //         $room->id
    //     );
    // }

    // public function reviewPage(Room $room)
    // {
    //     $data = session('reservation_review_data');

    //     if (!$data) {
    //         return redirect()
    //             ->route('Reservation.create', $room->id);
    //     }

    //     return view('pages.Reservation.review', compact('data', 'room'));
    // }

    public function store(Request $request, Room $room)
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            abort(403, 'Admin tidak dapat melakukan Reservation.');
        }

        $room->load('floor.building');

        $userGender = strtolower(auth()->user()->gender);

        $buildingGender = strtolower(
            $room->floor?->building?->gender_type
        );

        if (!$this->genderMatches($userGender, $buildingGender)) {

            return back()->with(
                'error',
                $buildingGender === 'putra'
                    ? 'Kamar ini hanya tersedia untuk mahasiswa laki-laki.'
                    : 'Kamar ini hanya tersedia untuk mahasiswa perempuan.'
            );
        }
        $request->validate([
            'guest_name' => 'required|string|max:255',
            'guest_nim' => 'required|string|max:14',
            'guest_faculty' => 'required|string|max:100',
            'guest_major' => 'required|string|max:100',
            'guest_intake_year' => 'required|digits:4',
            'contact_phone' => 'required|string|max:32',
            'contact_email' => 'required|email|max:255',
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:32',
            'duration_month' => 'required|in:6',
            'occupancy_type' => 'required|in:private,shared',
            'profile_photo_file' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'ktm_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'has_motor' => 'required|in:0,1',
            'vehicle_plate_number' => 'nullable|required_if:has_motor,1|string|max:20',
            'stnk_file' => 'required_if:has_motor,1|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'special_request' => 'nullable|string',
            'birth_place' => 'required|string|max:100',
            'birth_date' => 'required|date',
            'religion' => 'required|string|max:50',
            'home_address' => 'required|string',
            'parent_job' => 'required|string|max:100',
            'parent_address' => 'required|string',
            'jalur_pembiayaan' => ['required', 'in:Bidikmisi/KIP-K,Non-Bidikmisi/KIP-K'],
            'payment_term' => 'required|in:3,6',
            'kip_document' => 'required_if:jalur_pembiayaan,Bidikmisi/KIP-K|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        if (!$user) {
            $user = User::firstOrCreate(
                ['email' => $request->contact_email],
                [
                    'name' => $request->guest_name,
                    'password' => Hash::make('password'),
                    'role' => 'mahasiswa',
                    'number_phone' => $request->contact_phone,
                ]
            );

            Auth::login($user);
            $request->session()->regenerate();
        }

        $user->update([
            'name' => $request->guest_name,
            'email' => $request->contact_email,
            'number_phone' => $request->contact_phone,
        ]);

        if ($request->hasFile('profile_photo_file')) {
            $profilePhotoPath = $request->file('profile_photo_file')
                ->store('profile-photos', 'public');

            $user->update([
                'profile_photo' => $profilePhotoPath,
            ]);
        }

        $ktmPath = $request->file('ktm_file')->store('student/ktm', 'public');

        $stnkPath = null;
        if ($request->hasFile('stnk_file')) {
            $stnkPath = $request->file('stnk_file')->store('student/stnk', 'public');
        }
        $kipDocument = null;

        if ($request->hasFile('kip_document')) {

            $kipDocument = $request
                ->file('kip_document')
                ->store(
                    'kip-documents',
                    'public'
                );
        }
        $existingNim = StudentProfile::where('nim', $request->guest_nim)
            ->where('user_id', '!=', $user->id)
            ->exists();

        if ($existingNim) {

            return back()
                ->withInput()
                ->withErrors([
                    'guest_nim' => 'NIM sudah terdaftar pada akun lain.',
                ]);
        }
        StudentProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nim' => $request->guest_nim,
                'fakultas' => $request->guest_faculty,
                'jurusan' => $request->guest_major,
                'angkatan' => $request->guest_intake_year,
                'tempat_lahir' => $request->birth_place,
                'tanggal_lahir' => $request->birth_date,
                'agama' => $request->religion,
                'alamat' => $request->home_address,
                'no_hp' => $request->contact_phone,
                'nama_ortu' => $request->parent_name,
                'no_hp_ortu' => $request->parent_phone,
                'alamat_orang_tua' => $request->parent_address,
                'pekerjaan_orang_tua' => $request->parent_job,
                'ktm_path' => $ktmPath,
                'has_vehicle' => $request->has_motor == '1',
                'vehicle_plate_number' => $request->has_motor == '1' ? $request->vehicle_plate_number : null,
                'stnk_path' => $request->has_motor == '1' ? $stnkPath : null,
                'status_mahasiswa' => 'tidak_penghuni',
                'jalur_pembiayaan' => $request->jalur_pembiayaan,
                'jalur_pembiayaan' => $request->jalur_pembiayaan,

                'kip_document_path' => $kipDocument,
                // 'payment_term' => $request->payment_term,
            ]
        );
        if (
            $request->jalur_pembiayaan !== 'Bidikmisi/KIP-K'
            &&
            $request->payment_term == 3
        ) {
            return back()->with(
                'error',
                'Termin 3 bulan hanya tersedia untuk mahasiswa Bidikmisi/KIP-K.'
            );
        }


        try {
            $transaction = DB::transaction(function () use ($request, $room, $user, $kipDocument) {

                $lockedRoom = Room::where('id', $room->id)->lockForUpdate()->firstOrFail();
                $lockedRoom->load('floor.building');

                $capacity = (int) ($lockedRoom->floor?->room_capacity ?? 2);
                $occupied = (int) ($lockedRoom->occupied ?? 0);

                $activeReservationSlot = Reservation::where('room_id', $lockedRoom->id)
                    ->whereIn('status', ['pending', 'paid', 'approved', 'active'])
                    ->sum('slot_used');

                $usedSlot = $occupied + $activeReservationSlot;

                if ($request->occupancy_type === 'private') {

                    if ($usedSlot > 0) {
                        throw new \Exception('Kamar sudah terisi.');
                    }

                    $slotUsed = $capacity;

                    $pricePerMonth =
                        ($lockedRoom->floor->monthly_price ?? 0)
                        * $capacity;
                } else {

                    if ($usedSlot >= $capacity) {
                        throw new \Exception('Kamar penuh.');
                    }

                    $slotUsed = 1;

                    $pricePerMonth =
                        $lockedRoom->floor->monthly_price ?? 0;
                }

                $duration = $this->calculateDurationMonth();
                $startDate = now()->startOfDay();
                $endDate = $startDate->copy()->addMonths($duration);

                $totalPrice = $pricePerMonth * $duration;
                $fullSemesterPrice = $pricePerMonth * $duration;
                $totalPrice = $request->payment_term == 3 ? $fullSemesterPrice / 2 : $fullSemesterPrice;

                // dd([
                //     'monthlyPrice' => $pricePerMonth,
                //     'duration' => $duration,
                //     'fullSemesterPrice' => $fullSemesterPrice,
                //     'payment_term' => $request->payment_term,
                //     'totalPrice' => $totalPrice,
                // ]);

                // $expiredAt = now()->addHour();
                $expiredAt = now()->addMinutes(15);
                $orderId = $this->generateOrderId();


                $isKip = $request->jalur_pembiayaan === 'Bidikmisi/KIP-K';

                $isInstallment = $isKip && $request->payment_term == 3;

                $reservation = Reservation::create([
                    'reservation_code' => $this->generateReservationCode(),
                    // 'reservation_code' => null,
                    'room_id' => $lockedRoom->id,
                    'user_id' => $user->id,
                    'contact_name' => $request->guest_name,
                    'contact_phone' => $request->contact_phone,
                    'contact_email' => $request->contact_email,
                    'guest_name' => $request->guest_name,
                    'guest_nim' => $request->guest_nim,
                    'guest_faculty' => $request->guest_faculty,
                    'guest_major' => $request->guest_major,
                    'guest_intake_year' => $request->guest_intake_year,
                    'parent_name' => $request->parent_name,
                    'parent_phone' => $request->parent_phone,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'duration_month' => $duration,
                    'occupancy_type' => $request->occupancy_type,
                    'slot_used' => $slotUsed,
                    'price_per_month' => $pricePerMonth,
                    'total_price' => $fullSemesterPrice,
                    'status' => 'pending',
                    'special_request' => $request->special_request,
                    'payment_term' => $request->payment_term,

                ]);
                if (!$isInstallment) {
                    $invoiceAmount = $fullSemesterPrice;
                } else {
                    $invoiceAmount = ceil($fullSemesterPrice / 2);
                }
                $invoice = Invoice::create([
                    'user_id' => $user->id,
                    'reservation_id' => $reservation->id,
                    'room_id' => $lockedRoom->id,
                    'invoice_number' => $this->generateInvoiceNumber(),
                    'amount' => $invoiceAmount,
                    'status' => 'pending',
                    'due_at' => $expiredAt,
                    'description' => 'Pembayaran Reservation kamar ' . ($lockedRoom->kode_kamar ?? '-'),
                ]);
                if ($isInstallment) {

                    Invoice::create([

                        'user_id' => $user->id,

                        'reservation_id' => $reservation->id,

                        'room_id' => $lockedRoom->id,

                        'invoice_number' => $this->generateInvoiceNumber(),

                        'amount' => $fullSemesterPrice - $invoiceAmount,

                        'status' => 'pending',

                        'due_at' => now()->addMonths(3),

                        'description' => 'Termin Kedua Rusunawa ' . ($lockedRoom->kode_kamar ?? '-'),
                    ]);
                }

                $transaction = PaymentTransaction::create([
                    'invoice_id' => $invoice->id,
                    'user_id' => $user->id,
                    'order_id' => $orderId,
                    'payment_gateway' => 'midtrans',
                    'transaction_status' => 'pending',
                    'gross_amount' => $totalPrice,
                    'expired_at' => $expiredAt,
                    'order_hash' => hash(
                        'sha256',
                        $reservation->id . '|' . $orderId . '|' . config('app.key')
                    ),
                ]);

                ExpirePendingReservationJob::dispatch($reservation->id);

                return $transaction;
            });
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('Reservation.payment.page', [
            'order_id' => $transaction->order_id,
            'order_hash' => $transaction->order_hash,
        ])->with('success', 'Reservation berhasil dibuat. Silakan lanjutkan pembayaran.');
    }

    public function show(Reservation $Reservation)
    {
        abort(404);
    }

    public function downloadTicket(Reservation $Reservation)
    {
        if ($Reservation->user_id !== auth()->id()) {
            abort(403);
        }

        $Reservation->load([
            'room.floor.building',
            'user',
        ]);

        $pdf = Pdf::loadView(
            'pages.Reservation.ticket',
            [
                'Reservation' => $Reservation,
            ]
        );

        return $pdf->download(
            'E-Ticket-' .
                $Reservation->reservation_code .
                '.pdf'
        );
    }
    public function checkReservation(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string',
        ]);

        $keyword = trim($request->keyword);

        $reservation = Reservation::with([
            'room.floor.building',
            'user',
            'invoices',
        ])
            ->where('reservation_code', strtoupper($keyword))
            ->first();

        if (!$reservation) {

            $invoice = Invoice::with([
                'reservation.room.floor.building',
                'reservation.user',
            ])
                ->where('invoice_number', $keyword)
                ->first();

            if ($invoice) {
                $reservation = $invoice->reservation;
            }
        }

        if (!$reservation) {

            return back()
                ->withInput()
                ->withErrors([
                    'keyword' => 'Kode reservasi atau nomor invoice tidak ditemukan.',
                ]);
        }

        return view('pages.Reservation.check-result', [
            'Reservation' => $reservation,
        ]);
    }

    public function generateReservationCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (Reservation::where('reservation_code', $code)->exists());

        return $code;
    }

    private function generateInvoiceNumber(): string
    {
        do {
            $number = 'INV-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));
        } while (Invoice::where('invoice_number', $number)->exists());

        return $number;
    }

    private function generateOrderId(): string
    {
        do {
            $orderId = 'SR' . now()->format('YmdHis') . strtoupper(Str::random(5));
        } while (PaymentTransaction::where('order_id', $orderId)->exists());

        return $orderId;
    }

    private function genderMatches(string $userGender, string $buildingGender): bool
    {
        return ($userGender === 'laki-laki' && $buildingGender === 'putra')
            ||
            ($userGender === 'perempuan' && $buildingGender === 'putri');
    }
}
