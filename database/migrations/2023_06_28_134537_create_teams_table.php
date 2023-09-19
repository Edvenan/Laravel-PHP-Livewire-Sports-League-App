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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('stadium')->unique();
            $table->integer('foundation_year');
            $table->integer('points')->unsigned()->nullable();
            $table->text('emblem_photo')->nullable();
            $table->integer('num_games')->unsigned()->nullable();
            $table->integer('won')->unsigned()->nullable();
            $table->integer('draw')->unsigned()->nullable();
            $table->integer('lost')->unsigned()->nullable();
            $table->integer('goals')->unsigned()->nullable();
            $table->integer('against')->unsigned()->nullable();
            $table->integer('average')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
