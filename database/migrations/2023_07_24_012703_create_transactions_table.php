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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->decimal('value', 10, 2);
            $table->text('description')->nullable();
            $table->timestamp('date');
            $table->unsignedBigInteger('paymentoption_id');
            $table->timestamps();

            $table->foreign('paymentoption_id')
                ->references('id')
                ->on('payment_options')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
