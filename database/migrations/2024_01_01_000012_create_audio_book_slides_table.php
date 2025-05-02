<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('audio_book_slides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audio_book_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image');
            $table->string('audio_url');
            $table->integer('duration')->comment('مدت زمان به ثانیه');
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('audio_book_slides');
    }
}; 