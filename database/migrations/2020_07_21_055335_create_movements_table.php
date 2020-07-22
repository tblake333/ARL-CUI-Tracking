<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->string('barcode', 10);
            $table->mediumInteger('badge_number')->unsigned();
            $table->enum('type', ['in', 'out']);
            $table->timestamp('time')->useCurrent();

            $table->foreign('barcode')->references('barcode')->on('items');
            $table->foreign('badge_number')->references('badge_number')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movements');
    }
}
