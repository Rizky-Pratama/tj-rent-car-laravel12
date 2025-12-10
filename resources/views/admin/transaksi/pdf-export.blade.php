<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi - TJ Rent Car</title>
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

        .stats-row {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .stats-box {
            display: table-cell;
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

        .status-pending {
            background: #fff;
            color: #000;
        }

        .status-dibayar {
            background: #ddd;
            color: #000;
        }

        .status-berjalan {
            background: #000;
            color: #fff;
        }

        .status-selesai {
            background: #000;
            color: #fff;
        }

        .status-telat {
            background: #fff;
            color: #000;
            text-decoration: underline;
        }

        .status-dibatalkan {
            background: #fff;
            color: #000;
            text-decoration: line-through;
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
            <div class="report-label">LAPORAN TRANSAKSI</div>
            <div class="report-sublabel">{{ $generated_at }} WIB</div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="stats-row">
        <div class="stats-box">
            <div class="stats-label">Total</div>
            <div class="stats-value">{{ $statistik['total'] ?? $transaksi->count() }}</div>
        </div>
        <div class="stats-box">
            <div class="stats-label">Pending</div>
            <div class="stats-value">{{ $statistik['pending'] ?? $transaksi->where('status', 'pending')->count() }}
            </div>
        </div>
        <div class="stats-box">
            <div class="stats-label">Berjalan</div>
            <div class="stats-value">{{ $statistik['berjalan'] ?? $transaksi->where('status', 'berjalan')->count() }}
            </div>
        </div>
        <div class="stats-box">
            <div class="stats-label">Selesai</div>
            <div class="stats-value">{{ $statistik['selesai'] ?? $transaksi->where('status', 'selesai')->count() }}
            </div>
        </div>
        <div class="stats-box highlight">
            <div class="stats-label">Pendapatan</div>
            <div class="stats-value">
                {{ number_format(($statistik['total_pendapatan'] ?? $transaksi->sum('total')) / 1000000, 1) }}jt</div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="section-title">Daftar Transaksi</div>

    @if ($transaksi->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 4%">No</th>
                    <th style="width: 12%">Kode</th>
                    <th style="width: 16%">Pelanggan</th>
                    <th style="width: 14%">Mobil</th>
                    <th class="text-center" style="width: 14%">Periode</th>
                    <th class="text-center" style="width: 8%">Durasi</th>
                    <th class="text-center" style="width: 10%">Status</th>
                    <th class="text-right" style="width: 14%">Total</th>
                    <th class="text-center" style="width: 8%">Sopir</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td><strong>{{ $item->no_transaksi }}</strong></td>
                        <td>
                            {{ $item->pelanggan->nama ?? 'N/A' }}
                            <div class="text-small">{{ $item->pelanggan->telepon ?? '' }}</div>
                        </td>
                        <td>
                            {{ $item->mobil->merk ?? '' }} {{ $item->mobil->model ?? '' }}
                            <div class="text-small">{{ $item->mobil->plat_nomor ?? '' }}</div>
                        </td>
                        <td class="text-center">
                            {{ $item->tanggal_sewa ? \Carbon\Carbon::parse($item->tanggal_sewa)->format('d/m/Y') : '-' }}
                            <div class="text-small">s/d
                                {{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') : '-' }}
                            </div>
                        </td>
                        <td class="text-center">{{ $item->durasi_hari ?? 0 }} hari</td>
                        <td class="text-center">
                            <span class="status-badge status-{{ $item->status }}">{{ $item->status }}</span>
                        </td>
                        <td class="text-right"><strong>Rp {{ number_format($item->total ?? 0, 0, ',', '.') }}</strong>
                        </td>
                        <td class="text-center">
                            @if ($item->sopir)
                                <span class="text-small">{{ $item->sopir->nama }}</span>
                            @else
                                <span class="text-small">-</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" class="text-right">TOTAL PENDAPATAN</td>
                    <td class="text-right">Rp
                        {{ number_format($statistik['total_pendapatan'] ?? $transaksi->sum('total'), 0, ',', '.') }}
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    @else
        <div class="no-data">Tidak ada data transaksi yang ditemukan</div>
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
        Dicetak: {{ $generated_at }} WIB | TJ Rent Car © {{ date('Y') }}
    </div>
</body>

</html>
