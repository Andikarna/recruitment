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
        Schema::create('resource_detail', callback: function (Blueprint $table) {
            $table->id();
            $table->bigInteger(column: 'resource_id')->nullable();
            $table->string(column: 'position')->nullable();
            $table->string(column: 'skill')->nullable();
            $table->string(column: 'quantity')->nullable();
            $table->string(column: 'education')->nullable();
            $table->string(column: 'qualification')->nullable();
            $table->string(column: 'experience')->nullable();
            $table->string(column: 'contract')->nullable();
            $table->string(column: 'description')->nullable();
            $table->timestamp(column: 'created_date')->nullable();
            $table->string(column: 'created_by')->nullable();
            $table->bigInteger(column: 'created_id')->nullable();
            $table->timestamp(column: 'updated_date')->nullable();
            $table->string(column: 'updated_by')->nullable();
            $table->bigInteger(column: 'updated_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource_detail');
    }
};
