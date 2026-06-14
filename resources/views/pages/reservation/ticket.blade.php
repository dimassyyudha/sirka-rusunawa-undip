<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>E-Ticket Reservation</title>

    <style>
        body {
            font-family: sans-serif;
            color: #0f172a;
            padding: 30px;
        }

        .ticket {
            border: 2px dashed #cbd5e1;
            border-radius: 24px;
            padding: 30px;
        }

        .title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .subtitle {
            color: #64748b;
            margin-bottom: 30px;
        }

        .section {
            margin-bottom: 18px;
        }

        .label {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 4px;
        }

        .value {
            font-size: 16px;
            font-weight: bold;
        }

        .ticket-code {
            margin-top: 30px;
            padding: 20px;
            text-align: center;
            background: #ecfdf5;
            border-radius: 18px;
        }

        .ticket-number {
            font-size: 34px;
            letter-spacing: 6px;
            font-weight: bold;
            color: #047857;
        }

        .footer {
            margin-top: 35px;
            font-size: 12px;
            color: #64748b;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="ticket">

        <div class="title">
            E-Ticket Reservation Rusunawa
        </div>

        <div class="subtitle">
            Bukti Reservation kamar Rusunawa Universitas Diponegoro
        </div>

        <div class="section">
            <div class="label">Nama Mahasiswa</div>
            <div class="value">{{ $Reservation->guest_name }}</div>
        </div>

        <div class="section">
            <div class="label">NIM</div>
            <div class="value">{{ $Reservation->guest_nim }}</div>
        </div>

        <div class="section">
            <div class="label">Gedung & Kamar</div>
            <div class="value">
                {{ $Reservation->room?->floor?->building?->name }}
                -
                {{ $Reservation->room?->kode_kamar }}
            </div>
        </div>

        <div class="section">
            <div class="label">Durasi Sewa</div>
            <div class="value">
                {{ $Reservation->duration_month }} Bulan
            </div>
        </div>

        <div class="section">
            <div class="label">Total Pembayaran</div>
            <div class="value">
                Rp {{ number_format($Reservation->total_price, 0, ',', '.') }}
            </div>
        </div>

        <div class="section">
            <div class="label">Status</div>
            <div class="value">
                Menunggu Verifikasi Admin
            </div>
        </div>

        <div class="ticket-code">
            <div style="font-size:13px; margin-bottom:10px;">
                KODE E-TICKET
            </div>

            <div class="ticket-number">
                {{ $Reservation->ticket_code ?? $Reservation->Reservation_code }}
            </div>
        </div>

        <div class="footer">
            Tunjukkan e-ticket ini saat proses verifikasi administrasi Rusunawa.
        </div>

    </div>

</body>

</html>
