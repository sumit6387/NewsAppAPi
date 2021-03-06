<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrendingNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trending_news', function (Blueprint $table) {
            $table->string('id', 20);
            $table->string('category')->default('By This App');
            $table->longText('title');
            $table->string('author');
            $table->longText('content');
            $table->string('postedAt');
            $table->string('sourceURL');
            $table->string('imgsrc');
            $table->string('status')->default(false);
            $table->string('writtenBy')->nullable(); //user_id
            $table->longText('likes')->nullable();
            $table->unique('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trending_news');
    }
}
