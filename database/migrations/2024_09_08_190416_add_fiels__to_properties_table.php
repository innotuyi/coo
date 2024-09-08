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
        Schema::table('properties', function (Blueprint $table) {
            //
            $table->string('property_file')->nullable(); // Field for property file
            $table->string('property_value')->nullable(); // Field for property value
            $table->string('property_attachment')->nullable(); // Field for property attachment
            $table->date('property_date')->nullable(); // Field for property date
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            //
        });
    }
};
