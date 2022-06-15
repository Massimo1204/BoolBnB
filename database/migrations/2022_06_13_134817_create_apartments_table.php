<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedTinyInteger('n_rooms');
            $table->unsignedTinyInteger('n_bedrooms');
            $table->unsignedTinyInteger('n_bathrooms');
            $table->unsignedTinyInteger('n_beds');
            $table->unsignedTinyInteger('guests');
            $table->string('title');
            $table->text('description');
            $table->float('price', 7, 2);
            $table->unsignedMediumInteger('square_meters')->nullable();
            $table->text('image');
            $table->string('address');
            $table->string('address_number');
            $table->string('address_city');
            $table->string('lat');
            $table->string('long');
            $table->tinyInteger('visible');
            $table->tinyInteger('available');
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
        Schema::dropIfExists('apartments');
    }
}
