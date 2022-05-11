<?php

namespace App\Http\Controllers;

use App\Actions\MonthlyReport;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function getMonthlyReport(Request $request, MonthlyReport $monthlyReport)
    {
//       $results = $monthlyReport->execute($request->startYearMonthly, $request->startMonthMonthly, $request->endYearMonthly, $request->endMonthMonthly);
       $results = $monthlyReport->execute($request->start, $request->end);

       return $results;
    }
}
