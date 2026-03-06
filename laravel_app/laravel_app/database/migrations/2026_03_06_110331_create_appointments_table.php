<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained()->onDelete('cascade');
            $table->foreignId('medical_institution_id')->constrained()->onDelete('cascade');
            $table->foreignId('vaccination_schedule_id')->nullable()->constrained()->onDelete('set null');
            $table->date('appointment_date');            // 予約日
            $table->time('appointment_time')->nullable(); // 予約時間
            $table->text('memo')->nullable();            // 予約メモ
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};