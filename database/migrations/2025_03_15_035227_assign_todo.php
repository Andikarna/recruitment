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
        Schema::create('assign_todo', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('user_name')->nullable();
            $table->bigInteger('action_id')->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('status')->nullable();
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
