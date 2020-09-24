<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id');
            $table->mediumInteger('badge_number')->unsigned();
            $table->timestamp('time')->useCurrent();
            $table->string('field');
            $table->string('old');
            $table->string('new');

            $table->foreign('item_id')->references('id')->on('items');
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
        Schema::dropIfExists('modifications');
    }
}
