@extends('layouts.admin')

@section('title', 'Jadwal & Ketersediaan Mobil')

@push('styles')
    <style>
        /* DayPilot Custom Styling - Clean Design */
        .scheduler_default_main {
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            overflow: hidden;
            background: white;
            font-family: 'Inter', sans-serif;
        }

        .scheduler_default_rowheader {
            background: #f8fafc !important;
            border-right: 1px solid #e2e8f0 !important;
            font-weight: 600;
            color: #334155;
            min-width: 180px;
        }

        .scheduler_default_rowheader_inner {
            padding: 12px 16px !important;
            font-size: 0.875rem;
            line-height: 1.25;
        }

        .scheduler_default_corner {
            background: #f1f5f9 !important;
            border-bottom: 1px solid #e2e8f0 !important;
            border-right: 1px solid #e2e8f0 !important;
            font-weight: 600;
            color: #64748b;
        }

        .scheduler_default_colheader {
            background: #f1f5f9 !important;
            border-bottom: 1px solid #e2e8f0 !important;
            border-right: 1px solid #f1f5f9 !important;
            color: #475569;
            font-weight: 500;
            font-size: 0.75rem;
            text-align: center;
            padding: 8px 4px;
        }

        .scheduler_default_cell {
            border-right: 1px solid #f1f5f9 !important;
            border-bottom: 1px solid #f8fafc !important;
            background: #ffffff;
        }

        .scheduler_default_cell.scheduler_default_cell_business {
            background: #ffffff;
        }

        .scheduler_default_event {
            border-radius: 6px;
            border: none !important;
            font-size: 0.75rem;
            font-weight: 500;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            margin: 1px;
        }

        .scheduler_default_event_inner {
            padding: 6px 10px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Grid Lines */
        .scheduler_default_matrix {
            border-collapse: separate;
            border-spacing: 0;
        }

        /* Weekend styling */
        .scheduler_default_cell_weekend {
            background: #fafafa !important;
        }

        /* Dark Mode Support */
        /* @media (prefers-color-scheme: dark) {
                                .scheduler_default_main {
                                    background: #1e293b;
                                    border-color: #334155;
                                }

                                .scheduler_default_rowheader {
                                    background: #334155 !important;
                                    color: #f1f5f9;
                                    border-color: #475569 !important;
                                }

                                .scheduler_default_corner {
                                    background: #475569 !important;
                                    border-color: #64748b !important;
                                    color: #cbd5e1;
                                }

                                .scheduler_default_colheader {
                                    background: #475569 !important;
                                    color: #f1f5f9;
                                    border-color: #64748b !important;
                                }

                                .scheduler_default_cell {
                                    border-color: #475569 !important;
                                    background: #1e293b !important;
                                }

                                .scheduler_default_cell.scheduler_default_cell_business {
                                    background: #1e293b !important;
                                }

                                .scheduler_default_cell_weekend {
                                    background: #0f172a !important;
                                }
                            } */

        /* Responsive */
        @media (max-width: 768px) {
            .scheduler_default_rowheader_inner {
                padding: 8px 12px !important;
                font-size: 0.75rem;
            }

            .scheduler_default_rowheader {
                min-width: 140px;
            }
        }

        /* Event Status Classes */
        .event-dibayar {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
            color: white !important;
        }

        .event-berjalan {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
            color: white !important;
        }

        .event-telat {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
            color: white !important;
        }
    </style>
@endpush

@section('content')
    <div class="space-y-6">
        <!-- Header & Controls -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Jadwal & Ketersediaan</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Kelola jadwal dan ketersediaan armada mobil</p>
            </div>

            <!-- View Controls -->
            <div class="flex items-center space-x-4">
                <select id="mobilFilter"
                    class="px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="">Semua Mobil</option>
                    @foreach ($mobils as $mobil)
                        <option value="{{ $mobil->id }}">{{ $mobil->nama_mobil }} - {{ $mobil->plat_nomor }}</option>
                    @endforeach
                </select>

                <!-- Month Navigation -->
                <div
                    class="flex items-center space-x-2 bg-white dark:bg-gray-700 rounded-xl border border-gray-300 dark:border-gray-600 px-4 py-2">
                    <button id="prevMonth" class="p-1 hover:bg-gray-100 dark:hover:bg-gray-600 rounded">
                        <iconify-icon icon="heroicons:chevron-left-20-solid"
                            class="w-5 h-5 text-gray-600 dark:text-gray-400"></iconify-icon>
                    </button>
                    <span id="currentMonth"
                        class="text-sm font-medium text-gray-900 dark:text-white min-w-[120px] text-center">
                        Oktober 2025
                    </span>
                    <button id="nextMonth" class="p-1 hover:bg-gray-100 dark:hover:bg-gray-600 rounded">
                        <iconify-icon icon="heroicons:chevron-right-20-solid"
                            class="w-5 h-5 text-gray-600 dark:text-gray-400"></iconify-icon>
                    </button>
                </div>

                <button id="todayBtn"
                    class="px-4 py-2 text-sm font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600">
                    Bulan Ini
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Total Mobil</p>
                        <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $stats['total_mobil'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                        <iconify-icon icon="heroicons:truck-20-solid"
                            class="w-5 h-5 text-blue-600 dark:text-blue-400"></iconify-icon>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Tersedia</p>
                        <p class="text-xl font-semibold text-green-600 dark:text-green-400">
                            {{ $stats['tersedia_hari_ini'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                        <iconify-icon icon="heroicons:check-circle-20-solid"
                            class="w-5 h-5 text-green-600 dark:text-green-400"></iconify-icon>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Sedang Disewa</p>
                        <p class="text-xl font-semibold text-yellow-600 dark:text-yellow-400">
                            {{ $stats['disewa_hari_ini'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center">
                        <iconify-icon icon="heroicons:clock-20-solid"
                            class="w-5 h-5 text-yellow-600 dark:text-yellow-400"></iconify-icon>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Telat Kembali</p>
                        <p class="text-xl font-semibold text-red-600 dark:text-red-400">{{ $stats['telat_hari_ini'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-xl flex items-center justify-center">
                        <iconify-icon icon="heroicons:exclamation-triangle-20-solid"
                            class="w-5 h-5 text-red-600 dark:text-red-400"></iconify-icon>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Siap Diambil</p>
                        <p class="text-xl font-semibold text-blue-600 dark:text-blue-400">{{ $stats['siap_diambil'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                        <iconify-icon icon="heroicons:hand-raised-20-solid"
                            class="w-5 h-5 text-blue-600 dark:text-blue-400"></iconify-icon>
                    </div>
                </div>
            </div>
        </div>

        <!-- Legend -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Keterangan Status:</h3>
            <div class="flex flex-wrap gap-4">
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 rounded event-dibayar"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Sudah Dibayar</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 rounded event-berjalan"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Sedang Berjalan</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 rounded event-telat"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Telat Kembali</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 rounded bg-gray-100 dark:bg-gray-600"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Tersedia (Kosong)</span>
                </div>
            </div>
        </div>

        <!-- Scheduler Container -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div id="scheduler" style="height: 500px;"></div>
        </div>

        <!-- Event Detail Modal -->
        <div id="eventModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <div
                    class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                                Detail Transaksi
                            </h3>
                            <button id="closeModal" class="text-gray-400 hover:text-gray-600">
                                <iconify-icon icon="heroicons:x-mark-20-solid" class="w-5 h-5"></iconify-icon>
                            </button>
                        </div>

                        <div id="modalContent" class="space-y-4">
                            <!-- Modal content will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let scheduler;
            let currentDate = new DayPilot.Date();
            const mobilFilter = document.getElementById('mobilFilter');
            const prevMonthBtn = document.getElementById('prevMonth');
            const nextMonthBtn = document.getElementById('nextMonth');
            const todayBtn = document.getElementById('todayBtn');
            const currentMonthSpan = document.getElementById('currentMonth');
            const eventModal = document.getElementById('eventModal');
            const closeModal = document.getElementById('closeModal');

            // Initialize DayPilot Scheduler (Month view only)
            function initScheduler() {
                const today = DayPilot.Date.today();
                currentDate = today.firstDayOfMonth();

                scheduler = new DayPilot.Scheduler("scheduler", {
                    startDate: currentDate,
                    days: currentDate.daysInMonth(),
                    scale: "Day",
                    timeHeaders: [{
                            groupBy: "Month",
                            format: "MMMM yyyy"
                        },
                        {
                            groupBy: "Day",
                            format: "d"
                        }
                    ],
                    heightSpec: "Max",
                    height: 600,
                    cellWidthSpec: "Auto",
                    cellWidth: 35,
                    cellHeight: 50,
                    eventHeight: 40,
                    rowHeaderWidth: 180,
                    onEventClick: function(args) {
                        showEventDetail(args.e.data);
                    },
                    onBeforeEventRender: function(args) {
                        const status = args.data.status;

                        // Set colors based on status
                        if (status === 'dibayar') {
                            args.data.barColor = "#3b82f6";
                            args.data.barBackColor = "#dbeafe";
                        } else if (status === 'berjalan') {
                            args.data.barColor = "#f59e0b";
                            args.data.barBackColor = "#fef3c7";
                        } else if (status === 'telat') {
                            args.data.barColor = "#ef4444";
                            args.data.barBackColor = "#fecaca";
                        }
                        // Show customer name if available
                        if (args.data.pelanggan) {
                            args.data.text = `${args.data.pelanggan} (${args.data.no_transaksi})`;
                        }
                    }
                });

                scheduler.init();
                updateMonthDisplay();
                loadSchedulerData();
            }

            // Update month display
            function updateMonthDisplay() {
                const monthNames = [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];

                const month = monthNames[currentDate.getMonth()];
                const year = currentDate.getYear();
                currentMonthSpan.textContent = `${month} ${year}`;
            }

            // Load data for scheduler
            function loadSchedulerData() {
                if (!scheduler) {
                    console.log('Scheduler not initialized yet');
                    return;
                }

                const startDate = scheduler.visibleStart().toString("yyyy-MM-dd");
                const endDate = scheduler.visibleEnd().toString("yyyy-MM-dd");

                const url = new URL('{{ route('admin.jadwal.events') }}');
                url.searchParams.set('start', startDate);
                url.searchParams.set('end', endDate);
                url.searchParams.set('scheduler', '1'); // Flag for scheduler format

                if (mobilFilter.value) {
                    url.searchParams.set('mobil_id', mobilFilter.value);
                }

                fetch(url)
                    .then(response => response.json())
                    .then(data => {

                        // Clear existing events
                        scheduler.events.list = [];

                        // Add events manually using scheduler.events.add()
                        data.events.forEach(eventData => {
                            scheduler.events.add({
                                id: eventData.id,
                                start: new DayPilot.Date(eventData.start),
                                end: new DayPilot.Date(eventData.end),
                                text: `${eventData.text} (${eventData.no_transaksi})`,
                                resource: eventData.resource,
                                // Additional data for modal
                                transaksi_id: eventData.transaksi_id,
                                no_transaksi: eventData.no_transaksi,
                                pelanggan: eventData.pelanggan,
                                mobil: eventData.mobil,
                                status: eventData.status,
                                status_text: eventData.status_text,
                                total: eventData.total,
                                tanggal_sewa: eventData.tanggal_sewa,
                                tanggal_kembali: eventData.tanggal_kembali
                            });
                        });

                        // Update resources
                        scheduler.update({
                            resources: data.resources
                        });

                        console.log("Scheduler events after manual add:", scheduler.events.list);
                    })
                    .catch(error => {
                        console.error('Error loading scheduler data:', error);
                    });

            }

            // Show event detail modal
            function showEventDetail(eventData) {
                const modalContent = document.getElementById('modalContent');

                // Status color mapping
                const statusColors = {
                    'dibayar': 'bg-blue-500',
                    'berjalan': 'bg-yellow-500',
                    'telat': 'bg-red-500'
                };

                modalContent.innerHTML = `
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 ${statusColors[eventData.status]} rounded-full flex items-center justify-center">
                                    <iconify-icon icon="heroicons:user-20-solid" class="w-6 h-6 text-white"></iconify-icon>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">${eventData.pelanggan}</h4>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-white ${statusColors[eventData.status]}">
                                        ${eventData.status_text}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                            <h5 class="font-medium text-gray-900 dark:text-white mb-3">Detail Transaksi</h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">No. Transaksi:</span>
                                    <div class="font-medium text-gray-900 dark:text-white">${eventData.no_transaksi}</div>
                                </div>
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">Mobil:</span>
                                    <div class="font-medium text-gray-900 dark:text-white">${eventData.mobil}</div>
                                </div>
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">Tanggal Sewa:</span>
                                    <div class="font-medium text-gray-900 dark:text-white">${eventData.tanggal_sewa}</div>
                                </div>
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">Tanggal Kembali:</span>
                                    <div class="font-medium text-gray-900 dark:text-white">${eventData.tanggal_kembali}</div>
                                </div>
                                <div class="md:col-span-2">
                                    <span class="text-gray-500 dark:text-gray-400">Total Pembayaran:</span>
                                    <div class="font-semibold text-lg text-green-600 dark:text-green-400">${eventData.total}</div>
                                </div>
                            </div>
                        </div>

                        <div class="flex space-x-3">
                            <button onclick="viewTransactionDetail(${eventData.transaksi_id})"
                                    class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <iconify-icon icon="heroicons:eye-20-solid" class="w-4 h-4 mr-2"></iconify-icon>
                                Lihat Detail Lengkap
                            </button>
                        </div>
                    </div>
                `;

                eventModal.classList.remove('hidden');
            }

            // View transaction detail function (global)
            window.viewTransactionDetail = function(transaksiId) {
                const baseUrl = '{{ url('admin/jadwal/transaksi') }}';
                fetch(`${baseUrl}/${transaksiId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Transaction detail:', data);
                        eventModal.classList.add('hidden');
                        // You can redirect to transaction detail page or show more details
                        window.open(`{{ url('admin/orders') }}/${transaksiId}`, '_blank');
                    })
                    .catch(error => {
                        console.error('Error loading transaction detail:', error);
                        alert('Terjadi kesalahan saat memuat detail transaksi');
                    });
            }

            // Month navigation
            prevMonthBtn.addEventListener('click', () => {
                if (scheduler) {
                    currentDate = currentDate.addMonths(-1);
                    scheduler.update({
                        startDate: currentDate,
                        days: currentDate.daysInMonth()
                    });
                    updateMonthDisplay();
                    setTimeout(() => loadSchedulerData(), 100);
                }
            });

            nextMonthBtn.addEventListener('click', () => {
                if (scheduler) {
                    currentDate = currentDate.addMonths(1);
                    scheduler.update({
                        startDate: currentDate,
                        days: currentDate.daysInMonth()
                    });
                    updateMonthDisplay();
                    setTimeout(() => loadSchedulerData(), 100);
                }
            });

            todayBtn.addEventListener('click', () => {
                if (scheduler) {
                    const today = DayPilot.Date.today();
                    currentDate = today.firstDayOfMonth();
                    scheduler.update({
                        startDate: currentDate,
                        days: currentDate.daysInMonth()
                    });
                    updateMonthDisplay();
                    setTimeout(() => loadSchedulerData(), 100);
                }
            });

            // Filter handling
            mobilFilter.addEventListener('change', () => {
                if (scheduler) {
                    loadSchedulerData();
                }
            });

            // Modal handling
            closeModal.addEventListener('click', () => {
                eventModal.classList.add('hidden');
            });

            eventModal.addEventListener('click', (e) => {
                if (e.target === eventModal) {
                    eventModal.classList.add('hidden');
                }
            });

            // Initialize scheduler on page load
            if (typeof DayPilot !== 'undefined') {
                console.log('DayPilot loaded, initializing scheduler...');
                initScheduler();
            } else {
                console.error('DayPilot library not loaded');
                document.getElementById('scheduler').innerHTML =
                    '<div class="p-4 text-center text-red-500">Error: DayPilot library gagal dimuat. Silakan refresh halaman.</div>';
            }
        });
    </script>
@endsection
