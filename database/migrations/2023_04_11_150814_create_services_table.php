<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('parent_id')->nullable();
            $table->string('name', 255)->nullable();
            $table->string('brand', 255)->nullable();
            $table->string('photo', 255)->nullable();
            $table->string('photo1', 255)->nullable();
            $table->string('photo2', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->string('code', 30)->nullable();
            $table->string('type', 30)->nullable();
            $table->string('status')->nullable();
            $table->string('qty')->nullable();
            $table->mediumText('desc')->nullable();
            $table->mediumText('content')->nullable();
            $table->mediumText('options')->nullable();
            $table->string('price')->nullable();
            $table->string('price_old')->nullable();
            $table->string('discount')->nullable();
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
        Schema::dropIfExists('services');
    }
}
