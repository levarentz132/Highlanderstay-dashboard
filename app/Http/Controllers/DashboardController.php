<?php

namespace App\Http\Controllers;

use App\Models\KostSetting;
use App\Models\MaintenanceTicket;
use App\Models\Payment;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\UtilityReading;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $rooms = Room::with('tenant')->orderBy('code')->get();
        $tenants = Tenant::with('room')->orderBy('name')->get();
        $payments = Payment::with(['tenant', 'room'])->latest('due_date')->get();
        $maintenanceTickets = MaintenanceTicket::with('room')->latest()->get();
        $utilityReadings = UtilityReading::latest('recorded_at')->get();
        $setting = KostSetting::first();

        $paidThisMonth = $payments
            ->where('status', 'paid')
            ->filter(fn (Payment $payment) => $payment->paid_at?->isSameMonth(now()))
            ->sum('amount');

        $arrears = $payments->where('status', 'overdue');
        $lastSixMonths = collect(range(5, 0))->map(function (int $monthsAgo) use ($payments) {
            $date = now()->subMonths($monthsAgo);

            return [
                'label' => $date->translatedFormat('M'),
                'total' => $payments
                    ->where('status', 'paid')
                    ->filter(fn (Payment $payment) => $payment->paid_at?->isSameMonth($date))
                    ->sum('amount'),
            ];
        });

        $maxIncome = max($lastSixMonths->max('total'), 1);

        return view('dashboard', [
            'rooms' => $rooms,
            'tenants' => $tenants,
            'payments' => $payments,
            'maintenanceTickets' => $maintenanceTickets,
            'utilityReadings' => $utilityReadings,
            'setting' => $setting,
            'stats' => [
                'totalRooms' => $rooms->count(),
                'occupiedRooms' => $rooms->where('status', 'terisi')->count(),
                'emptyRooms' => $rooms->where('status', 'kosong')->count(),
                'maintenanceRooms' => $rooms->where('status', 'perawatan')->count(),
                'occupancyRate' => $rooms->count() ? round(($rooms->where('status', 'terisi')->count() / $rooms->count()) * 100) : 0,
                'paidThisMonth' => $paidThisMonth,
                'arrearsTotal' => $arrears->sum('amount'),
                'arrearsCount' => $arrears->count(),
                'upcomingDue' => $payments->where('status', 'pending')->filter(fn (Payment $payment) => $payment->due_date->between(now(), now()->addDays(7)))->count(),
                'netIncome' => $paidThisMonth - $maintenanceTickets->sum('cost') - $utilityReadings->take(1)->sum(fn (UtilityReading $reading) => $reading->electricity_cost + $reading->water_cost),
            ],
            'lastSixMonths' => $lastSixMonths,
            'maxIncome' => $maxIncome,
            'today' => Carbon::now()->translatedFormat('d M Y'),
        ]);
    }
}
