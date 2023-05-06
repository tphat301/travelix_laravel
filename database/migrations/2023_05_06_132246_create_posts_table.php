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
            $table->string('name', 255)->nullable();
            $table->string('parent_id1')->nullable();
            $table->string('parent_id2')->nullable();
            $table->string('parent_id3')->nullable();
            $table->string('parent_id4')->nullable();
            $table->string('office', 255)->nullable();
            $table->string('number', 255)->nullable();
            $table->string('photo', 255)->nullable();
            $table->string('photo1', 255)->nullable();
            $table->string('photo2', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->string('slogan', 255)->nullable();
            $table->string('status', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->string('type', 255)->nullable();
            $table->mediumText('desc')->nullable();
            $table->mediumText('content')->nullable();
            $table->mediumText('options')->nullable();
            $table->string('view', 255)->nullable();
            $table->softDeletes();
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
