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
        Schema::create('shares', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userID');
            $table->float('amount')->nullable();
            $table->date('joining_date')->nullable();
            $table->float('amount_increase')->nullable();
            $table->float('interest_rate')->nullable();
            $table->float("total_share")->nullable();
            $table->foreign('userID')->references('id')->on("users");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shares');
    }
};
