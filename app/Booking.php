<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
  //
  protected $fillable = [
    "id", "room", "name", "contact", "guests", "concerns", "status", "is_paid", "start_date", "end_date"
  ];

  protected $primaryKey = 'id';
  public $incrementing = false;
}
