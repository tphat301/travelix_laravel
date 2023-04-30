<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('code_product')->nullable();
            $table->enum('discount', ['price', 'percent'])->nullable();
            $table->string('status')->nullable();
            $table->string('qty')->nullable();
            $table->string('type', 30)->nullable();
            $table->string('timestart')->nullable();
            $table->string('timeend')->nullable();
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
        Schema::dropIfExists('coupons');
    }
}
