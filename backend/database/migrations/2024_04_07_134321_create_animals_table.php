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
        Schema::create('animals', function (Blueprint $table) {
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
            $table->foreignId('specie_id')->constrained('species');
            $table->foreignId('breed_id')->nullable()->constrained('breeds');
            $table->foreignId('gender_id')->nullable()->constrained('genders');
            $table->foreignId('color_id')->nullable()->constrained('colors'); 
            $table->foreignId('coat_id')->nullable()->constrained('coats');
            $table->foreignId('sizerange_id')->nullable()->constrained('SizeRanges');
            $table->foreignId('agerange_id')->nullable()->constrained('AgeRanges');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
