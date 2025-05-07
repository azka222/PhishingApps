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
        Schema::table('course_quiz_materials', function (Blueprint $table) {
            $table->dropForeign(['material_id']);
            $table->dropForeign(['quiz_id']);
            $table->dropColumn('material_id');
            $table->dropColumn('quiz_id');
            $table->integer('model_id');
            $table->string('model_type');
            $table->integer('order')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_quiz_materials', function (Blueprint $table) {
            $table->dropColumn('model_id');
            $table->dropColumn('model_type');
            $table->dropColumn('order');
            $table->foreignId('material_id')->constrained('materials')->onDelete('cascade');
            $table->foreignId('quiz_id')->constrained('quizzes')->onDelete('cascade');
            $table->integer('order')->default(0);
        });
    }
};
