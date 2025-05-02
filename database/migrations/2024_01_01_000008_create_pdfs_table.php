<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pdfs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('thumbnail');
            $table->string('file_url');
            $table->integer('pages_count');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('creator_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('age_group_id')->constrained()->onDelete('cascade');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('downloads_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pdfs');
    }
}; 