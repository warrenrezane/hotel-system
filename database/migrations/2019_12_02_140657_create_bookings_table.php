<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('bookings', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->integer('room')->nullable();
      $table->string('name')->nullable();
      $table->string('contact')->nullable();
      $table->string('guests')->nullable();
      $table->string('concerns')->nullable();
      $table->integer('status')->nullable();
      $table->integer('is_paid')->nullable();
      $table->dateTime('start_date')->nullable();
      $table->dateTime('end_date')->nullable();
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
    Schema::dropIfExists('bookings');
  }
}
