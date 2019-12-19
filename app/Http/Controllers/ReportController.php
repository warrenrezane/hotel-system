<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

class ReportController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index($from, $to)
  {
    $reports = DB::table('reports')
      ->select(DB::raw('room_type, sum(guests) as total_guests, sum(payment) as total_payment'))
      ->whereBetween('created_at', [$from, $to])
      ->groupBy('room_type')
      ->get();

    return view('reports')->with(['reports' => $reports, 'range' => date('F d, Y', strtotime($from)) . ' to ' . date('F d, Y', strtotime($to)), "from" => $from, "to" => $to]);
  }

  public function download($from, $to)
  {
    // Load Template
    $phpWord = new PhpWord();
    $document = $phpWord->loadTemplate('template.docx');
    // Load Data
    $reports = DB::table('reports')
      ->select(DB::raw('room_type, sum(guests) as total_guests, sum(payment) as total_payment'))
      ->whereBetween('created_at', [$from, $to])
      ->groupBy('room_type')
      ->get();

    $count = sizeof($reports);
    $i = 0;
    $sum_of_guests = 0;
    $sum_of_sales = 0;
    $document->cloneRow('room_types', $count);
    $document->setValue('from', $from);
    $document->setValue('to', $to);
    $document->setValue('prepared_by', Auth::user()->name);
    $document->setValue('date', date('F d, Y g:i A'));

    foreach ($reports as $report) {
      $i++;
      $document->setValue("room_types#{$i}", $report->room_type);
      $document->setValue("total_guests#{$i}", $report->total_guests);
      $document->setValue("total_sales#{$i}", '₱ ' . $report->total_payment);
      $sum_of_guests += $report->total_guests;
      $sum_of_sales += $report->total_payment;
    }

    $document->setValue('sum_of_guests', $sum_of_guests);
    $document->setValue('sum_of_sales', '₱ ' . $sum_of_sales);

    $document->saveAs('BSHM Hotel Sales Activity Report - ' . $from . ' - ' . $to . ' .docx');
    return response()->download(public_path('BSHM Hotel Sales Activity Report - ' . $from . ' - ' . $to . ' .docx'))->deleteFileAfterSend();
  }

  // public function showReportsMonthly($month, $year)
  // {
  //   $months = ['1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April', '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'August', '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'];

  //   $reports = DB::table('reports')
  //     ->select(DB::raw('room_type, sum(guests) as total_guests, sum(payment) as total_payment'))
  //     ->whereYear('created_at', $year)
  //     ->whereMonth('created_at', $month)
  //     ->groupBy('room_type')
  //     ->get();

  //   return view('reports')->with(['reports' => $reports, 'month' => $months[$month]]);
  // }

  // public function showReportsAnnually($year)
  // {
  //   $fromDate = date($year . '-01-01');
  //   $toDate = date($year . '-12-31');

  //   $reports = DB::table('reports')
  //     ->select(DB::raw('room_type, sum(guests) as total_guests, sum(payment) as total_payment'))
  //     ->whereBetween('created_at', [$fromDate, $toDate])
  //     ->groupBy('room_type')
  //     ->get();

  //   return view('reports')->with(['reports' => $reports, 'year' => $year]);
  // }
}
