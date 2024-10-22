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
        Schema::create('card_records', function (Blueprint $table) {
            $table->id();
            $table->string('card');
            $table->decimal('price',8,2);
            $table->integer('discount');
            $table->string('payment');
            $table->date('date_expiry');
            $table->text('comment');
            $table->decimal('total',8,2);
            $table->integer('status')->default(0);
            $table->string('method');
            $table->string('user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_records');
    }
};
