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
        Schema::create('cooperative_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('account_number')->unique();
            $table->string('account_holder_name');
            $table->decimal('balance', 15, 2)->default(0.00);
            $table->decimal('interest_rate', 5, 2)->default(0.00);
            $table->date('opening_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cooperative_accounts');
    }
};
