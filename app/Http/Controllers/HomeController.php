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

        $paid_invoices_count = invoiceCountByStatus(1);
        $part_paid_invoices_count = invoiceCountByStatus(2);
        $unpaid_invoices_count = invoiceCountByStatus(0);

        $pieChartjs = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels([__('frontend.paid_invoices'), __('frontend.part_paid_invoices'),  __('frontend.unpaid_invoices')])
            ->datasets([
                [
                    'backgroundColor' => ['green', 'orange', 'red'],
                    'data' => [$paid_invoices_count, $part_paid_invoices_count, $unpaid_invoices_count]
                ]
            ])
            ->options([]);

        return view('home', compact(['pieChartjs']));
    }

}
