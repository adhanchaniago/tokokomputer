<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pakets', function(Blueprint $table) {
            $table->increments('id');
            $table->string('nama',100);
            $table->text('detail');
            $table->integer('total_harga_jual');
            $table->integer('total_harga_asli');
            $table->integer('stok');
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
        Schema::drop('pakets');
    }
}
