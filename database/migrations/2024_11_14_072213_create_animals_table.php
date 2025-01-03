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
            $table->string('name');
            $table->boolean('isMale');
            $table->string('breed')->nullable();
            $table->boolean('forSale')->default(false);
            $table->string('color')->nullable();
            $table->string('eyeColor')->nullable();
            $table->date('birthDate')->nullable();
            $table->string('direction')->nullable();
            $table->unsignedInteger('siblings')->nullable();
            $table->string('hornedness')->nullable();
            $table->string('birthCountry')->nullable();
            $table->string('residenceCountry')->nullable();
            $table->string('status')->nullable();
            $table->string('labelNumber')->nullable();
            $table->string('height')->nullable();
            $table->string('rudiment')->nullable();
            $table->text('extraInfo')->nullable();
            $table->text('certificates')->nullable();
            $table->boolean('showOnMain')->default(false);
            $table->json('images')->nullable();
            $table->foreignId('household_owner_id')
                ->nullable()
                ->constrained('households')
                ->onDelete('restrict');

            $table->foreignId('household_breeder_id')
                ->nullable()
                ->constrained('households')
                ->onDelete('restrict');

            $table->foreignId('mother_id')->nullable()->constrained('animals')->nullOnDelete();
            $table->foreignId('father_id')->nullable()->constrained('animals')->nullOnDelete();

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
