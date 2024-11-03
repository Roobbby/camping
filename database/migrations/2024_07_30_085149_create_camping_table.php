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
        Schema::create('camping', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullabel();
            $table->integer('price')->nullabel();
            $table->string('cover')->nullabel();
            $table->text('description')->nullabel();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camping');
    }
};
