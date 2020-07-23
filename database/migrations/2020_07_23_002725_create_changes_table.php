<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('changes', function (Blueprint $table) {
            $table->string('barcode', 10);
            $table->mediumInteger('badge_number')->unsigned();
            $table->timestamp('time');
            $table->string('field');
            $table->string('old');
            $table->string('new');

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
        Schema::dropIfExists('changes');
    }
}
