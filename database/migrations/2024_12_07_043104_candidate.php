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
        Schema::create('candidate', function(Blueprint $table){
            $table->id();
            $table->string('uniq_code')->nullable();
            $table->string('name')->nullable();
            $table->string('position')->nullable();
            $table->string(column: 'qualification')->nullable();
            $table->string(column: 'education')->nullable();
            $table->string(column: 'experience')->nullable();
            $table->string(column: 'status')->nullable();
            $table->string(column: 'gender')->nullable();
            $table->string(column: 'major')->nullable();
            $table->string(column: 'source')->nullable();
            $table->string(column: 'url')->nullable();
            $table->tinyInteger(column: 'isSpecial')->nullable();
            $table->tinyInteger(column: 'isFavoriteId')->nullable();
            $table->string(column: 'isFavoriteName')->nullable();
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
        Schema::dropIfExists('candidate');
    }
};
