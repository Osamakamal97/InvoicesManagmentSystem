<?php

namespace App\Http\Controllers;

use App\Charts\SampleChart;
use App\Models\Invoice;
use App\Models\User;
use App\Notifications\CreateInvoice;
use App\Notifications\RealTimeNotification;
use Carbon\Carbon;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\ChartsController;
use CreateNotificationsTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        // $user = User::first();
        
        // $user->notify(new CreateInvoice(Invoice::first()));

        $paid_invoices_count = invoiceCountByStatus(1);
        $part_paid_invoices_count = invoiceCountByStatus(2);
        $unpaid_invoices_count = invoiceCountByStatus(0);

        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
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
            ]);

        $pieChartjs = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['الفواتير المدفوعة', 'الفواتير المدفوعة جزئياً', 'الفواتير الغير مدفوعة'])
            ->datasets([
                [
                    'backgroundColor' => ['green', 'orange', 'red'],
                    'data' => [$paid_invoices_count, $part_paid_invoices_count, $unpaid_invoices_count]
                ]
            ])
            ->options([]);

        return view('home', compact(['chartjs', 'pieChartjs']));
    }

    public function test()
    {
        // return 11%10;
        $is_reach_ten = false;
        $text = '';
        $index = 1;
        while ($index <= 100) {
            if (!$is_reach_ten) {
                if ($index % 10 == 0) {
                    $is_reach_ten = true;
                } else {
                    for ($i = 1; $i <= $index % 10; $i++)
                        // $text .= "صمتسسسي ";
                        $text .= ".";
                    $text .= "<br>";
                }
            } else {
                if ($index % 10 == 0) {
                    $is_reach_ten = false;
                } else {
                    for ($i = 10; $i >= $index % 10; $i--)
                        // $text .= "صمتسسسي ";
                        $text .= ".";
                    $text .= "<br>";
                }
            }
            $index++;
        }

        $input = 1;
        if ($input % 2 != 0 || (5 < $input && $input < 21)) {
            $text = 'Wired';
        } else {
            $text = 'Not Wired';
        }

        return view('test', compact('text'));
    }
}
