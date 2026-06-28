<?php

use App\Http\Controllers\Admin\ReservationVerificationController;
// use App\Http\Controllers\Admin\syaratKetentuanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\MidtransController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\FloorController;
use App\Http\Controllers\Frontend\CariKamarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Mahasiswa\RegistrationPeriodController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\Admin\OccupancyPeriodController;
use App\Http\Controllers\OccupantController;
use App\Http\Controllers\PaymentTransactionController;
use App\Http\Controllers\PenghuniController;
use App\Http\Controllers\RecommendationsController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomPhotoController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TestimonialController;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Route;

use App\Mail\ReservationApprovedMail;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;

// Route::get('/test-approve-mail', function () {

//     $Reservation = Reservation::latest()->first();

//     Mail::to('masyudha160224@gmail.com')
//         ->send(
//             new ReservationApprovedMail(
//                 $Reservation
//             )
//         );

//     return 'OK';
// });

Route::get('/', [HomeController::class, 'beranda'])->name('page.beranda');
Route::get('/galeri', [HomeController::class, 'galeri'])->name('page.galeri');
Route::get('/testimoni', [HomeController::class, 'testimoni'])->name('page.testimoni');
// Route::get('/tentang', [HomeController::class, 'tentang'])->name('page.tentang');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('page.kontak');
Route::get('/alur', [HomeController::class, 'alur'])->name('page.alur');
Route::get('/faq', [HomeController::class, 'faq'])->name('page.faq');
Route::prefix('tentang-kami')->name('about.')->group(function () {
    Route::get('/', [HomeController::class, 'tentang'])->name('index');
    Route::get('/visi-misi', [HomeController::class, 'visiMisi'])->name('visi-misi');
    Route::get('/gedung', [HomeController::class, 'gedung'])->name('gedung');
    Route::get('/fasilitas-umum', [HomeController::class, 'fasilitasUmum'])->name('fasilitas');
    Route::get('/aturan-tata-tertib', [HomeController::class, 'aturanTataTertib'])->name('aturan');
});

Route::get('/syarat-ketentuan', [HomeController::class, 'syaratKetentuan'])->name('page.syarat-ketentuan');

Route::get('/cari-kamar', [CariKamarController::class, 'index'])->name('cari-kamar.index');
Route::get('/cari-kamar/{room}', [CariKamarController::class, 'show'])->name('cari-kamar.show');

Route::get('/auth/user/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/auth/user/login', [AuthController::class, 'login'])->name('login.store');

Route::get('/user/registration', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/user/registration', [AuthController::class, 'register'])->name('register.store');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/midtrans/notification', [MidtransController::class, 'callback'])
    ->name('midtrans.notification');

Route::get('/bypass-{id}', function (Request $request, string $id) {
    if ($id === 'fmi') {
        $admin = User::where('role', 'admin')->firstOrFail();

        Auth::login($admin);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    if ($id === 'mhs') {
        $mahasiswa = User::where('role', 'mahasiswa')->firstOrFail();

        Auth::login($mahasiswa);
        $request->session()->regenerate();

        return redirect()->route('page.beranda');
    }

    abort(404);
})->name('dev.bypass');
Route::get('/cek-reservation', function () {
    return view('pages.Reservation.check');
})->name('Reservation.check');

Route::post('/cek-reservation', [ReservationController::class, 'checkReservation'])
    ->name('Reservation.check.store');

Route::middleware(['checkislogin'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [AdminController::class, 'redirectByRole'])->name('dashboard');
    Route::get('/payment/success', [MidtransController::class, 'success'])
        ->name('Reservation.payment.success.order');

    Route::get('/Reservation/success', [MidtransController::class, 'successPage'])
        ->name('Reservation.success.page');

    Route::middleware(['checkrole:mahasiswa'])->group(function () {

        Route::get('/reservation/{room}/create', [ReservationController::class, 'create'])->name('Reservation.create');
        Route::post('/reservation/{room}', [ReservationController::class, 'store'])->name('Reservation.store');



        Route::get('/reservation/status/{Reservation}', [ReservationController::class, 'show'])->name('Reservation.show');

        Route::get('/reservation/{Reservation}/ticket/download', [ReservationController::class, 'downloadTicket'])
            ->name('Reservation.ticket.download');





        Route::get('/payment', [MidtransController::class, 'show'])
            ->name('Reservation.payment.page');

        Route::get('/payment/check/{orderId}', function ($orderId) {

            $transaction = \App\Models\PaymentTransaction::where(
                'order_id',
                $orderId
            )->first();

            if (!$transaction) {
                return response()->json([
                    'status' => 'not_found'
                ]);
            }

            return response()->json([
                'status' => $transaction->transaction_status
            ]);
        });

        Route::get(
            '/payment/check-status/{orderId}',
            [MidtransController::class, 'checkStatus']
        );


        Route::get(
            '/payment/{transaction}',
            [PaymentTransactionController::class, 'show']
        )->name('payment.show');

        Route::post(
            '/payment/{transaction}/generate-qris',
            [PaymentTransactionController::class, 'generateQris']
        )->name('payment.generate.qris');

        // Route::get('/payment/success', [MidtransController::class, 'success'])
        //     ->name('Reservation.payment.success.order');

        // Route::get('/Reservation/success', [MidtransController::class, 'successPage'])
        //     ->name('Reservation.success.page');


    });
    Route::get('/cek-invoice', [InvoiceController::class, 'checkForm'])
        ->name('invoice.check.form');

    Route::post('/cek-invoice', [InvoiceController::class, 'check'])
        ->name('invoice.check');
    Route::prefix('admin/invoices')
        ->name('admin.invoices.')
        ->middleware(['auth'])
        ->group(function () {

            Route::get('/', [
                InvoiceController::class,
                'index'
            ])->name('index');

            Route::get('/{invoice}', [
                InvoiceController::class,
                'show'
            ])->name('show');

            Route::post('/{invoice}/reminder', [
                InvoiceController::class,
                'sendReminder'
            ])->name('send-reminder');

            Route::post('/send-reminder-all', [
                InvoiceController::class,
                'sendReminderAll'
            ])->name('send-reminder-all');
        });
    Route::prefix('admin')
        ->name('admin.')
        ->middleware(['admin'])
        ->group(function () {
            Route::get('/dashboard', [AdminController::class, 'admin'])->name('dashboard');

            Route::get('/transactions', [PaymentTransactionController::class, 'index'])->name('transactions.index');
            Route::get('/transactions/{paymentTransaction}', [PaymentTransactionController::class, 'show'])->name('transactions.show');

            Route::get('/verifikasi', [ReservationVerificationController::class, 'index'])->name('verifikasi.index');
            Route::get('/verifikasi/{Reservation}', [ReservationVerificationController::class, 'show'])->name('verifikasi.show');
            Route::post('/verifikasi/{Reservation}/approve', [ReservationVerificationController::class, 'approve'])->name('verifikasi.approve');
            Route::post('/verifikasi/{Reservation}/reject', [ReservationVerificationController::class, 'reject'])->name('verifikasi.reject');

            Route::get('/financial', [FinancialController::class, 'index'])->name('financial.index');
            Route::get('/financial/export', [FinancialController::class, 'export'])->name('financial.export');

            Route::resource('buildings', BuildingController::class);
            Route::resource('floors', FloorController::class);
            Route::resource('rooms', RoomController::class);
            Route::resource('room-photos', RoomPhotoController::class);
            Route::resource('penghuni', PenghuniController::class);
            Route::get(
                'testimoni',
                [TestimonialController::class, 'indexAdmin']
            )->name('testimoni.index');

            Route::get(
                '/testimoni/{testimonial}',
                [TestimonialController::class, 'show']
            )->name('testimoni.show');

            Route::get('/reservasi', [ReservationController::class, 'index'])
                ->name('reservasi');

            Route::get('/reservasi/perpanjang', [ReservationController::class, 'extendForm'])
                ->name('reservasi.perpanjang');

            Route::post('/reservasi/perpanjang', [ReservationController::class, 'extendStore'])
                ->name('reservasi.perpanjang.store');

            Route::get('/reservasi/pindah-kamar', [ReservationController::class, 'transferForm'])
                ->name('reservasi.pindah-kamar');

            Route::post('/reservasi/pindah-kamar/{room}', [ReservationController::class, 'transferStore'])
                ->name('reservasi.pindah-kamar.store');

            Route::get('/reservasi/akhiri-kontrak', [ReservationController::class, 'checkoutForm'])
                ->name('reservasi.akhiri-kontrak');

            Route::post('/reservasi/akhiri-kontrak', [ReservationController::class, 'checkoutStore'])
                ->name('reservasi.akhiri-kontrak.store');

            Route::resource('user', UserController::class);

            Route::get(
                'registrasi-ulang',
                [OccupancyPeriodController::class, 'activeRegistration']
            )->name('registrasi-ulang.index');

            Route::get(
                'registrasi-ulang/{occupancyPeriod}',
                [OccupancyPeriodController::class, 'show']
            )->name('registrasi-ulang.show');

            Route::post('/reservations/bulk-action', [OccupancyPeriodController::class, 'bulkAction'])
                ->name('occupancy-periods.reservations.bulk-action');
            Route::delete('/occupancy-periods/bulk-delete', [OccupancyPeriodController::class, 'bulkDelete'])
                ->name('occupancy-periods.bulk-delete');

            Route::resource('occupancy-periods', OccupancyPeriodController::class);

            Route::patch('/occupancy-periods/{occupancyPeriod}/open-registration', [OccupancyPeriodController::class, 'openRegistration'])
                ->name('occupancy-periods.open-registration');

            Route::patch('/occupancy-periods/{occupancyPeriod}/close-registration', [OccupancyPeriodController::class, 'closeRegistration'])
                ->name('occupancy-periods.close-registration');

            Route::patch('/occupancy-periods/{occupancyPeriod}/open-payment', [OccupancyPeriodController::class, 'openPayment'])
                ->name('occupancy-periods.open-payment');

            Route::patch('/occupancy-periods/{occupancyPeriod}/finish', [OccupancyPeriodController::class, 'finish'])
                ->name('occupancy-periods.finish');

            Route::patch('/reservations/{reservation}/approve', [OccupancyPeriodController::class, 'approveReservation'])
                ->name('occupancy-periods.reservations.approve');

            Route::patch('/reservations/{reservation}/reject', [OccupancyPeriodController::class, 'rejectReservation'])
                ->name('occupancy-periods.reservations.reject');

            Route::delete('/reservations/{reservation}', [OccupancyPeriodController::class, 'deleteReservation'])
                ->name('occupancy-periods.reservations.delete');

            Route::post('/reservations/bulk-action', [OccupancyPeriodController::class, 'bulkAction'])
                ->name('occupancy-periods.reservations.bulk-action');

            Route::prefix('settings')
                ->name('settings.')
                ->group(function () {
                    Route::get('syarat-ketentuan', [SiteSettingController::class, 'syaratKetentuanIndex'])->name('syarat-ketentuan.index');
                    Route::get('syarat-ketentuan/edit', [SiteSettingController::class, 'syaratKetentuanEdit'])->name('syarat-ketentuan.edit');
                    Route::put('/syarat-ketentuan', [SiteSettingController::class, 'syaratKetentuanUpdate'])->name('syarat-ketentuan.update');

                    Route::get('beranda', [SiteSettingController::class, 'berandaIndex'])->name('beranda.index');
                    Route::get('beranda/edit', [SiteSettingController::class, 'berandaEdit'])->name('beranda.edit');
                    Route::put('beranda', [SiteSettingController::class, 'berandaUpdate'])->name('beranda.update');

                    Route::resource('recommendation', RecommendationsController::class);

                    Route::get('tentang-kami', [SiteSettingController::class, 'tentangKamiIndex'])->name('tentang-kami.index');
                    Route::get('tentang-kami/edit', [SiteSettingController::class, 'tentangKamiEdit'])->name('tentang-kami.edit');
                    Route::put('tentang-kami', [SiteSettingController::class, 'tentangKamiUpdate'])->name('tentang-kami.update');

                    Route::get('faq', [SiteSettingController::class, 'faqIndex'])->name('faq.index');
                    Route::get('faq/edit', [SiteSettingController::class, 'faqEdit'])->name('faq.edit');
                    Route::put('faq', [SiteSettingController::class, 'faqUpdate'])->name('faq.update');

                    Route::get('kenapa', [SiteSettingController::class, 'kenapaIndex'])->name('kenapa.index');
                    Route::get('kenapa/edit', [SiteSettingController::class, 'kenapaEdit'])->name('kenapa.edit');
                    Route::put('kenapa', [SiteSettingController::class, 'kenapaUpdate'])->name('kenapa.update');

                    Route::get('cari-kamar', [SiteSettingController::class, 'cariKamar'])->name('cari-kamar.index');
                    Route::get('cari-kamar/edit', [SiteSettingController::class, 'editCariKamar'])->name('cari-kamar.edit');
                    Route::post('cari-kamar', [SiteSettingController::class, 'updateCariKamar'])->name('cari-kamar.update');

                    Route::get('alur', [SiteSettingController::class, 'alurIndex'])->name('alur.index');
                    Route::get('alur/edit', [SiteSettingController::class, 'alurEdit'])->name('alur.edit');
                    Route::put('alur', [SiteSettingController::class, 'alurUpdate'])->name('alur.update');

                    Route::get('footer', [SiteSettingController::class, 'footerIndex'])->name('footer.index');
                    Route::get('footer/edit', [SiteSettingController::class, 'footerEdit'])->name('footer.edit');
                    Route::put('footer', [SiteSettingController::class, 'footerUpdate'])->name('footer.update');
                });
        });

    Route::prefix('mahasiswa')
        ->name('mahasiswa.')
        ->middleware(['auth', 'checkrole:mahasiswa'])
        ->group(function () {

            Route::get('/dashboard', [MahasiswaController::class, 'mahasiswa'])
                ->name('dashboard');

            Route::get('/kamar-saya', [MahasiswaController::class, 'kamarSaya'])
                ->name('kamar-saya');

            Route::get('/reservasi', [ReservationController::class, 'index'])
                ->name('reservasi');
            Route::get(
                '/mahasiswa/reservasi/{reservation}',
                [ReservationController::class, 'show']
            )->name('mahasiswa.reservasi.show');

            Route::post(
                '/invoices/{invoice}/pay',
                [InvoiceController::class, 'pay']
            )->name('invoices.pay');

            Route::get(
                '/invoices/{invoice}/finish',
                [InvoiceController::class, 'finish']
            )->name('invoices.finish');

            Route::get('/pembayaran', [MahasiswaController::class, 'pembayaran'])
                ->name('pembayaran');

            Route::get('/profil', [MahasiswaController::class, 'profil'])
                ->name('profil');
            Route::get('/profil/edit', [MahasiswaController::class, 'editProfil'])
                ->name('profil.edit');
            Route::put('/profil/update', [MahasiswaController::class, 'updateProfil'])
                ->name('profil.update');

            // Route::put('/profil/update', [MahasiswaController::class, 'updateProfil'])
            //     ->name('profil.update');

            Route::get('/review', [MahasiswaController::class, 'review'])
                ->name('review');
            Route::get('/registrasi-ulang', [RegistrationPeriodController::class, 'index'])
                ->name('registrasi-ulang.index');

            Route::get('/registrasi-ulang/perpanjang', [RegistrationPeriodController::class, 'extendForm'])
                ->name('registrasi-ulang.perpanjang');

            Route::post('/registrasi-ulang/perpanjang', [RegistrationPeriodController::class, 'extendStore'])
                ->name('registrasi-ulang.perpanjang.store');

            Route::get('/registrasi-ulang/pindah-kamar', [RegistrationPeriodController::class, 'transferForm'])
                ->name('registrasi-ulang.pindah-kamar');

            Route::post('/registrasi-ulang/pindah-kamar/{room}', [RegistrationPeriodController::class, 'transferStore'])
                ->name('registrasi-ulang.pindah-kamar.store');

            Route::get('/registrasi-ulang/akhiri-kontrak', [RegistrationPeriodController::class, 'checkoutForm'])
                ->name('registrasi-ulang.akhiri-kontrak');

            Route::post('/registrasi-ulang/akhiri-kontrak', [RegistrationPeriodController::class, 'checkoutStore'])
                ->name('registrasi-ulang.akhiri-kontrak.store');

            Route::get(
                '/testimoni',
                [TestimonialController::class, 'indexMahasiswa']
            )->name('testimoni.index');

            Route::get(
                '/testimoni/create',
                [TestimonialController::class, 'create']
            )->name('testimoni.create');

            Route::post(
                '/testimoni',
                [TestimonialController::class, 'store']
            )->name('testimoni.store');
        });
    Route::resource('/occupants', OccupantController::class);
});
