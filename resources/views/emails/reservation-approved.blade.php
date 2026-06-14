<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Reservasi Rusunawa UNDIP Disetujui</title>
</head>

<body style="margin:0;padding:0;background:#f8fafc;font-family:Arial,Helvetica,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;padding:30px 0;">
        <tr>
            <td align="center">

                <table width="700" cellpadding="0" cellspacing="0"
                    style="background:#ffffff;border-radius:12px;overflow:hidden;">

                    <tr>
                        <td style="background:#1e293b;padding:24px;text-align:center;">
                            <h1 style="color:#ffffff;margin:0;font-size:24px;">
                                SIRKA - Rusunawa UNDIP
                            </h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:32px;">

                            <h2 style="margin-top:0;color:#0f172a;">
                                🎉 Reservasi Rusunawa Berhasil Diverifikasi
                            </h2>

                            <p>
                                Kepada Yth.
                                <strong>{{ $Reservation->guest_name }}</strong>,
                            </p>

                            <p>
                                Selamat! Kami informasikan bahwa reservasi Rusunawa
                                Universitas Diponegoro telah berhasil diverifikasi dan
                                disetujui oleh Admin Rusunawa.
                            </p>

                            <hr style="margin:24px 0;">

                            <h3>Detail Reservasi</h3>

                            <table width="100%" cellpadding="6">
                                <tr>
                                    <td width="220"><strong>Kode Reservasi</strong></td>
                                    <td>{{ $Reservation->reservation_code }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Nama Mahasiswa</strong></td>
                                    <td>{{ $Reservation->guest_name }}</td>
                                </tr>

                                <tr>
                                    <td><strong>NIM</strong></td>
                                    <td>{{ $Reservation->guest_nim }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Fakultas</strong></td>
                                    <td>{{ $Reservation->guest_faculty }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Program Studi</strong></td>
                                    <td>{{ $Reservation->guest_major }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Angkatan</strong></td>
                                    <td>{{ $Reservation->guest_intake_year }}</td>
                                </tr>
                            </table>

                            <hr style="margin:24px 0;">

                            <h3>Detail Hunian</h3>

                            <table width="100%" cellpadding="6">
                                <tr>
                                    <td width="220"><strong>Gedung</strong></td>
                                    <td>{{ $Reservation->room?->floor?->building?->name ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Lantai</strong></td>
                                    <td>{{ $Reservation->room?->floor?->floor_number ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Nomor Kamar</strong></td>
                                    <td>{{ $Reservation->room?->kode_kamar ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Tipe Hunian</strong></td>
                                    <td>{{ ucfirst($Reservation->occupancy_type) }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Durasi Sewa</strong></td>
                                    <td>{{ $Reservation->duration_month }} Bulan</td>
                                </tr>

                                <tr>
                                    <td><strong>Tanggal Mulai Huni</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($Reservation->start_date)->format('d-m-Y') }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Tanggal Berakhir</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($Reservation->end_date)->format('d-m-Y') }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Status Hunian</strong></td>
                                    <td>
                                        <strong style="color:green;">
                                            AKTIF
                                        </strong>
                                    </td>
                                </tr>
                            </table>

                            <hr style="margin:24px 0;">

                            <h3>Informasi Penting</h3>

                            <ol>
                                <li>Simpan email ini sebagai bukti resmi verifikasi reservasi.</li>
                                <li>Pastikan seluruh data yang tercantum sudah sesuai.</li>
                                <li>Patuhi seluruh Tata Tertib Rusunawa Universitas Diponegoro.</li>
                                <li>Hubungi Admin Rusunawa apabila terdapat kesalahan data.</li>
                            </ol>

                            <br>

                            <p>
                                Terima kasih atas kepercayaan Anda menggunakan layanan
                                Rusunawa Universitas Diponegoro.
                            </p>

                            <p>
                                Hormat kami,
                            </p>

                            <p>
                                <strong>UPT Rusunawa Universitas Diponegoro</strong><br>
                                SIRKA - Sistem Informasi Rusunawa UNDIP
                            </p>

                        </td>
                    </tr>

                    <tr>
                        <td style="background:#f1f5f9;padding:20px;text-align:center;font-size:12px;color:#64748b;">

                            Pesan ini dikirim secara otomatis oleh sistem.<br>
                            Mohon tidak membalas email ini.

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
