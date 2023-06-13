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
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('id');
            $table->string('display_name')->nullable()->after('name');
            $table->string('phone', 20)->nullable()->after('email_verified_at');
            $table->string('mobile', 20)->nullable()->after('phone');
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable()->after('mobile');
            $table->date('date_of_birth')->nullable()->after('gender');
            $table->string('address_line_one')->nullable()->after('date_of_birth');
            $table->string('address_line_two')->nullable()->after('address_line_one');
            $table->string('city', 100)->nullable()->after('address_line_two');
            $table->string('state', 100)->nullable()->after('city');
            $table->string('country', 100)->nullable()->after('state');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
