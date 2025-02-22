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
        Schema::create('onboarding', function(Blueprint $table){
            $table->id();
            $table->bigInteger('candidate_id')->nullable();
            $table->bigInteger('interivew_id')->nullable();
            $table->bigInteger('resource_id')->nullable();
            $table->bigInteger('resource_detail_id')->nullable();
            $table->string(column: 'name')->nullable();
            $table->string(column: 'gender')->nullable();
            $table->string(column: 'address')->nullable();
            $table->string(column: 'country')->nullable();
            $table->string(column: 'province')->nullable();
            $table->string(column: 'city')->nullable();
            $table->string(column: 'zipcode')->nullable();
            $table->string(column: 'place_of_birth')->nullable();
            $table->timestamp(column: 'date_of_birth')->nullable();
            $table->string(column: 'blood_type')->nullable();
            $table->string(column: 'religion')->nullable();
            $table->string(column: 'home_phone')->nullable();
            $table->string(column: 'mobile_phone')->nullable();
            $table->string(column: 'number_id')->nullable();
            $table->string(column: 'number_tax')->nullable();
            $table->string(column: 'status')->nullable();
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
