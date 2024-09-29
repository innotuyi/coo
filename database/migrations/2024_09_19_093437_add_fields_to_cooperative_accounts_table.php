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
        Schema::table('cooperative_accounts', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cooperative_accounts', function (Blueprint $table) {
            $table->string('bankname')->nullable()->after('interest_rate');
            $table->text('comment')->nullable()->after('bankname');
            $table->string('attachment')->nullable()->after('comment');
        });
    }
};
