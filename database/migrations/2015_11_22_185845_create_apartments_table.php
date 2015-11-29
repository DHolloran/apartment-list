<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('order')->unsigned();
            $table->string('name');
            $table->string('addressLine1');
            $table->string('addressLine2');
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->text('notes');
            $table->decimal('price', 10, 2);
            $table->decimal('parkingPrice', 10, 2);
            $table->decimal('deposit', 10, 2);
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('apartments');
    }
}
