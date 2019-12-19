<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingStatusesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('booking_statuses')->truncate();
    $i = 0;
    $statuses = ["New", "Guaranteed", "Checked-in", "Checked-out"];
    foreach($statuses as $status) {
      $i++;
      DB::table('booking_statuses')->insert([
        'value' => $i,
        'label' => $status
      ]);
    }
  }
}
