<?php

use App\Models\Target;
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
        Schema::table('targets', function (Blueprint $table) {
            $table->integer('age')->nullable();

        });

        Target::where('age', null)->update(['age' => 20]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('targets', function (Blueprint $table) {
            //
        });
    }
};
