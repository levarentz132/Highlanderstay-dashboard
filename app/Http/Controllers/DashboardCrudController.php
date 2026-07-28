<?php

namespace App\Http\Controllers;

use App\Models\KostSetting;
use App\Models\MaintenanceTicket;
use App\Models\Payment;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\UtilityReading;
use Illuminate\Http\Request;

class DashboardCrudController extends Controller
{
    public function storeRoom(Request $request)
    {
        Room::create($this->roomData($request));

        return back()->with('status', 'Kamar berhasil ditambahkan.');
    }

    public function updateRoom(Request $request, Room $room)
    {
        $room->update($this->roomData($request, $room->id));

        return back()->with('status', 'Kamar berhasil diperbarui.');
    }

    public function destroyRoom(Room $room)
    {
        $room->delete();

        return back()->with('status', 'Kamar berhasil dihapus.');
    }

    public function storeTenant(Request $request)
    {
        Tenant::create($this->tenantData($request));
        Room::whereKey($request->room_id)->update(['status' => 'terisi']);

        return back()->with('status', 'Penyewa berhasil ditambahkan.');
    }

    public function updateTenant(Request $request, Tenant $tenant)
    {
        $oldRoomId = $tenant->room_id;
        $tenant->update($this->tenantData($request));

        Room::whereKey($tenant->room_id)->update(['status' => $tenant->status === 'active' ? 'terisi' : 'kosong']);
        if ((int) $oldRoomId !== (int) $tenant->room_id && ! Tenant::where('room_id', $oldRoomId)->where('status', 'active')->exists()) {
            Room::whereKey($oldRoomId)->update(['status' => 'kosong']);
        }

        return back()->with('status', 'Penyewa berhasil diperbarui.');
    }

    public function destroyTenant(Tenant $tenant)
    {
        $roomId = $tenant->room_id;
        $tenant->delete();

        if (! Tenant::where('room_id', $roomId)->where('status', 'active')->exists()) {
            Room::whereKey($roomId)->update(['status' => 'kosong']);
        }

        return back()->with('status', 'Penyewa berhasil dihapus.');
    }

    public function storePayment(Request $request)
    {
        Payment::create($this->paymentData($request));

        return back()->with('status', 'Pembayaran berhasil ditambahkan.');
    }

    public function updatePayment(Request $request, Payment $payment)
    {
        $payment->update($this->paymentData($request));

        return back()->with('status', 'Pembayaran berhasil diperbarui.');
    }

    public function destroyPayment(Payment $payment)
    {
        $payment->delete();

        return back()->with('status', 'Pembayaran berhasil dihapus.');
    }

    public function storeUtility(Request $request)
    {
        UtilityReading::create($this->utilityData($request));

        return back()->with('status', 'Catatan listrik dan air berhasil ditambahkan.');
    }

    public function updateUtility(Request $request, UtilityReading $utilityReading)
    {
        $utilityReading->update($this->utilityData($request));

        return back()->with('status', 'Catatan listrik dan air berhasil diperbarui.');
    }

    public function destroyUtility(UtilityReading $utilityReading)
    {
        $utilityReading->delete();

        return back()->with('status', 'Catatan listrik dan air berhasil dihapus.');
    }

    public function storeMaintenance(Request $request)
    {
        MaintenanceTicket::create($this->maintenanceData($request));

        return back()->with('status', 'Tiket perawatan berhasil ditambahkan.');
    }

    public function updateMaintenance(Request $request, MaintenanceTicket $maintenanceTicket)
    {
        $maintenanceTicket->update($this->maintenanceData($request));

        return back()->with('status', 'Tiket perawatan berhasil diperbarui.');
    }

    public function destroyMaintenance(MaintenanceTicket $maintenanceTicket)
    {
        $maintenanceTicket->delete();

        return back()->with('status', 'Tiket perawatan berhasil dihapus.');
    }

    public function updateSettings(Request $request)
    {
        KostSetting::query()->updateOrCreate(['id' => KostSetting::query()->value('id')], $request->validate([
            'kost_name' => ['required', 'string', 'max:255'],
            'admin_phone' => ['required', 'string', 'max:50'],
            'default_due_day' => ['required', 'integer', 'min:1', 'max:31'],
            'standard_room_rate' => ['required', 'integer', 'min:0'],
            'auto_reminder' => ['nullable', 'boolean'],
            'compact_report' => ['nullable', 'boolean'],
        ]) + [
            'auto_reminder' => $request->boolean('auto_reminder'),
            'compact_report' => $request->boolean('compact_report'),
        ]);

        return back()->with('status', 'Pengaturan berhasil disimpan.');
    }

    private function roomData(Request $request, $ignoreId = null)
    {
        return $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:rooms,code,'.$ignoreId],
            'floor' => ['required', 'integer', 'min:1', 'max:50'],
            'type' => ['required', 'string', 'max:100'],
            'monthly_rate' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:terisi,kosong,perawatan'],
            'notes' => ['nullable', 'string'],
        ]);
    }

    private function tenantData(Request $request)
    {
        return $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'move_in_date' => ['required', 'date'],
            'deposit' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
        ]);
    }

    private function paymentData(Request $request)
    {
        $data = $request->validate([
            'tenant_id' => ['required', 'exists:tenants,id'],
            'period' => ['required', 'string', 'max:100'],
            'amount' => ['required', 'integer', 'min:0'],
            'due_date' => ['required', 'date'],
            'paid_at' => ['nullable', 'date'],
            'status' => ['required', 'in:paid,pending,overdue'],
            'notes' => ['nullable', 'string'],
        ]);

        $tenant = Tenant::findOrFail($data['tenant_id']);
        $data['room_id'] = $tenant->room_id;

        return $data;
    }

    private function utilityData(Request $request)
    {
        return $request->validate([
            'period' => ['required', 'string', 'max:100'],
            'electricity_kwh' => ['required', 'integer', 'min:0'],
            'water_m3' => ['required', 'integer', 'min:0'],
            'electricity_cost' => ['required', 'integer', 'min:0'],
            'water_cost' => ['required', 'integer', 'min:0'],
            'recorded_at' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ]);
    }

    private function maintenanceData(Request $request)
    {
        return $request->validate([
            'room_id' => ['nullable', 'exists:rooms,id'],
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'priority' => ['required', 'in:rendah,sedang,tinggi'],
            'status' => ['required', 'in:baru,proses,selesai'],
            'cost' => ['required', 'integer', 'min:0'],
            'scheduled_at' => ['nullable', 'date'],
            'completed_at' => ['nullable', 'date'],
        ]);
    }
}
