<?php

use Illuminate\Database\Seeder;
use Faker\Generator;
use App\Booking;
use App\Report;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run(Generator $faker)
  {
    Booking::truncate();
    Report::truncate();
    $faker->addProvider(new Faker\Provider\en_PH\PhoneNumber($faker));
    $faker->addProvider(new Faker\Provider\Lorem($faker));
    $status = rand(1, 3);
    $date = date('Y-m-d H:i:s');

    for ($i = 1; $i <= 56; $i++) {
      $id = rand();
      $booking = Booking::create([
        'id' => $id,
        'room' => $i,
        'name' => $faker->name,
        'contact' => $faker->phoneNumber,
        'guests' => rand(1, 5),
        'concerns' => $faker->text(rand(50, 100)),
        'is_paid' => rand(0, 1),
        'status' => $status,
        'start_date' => date('Y-m-d H:i:s'),
        'end_date' => date('Y-m-d H:i:s', strtotime($date . ' + ' . rand(1, 7) . ' days'))
      ]);
    }
  }

  public function getRoomType($id)
  {
    $rooms = DB::table('rooms')->where('value', $id)->get();
    foreach ($rooms as $room) {
      $types = DB::table('room_types')->where('value', $room->type)->get();

      foreach ($types as $type) {
        return $type->label;
      }
    }
  }
}
