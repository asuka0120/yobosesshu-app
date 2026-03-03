<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vaccines', function (Blueprint $table) {
            $table->id();
            $table->string('name');                    // ワクチン名
            $table->enum('type', ['regular', 'optional']); // 定期・任意
            $table->text('description')->nullable();   // 説明
            $table->text('reason')->nullable();        // なぜ必要か
            $table->integer('recommended_months');     // 推奨接種月齢
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vaccines');
    }
};