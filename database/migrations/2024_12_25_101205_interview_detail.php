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
        Schema::create('interview_detail', function(Blueprint $table){
            $table->id();
            $table->bigInteger('interview_id')->nullable();
            $table->bigInteger('interview_type_id')->nullable();
            $table->string(column: 'name_progress')->nullable();
            $table->timestamp(column: 'interview_date')->nullable();
            $table->string(column: 'user')->nullable();
            $table->string(column: 'interview_status')->nullable();
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
        Schema::dropIfExists('interview_detail');
    }
};
