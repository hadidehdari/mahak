<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('thumbnail');
            $table->string('video_url');
            $table->integer('duration')->comment('Duration in seconds');
            $table->string('file_size')->nullable()->comment('File size as string, e.g. "1.2GB"');
            $table->string('background_color')->default('#FFFFFF');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('creator_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('age_group_id')->constrained()->onDelete('cascade');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('views_count')->default(0);
            $table->decimal('rating', 3, 2)->default(0)->comment('Average rating');
            $table->integer('rating_count')->default(0)->comment('Number of ratings');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('videos');
    }
}; 