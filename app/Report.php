<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
  protected $fillable = ["booking_id", "room_type", "guests", "payment"];
}
