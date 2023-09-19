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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_1_id');
            $table->foreign('team_1_id')->references('id')->on('teams')->onDelete('cascade');
            $table->unsignedBigInteger('team_2_id');
            $table->foreign('team_2_id')->references('id')->on('teams')->onDelete('cascade');
            $table->date('date');
            $table->time('time');
            $table->integer('score_team_1')->nullable();
            $table->integer('score_team_2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
