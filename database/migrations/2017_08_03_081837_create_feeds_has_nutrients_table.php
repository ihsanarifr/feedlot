<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedsHasNutrientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed_has_nutrient', function (Blueprint $table) {
            $table->integer('feed_id')->unsigned();
            $table->integer('nutrient_id')->unsigned();
            $table->float('composition',8,2);
            $table->timestamps();

            $table->foreign('feed_id')->references('id')->on('feeds')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('nutrient_id')->references('id')->on('nutrients')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feed_has_nutrient');
    }
}
