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
            $table->string('ref_code');
            $table->string('num_bill');
            $table->string('fname');
            $table->integer('discount');
            $table->decimal('price',8,2);
            $table->integer('vat7');
            $table->integer('vat3');
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
