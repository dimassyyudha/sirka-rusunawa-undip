<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use Illuminate\Http\Request;

class PaymentTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = PaymentTransaction::with([
            'user',
            'invoice.Reservation.room.floor.building',
            'Reservation.room.floor.building',
        ])->latest();

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
                    ->orWhereHas('Reservation', function ($ReservationQuery) use ($search) {
                        $ReservationQuery->where('Reservation_code', 'like', "%{$search}%")
                            ->orWhere('guest_name', 'like', "%{$search}%")
                            ->orWhere('guest_nim', 'like', "%{$search}%");
                    })
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // $transactions = $query->paginate(10)->withQueryString();
        $transactions = PaymentTransaction::with([
            'user',
            'invoice.user',
            'invoice.room.floor.building',
            'invoice.Reservation.room.floor.building',
            'invoice.reservation.room.floor.building',
            'Reservation.room.floor.building',
        ])
            ->latest()
            ->paginate(10);

        return view('pages.admin.transactions.index', compact('transactions'));
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
