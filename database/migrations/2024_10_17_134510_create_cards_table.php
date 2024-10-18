<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('card');
            $table->integer('status')->default(0); // 1 คือใช้งาน 0 ยังไม่ได้ใช้งาน
            $table->integer('code')->default(0); // 1 คือใช้งาน 0 ยังไม่ได้ใช้งาน
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
