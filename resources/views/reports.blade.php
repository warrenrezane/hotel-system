@extends('layouts.app')

@push('name')
Reports
@endpush

@section('content')
<div class="container-fluid">
  <div class="btn-group float-right mb-5">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
      aria-expanded="false">
      Download Report As
    </button>
    <div class="dropdown-menu">
      <a class="dropdown-item" href="/report/{{ $from }}/{{ $to }}/download" onclick="">DOCX</a>
      <a class="dropdown-item" href="#">PDF</a>
      <a class="dropdown-item" href="#">XLSX</a>
    </div>
  </div>

  <div class="card">
    <div class="card-header card-header-rose">
      <h4 class="card-title">Reports</h4>
      <p class="card-category">Reports for @if(isset($range)) {{ $range }} @endif</p>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-hover">
        <thead class="text-rose">
          <th>Room Type</th>
          <th>Total no. of guests per Room Type</th>
          <th>Total sales per Room Type</th>
        </thead>
        <tbody>
          @if (count($reports) > 0)
          @foreach ($reports as $report)
          <tr>
            <td>{{ $report->room_type }}</td>
            <td>{{ $report->total_guests }}</td>
            <td class="font-weight-bold">₱ {{ $report->total_payment }}</td>
          </tr>
          @endforeach
          @else
          <tr class="text-center">
            <td colspan="4">There are no reports in this month.</td>
          </tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>

  <div class="card mt-5">
    <div class="card-header card-header-success">
      <h4 class="card-title">Sales</h4>
      <p class="card-category">Total Sales for @if(isset($range)) {{ $range }} @endif
      </p>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-hover">
        <thead class="text-success">
          <th>Room Types Occupied</th>
          <th>Total no. of Guests</th>
          <th>Total sales</th>
        </thead>
        <tbody>
          @if (count($reports) > 0)
          <tr>
            <td class="font-weight-bold">{{ getTotalRoomTypes($reports) }}</td>
            <td class="font-weight-bold">{{ getTotalGuests($reports) }}</td>
            <td class="font-weight-bold">₱ {{ getTotalSales($reports) }}</td>
          </tr>
          @else
          <tr class="text-center">
            <td colspan="4">There are no reports in this month.</td>
          </tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@push('custom')
<style>
  .main-panel>.content {
    margin-top: 0px;
  }
</style>
@endpush

<?php
function getTotalRoomTypes($reports) {
  $total = 0;
  foreach ($reports as $report) {
    $total++;
  }
  return $total;
}

function getTotalGuests($reports) {
  $total = 0;
  foreach ($reports as $report) {
    $total += $report->total_guests;
  }
  return $total;
}

function getTotalSales($reports) {
  $total = 0;
  foreach ($reports as $report) {
    $total += $report->total_payment;
  }
  return $total;
}
?>
