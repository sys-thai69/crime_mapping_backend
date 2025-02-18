<?php

namespace App\Http\Controllers;

use App\Models\Crime;
use App\Models\CrimeType;
use App\Models\CrimePending;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CrimeController extends Controller
{
    public function reportCrime(Request $request)
    {
        $report = $request->validate([
            'crime_type' => 'required|string',
            'date' => 'required|date',
            'description' => 'required|string',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
        if ($request->crime_type === 'other') {
            $request->validate([
                'new_crime_type' => 'required|string|max:255',
            ]);
            $crimeType = CrimeType::create(['crime_type_name' => $request->new_crime_type]);
            $crimeTypeId = $crimeType->id;
        } else {
            $crimeTypeId = $request->crime_type;
        }

        $pending_crime = CrimePending::create([
            'reportedby_user_id' => Auth::id(),  // Use the user ID instead of username
            'crime_type' => $report['crime_type'],
            'date' => $report['date'],
            'description' => $report['description'],
            'address' => $report['address'],
            'latitude' => $report['latitude'],
            'longitude' => $report['longitude'],
            'status' => 'pending'
        ]);

        return redirect('/map')->with('success', 'Crime reported successfully.');
    }
    
    public function update(Request $request, Crime $crime)
    {
        $validatedData = $request->validate([
            'crime_type' => 'required|string',
        ]);
        $crime->update($request->all());
        return redirect('/crime_dash')->with('success', 'Crime updated successfully');
    }

    public function deleteCrime(Crime $crime)
    {
        $crime->delete();
        return redirect('/crime_dash');
    }

    public function approvePendingCrime(CrimePending $crimePending)
    {
        $crime = new Crime([
            'description' => $crimePending->description,
            'date' => $crimePending->date,
            'status' => $crimePending->status,
            'longitude' => $crimePending->longitude,
            'latitude' => $crimePending->latitude,
            'address' => $crimePending->address,
            'reportedby_user_id' => $crimePending->reportedby_user_id,
            'crime_type' => $crimePending->crime_type,
            'approvedby_admin_id' => Auth::guard('admin')->id(),
        ]);

        $crime->save();
        $crimePending->delete();

        return redirect('/crime_dash')->with('success', 'Crime confirmed successfully');
    }

    public function deletePendingCrime(CrimePending $crimePending)
    {
        $crimePending->delete();
        return redirect('/pending_report')->with('success', 'Pending crime deleted successfully');
    }


}
