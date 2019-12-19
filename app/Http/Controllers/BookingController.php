<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booking;
use App\Report;
use Exception;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('bookings');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $reservation = $request->all();

    $booking = Booking::create([
      'id' => $reservation['id'],
      'room' => $reservation['room'],
      'name' => $reservation['name'],
      'contact' => $reservation['contact'],
      'guests' => $reservation['guests'],
      'concerns' => $reservation['concerns'],
      'status' => $reservation['status'],
      'is_paid' => $reservation['is_paid'] === "false" ? 0 : 1,
      'start_date' => $reservation['start_date'],
      'end_date' => $reservation['end_date'],
    ]);

    return response()->json($booking, 200);
  }

  /**
   * Display the specified resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function show()
  {
    $bookings = Booking::all();
    $collection = array(
      "roomTypes" => DB::table('room_types')->get(),
      "bookingStatuses" => DB::table('booking_statuses')->get(),
      "rooms" => DB::table('rooms')->get()
    );
    return response()->json(["data" => $bookings, "collections" => $collection], 200);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    $reservation = $request->all();

    $booking = Booking::where('id', $reservation['id'])
      ->update([
        'room' => $reservation['room'],
        'name' => $reservation['name'],
        'contact' => $reservation['contact'],
        'guests' => $reservation['guests'],
        'concerns' => $reservation['concerns'],
        'status' => $reservation['status'],
        'is_paid' => $reservation['is_paid'] === "false" ? 0 : 1,
        'start_date' => $reservation['start_date'],
        'end_date' => $reservation['end_date'],
      ]);

    return response()->json($booking, 200);
  }

  /**
   * Update the Booking to Check-Out status and put it into Reports table
   *
   * @param   \Illuminate\Http\Request  $request
   * @param   int  $id
   * @return  \Illuminate\Http\Response
   */
  public function checkout(Request $request)
  {
    $reservation = $request->all();
    $dateNow = date('Y-m-d');
    $dateCheckIn = date($reservation['start_date']);

    if ($dateNow < $dateCheckIn) {
      return response()->json($dateNow < $dateCheckIn);
    }
    else {
      $booking = Booking::where('id', $reservation['id'])
        ->update([
          'status' => 4,
          'is_paid' => 1,
        ]);

      Report::create([
        'booking_id' => $reservation['id'],
        'room_type' => $reservation['type'],
        'guests' => $reservation['guests'],
        'payment' => $reservation['payment']
      ]);

      return response()->json($booking, 201);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param   \Illuminate\Http\Request  $request
   * @return  \Illuminate\Http\Response
   */
  public function destroy(Request $request)
  {
    $reservation = $request->all();
    $booking = Booking::destroy($reservation['id']);

    return response()->json($booking, 200);
  }
}
