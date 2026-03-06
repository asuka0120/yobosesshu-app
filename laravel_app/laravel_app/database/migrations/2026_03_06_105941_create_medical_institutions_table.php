<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_institutions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');                      // 医療機関名
            $table->string('address')->nullable();       // 住所
            $table->string('phone')->nullable();         // 電話番号
            $table->string('reception_hours')->nullable(); // 受付時間
            $table->text('closed_days')->nullable();     // 休診日
            $table->text('memo')->nullable();            // メモ
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_institutions');
    }
};