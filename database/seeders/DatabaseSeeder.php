<?php

namespace Database\Seeders;

use App\Models\KostSetting;
use App\Models\MaintenanceTicket;
use App\Models\Payment;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\UtilityReading;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $rooms = collect([
            ['code' => 'A-101', 'floor' => 1, 'type' => 'Standar', 'monthly_rate' => 1250000, 'status' => 'terisi', 'notes' => 'Dekat tangga utama'],
            ['code' => 'A-102', 'floor' => 1, 'type' => 'Standar', 'monthly_rate' => 1250000, 'status' => 'terisi', 'notes' => 'Sirkulasi udara bagus'],
            ['code' => 'A-103', 'floor' => 1, 'type' => 'Standar', 'monthly_rate' => 1250000, 'status' => 'kosong', 'notes' => 'Siap huni'],
            ['code' => 'A-104', 'floor' => 1, 'type' => 'Ekonomi', 'monthly_rate' => 850000, 'status' => 'terisi', 'notes' => 'Perlu cek pintu kamar mandi'],
            ['code' => 'B-201', 'floor' => 2, 'type' => 'Premium', 'monthly_rate' => 1450000, 'status' => 'terisi', 'notes' => 'Kontrak sampai Desember'],
            ['code' => 'B-202', 'floor' => 2, 'type' => 'Premium', 'monthly_rate' => 1450000, 'status' => 'perawatan', 'notes' => 'Pompa air sedang diperbaiki'],
            ['code' => 'B-203', 'floor' => 2, 'type' => 'Premium', 'monthly_rate' => 1450000, 'status' => 'kosong', 'notes' => 'Butuh cek AC'],
            ['code' => 'B-204', 'floor' => 2, 'type' => 'Premium', 'monthly_rate' => 1450000, 'status' => 'terisi', 'notes' => 'Deposit lengkap'],
            ['code' => 'B-205', 'floor' => 2, 'type' => 'Premium', 'monthly_rate' => 1450000, 'status' => 'terisi', 'notes' => 'Follow-up pembayaran'],
            ['code' => 'C-301', 'floor' => 3, 'type' => 'Standar', 'monthly_rate' => 1200000, 'status' => 'terisi', 'notes' => 'Menghadap halaman'],
            ['code' => 'C-302', 'floor' => 3, 'type' => 'Standar', 'monthly_rate' => 1200000, 'status' => 'terisi', 'notes' => 'Meter air perlu dicek'],
            ['code' => 'C-303', 'floor' => 3, 'type' => 'Standar', 'monthly_rate' => 1200000, 'status' => 'kosong', 'notes' => 'Baru dicat'],
        ])->map(fn (array $room) => Room::create($room));

        $tenantRows = [
            ['room' => 'A-101', 'name' => 'Penyewa A', 'phone' => '0812-1100-2101', 'move_in_date' => '2026-01-12', 'deposit' => 1250000, 'status' => 'active'],
            ['room' => 'A-102', 'name' => 'Penyewa B', 'phone' => '0812-1100-2102', 'move_in_date' => '2026-02-03', 'deposit' => 1250000, 'status' => 'active'],
            ['room' => 'A-104', 'name' => 'Penyewa G', 'phone' => '0812-1100-2104', 'move_in_date' => '2026-06-18', 'deposit' => 850000, 'status' => 'active'],
            ['room' => 'B-201', 'name' => 'Penyewa E', 'phone' => '0812-1100-2201', 'move_in_date' => '2026-05-05', 'deposit' => 1450000, 'status' => 'active'],
            ['room' => 'B-204', 'name' => 'Penyewa D', 'phone' => '0812-1100-2204', 'move_in_date' => '2026-04-21', 'deposit' => 1450000, 'status' => 'active'],
            ['room' => 'B-205', 'name' => 'Penyewa C', 'phone' => '0812-1100-2205', 'move_in_date' => '2026-03-08', 'deposit' => 1450000, 'status' => 'active'],
            ['room' => 'C-301', 'name' => 'Penyewa H', 'phone' => '0812-1100-2301', 'move_in_date' => '2026-07-01', 'deposit' => 1200000, 'status' => 'active'],
            ['room' => 'C-302', 'name' => 'Penyewa K', 'phone' => '0812-1100-2302', 'move_in_date' => '2026-07-08', 'deposit' => 1200000, 'status' => 'active'],
        ];

        $tenants = collect($tenantRows)->map(function (array $tenant) {
            $room = Room::where('code', $tenant['room'])->firstOrFail();
            unset($tenant['room']);

            $tenant['room_id'] = $room->id;

            return Tenant::create($tenant);
        });

        foreach (range(5, 0) as $monthsAgo) {
            $periodDate = Carbon::now()->subMonths($monthsAgo);

            $tenants->each(function (Tenant $tenant, int $index) use ($periodDate, $monthsAgo) {
                $isCurrentMonth = $monthsAgo === 0;
                $isOverdue = $isCurrentMonth && in_array($tenant->room->code, ['B-205', 'A-104', 'C-302'], true);
                $dueDate = $isOverdue ? now()->subDays([13, 8, 3][$index % 3]) : $periodDate->copy()->day(5);

                Payment::create([
                    'tenant_id' => $tenant->id,
                    'room_id' => $tenant->room_id,
                    'period' => $periodDate->translatedFormat('F Y'),
                    'amount' => $tenant->room->monthly_rate,
                    'due_date' => $dueDate,
                    'paid_at' => $isOverdue ? null : $periodDate->copy()->day(rand(2, 6))->hour(9 + ($index % 5)),
                    'status' => $isOverdue ? 'overdue' : 'paid',
                    'notes' => $isOverdue ? 'Belum ada konfirmasi pembayaran' : 'Pembayaran diterima',
                ]);
            });
        }

        Payment::whereHas('room', fn ($query) => $query->whereIn('code', ['A-101', 'B-201']))
            ->where('period', now()->translatedFormat('F Y'))
            ->update(['status' => 'pending', 'paid_at' => null, 'due_date' => now()->addDays(4)]);

        UtilityReading::create([
            'period' => now()->translatedFormat('F Y'),
            'electricity_kwh' => 1250,
            'water_m3' => 45,
            'electricity_cost' => 3120000,
            'water_cost' => 820000,
            'recorded_at' => now()->subDay(),
            'notes' => 'Catat meter rutin bulanan',
        ]);

        UtilityReading::create([
            'period' => now()->subMonth()->translatedFormat('F Y'),
            'electricity_kwh' => 1360,
            'water_m3' => 43,
            'electricity_cost' => 3340000,
            'water_cost' => 770000,
            'recorded_at' => now()->subMonth()->day(28),
            'notes' => 'Baseline bulan sebelumnya',
        ]);

        collect([
            ['room' => 'B-203', 'title' => 'AC kurang dingin', 'category' => 'AC', 'priority' => 'sedang', 'status' => 'baru', 'cost' => 0, 'scheduled_at' => now()->addDay()],
            ['room' => 'A-103', 'title' => 'Kunci pintu macet', 'category' => 'Kunci', 'priority' => 'rendah', 'status' => 'baru', 'cost' => 0, 'scheduled_at' => now()->addDays(2)],
            ['room' => 'B-202', 'title' => 'Pompa air tidak stabil', 'category' => 'Air', 'priority' => 'tinggi', 'status' => 'proses', 'cost' => 950000, 'scheduled_at' => now()->hour(15)],
            ['room' => null, 'title' => 'Ganti lampu koridor lantai 2', 'category' => 'Listrik', 'priority' => 'rendah', 'status' => 'selesai', 'cost' => 180000, 'completed_at' => now()->subDays(2)],
            ['room' => 'B-204', 'title' => 'Perbaikan keran air', 'category' => 'Air', 'priority' => 'sedang', 'status' => 'selesai', 'cost' => 220000, 'completed_at' => now()->subDays(1)],
        ])->each(function (array $ticket) {
            $roomCode = $ticket['room'];
            unset($ticket['room']);

            $ticket['room_id'] = $roomCode ? Room::where('code', $roomCode)->value('id') : null;

            MaintenanceTicket::create($ticket);
        });

        KostSetting::create([
            'kost_name' => 'HighlanderStay Kost',
            'admin_phone' => '0812-0000-2026',
            'default_due_day' => 5,
            'standard_room_rate' => 1250000,
            'auto_reminder' => true,
            'compact_report' => false,
        ]);
    }
}
