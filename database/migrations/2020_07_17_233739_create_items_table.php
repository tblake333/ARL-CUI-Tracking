<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {

            $table->id();
            $table->string('barcode', 10)->unique();
            $table->mediumInteger('owner_badge_number')->unsigned();
            $table->string('title', 30);
            $table->string('type', 30);
            $table->string('source', 30)->nullable();
            $table->date('source_date')->nullable();
            $table->string('location', 30);
            $table->string('description', 250)->nullable();
            $table->string('keywords', 40)->nullable();
            $table->timestamps();

            // TODO: Fix timezones
            
            $table->foreign('owner_badge_number')->references('badge_number')->on('users')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
