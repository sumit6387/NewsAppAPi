<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->string('id');
            $table->string('category');
            $table->longText('title');
            $table->string('author');
            $table->longText('content');
            $table->string('postedAt');
            $table->string('sourceURL');
            $table->string('imgsrc');
            $table->string('status')->default(false);
            $table->string('writtenBy')->nullable();
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
        Schema::dropIfExists('news');
    }
}
