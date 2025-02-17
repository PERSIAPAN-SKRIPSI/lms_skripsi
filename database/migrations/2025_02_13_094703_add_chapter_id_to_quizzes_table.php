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
        Schema::table('quizzes', function (Blueprint $table) {
            //
            $table->foreignId('chapter_id')->after('id')->constrained()->onDelete('cascade'); //->default(1) untuk menghindari null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            //
            $table->dropForeign(['chapter_id']);
            $table->dropColumn('chapter_id');
        });
    }
};
