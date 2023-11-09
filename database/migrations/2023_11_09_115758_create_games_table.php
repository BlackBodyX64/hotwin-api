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
            $table->string('name');
            $table->string('image');
            $table->boolean('popular')->default(false);
            $table->longText('url');

            //เชื่อมความสัมพันธ์
            $table->unsignedBigInteger('casino_id');
            $table->foreign('casino_id')->references('id')->on('casinos');

            $table->unsignedBigInteger('game_type_id');
            $table->foreign('game_type_id')->references('id')->on('game_types');

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
