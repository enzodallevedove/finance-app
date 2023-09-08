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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->float('value');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('paymentoption_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('paymentoption_id')
                ->references('id')
                ->on('payment_options')
                ->onDelete('set null');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
