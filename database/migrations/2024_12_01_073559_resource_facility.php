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
        Schema::create('resource_facility', function(Blueprint $table){
            $table->id();
            $table->bigInteger('resource_id')->nullable();
            $table->bigInteger('resource_detail_id')->nullable();
            $table->string(column: 'fasilitas_name')->nullable();
            $table->string(column: 'ket_fasilitas')->nullable();
            
            $table->timestamp('created_date')->nullable();
            $table->bigInteger(column: 'created_id')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamp(column: 'updated_date')->nullable();
            $table->bigInteger(column: 'updated_id')->nullable();
            $table->string('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource_facility');
    }
};
