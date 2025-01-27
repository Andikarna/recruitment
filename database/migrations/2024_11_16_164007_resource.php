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
        Schema::create('resource', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string(column: 'client')->nullable();
            $table->string('project')->nullable();
            $table->string('level_priority')->nullable();
            $table->timestamp('target_date')->nullable();
            $table->string('requirment')->nullable();
            $table->string('file')->nullable();
            $table->timestamp(column: 'created_date')->nullable();
            $table->string(column: 'created_by')->nullable();
            $table->bigInteger(column: 'created_id')->nullable();
            $table->timestamp(column: 'updated_date')->nullable();
            $table->string(column: 'updated_by')->nullable();
            $table->bigInteger(column: 'updated_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource');
    }
};
