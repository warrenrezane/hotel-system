<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('rooms')->truncate();
    $tc = 1;
    for ($i = 1; $i < 57; $i++) {
      if ($i % 3 === 0) {
        $tc++; // Type Counter
      }

      DB::table('rooms')->insert([
        'value' => $i,
        'label' => $i,
        'type' => $tc
      ]);
    }
  }
}
