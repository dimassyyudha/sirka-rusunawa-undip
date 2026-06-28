<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>

<h2>
    Registrasi Ulang Rusunawa Dibuka
</h2>

<p>
    Halo Mahasiswa,
</p>

<p>
    Registrasi ulang untuk
    <b>{{ $period->name }}</b>
    telah dibuka.
</p>

<p>
    Periode registrasi:
    {{ \Carbon\Carbon::parse($period->registration_start_date)->format('d M Y') }}
    -
    {{ \Carbon\Carbon::parse($period->registration_end_date)->format('d M Y') }}
</p>

<p>
    Silakan login ke Sistem Informasi Rusunawa
    untuk melakukan registrasi ulang.
</p>

<p>
    Terima kasih.
</p>

</body>
</html>