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
        Schema::create('additional_information', function(Blueprint $table){
            $table->id();
            $table->bigInteger('candidate_id')->nullable();
            $table->string(column: 'source')->nullable();
            $table->string(column: 'been_treated')->nullable();
            $table->string(column: 'disease')->nullable();
            $table->string(column: 'strength')->nullable();
            $table->string(column: 'weakness')->nullable();   
            $table->string(column: 'against_weakness')->nullable();
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
        //
    }
};
