<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('language_id');
            $table->string('post_type');
            $table->boolean('post_thumbnail')->default(false);
            $table->string('title');
            $table->string('slug');
            $table->string('keyword_meta_tag')->nullable();
            $table->longText('featured')->nullable();
            $table->longText('description');
            $table->boolean('status')->default(true);
            $table->boolean('trash')->default(false);
            $table->unsignedBigInteger('views')->nullable();
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
        Schema::dropIfExists('posts');
    }
}
