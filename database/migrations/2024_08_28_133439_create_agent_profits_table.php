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
        Schema::create('agent_profits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agent_id');  // Foreign key linking to the agents table
            $table->decimal('profit', 10, 2);        // Profit amount
            $table->string('month');                 // Month for which the profit is being recorded (e.g., "August 2024")            // Foreign key constraint
            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_profits');
    }
};
