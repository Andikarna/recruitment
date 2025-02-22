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
        Schema::create('languange', function(Blueprint $table){
            $table->id();
            $table->bigInteger('candidate_id')->nullable();
            $table->string(column: 'name_languange')->nullable();
            $table->string(column: 'write')->nullable();
            $table->string(column: 'speak')->nullable();
            $table->string(column: 'read')->nullable();
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
