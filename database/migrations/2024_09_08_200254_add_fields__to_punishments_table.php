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
        Schema::table('punishments', function (Blueprint $table) {
            //
            $table->string('type')->nullable();
            $table->string('account_number')->unique();
            $table->string('account_holder_name');
            $table->decimal('balance', 15, 2)->default(0.00);
            $table->decimal('interest_rate', 5, 2)->default(0.00);
            $table->date('opening_date');
            $table->timestamps();
            $table->date("punishimentDate")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('punishments', function (Blueprint $table) {
            //
        });
    }
};
