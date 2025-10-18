<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 15px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #0ea5e9;
            padding-bottom: 15px;
        }

        .header h1 {
            color: #0ea5e9;
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .filter-info {
            background: #f8fafc;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid #0ea5e9;
        }

        .filter-info h3 {
            margin: 0 0 8px 0;
            color: #374151;
            font-size: 12px;
        }

        .filter-item {
            display: inline-block;
            margin-right: 15px;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 9px;
        }

        th,
        td {
            border: 1px solid #e5e7eb;
            padding: 4px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f9fafb;
            font-weight: bold;
            color: #374151;
            text-align: center;
        }

        .status {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status.pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status.dibayar {
            background: #d1fae5;
            color: #065f46;
        }

        .status.berjalan {
            background: #e0e7ff;
            color: #3730a3;
        }

        .status.selesai {
            background: #dcfce7;
            color: #14532d;
        }

        .status.telat {
            background: #fecaca;
            color: #991b1b;
        }

        .status.dibatalkan {
            background: #f3f4f6;
            color: #374151;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .font-medium {
            font-weight: 600;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 9px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }

        .no-data {
            text-align: center;
            padding: 30px;
            color: #6b7280;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('logo/logo.png') }}" alt="TJ RENT CAR" style="height: 120px; margin-bottom: 10px;">
        <h1>TJ RENT CAR</h1>
        <p>Laporan Transaksi Rental Mobil</p>
        <p>Digenerate pada: {{ $generated_at->format('d F Y H:i:s') }} WIB</p>
    </div>

    @if (isset($filters) && is_array($filters) && array_filter($filters))
        <div class="filter-info">
            <h3>Filter yang Diterapkan:</h3>
            @if (isset($filters['period']) && !empty($filters['period']))
                <span class="filter-item"><strong>Periode:</strong>
                    @switch($filters['period'])
                        @case('today')
                            Hari Ini
                        @break

                        @case('yesterday')
                            Kemarin
                        @break

                        @case('this_week')
                            Minggu Ini
                        @break

                        @case('last_week')
                            Minggu Lalu
                        @break

                        @case('this_month')
                            Bulan Ini
                        @break

                        @case('last_month')
                            Bulan Lalu
                        @break

                        @case('this_year')
                            Tahun Ini
                        @break

                        @default
                            {{ $filters['period'] }}
                    @endswitch
                </span>
            @endif
            @if (isset($filters['date_from']) && !empty($filters['date_from']))
                <span class="filter-item"><strong>Dari:</strong>
                    {{ \Carbon\Carbon::parse($filters['date_from'])->format('d/m/Y') }}</span>
            @endif
            @if (isset($filters['date_to']) && !empty($filters['date_to']))
                <span class="filter-item"><strong>Sampai:</strong>
                    {{ \Carbon\Carbon::parse($filters['date_to'])->format('d/m/Y') }}</span>
            @endif
            @if (isset($filters['status']) && !empty($filters['status']))
                <span class="filter-item"><strong>Status:</strong> {{ ucfirst($filters['status']) }}</span>
            @endif
            @if (isset($filters['search']) && !empty($filters['search']))
                <span class="filter-item"><strong>Pencarian:</strong> "{{ $filters['search'] }}"</span>
            @endif
        </div>
    @endif

    @if ($transaksi->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 8%">No</th>
                    <th style="width: 12%">Kode</th>
                    <th style="width: 15%">Pelanggan</th>
                    <th style="width: 15%">Mobil</th>
                    <th style="width: 12%">Tanggal Sewa</th>
                    <th style="width: 10%">Durasi</th>
                    <th style="width: 10%">Status</th>
                    <th style="width: 12%">Total</th>
                    <th style="width: 6%">Sopir</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="font-medium">{{ $item->no_transaksi }}</td>
                        <td>
                            <div>{{ $item->pelanggan->nama ?? 'N/A' }}</div>
                            <div style="font-size: 8px; color: #6b7280;">{{ $item->pelanggan->telepon ?? '' }}</div>
                        </td>
                        <td>
                            <div>{{ $item->mobil->merk ?? 'N/A' }} {{ $item->mobil->model ?? '' }}</div>
                            <div style="font-size: 8px; color: #6b7280;">{{ $item->mobil->plat_nomor ?? '' }}</div>
                        </td>
                        <td class="text-center">
                            <div>
                                {{ $item->tanggal_sewa ? \Carbon\Carbon::parse($item->tanggal_sewa)->format('d/m/Y') : '-' }}
                            </div>
                            <div style="font-size: 8px; color: #6b7280;">
                                {{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') : '-' }}
                            </div>
                        </td>
                        <td class="text-center">{{ $item->durasi_hari ?? 0 }} hari</td>
                        <td class="text-center">
                            <span class="status {{ $item->status }}">{{ ucfirst($item->status) }}</span>
                        </td>
                        <td class="text-right font-medium">Rp {{ number_format($item->total ?? 0, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @if ($item->sopir)
                                <div style="font-size: 8px;">{{ $item->sopir->nama }}</div>
                            @else
                                <span style="color: #6b7280; font-size: 8px;">Tanpa Sopir</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background: #f9fafb; font-weight: bold;">
                    <td colspan="7" class="text-right">Total Pendapatan:</td>
                    <td class="text-right">Rp {{ number_format($statistik['total_pendapatan'] ?? 0, 0, ',', '.') }}
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    @else
        <div class="no-data">
            <p>Tidak ada data transaksi yang ditemukan dengan filter yang diterapkan.</p>
        </div>
    @endif

    <div class="footer">
        <p>Laporan ini digenerate secara otomatis oleh Sistem TJ Rent Car</p>
        <p>© {{ date('Y') }} TJ Rent Car - Semua hak dilindungi</p>
    </div>
</body>

</html>
