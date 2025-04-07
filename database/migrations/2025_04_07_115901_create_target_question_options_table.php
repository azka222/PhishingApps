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
        Schema::create('target_question_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('target_id')->constrained('targets')->cascadeOnDelete();
            $table->foreignId('question_option_id')->constrained('question_options')->cascadeOnDelete();
            $table->boolean('passed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target_question_options');
    }
};
