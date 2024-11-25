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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('num_bill');
            $table->string('fname');
            $table->integer('discount');
            $table->integer('vat7');
            $table->integer('vat3');
            $table->decimal('net',8,2);
            $table->decimal('total',8,2);
            $table->string('payment');
            $table->date('sta_date');
            $table->date('exp_date');
            $table->text('comment');
            $table->string('user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
