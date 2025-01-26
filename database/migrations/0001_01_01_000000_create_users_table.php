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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('occupation')->nullable(); // Bisa null
            $table->string('avatar')->nullable(); // Bisa null
            $table->string('nik')->unique()->nullable(); // Kolom baru, unique, bisa null
            $table->string('gender')->nullable(); // Kolom baru, bisa null
            $table->date('date_of_birth')->nullable(); // Kolom baru, bisa null
            $table->text('address')->nullable(); // Kolom baru, bisa null
            $table->string('phone_number')->nullable(); // Kolom baru, bisa null
            $table->string('division')->nullable(); // Kolom baru, bisa null
            $table->string('position')->nullable(); // Kolom baru, bisa null
            $table->string('employment_status')->nullable(); // Kolom baru, bisa null
            $table->date('join_date')->nullable(); // Kolom baru, bisa null
            $table->boolean('is_active')->default(false);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
