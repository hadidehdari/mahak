<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('child_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained()->onDelete('cascade');
            $table->enum('activity_type', ['video', 'audio_book', 'campaign', 'rating', 'comment', 'storytelling']);
            $table->string('content_name');
            $table->string('content_url')->nullable();
            $table->integer('points')->default(0);
            $table->text('details')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('child_activities');
    }
}; 