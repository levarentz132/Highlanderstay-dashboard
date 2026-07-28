<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->unsignedTinyInteger('floor');
            $table->string('type')->default('Standar');
            $table->unsignedInteger('monthly_rate');
            $table->string('status')->default('kosong');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('phone');
            $table->date('move_in_date');
            $table->unsignedInteger('deposit')->default(0);
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->string('period');
            $table->unsignedInteger('amount');
            $table->date('due_date');
            $table->timestamp('paid_at')->nullable();
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('utility_readings', function (Blueprint $table) {
            $table->id();
            $table->string('period');
            $table->unsignedInteger('electricity_kwh');
            $table->unsignedInteger('water_m3');
            $table->unsignedInteger('electricity_cost');
            $table->unsignedInteger('water_cost');
            $table->date('recorded_at');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('maintenance_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('category');
            $table->string('priority')->default('sedang');
            $table->string('status')->default('baru');
            $table->unsignedInteger('cost')->default(0);
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('kost_settings', function (Blueprint $table) {
            $table->id();
            $table->string('kost_name');
            $table->string('admin_phone');
            $table->unsignedTinyInteger('default_due_day')->default(5);
            $table->unsignedInteger('standard_room_rate');
            $table->boolean('auto_reminder')->default(true);
            $table->boolean('compact_report')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kost_settings');
        Schema::dropIfExists('maintenance_tickets');
        Schema::dropIfExists('utility_readings');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('tenants');
        Schema::dropIfExists('rooms');
    }
};
