<?php

namespace App\Http\Controllers;

use App\Models\Crime;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ChartController extends Controller
{
    public function crimeStats()
    {
        $crimes = Crime::select('crime_type', \DB::raw('count(*) as total'))
                              ->groupBy('crime_type')
                              ->get();

        $totalCrimes = $crimes->sum('total');
        $crimeStats = $crimes->map(function ($crime) use ($totalCrimes) {
            return [
                'crime_type' => $crime->crime_type,
                'percentage' => round(($crime->total / $totalCrimes) * 100, 2)
            ];
        });

        return response()->json($crimeStats);
    }

    public function crimeCounts()
    {
        $crimes = Crime::select('crime_type', \DB::raw('count(*) as total'))
                              ->groupBy('crime_type')
                              ->get();

        return response()->json($crimes);
    }


    public function crimeOverMonths()
    {
        $crimes = Crime::select(\DB::raw('MONTH(date) as month'), \DB::raw('count(*) as total'))
                              ->groupBy('month')
                              ->orderBy('month')
                              ->get();

        // Format data for the chart
        $crimeData = $crimes->map(function ($crime) {
            return [
                'month' => Carbon::create()->month($crime->month)->format('M'), // Convert month number to month name
                'total' => $crime->total,
            ];
        });

        return response()->json($crimeData);
    }

}
