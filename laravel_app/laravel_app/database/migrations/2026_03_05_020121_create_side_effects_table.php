<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('side_effects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained()->onDelete('cascade');
            $table->foreignId('vaccination_schedule_id')->constrained()->onDelete('cascade');
            $table->string('symptom');           // 症状
            $table->date('start_date');          // 開始日
            $table->date('end_date')->nullable(); // 終了日
            $table->text('memo')->nullable();     // メモ
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('side_effects');
    }
};