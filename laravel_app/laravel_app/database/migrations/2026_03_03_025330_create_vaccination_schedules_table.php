<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vaccination_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained()->onDelete('cascade');
            $table->foreignId('vaccine_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'completed', 'scheduled'])->default('pending'); // 未接種・接種済・次回予定
            $table->date('scheduled_date')->nullable();  // 次回予定日
            $table->date('vaccinated_date')->nullable(); // 接種済み日
            $table->text('memo')->nullable();            // メモ
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vaccination_schedules');
    }
};