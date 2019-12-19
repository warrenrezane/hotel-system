<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomTypesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('room_types')->truncate();
    $i = 0;
    $types = ["Single Room", "Double Room", "Triple Room", "Quad Room", "Queen Room", "King Room", "Twin Room", "Double-double Room", "Executive Suite", "Junior Suite", "Presidential Suite", "Connecting Room", "Murphy Room", "Accessible/Disabled Room", "Cabana Room", "Adjoining Room", "Adjacent Room", "Executive Room", "Smoking/Non-Smoking Room"];
    $rate = 500;
    foreach($types as $type) {
      $i++;
      DB::table('room_types')->insert([
        'value' => $i,
        'label' => $type,
        'rate' => $rate
      ]);
      $rate += 150;
    }
  }
}
