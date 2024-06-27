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
        Schema::create('house_plan', function (Blueprint $table) {
            $table->unsignedBigInteger('house_id');
            $table->foreign('house_id')->references('id')->on('houses')->cascadeOnDelete();
            $table->unsignedBigInteger('plan_id');
            $table->foreign('plan_id')->references('id')->on('plans')->cascadeOnDelete();
            $table->timestamps();
            $table->timestamp('expires_at')->nullable();
            $table->primary(['house_id', 'plan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house_plan');
    }
};
