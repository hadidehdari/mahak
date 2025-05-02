<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('route_name')->nullable()->after('slug');
            $table->string('route_path')->nullable()->after('route_name');
            $table->string('meta_title')->nullable()->after('route_path');
            $table->text('meta_description')->nullable()->after('meta_title');
        });
    }

    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['route_name', 'route_path', 'meta_title', 'meta_description']);
        });
    }
}; 