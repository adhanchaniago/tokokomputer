<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotaPerakitansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_perakitans', function(Blueprint $table) {
            $table->increments('id');
            $table->datetime('tgl');
            $table->integer('biaya');
            $table->integer('id_nota_jual')->unsigned();
            $table->foreign('id_nota_jual')->references('id')->on("nota_juals")->onDelete('cascade');
            $table->integer('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on("users")->onDelete('cascade');
            $table->string('status',20);
            $table->text('catatan')->nullable();
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
        Schema::drop('nota_perakitans');
    }
}
