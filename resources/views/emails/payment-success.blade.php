<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Pembayaran Rusunawa UNDIP Berhasil</title>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; color:#1e293b; line-height:1.7;">

    <h2 style="color:#ea580c;">
        ✅ PEMBAYARAN RUSUNAWA UNIVERSITAS DIPONEGORO BERHASIL DITERIMA
    </h2>

    <p>
        Kepada Yth.
        <strong>{{ $transaction->Reservation?->guest_name ?? 'Mahasiswa' }}</strong>,
    </p>

    <p>
        Kami informasikan bahwa pembayaran Rusunawa Universitas Diponegoro telah berhasil diterima
        dan tercatat pada sistem.
    </p>

    <hr>

    <h3>Detail Pembayaran</h3>

    <table cellpadding="8" cellspacing="0" border="1" width="100%" style="border-collapse: collapse;">

        <tr>
            <td width="35%"><strong>Nomor Invoice</strong></td>
            <td>{{ $transaction->invoice?->invoice_number ?? '-' }}</td>
        </tr>

        {{-- <tr>
            <td><strong>Kode Reservasi</strong></td>
            <td>{{ $transaction->Reservation?->reservation_code ?? '-' }}</td>
        </tr> --}}

        <tr>
            <td><strong>Nama Mahasiswa</strong></td>
            <td>{{ $transaction->Reservation?->guest_name ?? '-' }}</td>
        </tr>

        <tr>
            <td><strong>NIM</strong></td>
            <td>{{ $transaction->Reservation?->guest_nim ?? '-' }}</td>
        </tr>

        <tr>
            <td><strong>Fakultas</strong></td>
            <td>{{ $transaction->Reservation?->guest_faculty ?? '-' }}</td>
        </tr>

        <tr>
            <td><strong>Program Studi</strong></td>
            <td>{{ $transaction->Reservation?->guest_major ?? '-' }}</td>
        </tr>

        <tr>
            <td><strong>Gedung</strong></td>
            <td>
                {{ $transaction->Reservation?->room?->floor?->building?->name ?? '-' }}
            </td>
        </tr>

        <tr>
            <td><strong>Nomor Kamar</strong></td>
            <td>
                {{ $transaction->Reservation?->room?->kode_kamar ?? '-' }}
            </td>
        </tr>

        <tr>
            <td><strong>Metode Pembayaran</strong></td>
            <td>
                {{ strtoupper($transaction->payment_type ?? '-') }}
            </td>
        </tr>

        <tr>
            <td><strong>Tanggal Pembayaran</strong></td>
            <td>
                {{ optional($transaction->paid_at)->timezone('Asia/Jakarta')->format('d-m-Y H:i:s') }}
                WIB
            </td>
        </tr>

        <tr>
            <td><strong>Total Pembayaran</strong></td>
            <td>
                Rp {{ number_format($transaction->gross_amount, 0, ',', '.') }}
            </td>
        </tr>

        <tr>
            <td><strong>Status Pembayaran</strong></td>
            <td>
                <strong style="color:green;">LUNAS</strong>
            </td>
        </tr>

    </table>

    <br>

    <p>
        Pembayaran Anda telah berhasil diterima dan saat ini sedang menunggu proses verifikasi
        administrasi oleh pengelola Rusunawa Universitas Diponegoro.
    </p>

    <hr>

    <h3>Informasi Penting</h3>

    <ol>
        <li>Simpan email ini sebagai bukti pembayaran resmi.</li>
        <li>Nomor Invoice dan Kode Reservasi digunakan untuk proses administrasi.</li>
        <li>Status reservasi akan diperbarui setelah proses verifikasi admin selesai.</li>
        <li>Informasi lebih lanjut dapat dilihat melalui Sistem Informasi Rusunawa (SIRKA).</li>
    </ol>

    <br>

    <p>
        Terima kasih atas kepercayaan Anda menggunakan layanan Rusunawa Universitas Diponegoro.
    </p>

    <p>
        Hormat kami,
    </p>

    <p>
        <strong>Unit Usaha Rusunawa Universitas Diponegoro</strong><br>
        <strong>SIRKA - Sistem Informasi Rusunawa UNDIP</strong>
    </p>

    <hr>

    <small style="color:#64748b;">
        Email ini dikirim secara otomatis oleh sistem.
        Mohon tidak membalas email ini.
    </small>

</body>

</html>
