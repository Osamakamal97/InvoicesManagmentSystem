<?php

declare(strict_types=1);

namespace App\Charts;

use App\Models\Invoice;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class SampleChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        // Homepage bar chart
        $paid_invoices = Invoice::whereStatus(1)->count();
        $part_paid_invoices = Invoice::whereStatus(2)->count();
        $unpaid_invoices = Invoice::whereStatus(0)->count();
        return Chartisan::build()
            ->labels([__('frontend.paid_invoices'), __('frontend.part_paid_invoices'), __('frontend.unpaid_invoices')])
            ->dataset('Sample', [$paid_invoices, $part_paid_invoices, $unpaid_invoices]);
    }
}
