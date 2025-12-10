<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pembayaran - TJ Rent Car</title>
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

        .report-label {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .report-sublabel {
            font-size: 9px;
            color: #555;
            margin-top: 2px;
        }

        .filter-info {
            background: #f5f5f5;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 8px;
        }

        .filter-info-row {
            display: table;
            width: 100%;
        }

        .filter-info-cell {
            display: table-cell;
            width: 25%;
            padding-right: 10px;
        }

        .filter-label {
            color: #555;
            font-size: 7px;
            text-transform: uppercase;
        }

        .filter-value {
            font-weight: bold;
            font-size: 9px;
        }

        .stats-row {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .stats-box {
            display: table-cell;
            width: 16.66%;
            text-align: center;
            padding: 8px 5px;
            border: 1px solid #ddd;
            background: #fafafa;
        }

        .stats-box.highlight {
            background: #000;
            color: #fff;
            border-color: #000;
        }

        .stats-box.highlight .stats-label {
            color: #ccc;
        }

        .stats-label {
            font-size: 7px;
            color: #666;
            text-transform: uppercase;
        }

        .stats-value {
            font-size: 14px;
            font-weight: bold;
            margin-top: 2px;
        }

        .stats-box.highlight .stats-value {
            color: #fff;
        }

        .section-title {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #000;
            padding-bottom: 3px;
            margin-bottom: 10px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .data-table th {
            background: #000;
            color: #fff;
            padding: 6px 8px;
            text-align: left;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .data-table th.text-center {
            text-align: center;
        }

        .data-table th.text-right {
            text-align: right;
        }

        .data-table td {
            padding: 5px 8px;
            border-bottom: 1px solid #ddd;
            font-size: 8px;
            vertical-align: top;
        }

        .data-table td.text-center {
            text-align: center;
        }

        .data-table td.text-right {
            text-align: right;
        }

        .data-table tbody tr:nth-child(even) {
            background: #fafafa;
        }

        .data-table tfoot td {
            background: #f5f5f5;
            font-weight: bold;
            border-top: 2px solid #000;
            padding: 8px;
        }

        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 7px;
            font-weight: bold;
            text-transform: uppercase;
            border: 1px solid #000;
        }

        .status-terkonfirmasi {
            background: #000;
            color: #fff;
        }

        .status-pending {
            background: #fff;
            color: #000;
        }

        .status-gagal {
            background: #fff;
            color: #000;
            text-decoration: line-through;
        }

        .status-refund {
            background: #ddd;
            color: #000;
        }

        .metode-badge {
            display: inline-block;
            padding: 1px 4px;
            font-size: 7px;
            background: #f0f0f0;
            border: 1px solid #ccc;
        }

        .summary-section {
            display: table;
            width: 100%;
            margin-top: 15px;
        }

        .summary-left {
            display: table-cell;
            width: 60%;
            vertical-align: top;
        }

        .summary-right {
            display: table-cell;
            width: 40%;
            vertical-align: top;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary-table td {
            padding: 4px 8px;
            font-size: 9px;
            border-bottom: 1px solid #eee;
        }

        .summary-table td:first-child {
            text-align: left;
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
            border-bottom: none;
            padding-top: 8px;
        }

        .signature-section {
            display: table;
            width: 100%;
            margin-top: 40px;
        }

        .signature-box {
            display: table-cell;
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 0 30px;
        }

        .signature-title {
            font-size: 8px;
            color: #555;
            margin-bottom: 50px;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            width: 150px;
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

        .no-data {
            text-align: center;
            padding: 30px;
            color: #666;
            font-style: italic;
        }

        .text-small {
            font-size: 7px;
            color: #666;
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
            <div class="report-label">LAPORAN PEMBAYARAN</div>
            <div class="report-sublabel">{{ $generated_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB</div>
        </div>
    </div>

    <!-- Filter Info -->
    <div class="filter-info">
        <div class="filter-info-row">
            <div class="filter-info-cell">
                <div class="filter-label">Periode</div>
                <div class="filter-value">{{ $filter_label }}</div>
            </div>
            <div class="filter-info-cell">
                <div class="filter-label">Status</div>
                <div class="filter-value">{{ $filters['status'] ? ucfirst($filters['status']) : 'Semua' }}</div>
            </div>
            <div class="filter-info-cell">
                <div class="filter-label">Metode</div>
                <div class="filter-value">
                    {{ $filters['metode'] ? ucfirst(str_replace('_', ' ', $filters['metode'])) : 'Semua' }}</div>
            </div>
            <div class="filter-info-cell">
                <div class="filter-label">Total Data</div>
                <div class="filter-value">{{ $pembayaran->count() }} Pembayaran</div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="stats-row">
        <div class="stats-box">
            <div class="stats-label">Total</div>
            <div class="stats-value">{{ $statistik['total'] }}</div>
        </div>
        <div class="stats-box">
            <div class="stats-label">Pending</div>
            <div class="stats-value">{{ $statistik['pending'] }}</div>
        </div>
        <div class="stats-box">
            <div class="stats-label">Terkonfirmasi</div>
            <div class="stats-value">{{ $statistik['terkonfirmasi'] }}</div>
        </div>
        <div class="stats-box">
            <div class="stats-label">Gagal</div>
            <div class="stats-value">{{ $statistik['gagal'] }}</div>
        </div>
        <div class="stats-box">
            <div class="stats-label">Refund</div>
            <div class="stats-value">{{ $statistik['refund'] }}</div>
        </div>
        <div class="stats-box highlight">
            <div class="stats-label">Total Nilai</div>
            <div class="stats-value">{{ number_format($statistik['total_nilai'] / 1000000, 1) }}jt</div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="section-title">Daftar Pembayaran</div>

    @if ($pembayaran->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 4%">No</th>
                    <th style="width: 12%">Tanggal</th>
                    <th style="width: 14%">No. Transaksi</th>
                    <th style="width: 18%">Pelanggan</th>
                    <th style="width: 14%">Mobil</th>
                    <th class="text-center" style="width: 10%">Metode</th>
                    <th class="text-center" style="width: 10%">Status</th>
                    <th class="text-right" style="width: 18%">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pembayaran as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            {{ $item->tanggal_bayar->timezone('Asia/Jakarta')->format('d/m/Y') }}
                            <div class="text-small">{{ $item->tanggal_bayar->timezone('Asia/Jakarta')->format('H:i') }}
                            </div>
                        </td>
                        <td>
                            {{ $item->transaksi->no_transaksi ?? '-' }}
                        </td>
                        <td>
                            {{ $item->transaksi->pelanggan->nama ?? '-' }}
                            <div class="text-small">{{ $item->transaksi->pelanggan->telepon ?? '' }}</div>
                        </td>
                        <td>
                            {{ $item->transaksi->mobil->merk ?? '' }} {{ $item->transaksi->mobil->model ?? '' }}
                            <div class="text-small">{{ $item->transaksi->mobil->plat_nomor ?? '' }}</div>
                        </td>
                        <td class="text-center">
                            <span class="metode-badge">{{ strtoupper($item->metode) }}</span>
                        </td>
                        <td class="text-center">
                            <span class="status-badge status-{{ $item->status }}">{{ $item->status }}</span>
                        </td>
                        <td class="text-right">
                            Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                            @if ($item->catatan)
                                <div class="text-small">{{ Str::limit($item->catatan, 30) }}</div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" class="text-right">TOTAL PEMBAYARAN TERKONFIRMASI</td>
                    <td class="text-right">Rp {{ number_format($statistik['total_nilai'], 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Summary by Method -->
        <div class="summary-section">
            <div class="summary-left">
                <div class="section-title">Ringkasan per Metode Pembayaran</div>
                <table class="summary-table">
                    @php
                        $byMethod = $pembayaran->where('status', 'terkonfirmasi')->groupBy('metode');
                    @endphp
                    @foreach ($byMethod as $metode => $items)
                        <tr>
                            <td>{{ ucfirst(str_replace('_', ' ', $metode)) }} ({{ $items->count() }}x)</td>
                            <td>Rp {{ number_format($items->sum('jumlah'), 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td>Total Terkonfirmasi</td>
                        <td>Rp {{ number_format($statistik['total_nilai'], 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
            <div class="summary-right">
                <div class="section-title">Ringkasan per Status</div>
                <table class="summary-table">
                    <tr>
                        <td>Pending</td>
                        <td>{{ $statistik['pending'] }} transaksi</td>
                    </tr>
                    <tr>
                        <td>Terkonfirmasi</td>
                        <td>{{ $statistik['terkonfirmasi'] }} transaksi</td>
                    </tr>
                    <tr>
                        <td>Gagal</td>
                        <td>{{ $statistik['gagal'] }} transaksi</td>
                    </tr>
                    <tr>
                        <td>Refund</td>
                        <td>{{ $statistik['refund'] }} transaksi</td>
                    </tr>
                </table>
            </div>
        </div>
    @else
        <div class="no-data">Tidak ada data pembayaran untuk filter yang dipilih</div>
    @endif

    <!-- Signature -->
    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-title">Mengetahui</div>
            <div class="signature-line"></div>
            <div class="signature-name">........................</div>
            <div class="signature-role">Pemilik / Direktur</div>
        </div>
        <div class="signature-box">
            <div class="signature-title">Dibuat oleh</div>
            <div class="signature-line"></div>
            <div class="signature-name">{{ auth()->user()->name ?? '........................' }}</div>
            <div class="signature-role">Admin / Staff</div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        Dicetak: {{ $generated_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB | TJ Rent Car ©
        {{ date('Y') }}
    </div>
</body>

</html>
