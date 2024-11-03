<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecommendedItemsTable extends Migration
{
    public function up()
    {
        Schema::create('recommended_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recommendation_id')->constrained('recommendations')->onDelete('cascade');
            $table->foreignId('camping_id')->constrained('camping')->onDelete('cascade');
            $table->integer('quantity')->nullable();
            $table->integer('subtotal_price')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recommended_items');
    }
}
