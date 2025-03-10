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
        Schema::table('course_employees', function (Blueprint $table) {
            $table->json('video_completions')->nullable()->after('is_approved'); // Tambahkan kolom json setelah 'is_approved' (sesuaikan posisi jika perlu)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_employees', function (Blueprint $table) {
            $table->dropColumn('video_completions');
        });
    }
};
