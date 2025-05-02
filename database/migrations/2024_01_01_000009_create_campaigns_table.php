<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('banner_image');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('campaign_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
            $table->foreignId('child_id')->constrained()->onDelete('cascade');
            $table->string('file_url');
            $table->text('description')->nullable();
            $table->integer('votes_count')->default(0);
            $table->boolean('is_winner')->default(false);
            $table->timestamps();
        });

        Schema::create('campaign_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('campaign_submissions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('campaign_votes');
        Schema::dropIfExists('campaign_submissions');
        Schema::dropIfExists('campaigns');
    }
}; 