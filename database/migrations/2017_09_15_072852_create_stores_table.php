<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('store_name');
            $table->string('phone_number', 20);
            $table->string('password');
            $table->time('open_time')->default('07:00:00')->nullable();
            $table->time('close_time')->default('17:00:00')->nullable();
            $table->string('category')->default('Top Seller')->nullable();
            $table->string('store_description')->nullable();
            $table->string('address')->nullable();
            $table->double('address_latitude')->default('11.5763694')->nullable();
            $table->double('address_longitude')->default('104.8879874')->nullable();
            $table->string('cover_dir')->default('https://lh3.googleusercontent.com/proxy/OrkYLTEDm1y12maxoec0mVZZi1ziMVrHqjoL4Y_sPzIWNHl5ElYzVw3A1fCp7-80Rf1iCoK83JtoNEIdo0kheLSuMK0AKLKQQEAeCG1FyhjpRaSuu45FZ2yTGRshYnXZJIC6P7VSCZylzb2b4S4BP2BkFUmtP2w_6SyO=w530-h349-p')->nullable();
            $table->string('profile_dir')->default('http://www.h3diagnostics.com/wp-content/themes/wewoo/images/no_image.jpg')->nullable();
            $table->rememberToken();
            $table->unique('phone_number');
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
        Schema::dropIfExists('stores');
    }
}
