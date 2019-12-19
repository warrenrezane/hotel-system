<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $this->call(UsersTableSeeder::class);
    $this->call(BookingStatusesTableSeeder::class);
    $this->call(RoomTypesTableSeeder::class);
    $this->call(RoomsTableSeeder::class);
    $this->call(BookingsTableSeeder::class);
  }
}
