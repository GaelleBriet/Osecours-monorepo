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
        Schema::create('table_animal', function (Blueprint $table) {
            $table->id();
            $table->string("name",100)->nullable();
            $table->text("description")->nullable();
            $table->date("birth_date")->nullable();
            $table->boolean("cats_friendly")->nullable();
            $table->boolean("dogs_friendly")->nullable();
            $table->boolean("children_friendly")->nullable();
            $table->integer("age")->nullable();
            $table->text("behavioral_comment")->nullable();
            $table->boolean("sterilized")->nullable();
            $table->boolean("deceased")->default(0);

            $table->foreignId('specie_id');
            $table->foreignId('gender_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_animal');
    }
};
