<?php

use App\Models\guardian;
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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('guardID');
            $table->string('phone', 10); // Phone number stored as a string with a max length of 10
            $table->string('idcard', 16); // ID card number stored as a string with a max length of 16
            $table->string('district');
            $table->string('sector');
            $table->foreign('guardID')->references('id')->on("guardians");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
