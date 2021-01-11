<?php

namespace App\Http\Controllers;

use App\Charts\SampleChart;
use App\Models\Invoice;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\ChartsController;
use Illuminate\Http\Request;
use mysqli;
use PhpOffice\PhpSpreadsheet\Helper\Sample;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $paid_invoices_count = invoiceCountByStatus(1);
        $part_paid_invoices_count = invoiceCountByStatus(2);
        $unpaid_invoices_count = invoiceCountByStatus(0);

        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 200])
            ->labels(['الفواتير المدفوعة', 'الفواتير المدفوعة جزئياً', 'الفواتير الغير مدفوعة'])
            ->datasets([
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['green'],
                    'data' => [$paid_invoices_count]
                ],
                [
                    "label" => "الفواتير المدفوعة جزئياً",
                    'backgroundColor' => ['orange'],
                    'data' => [$part_paid_invoices_count]
                ],
                [
                    "label" => "الفواتير الغير مدفوعة",
                    'backgroundColor' => ['red'],
                    'data' => [$unpaid_invoices_count]
                ],
            ])
            ->options([]);

        $pieChartjs = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['الفواتير المدفوعة', 'الفواتير المدفوعة جزئياً', 'الفواتير الغير مدفوعة'])
            ->datasets([
                [
                    'backgroundColor' => ['green', 'orange','red'],
                    'data' => [$paid_invoices_count,$part_paid_invoices_count,$unpaid_invoices_count]
                ]
            ])
            ->options([]);

        

        return view('home', compact(['chartjs', 'pieChartjs']));
    }

    public function test()
    {
        $chartjs = app()->chartjs
            ->name('lineChartTest')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July'])
            ->datasets([
                [
                    "label" => "My First dataset",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [65, 59, 80, 81, 56, 55, 40],
                ],
                [
                    "label" => "My Second dataset",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [12, 33, 44, 44, 55, 23, 40],
                ]
            ])
            ->options([]);
    }
}
