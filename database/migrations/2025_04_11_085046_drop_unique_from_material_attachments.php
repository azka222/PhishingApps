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
      
        
        Schema::table('material_attachments', function (Blueprint $table) {
            $table->string('name')->change(); // Tidak perlu unique(false)
        });
       
        
      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('material_attachments', function (Blueprint $table) {
            //
        });
    }
};
