@extends('layouts.app')

@push('name')
Dashboard
@endpush

@section('nav')
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
  <div class="container-fluid">
    <div class="navbar-wrapper">
      <a class="navbar-brand" href="#">Today's Stats</a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="sr-only">Toggle navigation</span>
      <span class="navbar-toggler-icon icon-bar"></span>
      <span class="navbar-toggler-icon icon-bar"></span>
      <span class="navbar-toggler-icon icon-bar"></span>
    </button>
  </div>
</nav>
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-header card-header-warning card-header-icon">
          <div class="card-icon">
            <i class="material-icons">content_copy</i>
          </div>
          <p class="card-category">Used Space</p>
          <h3 class="card-title">49/50
            <small>GB</small>
          </h3>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons text-danger">warning</i>
            <a href="#pablo">Get More Space...</a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-header card-header-success card-header-icon">
          <div class="card-icon">
            <i class="material-icons">store</i>
          </div>
          <p class="card-category">Revenue</p>
          <h3 class="card-title">$34,245</h3>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons">date_range</i> Last 24 Hours
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-header card-header-danger card-header-icon">
          <div class="card-icon">
            <i class="material-icons">info_outline</i>
          </div>
          <p class="card-category">Fixed Issues</p>
          <h3 class="card-title">75</h3>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons">local_offer</i> Tracked from Github
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-header card-header-info card-header-icon">
          <div class="card-icon">
            <i class="fa fa-twitter"></i>
          </div>
          <p class="card-category">Followers</p>
          <h3 class="card-title">+245</h3>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons">update</i> Just Updated
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header card-header-rose">
      <h4 class="card-title">Customer Stats</h4>
      <p class="card-category">Customers for the month of December.</p>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-hover">
        <thead class="text-rose">
          <th>Room</th>
          <th>Type</th>
          <th>Reserved To</th>
          <th>No. of Guests</th>
          <th>Booking Status</th>
          <th>Is Paid</th>
          <th>Check-in date</th>
          <th>Check-out date</th>
        </thead>
        <tbody>
          @if(count($bookings) > 0)
          @foreach ($bookings as $booking)
          <tr>
            <td>{{ $booking->room }}</td>
            <td>{{ getRoomType($booking->room) }}</td>
            <td>{{ $booking->name }}</td>
            <td>{{ $booking->guests }}</td>
            <td>{{ getStatus($booking->status) }}</td>
            <td>{{ getPaid($booking->is_paid) }}</td>
            <td>{{ getDateEquivalent($booking->start_date) }}</td>
            <td>{{ getDateEquivalent($booking->end_date) }}</td>
          </tr>
          @endforeach
          @else
          <tr class="text-center">
            <td colspan="8">There are no guests for this month.</td>
          </tr>
          @endif
        </tbody>
      </table>
      {{ $bookings->links() }}
    </div>
  </div>
</div>
@endsection

@push('custom')
<style>
  .page-item.active .page-link {
    background-color: #ec407a;
    border-color: #d81b60;
  }

  .page-link {
    color: #ec407a;
  }
</style>
@endpush

<?php
use Illuminate\Support\Facades\DB;

function getRoomType($id) {
  $rooms = DB::table('rooms')->where('value', $id)->get();
  foreach ($rooms as $room) {
    $types = DB::table('room_types')->where('value', $room->type)->get();

    foreach ($types as $type) {
      return $type->label;
    }
  }
}

function getStatus($status) {
  $arr = [
    '1' => 'Walk-in',
    '2' => 'Guaranteed',
    '3' => 'Checked-in',
    '4' => 'Checked-out'
];

  return $arr[$status];
}

function getPaid($is_paid) {
  $arr = [
    '1' => 'Yes',
    '0' => 'No'
  ];

  return $arr[$is_paid];
}

function getDateEquivalent($date) {
  $timestamp = strtotime($date);
  return date("F d, Y g:i A", $timestamp);
}
?>
