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
        Schema::create('offering_salary', function(Blueprint $table){
            $table->id();
            $table->bigInteger('offering_id')->nullable();
            $table->string(column: 'salary')->nullable();
            $table->tinyInteger(column: 'pph21')->nullable();
            $table->string(column: 'ket_pph21')->nullable();
            $table->tinyInteger(column: 'bpjs_ket')->nullable();
            $table->string(column: 'ket_bpjsket')->nullable();
            $table->tinyInteger(column: 'bpjs_kes')->nullable();
            $table->string(column: 'ket_bpjskes')->nullable();
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
