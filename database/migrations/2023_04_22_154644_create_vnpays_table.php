<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVnpaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vnpays', function (Blueprint $table) {
            $table->id();
            $table->string('fullname')->nullable();
            $table->string('bank')->nullable();
            $table->string('code')->nullable();
            $table->string('total')->nullable();
            $table->string('status')->nullable();
            $table->mediumText('options')->nullable();
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
        Schema::dropIfExists('vnpays');
    }
}
