<?php
    $rupiah = fn ($value) => 'Rp ' . number_format($value, 0, ',', '.');
    $latestUtility = $utilityReadings->first();
    $paidPayments = $payments->where('status', 'paid')->take(5);
    $overduePayments = $payments->where('status', 'overdue');
    $pendingPayments = $payments->where('status', 'pending');
?>

<!doctype html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo e($setting->kost_name ?? 'KosCerdas'); ?> - Dashboard</title>
        <meta name="description" content="Dashboard Laravel untuk mengelola kamar, penyewa, tunggakan, listrik dan air, perawatan, laporan, dan pengaturan kost.">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo e(asset('build/assets/app-DI0RJGoj.css')); ?>">
        <script type="module" src="<?php echo e(asset('build/assets/app-B1A_BR5W.js')); ?>" defer></script>
    </head>
    <body>
        <div class="app-shell">
            <aside class="sidebar" aria-label="Navigasi utama">
                <div class="brand">
                    <div class="brand-mark">K</div>
                    <div>
                        <strong>KosCerdas</strong>
                        <span><?php echo e($setting->kost_name ?? 'Kelola kost2an'); ?></span>
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
                            <p class="eyebrow"><?php echo e($setting->kost_name ?? 'Kost'); ?></p>
                            <h2>Operasional kost yang rapi dari kamar sampai laporan.</h2>
                        </div>
                        <div class="hero-date"><?php echo e($today); ?></div>
                    </div>

                    <div class="metric-grid">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.metric','data' => ['label' => 'Total Kamar','value' => $stats['totalRooms'],'note' => 'Semua unit terdata','tone' => 'teal']]); ?>
<?php $component->withName('metric'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Total Kamar','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['totalRooms']),'note' => 'Semua unit terdata','tone' => 'teal']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.metric','data' => ['label' => 'Terisi','value' => $stats['occupiedRooms'],'note' => $stats['occupancyRate'] . '% okupansi','tone' => 'green']]); ?>
<?php $component->withName('metric'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Terisi','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['occupiedRooms']),'note' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['occupancyRate'] . '% okupansi'),'tone' => 'green']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.metric','data' => ['label' => 'Kosong','value' => $stats['emptyRooms'],'note' => 'Siap ditawarkan','tone' => 'amber']]); ?>
<?php $component->withName('metric'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Kosong','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['emptyRooms']),'note' => 'Siap ditawarkan','tone' => 'amber']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.metric','data' => ['label' => 'Tunggakan','value' => $stats['arrearsCount'],'note' => 'Butuh follow-up','tone' => 'red']]); ?>
<?php $component->withName('metric'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Tunggakan','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['arrearsCount']),'note' => 'Butuh follow-up','tone' => 'red']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>

                    <div class="dashboard-grid">
                        <article class="panel wide">
                            <div class="panel-head">
                                <div>
                                    <h3>Pemasukan 6 Bulan Terakhir</h3>
                                    <p>Realisasi pembayaran dari tabel payments</p>
                                </div>
                                <span class="tag success"><?php echo e($rupiah($stats['paidThisMonth'])); ?></span>
                            </div>
                            <div class="chart-bars">
                                <?php $__currentLoopData = $lastSixMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span style="height: <?php echo e(max(12, round(($month['total'] / $maxIncome) * 92))); ?>%">
                                        <b><?php echo e($month['label']); ?></b>
                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </article>

                        <article class="panel">
                            <div class="panel-head">
                                <h3>Status Kamar</h3>
                                <span class="tag"><?php echo e($stats['totalRooms']); ?> total</span>
                            </div>
                            <div class="donut-wrap">
                                <div class="donut" style="--occupied: <?php echo e($stats['occupancyRate']); ?>%"><span><?php echo e($stats['occupancyRate']); ?>%</span></div>
                                <ul class="legend">
                                    <li><i class="green-dot"></i><?php echo e($stats['occupiedRooms']); ?> terisi</li>
                                    <li><i class="amber-dot"></i><?php echo e($stats['emptyRooms']); ?> kosong</li>
                                    <li><i class="red-dot"></i><?php echo e($stats['maintenanceRooms']); ?> perawatan</li>
                                </ul>
                            </div>
                        </article>

                        <article class="panel">
                            <div class="panel-head">
                                <h3>Jadwal Pembayaran</h3>
                                <span class="tag warning"><?php echo e($stats['upcomingDue']); ?> dekat tempo</span>
                            </div>
                            <div class="calendar">
                                <?php $__currentLoopData = ['Sen','Sel','Rab','Kam','Jum','Sab','Min']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span><?php echo e($day); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php for($day = 1; $day <= 21; $day++): ?>
                                    <button class="<?php echo e(in_array($day, [4, 9, 13, 21], true) ? 'due' : ''); ?>"><?php echo e($day); ?></button>
                                <?php endfor; ?>
                            </div>
                        </article>

                        <article class="panel wide">
                            <div class="panel-head">
                                <h3>Aktivitas Terbaru</h3>
                                <button class="text-button">Lihat semua</button>
                            </div>
                            <div class="activity-list">
                                <?php $__currentLoopData = $paidPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <p><span class="check">✓</span><?php echo e($payment->tenant->name); ?> membayar kamar <?php echo e($payment->room->code); ?> <b><?php echo e(optional($payment->paid_at)->format('d M, H:i')); ?></b></p>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php $__currentLoopData = $maintenanceTickets->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <p><span class="tool">↗</span><?php echo e($ticket->title); ?> <?php echo e($ticket->room ? '- ' . $ticket->room->code : ''); ?> <b><?php echo e(ucfirst($ticket->status)); ?></b></p>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                        <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <article class="room-card">
                                <strong><?php echo e($room->code); ?></strong>
                                <span class="tag <?php echo e($room->status === 'terisi' ? 'success' : ($room->status === 'kosong' ? 'warning' : 'danger')); ?>"><?php echo e(ucfirst($room->status)); ?></span>
                                <p><?php echo e($room->tenant?->name ?? 'Belum ada penyewa'); ?> · <?php echo e($rupiah($room->monthly_rate)); ?></p>
                                <small><?php echo e($room->notes); ?></small>
                            </article>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </section>

                <section class="section-panel" id="penyewa">
                    <div class="section-head"><div><p class="eyebrow">Data penghuni</p><h2>Penyewa</h2></div><button class="primary-button">Tambah Penyewa</button></div>
                    <div class="table-card">
                        <table>
                            <thead><tr><th>Nama</th><th>Kamar</th><th>Kontak</th><th>Mulai Sewa</th><th>Status</th></tr></thead>
                            <tbody>
                                <?php $__currentLoopData = $tenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tenant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($tenant->name); ?></td>
                                        <td><?php echo e($tenant->room->code); ?></td>
                                        <td><?php echo e($tenant->phone); ?></td>
                                        <td><?php echo e($tenant->move_in_date->format('d M Y')); ?></td>
                                        <td><span class="tag <?php echo e($tenant->status === 'active' ? 'success' : 'danger'); ?>"><?php echo e(ucfirst($tenant->status)); ?></span></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="section-panel" id="tunggakan">
                    <div class="section-head"><div><p class="eyebrow">Penagihan</p><h2>Tunggakan</h2></div><button class="primary-button">Kirim Pengingat</button></div>
                    <div class="collection-grid">
                        <article class="panel"><h3>Total Tertunda</h3><strong class="money danger-text"><?php echo e($rupiah($stats['arrearsTotal'])); ?></strong><p><?php echo e($stats['arrearsCount']); ?> penyewa perlu follow-up.</p></article>
                        <article class="panel"><h3>Umur Tunggakan</h3><div class="stack-list"><p>1-30 hari <b><?php echo e($overduePayments->filter(fn ($payment) => $payment->due_date->diffInDays(now()) <= 30)->count()); ?></b></p><p>31-60 hari <b><?php echo e($overduePayments->filter(fn ($payment) => $payment->due_date->diffInDays(now()) > 30 && $payment->due_date->diffInDays(now()) <= 60)->count()); ?></b></p><p>&gt; 60 hari <b><?php echo e($overduePayments->filter(fn ($payment) => $payment->due_date->diffInDays(now()) > 60)->count()); ?></b></p></div></article>
                        <article class="panel wide"><h3>Daftar Prioritas</h3><div class="activity-list"><?php $__currentLoopData = $overduePayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p><span class="warn">!</span><?php echo e($payment->room->code); ?> · <?php echo e($payment->tenant->name); ?> · <?php echo e($rupiah($payment->amount)); ?> <b><?php echo e(round($payment->due_date->diffInDays(now()))); ?> hari</b></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div></article>
                    </div>
                </section>

                <section class="section-panel" id="listrik-air">
                    <div class="section-head"><div><p class="eyebrow">Utilitas</p><h2>Listrik & Air</h2></div><button class="primary-button">Catat Meter</button></div>
                    <div class="utility-grid">
                        <article class="panel"><h3>Listrik Bulan Ini</h3><strong class="money"><?php echo e(number_format($latestUtility?->electricity_kwh ?? 0, 0, ',', '.')); ?> kWh</strong><div class="progress"><span style="width: 68%"></span></div><p><?php echo e($rupiah($latestUtility?->electricity_cost ?? 0)); ?></p></article>
                        <article class="panel"><h3>Air Bulan Ini</h3><strong class="money"><?php echo e(number_format($latestUtility?->water_m3 ?? 0, 0, ',', '.')); ?> m3</strong><div class="progress blue"><span style="width: 54%"></span></div><p><?php echo e($rupiah($latestUtility?->water_cost ?? 0)); ?></p></article>
                        <article class="panel wide"><h3>Catatan Pencatatan</h3><div class="activity-list"><?php $__currentLoopData = $utilityReadings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reading): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p><span class="drop">●</span><?php echo e($reading->period); ?> · <?php echo e($reading->notes); ?> <b><?php echo e($reading->recorded_at->format('d M')); ?></b></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div></article>
                    </div>
                </section>

                <section class="section-panel" id="perawatan">
                    <div class="section-head"><div><p class="eyebrow">Maintenance</p><h2>Perawatan</h2></div><button class="primary-button">Tambah Tiket</button></div>
                    <div class="maintenance-board">
                        <?php $__currentLoopData = ['baru', 'proses', 'selesai']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <article class="panel">
                                <h3><?php echo e(ucfirst($status)); ?></h3>
                                <?php $__currentLoopData = $maintenanceTickets->where('status', $status); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <p class="ticket"><?php echo e($ticket->title); ?> <span><?php echo e($ticket->room?->code ?? 'Area umum'); ?> · <?php echo e(ucfirst($ticket->priority)); ?> · <?php echo e($rupiah($ticket->cost)); ?></span></p>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </article>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </section>

                <section class="section-panel" id="laporan">
                    <div class="section-head"><div><p class="eyebrow">Ringkasan bisnis</p><h2>Laporan</h2></div><button class="primary-button">Unduh PDF</button></div>
                    <div class="report-grid">
                        <article class="panel wide"><h3>Keuangan Bulan Ini</h3><div class="finance-line"><span>Pemasukan</span><b><?php echo e($rupiah($stats['paidThisMonth'])); ?></b></div><div class="finance-line"><span>Pengeluaran utilitas dan perawatan</span><b><?php echo e($rupiah($stats['paidThisMonth'] - $stats['netIncome'])); ?></b></div><div class="finance-line"><span>Tunggakan</span><b class="danger-text"><?php echo e($rupiah($stats['arrearsTotal'])); ?></b></div><div class="finance-line total"><span>Pemasukan Bersih</span><b><?php echo e($rupiah($stats['netIncome'])); ?></b></div></article>
                        <article class="panel"><h3>Okupansi</h3><strong class="money"><?php echo e($stats['occupancyRate']); ?>%</strong><p><?php echo e($stats['occupiedRooms']); ?> dari <?php echo e($stats['totalRooms']); ?> kamar terisi.</p></article>
                        <article class="panel"><h3>Perawatan</h3><strong class="money"><?php echo e($maintenanceTickets->count()); ?> tiket</strong><p><?php echo e($maintenanceTickets->where('status', 'proses')->count()); ?> masih berjalan.</p></article>
                    </div>
                </section>

                <section class="section-panel" id="pengaturan">
                    <div class="section-head"><div><p class="eyebrow">Preferensi</p><h2>Pengaturan</h2></div><button class="primary-button">Simpan</button></div>
                    <form class="settings-grid">
                        <label>Nama Kost <input value="<?php echo e($setting?->kost_name ?? 'HighlanderStay Kost'); ?>"></label>
                        <label>Nomor Admin <input value="<?php echo e($setting?->admin_phone ?? '0812-0000-2026'); ?>"></label>
                        <label>Jatuh Tempo Default <input type="number" value="<?php echo e($setting?->default_due_day ?? 5); ?>"></label>
                        <label>Harga Kamar Standar <input value="<?php echo e($rupiah($setting?->standard_room_rate ?? 1250000)); ?>"></label>
                        <label class="toggle-row"><span>Pengingat otomatis</span><input type="checkbox" @checked($setting?->auto_reminder ?? true)></label>
                        <label class="toggle-row"><span>Mode ringkas laporan</span><input type="checkbox" @checked($setting?->compact_report ?? false)></label>
                    </form>
                </section>
            </main>
        </div>
    </body>
</html>
<?php /**PATH C:\xampp\htdocs\Highlanderstay dashboard\resources\views/dashboard.blade.php ENDPATH**/ ?>