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
        Schema::create('education_formal', function(Blueprint $table){
            $table->id();
            $table->bigInteger('candidate_id')->nullable();
            $table->string(column: 'name')->nullable();
            $table->string(column: 'level')->nullable();
            $table->string(column: 'city')->nullable();
            $table->string(column: 'major')->nullable();
            $table->string(column: 'gpa')->nullable();
            $table->timestamp(column: 'start_date')->nullable();
            $table->timestamp(column: 'end_date')->nullable();
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
