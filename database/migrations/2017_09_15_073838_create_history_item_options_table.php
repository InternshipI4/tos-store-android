<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryItemOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_item_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('history_item_id')->unsigned();
            $table->foreign('history_item_id')->references('id')->on('history_items')->onDelete('cascade');
            $table->integer('option_id')->unsigned();
            $table->foreign('option_id')->references('id')->on('item_options')->onDelete('cascade');
            $table->integer('option_value_id')->unsigned();
            $table->foreign('option_value_id')->references('id')->on('item_option_values')->onDelete('cascade');
            $table->boolean('checked')->default(false);
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
        Schema::dropIfExists('history_item_options');
    }
}
