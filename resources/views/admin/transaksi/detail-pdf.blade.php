<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $transaksi->no_transaksi }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 9px;
            line-height: 1.4;
            color: #000;
            padding: 20px;
        }

        .header {
            display: table;
            width: 100%;
            margin-bottom: 15px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header-left {
            display: table-cell;
            vertical-align: middle;
            width: 50%;
        }

        .header-right {
            display: table-cell;
            vertical-align: middle;
            width: 50%;
            text-align: right;
        }

        .company-name {
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .company-tagline {
            font-size: 8px;
            color: #555;
            margin-top: 2px;
        }

        .invoice-label {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .invoice-info {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .invoice-info-left,
        .invoice-info-right {
            display: table-cell;
            vertical-align: top;
            width: 50%;
        }

        .invoice-info-right {
            text-align: right;
        }

        .invoice-number {
            font-size: 11px;
            font-weight: bold;
        }

        .invoice-date {
            font-size: 9px;
            color: #333;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            border: 1px solid #000;
            margin-top: 5px;
        }

        .status-lunas {
            background: #000;
            color: #fff;
        }

        .status-belum {
            background: #fff;
            color: #000;
        }

        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .info-box {
            display: table-cell;
            width: 33.33%;
            vertical-align: top;
            padding-right: 10px;
        }

        .info-box:last-child {
            padding-right: 0;
        }

        .info-box-title {
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #555;
            border-bottom: 1px solid #ccc;
            padding-bottom: 3px;
            margin-bottom: 5px;
        }

        .info-box-content {
            font-size: 9px;
        }

        .info-box-content strong {
            display: block;
            font-size: 10px;
            margin-bottom: 2px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .items-table th {
            background: #000;
            color: #fff;
            padding: 6px 8px;
            text-align: left;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .items-table th.text-center {
            text-align: center;
        }

        .items-table th.text-right {
            text-align: right;
        }

        .items-table td {
            padding: 6px 8px;
            border-bottom: 1px solid #ddd;
            font-size: 9px;
        }

        .items-table td.text-center {
            text-align: center;
        }

        .items-table td.text-right {
            text-align: right;
        }

        .items-table tbody tr:last-child td {
            border-bottom: 2px solid #000;
        }

        .summary-section {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .summary-left {
            display: table-cell;
            width: 55%;
            vertical-align: top;
        }

        .summary-right {
            display: table-cell;
            width: 45%;
            vertical-align: top;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary-table td {
            padding: 4px 8px;
            font-size: 9px;
        }

        .summary-table td:first-child {
            text-align: right;
            color: #555;
        }

        .summary-table td:last-child {
            text-align: right;
            font-weight: 500;
        }

        .summary-table .total-row td {
            font-size: 11px;
            font-weight: bold;
            border-top: 2px solid #000;
            padding-top: 8px;
        }

        .summary-table .total-row td:last-child {
            font-size: 12px;
        }

        .summary-table .paid-row td {
            color: #555;
        }

        .summary-table .balance-row td {
            font-weight: bold;
            border-top: 1px solid #ccc;
            padding-top: 6px;
        }

        .lunas-stamp {
            display: inline-block;
            padding: 5px 15px;
            border: 2px solid #000;
            font-size: 12px;
            font-weight: bold;
            transform: rotate(-5deg);
            margin-top: 10px;
        }

        .payment-section {
            margin-bottom: 15px;
        }

        .section-title {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #000;
            padding-bottom: 3px;
            margin-bottom: 8px;
        }

        .payment-table {
            width: 100%;
            border-collapse: collapse;
        }

        .payment-table th {
            background: #f5f5f5;
            padding: 4px 6px;
            text-align: left;
            font-size: 8px;
            font-weight: bold;
            border-bottom: 1px solid #ccc;
        }

        .payment-table td {
            padding: 4px 6px;
            font-size: 8px;
            border-bottom: 1px solid #eee;
        }

        .payment-table td.text-right {
            text-align: right;
        }

        .notes-section {
            background: #f9f9f9;
            border: 1px solid #ddd;
            padding: 8px;
            margin-bottom: 15px;
            font-size: 8px;
        }

        .notes-section strong {
            display: block;
            margin-bottom: 3px;
        }

        .signature-section {
            display: table;
            width: 100%;
            margin-top: 30px;
        }

        .signature-box {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            vertical-align: top;
            padding: 0 10px;
        }

        .signature-title {
            font-size: 8px;
            color: #555;
            margin-bottom: 40px;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            width: 120px;
            margin: 0 auto 5px;
        }

        .signature-name {
            font-size: 9px;
            font-weight: bold;
        }

        .signature-role {
            font-size: 7px;
            color: #555;
        }

        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
            text-align: center;
            font-size: 7px;
            color: #888;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <div class="company-name">TJ RENT CAR</div>
            <div class="company-tagline">Jasa Rental Mobil Terpercaya</div>
        </div>
        <div class="header-right">
            <div class="invoice-label">INVOICE</div>
        </div>
    </div>

    <!-- Invoice Info -->
    <div class="invoice-info">
        <div class="invoice-info-left">
            <div class="invoice-number">{{ $transaksi->no_transaksi }}</div>
            <div class="invoice-date">Tanggal:
                {{ $transaksi->created_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}</div>
        </div>
        <div class="invoice-info-right">
            <span class="status-badge {{ $transaksi->sisa_pembayaran <= 0 ? 'status-lunas' : 'status-belum' }}">
                {{ $transaksi->sisa_pembayaran <= 0 ? 'LUNAS' : strtoupper($transaksi->status) }}
            </span>
        </div>
    </div>

    <!-- Info Boxes -->
    <div class="info-row">
        <div class="info-box">
            <div class="info-box-title">Pelanggan</div>
            <div class="info-box-content">
                <strong>{{ $transaksi->pelanggan->nama }}</strong>
                {{ $transaksi->pelanggan->telepon }}<br>
                {{ $transaksi->pelanggan->email }}<br>
                KTP: {{ $transaksi->pelanggan->no_ktp }}
            </div>
        </div>
        <div class="info-box">
            <div class="info-box-title">Kendaraan</div>
            <div class="info-box-content">
                <strong>{{ $transaksi->mobil->merk }} {{ $transaksi->mobil->model }}</strong>
                {{ $transaksi->mobil->plat_nomor }}<br>
                {{ $transaksi->mobil->warna }} - {{ $transaksi->mobil->tahun }}<br>
                {{ ucfirst($transaksi->mobil->transmisi) }}
            </div>
        </div>
        <div class="info-box">
            <div class="info-box-title">Periode Sewa</div>
            <div class="info-box-content">
                <strong>{{ $transaksi->durasi_hari }} Hari</strong>
                {{ $transaksi->tanggal_sewa->format('d/m/Y') }} - {{ $transaksi->tanggal_kembali->format('d/m/Y') }}
                @if ($transaksi->sopir)
                    <br>Sopir: {{ $transaksi->sopir->nama }}
                @endif
                @if ($transaksi->tanggal_dikembalikan)
                    <br>Dikembalikan: {{ $transaksi->tanggal_dikembalikan->format('d/m/Y') }}
                @endif
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 45%">Deskripsi</th>
                <th class="text-center" style="width: 15%">Qty</th>
                <th class="text-right" style="width: 20%">Harga</th>
                <th class="text-right" style="width: 20%">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    Sewa {{ $transaksi->mobil->merk }} {{ $transaksi->mobil->model }}<br>
                    <span
                        style="font-size: 8px; color: #666;">{{ $transaksi->hargaSewa->jenisSewa->nama_jenis }}</span>
                </td>
                <td class="text-center">{{ $transaksi->durasi_hari }} hari</td>
                <td class="text-right">Rp {{ number_format($transaksi->hargaSewa->harga_per_hari, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</td>
            </tr>
            @if ($transaksi->biaya_tambahan > 0)
                <tr>
                    <td>Biaya Tambahan</td>
                    <td class="text-center">-</td>
                    <td class="text-right">-</td>
                    <td class="text-right">Rp {{ number_format($transaksi->biaya_tambahan, 0, ',', '.') }}</td>
                </tr>
            @endif
            @if ($transaksi->denda > 0)
                <tr>
                    <td>Denda Keterlambatan</td>
                    <td class="text-center">-</td>
                    <td class="text-right">-</td>
                    <td class="text-right">Rp {{ number_format($transaksi->denda, 0, ',', '.') }}</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Summary -->
    <div class="summary-section">
        <div class="summary-left">
            @if ($transaksi->catatan)
                <div class="notes-section">
                    <strong>Catatan:</strong>
                    {{ $transaksi->catatan }}
                </div>
            @endif
        </div>
        <div class="summary-right">
            <table class="summary-table">
                <tr class="total-row">
                    <td>TOTAL</td>
                    <td>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                </tr>
                <tr class="paid-row">
                    <td>Dibayar</td>
                    <td>Rp {{ number_format($transaksi->total_pembayaran, 0, ',', '.') }}</td>
                </tr>
                <tr class="balance-row">
                    <td>{{ $transaksi->sisa_pembayaran > 0 ? 'Sisa' : 'Status' }}</td>
                    <td>
                        @if ($transaksi->sisa_pembayaran > 0)
                            Rp {{ number_format($transaksi->sisa_pembayaran, 0, ',', '.') }}
                        @else
                            <span class="lunas-stamp">LUNAS</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Payment History -->
    @if ($transaksi->pembayaran->count() > 0)
        <div class="payment-section">
            <div class="section-title">Riwayat Pembayaran</div>
            <table class="payment-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th class="text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi->pembayaran as $payment)
                        <tr>
                            <td>{{ $payment->tanggal_bayar->format('d/m/Y H:i') }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $payment->metode)) }}</td>
                            <td>{{ ucfirst($payment->status) }}</td>
                            <td class="text-right">Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Signature -->
    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-title">Pelanggan</div>
            <div class="signature-line"></div>
            <div class="signature-name">{{ $transaksi->pelanggan->nama }}</div>
        </div>
        <div class="signature-box">
            <div class="signature-title">Mengetahui</div>
            <div class="signature-line"></div>
            <div class="signature-name">........................</div>
            <div class="signature-role">Pemilik</div>
        </div>
        <div class="signature-box">
            <div class="signature-title">Admin</div>
            <div class="signature-line"></div>
            <div class="signature-name">{{ auth()->user()->name ?? '........................' }}</div>
            <div class="signature-role">Staff</div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        Dicetak: {{ $generated_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB | TJ Rent Car ©
        {{ date('Y') }}
    </div>
</body>

</html>
