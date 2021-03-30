<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authers', function (Blueprint $table) {
            $table->id();
            $table->string('auther_id');
            $table->string('name');
            $table->string('email');
            $table->string('mobile_no');
            $table->string('blog_article')->nullable();
            $table->string('approved')->default(false);
            $table->string('social_link')->nullable();
            $table->string('password')->nullable();
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
        Schema::dropIfExists('authers');
    }
}
