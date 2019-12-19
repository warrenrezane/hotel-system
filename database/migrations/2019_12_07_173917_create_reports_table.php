<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('reports', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('booking_id');
      $table->string('room_type');
      $table->integer('guests');
      $table->integer('payment');
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
    Schema::dropIfExists('reports');
  }
}
