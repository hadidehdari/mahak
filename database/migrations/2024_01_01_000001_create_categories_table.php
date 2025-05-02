<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('poster')->nullable();
            $table->enum('content_type', ['video', 'audio_book']);
            $table->string('background_color')->default('#FFFFFF');
            $table->string('text_color')->default('#000000');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}; 