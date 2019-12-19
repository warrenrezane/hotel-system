@extends('layouts.app')

@push('name')
Bookings
@endpush

@section('content')
<div class="container-fluid">
  <div id="scheduler_here" class="dhx_cal_container shadow corner" style='width: 100%; height: 575px;'>
    <div class="dhx_cal_navline">
      <div class="dhx_cal_prev_button">&nbsp;</div>
      <div class="dhx_cal_next_button">&nbsp;</div>
      <div class="dhx_cal_today_button"></div>
      <div class="dhx_cal_date"></div>
      <div class="d-flex flex-row justify-content-center">
        <label class="ml-3 align-self-center">Filter Rooms:</label>
        <select id="room_filter" class="form-control ml-3" onchange='showRooms(this.value)'></select>
        <button class="btn btn-success btn-sm" style="right: -350px; top: -5px" onclick="scheduler.addEventNow()">Create
          Reservation</button>
      </div>
    </div>
    <div class="dhx_cal_header">
    </div>
    <div class="dhx_cal_data">
    </div>
  </div>
</div>

@endsection

@push('scheduler')
<script src='{{ asset('dhtmlx/codebase/dhtmlxscheduler.js')}}'></script>
<script src="{{ asset('dhtmlx/codebase/ext/dhtmlxscheduler_limit.js')}}"></script>
<script src='{{ asset('dhtmlx/codebase/ext/dhtmlxscheduler_timeline.js')}}'></script>
<script src="{{ asset('dhtmlx/codebase/ext/dhtmlxscheduler_tooltip.js')}}"></script>
<script src="{{ asset('dhtmlx/codebase/ext/dhtmlxscheduler_minical.js')}}"></script>
<script src="{{ asset('dhtmlx/codebase/ext/dhtmlxscheduler_editors.js')}}"></script>
<script src="{{ asset('dhtmlx/codebase/ext/dhtmlxscheduler_collision.js')}}"></script>
<script src="{{ asset('dhtmlx/codebase/ext/dhtmlxscheduler_readonly.js')}}"></script>
<link rel='stylesheet' href='{{ asset('dhtmlx/codebase/dhtmlxscheduler.css')}}'>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script src="{{ asset('js/script.js') }}"></script>

<style>
  .main-panel>.content {
    margin-top: 0px;
  }

  .shadow {
    box-shadow:
      0 16px 38px -12px rgba(0, 0, 0, 0.56),
      0 4px 25px 0px rgba(0, 0, 0, 0.12),
      0 8px 10px -5px rgba(0, 0, 0, 0.2)
  }

  .corner {
    border-radius: 5px;
  }

  .checkout_button_set {
    background-color: #4CAF50;
    color: white;
  }

  .table,
  .th,
  .td {
    border: 1px solid black;
    border-collapse: collapse;
  }

  .th,
  .td {
    padding: 5px;
    text-align: left;
  }
</style>
@endpush
