<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body>

    <h2>Pengingat Pembayaran Rusunawa UNDIP</h2>

    <p>
        Halo {{ $invoice->user->name }},
    </p>

    <p>
        Anda masih memiliki tagihan Rusunawa yang belum dibayarkan.
    </p>

    <table cellpadding="8">

        <tr>
            <td>Nomor Invoice</td>
            <td>:</td>
            <td>{{ $invoice->invoice_number }}</td>
        </tr>

        <tr>
            <td>Kamar</td>
            <td>:</td>
            <td>{{ $invoice->room?->kode_kamar }}</td>
        </tr>

        <tr>
            <td>Total Tagihan</td>
            <td>:</td>
            <td>
                Rp {{ number_format($invoice->amount,0,',','.') }}
            </td>
        </tr>

        <tr>
            <td>Jatuh Tempo</td>
            <td>:</td>
            <td>
                {{ optional($invoice->due_at)->format('d M Y') }}
            </td>
        </tr>

    </table>

    <p>
        Silakan melakukan pembayaran melalui Sistem Informasi Rusunawa UNDIP.
    </p>

    <br>

    <p>
        Pengelola Rusunawa UNDIP
    </p>

</body>
</html>