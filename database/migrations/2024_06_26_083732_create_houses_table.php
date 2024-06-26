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
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->text('title');
            $table->text('slug');
            $table->text('description')->nullable();
            $table->tinyInteger('rooms')->unsigned();
            $table->tinyInteger('beds')->unsigned();
            $table->tinyInteger('bathrooms')->unsigned();
            $table->smallInteger('square_mt')->unsigned();
            $table->text('address');
            $table->string('thumb', 255);
            $table->boolean('available')->default(1);
            $table->decimal('price_per_night', $precision = 6, $scale = 2)->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('category_id')->references('id')->on('categories')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('houses', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['category_id']);
        });
        Schema::dropIfExists('houses');
    }
};
