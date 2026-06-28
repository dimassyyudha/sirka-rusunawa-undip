<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;

class PaymentTransactionController extends Controller
{
    public function index(Request $request)
    {
        
        $perPage = $request->integer('per_page', 10);
        $query = PaymentTransaction::with([
            'user',
            'invoice.Reservation.room.floor.building',
            'Reservation.room.floor.building',
        ]);

        if ($request->filled('status')) {
            $query->where('transaction_status', $request->status);
        }

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('order_id', 'like', "%{$search}%")
                    ->orWhere('transaction_id', 'like', "%{$search}%")
                    ->orWhereHas('invoice', function ($invoiceQuery) use ($search) {
                        $invoiceQuery->where('invoice_number', 'like', "%{$search}%");
                    })
                    ->orWhereHas('Reservation', function ($reservationQuery) use ($search) {
                        $reservationQuery->where('Reservation_code', 'like', "%{$search}%")
                            ->orWhere('guest_name', 'like', "%{$search}%")
                            ->orWhere('guest_nim', 'like', "%{$search}%");
                    })
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }
        if ($request->filled('payment_method')) {

            $query->where('payment_type', $request->payment_method);
        }
        if ($request->filled('building_id')) {

            $query->whereHas(
                'Reservation.room.floor.building',
                function ($q) use ($request) {

                    $q->where(
                        'id',
                        $request->building_id
                    );
                }
            );
        }
        $transactions = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
        $paymentMethods = PaymentTransaction::query()
            ->whereNotNull('payment_type')
            ->distinct()
            ->pluck('payment_type');

        $buildings = Building::orderBy('name')->get();
        return view('pages.admin.transactions.index', compact('transactions', 'paymentMethods', 'buildings'));
    }

    public function show(PaymentTransaction $paymentTransaction)
    {
        $paymentTransaction->load([
            'user',
            'invoice.Reservation.room.floor.building',
            'Reservation.room.floor.building',
        ]);

        return view('pages.admin.transactions.show', [
            'transaction' => $paymentTransaction,
        ]);
    }
}
