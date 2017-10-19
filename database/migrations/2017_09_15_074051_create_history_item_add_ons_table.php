 <?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryItemAddOnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_item_add_ons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('history_item_id')->unsigned();
            $table->foreign('history_item_id')->references('id')->on('history_items')->onDelete('cascade');
            $table->integer('add_on_id')->unsigned();
            $table->foreign('add_on_id')->references('id')->on('item_add_ons')->onDelete('cascade');
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
        Schema::dropIfExists('history_item_add_ons');
    }
}
