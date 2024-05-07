<?php

use App\Enum\IdentificationTypeEnum;
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
        Schema::create('identifications', function (Blueprint $table) {
            $table->id();
            $table->date("date");
            $table->enum("type", collect(IdentificationTypeEnum::cases())->map(function($case) {
                return $case->value;
            })->toArray() );
            $table->string("number", 15);
            $table->foreignId("animal_id")->constrained('animals');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identifications');
    }
};
