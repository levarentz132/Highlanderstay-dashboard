@php
    $rupiah = fn ($value) => 'Rp ' . number_format($value, 0, ',', '.');
    $latestUtility = $utilityReadings->first();
    $paidPayments = $payments->where('status', 'paid')->take(5);
    $overduePayments = $payments->where('status', 'overdue');
    $pendingPayments = $payments->where('status', 'pending');
@endphp

<!doctype html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $setting->kost_name ?? 'KosCerdas' }} - Dashboard</title>
        <meta name="description" content="Dashboard Laravel untuk mengelola kamar, penyewa, tunggakan, listrik dan air, perawatan, laporan, dan pengaturan kost.">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('build/assets/app-DI0RJGoj.css') }}">
        <script type="module" src="{{ asset('build/assets/app-B1A_BR5W.js') }}" defer></script>
    </head>
    <body>
        <div class="app-shell">
            <aside class="sidebar" aria-label="Navigasi utama">
                <div class="brand">
                    <div class="brand-mark">K</div>
                    <div>
                        <strong>KosCerdas</strong>
                        <span>{{ $setting->kost_name ?? 'Kelola kost2an' }}</span>
                    </div>
                </div>

                <nav class="nav-list">
                    <button class="nav-item active" data-section="beranda">Beranda</button>
                    <button class="nav-item" data-section="kamar">Kamar</button>
                    <button class="nav-item" data-section="penyewa">Penyewa</button>
                    <button class="nav-item" data-section="tunggakan">Tunggakan</button>
                    <button class="nav-item" data-section="listrik-air">Listrik & Air</button>
                    <button class="nav-item" data-section="perawatan">Perawatan</button>
                    <button class="nav-item" data-section="laporan">Laporan</button>
                    <button class="nav-item" data-section="pengaturan">Pengaturan</button>
                </nav>

                <div class="trust-box">
                    <span class="pulse"></span>
                    <p>Database terhubung via Laravel Eloquent</p>
                </div>
            </aside>

            <main class="workspace">
                <header class="topbar">
                    <div>
                        <p class="eyebrow">Ringkasan hari ini</p>
                        <h1 id="page-title">Beranda</h1>
                    </div>
                    <div class="top-actions">
                        <button class="icon-button" aria-label="Cari">⌕</button>
                        <button class="icon-button" aria-label="Notifikasi">◔</button>
                        <button class="primary-button">Tambah Data</button>
                    </div>
                </header>

                <section class="section-panel active" id="beranda">
                    <div class="hero-strip">
                        <div>
                            <p class="eyebrow">{{ $setting->kost_name ?? 'Kost' }}</p>
                            <h2>Operasional kost yang rapi dari kamar sampai laporan.</h2>
                        </div>
                        <div class="hero-date">{{ $today }}</div>
                    </div>

                    <div class="metric-grid">
                        <x-metric label="Total Kamar" :value="$stats['totalRooms']" note="Semua unit terdata" tone="teal" />
                        <x-metric label="Terisi" :value="$stats['occupiedRooms']" :note="$stats['occupancyRate'] . '% okupansi'" tone="green" />
                        <x-metric label="Kosong" :value="$stats['emptyRooms']" note="Siap ditawarkan" tone="amber" />
                        <x-metric label="Tunggakan" :value="$stats['arrearsCount']" note="Butuh follow-up" tone="red" />
                    </div>

                    <div class="dashboard-grid">
                        <article class="panel wide">
                            <div class="panel-head">
                                <div>
                                    <h3>Pemasukan 6 Bulan Terakhir</h3>
                                    <p>Realisasi pembayaran dari tabel payments</p>
                                </div>
                                <span class="tag success">{{ $rupiah($stats['paidThisMonth']) }}</span>
                            </div>
                            <div class="chart-bars">
                                @foreach ($lastSixMonths as $month)
                                    <span style="height: {{ max(12, round(($month['total'] / $maxIncome) * 92)) }}%">
                                        <b>{{ $month['label'] }}</b>
                                    </span>
                                @endforeach
                            </div>
                        </article>

                        <article class="panel">
                            <div class="panel-head">
                                <h3>Status Kamar</h3>
                                <span class="tag">{{ $stats['totalRooms'] }} total</span>
                            </div>
                            <div class="donut-wrap">
                                <div class="donut" style="--occupied: {{ $stats['occupancyRate'] }}%"><span>{{ $stats['occupancyRate'] }}%</span></div>
                                <ul class="legend">
                                    <li><i class="green-dot"></i>{{ $stats['occupiedRooms'] }} terisi</li>
                                    <li><i class="amber-dot"></i>{{ $stats['emptyRooms'] }} kosong</li>
                                    <li><i class="red-dot"></i>{{ $stats['maintenanceRooms'] }} perawatan</li>
                                </ul>
                            </div>
                        </article>

                        <article class="panel">
                            <div class="panel-head">
                                <h3>Jadwal Pembayaran</h3>
                                <span class="tag warning">{{ $stats['upcomingDue'] }} dekat tempo</span>
                            </div>
                            <div class="calendar">
                                @foreach (['Sen','Sel','Rab','Kam','Jum','Sab','Min'] as $day)
                                    <span>{{ $day }}</span>
                                @endforeach
                                @for ($day = 1; $day <= 21; $day++)
                                    <button class="{{ in_array($day, [4, 9, 13, 21], true) ? 'due' : '' }}">{{ $day }}</button>
                                @endfor
                            </div>
                        </article>

                        <article class="panel wide">
                            <div class="panel-head">
                                <h3>Aktivitas Terbaru</h3>
                                <button class="text-button">Lihat semua</button>
                            </div>
                            <div class="activity-list">
                                @foreach ($paidPayments as $payment)
                                    <p><span class="check">✓</span>{{ $payment->tenant->name }} membayar kamar {{ $payment->room->code }} <b>{{ optional($payment->paid_at)->format('d M, H:i') }}</b></p>
                                @endforeach
                                @foreach ($maintenanceTickets->take(2) as $ticket)
                                    <p><span class="tool">↗</span>{{ $ticket->title }} {{ $ticket->room ? '- ' . $ticket->room->code : '' }} <b>{{ ucfirst($ticket->status) }}</b></p>
                                @endforeach
                            </div>
                        </article>
                    </div>
                </section>

                <section class="section-panel" id="kamar">
                    <div class="section-head">
                        <div><p class="eyebrow">Manajemen unit</p><h2>Kamar</h2></div>
                        <div class="segmented"><button class="active">Semua</button><button>Terisi</button><button>Kosong</button><button>Perawatan</button></div>
                    </div>
                    <div class="room-grid">
                        @foreach ($rooms as $room)
                            <article class="room-card">
                                <strong>{{ $room->code }}</strong>
                                <span class="tag {{ $room->status === 'terisi' ? 'success' : ($room->status === 'kosong' ? 'warning' : 'danger') }}">{{ ucfirst($room->status) }}</span>
                                <p>{{ $room->tenant?->name ?? 'Belum ada penyewa' }} · {{ $rupiah($room->monthly_rate) }}</p>
                                <small>{{ $room->notes }}</small>
                            </article>
                        @endforeach
                    </div>
                </section>

                <section class="section-panel" id="penyewa">
                    <div class="section-head"><div><p class="eyebrow">Data penghuni</p><h2>Penyewa</h2></div><button class="primary-button">Tambah Penyewa</button></div>
                    <div class="table-card">
                        <table>
                            <thead><tr><th>Nama</th><th>Kamar</th><th>Kontak</th><th>Mulai Sewa</th><th>Status</th></tr></thead>
                            <tbody>
                                @foreach ($tenants as $tenant)
                                    <tr>
                                        <td>{{ $tenant->name }}</td>
                                        <td>{{ $tenant->room->code }}</td>
                                        <td>{{ $tenant->phone }}</td>
                                        <td>{{ $tenant->move_in_date->format('d M Y') }}</td>
                                        <td><span class="tag {{ $tenant->status === 'active' ? 'success' : 'danger' }}">{{ ucfirst($tenant->status) }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="section-panel" id="tunggakan">
                    <div class="section-head"><div><p class="eyebrow">Penagihan</p><h2>Tunggakan</h2></div><button class="primary-button">Kirim Pengingat</button></div>
                    <div class="collection-grid">
                        <article class="panel"><h3>Total Tertunda</h3><strong class="money danger-text">{{ $rupiah($stats['arrearsTotal']) }}</strong><p>{{ $stats['arrearsCount'] }} penyewa perlu follow-up.</p></article>
                        <article class="panel"><h3>Umur Tunggakan</h3><div class="stack-list"><p>1-30 hari <b>{{ $overduePayments->filter(fn ($payment) => $payment->due_date->diffInDays(now()) <= 30)->count() }}</b></p><p>31-60 hari <b>{{ $overduePayments->filter(fn ($payment) => $payment->due_date->diffInDays(now()) > 30 && $payment->due_date->diffInDays(now()) <= 60)->count() }}</b></p><p>&gt; 60 hari <b>{{ $overduePayments->filter(fn ($payment) => $payment->due_date->diffInDays(now()) > 60)->count() }}</b></p></div></article>
                        <article class="panel wide"><h3>Daftar Prioritas</h3><div class="activity-list">@foreach ($overduePayments as $payment)<p><span class="warn">!</span>{{ $payment->room->code }} · {{ $payment->tenant->name }} · {{ $rupiah($payment->amount) }} <b>{{ round($payment->due_date->diffInDays(now())) }} hari</b></p>@endforeach</div></article>
                    </div>
                </section>

                <section class="section-panel" id="listrik-air">
                    <div class="section-head"><div><p class="eyebrow">Utilitas</p><h2>Listrik & Air</h2></div><button class="primary-button">Catat Meter</button></div>
                    <div class="utility-grid">
                        <article class="panel"><h3>Listrik Bulan Ini</h3><strong class="money">{{ number_format($latestUtility?->electricity_kwh ?? 0, 0, ',', '.') }} kWh</strong><div class="progress"><span style="width: 68%"></span></div><p>{{ $rupiah($latestUtility?->electricity_cost ?? 0) }}</p></article>
                        <article class="panel"><h3>Air Bulan Ini</h3><strong class="money">{{ number_format($latestUtility?->water_m3 ?? 0, 0, ',', '.') }} m3</strong><div class="progress blue"><span style="width: 54%"></span></div><p>{{ $rupiah($latestUtility?->water_cost ?? 0) }}</p></article>
                        <article class="panel wide"><h3>Catatan Pencatatan</h3><div class="activity-list">@foreach ($utilityReadings as $reading)<p><span class="drop">●</span>{{ $reading->period }} · {{ $reading->notes }} <b>{{ $reading->recorded_at->format('d M') }}</b></p>@endforeach</div></article>
                    </div>
                </section>

                <section class="section-panel" id="perawatan">
                    <div class="section-head"><div><p class="eyebrow">Maintenance</p><h2>Perawatan</h2></div><button class="primary-button">Tambah Tiket</button></div>
                    <div class="maintenance-board">
                        @foreach (['baru', 'proses', 'selesai'] as $status)
                            <article class="panel">
                                <h3>{{ ucfirst($status) }}</h3>
                                @foreach ($maintenanceTickets->where('status', $status) as $ticket)
                                    <p class="ticket">{{ $ticket->title }} <span>{{ $ticket->room?->code ?? 'Area umum' }} · {{ ucfirst($ticket->priority) }} · {{ $rupiah($ticket->cost) }}</span></p>
                                @endforeach
                            </article>
                        @endforeach
                    </div>
                </section>

                <section class="section-panel" id="laporan">
                    <div class="section-head"><div><p class="eyebrow">Ringkasan bisnis</p><h2>Laporan</h2></div><button class="primary-button">Unduh PDF</button></div>
                    <div class="report-grid">
                        <article class="panel wide"><h3>Keuangan Bulan Ini</h3><div class="finance-line"><span>Pemasukan</span><b>{{ $rupiah($stats['paidThisMonth']) }}</b></div><div class="finance-line"><span>Pengeluaran utilitas dan perawatan</span><b>{{ $rupiah($stats['paidThisMonth'] - $stats['netIncome']) }}</b></div><div class="finance-line"><span>Tunggakan</span><b class="danger-text">{{ $rupiah($stats['arrearsTotal']) }}</b></div><div class="finance-line total"><span>Pemasukan Bersih</span><b>{{ $rupiah($stats['netIncome']) }}</b></div></article>
                        <article class="panel"><h3>Okupansi</h3><strong class="money">{{ $stats['occupancyRate'] }}%</strong><p>{{ $stats['occupiedRooms'] }} dari {{ $stats['totalRooms'] }} kamar terisi.</p></article>
                        <article class="panel"><h3>Perawatan</h3><strong class="money">{{ $maintenanceTickets->count() }} tiket</strong><p>{{ $maintenanceTickets->where('status', 'proses')->count() }} masih berjalan.</p></article>
                    </div>
                </section>

                <section class="section-panel" id="pengaturan">
                    <div class="section-head"><div><p class="eyebrow">Preferensi</p><h2>Pengaturan</h2></div><button class="primary-button">Simpan</button></div>
                    <form class="settings-grid">
                        <label>Nama Kost <input value="{{ $setting?->kost_name ?? 'HighlanderStay Kost' }}"></label>
                        <label>Nomor Admin <input value="{{ $setting?->admin_phone ?? '0812-0000-2026' }}"></label>
                        <label>Jatuh Tempo Default <input type="number" value="{{ $setting?->default_due_day ?? 5 }}"></label>
                        <label>Harga Kamar Standar <input value="{{ $rupiah($setting?->standard_room_rate ?? 1250000) }}"></label>
                        <label class="toggle-row"><span>Pengingat otomatis</span><input type="checkbox" @checked($setting?->auto_reminder ?? true)></label>
                        <label class="toggle-row"><span>Mode ringkas laporan</span><input type="checkbox" @checked($setting?->compact_report ?? false)></label>
                    </form>
                </section>
            </main>
        </div>
    </body>
</html>
