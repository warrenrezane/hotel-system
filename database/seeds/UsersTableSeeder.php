<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    User::truncate();
    User::create([
      'name' => 'Admin 1',
      'username' => 'admin',
      'password' => '$2y$10$bAWR0O6w/YmgFQ5Tn6tmr.6pvVdQvUFJ9HMt2Nx2vwnInYhW/el6S',
      'access_level' => 2
    ]);
    User::create([
      'name' => 'User 1',
      'username' => 'user',
      'password' => '$2y$10$f9OBrIzLXQ1HvrJAJu.7iuQ0A/MXy/1xsvyrFRXqBmPVGCqJLQ7u6',
      'access_level' => 1
    ]);
  }
}
