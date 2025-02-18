<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Crime;
use App\Models\CrimeType;
use App\Models\Contact;
use App\Models\CrimePending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // User Data Table
    public function displayUser()
    {
        $users = User::all();
        return view('admin_page/users', ['users' => $users]);
    }

    //Displaa Approved Crime
    public function displayCrime()
    {
        $crimes = Crime::all();
        $user = Auth::user();
        $crimeTypes = CrimeType::all();
        return view('admin_page/crimes', ['crimes' => $crimes, 'crimeTypes' => $crimeTypes],compact('user'));
    }
    // Display Pending Crimes
    public function displayPendingCrime()
    {
        $crime_pendings = CrimePending::all();
        return view('admin_page/pending', ['crime_pendings' => $crime_pendings]);
    }

    public function displayCrimeReport(){
        return view('user/report');
    }

    public function displayRecently(){
        $recentUsers = User::where('created_at', '>=', now()->subDay(7))->get();
        $recentCrimes = Crime::where('created_at', '>=', now()->subDay(7))-> get();
        return view('admin_page/home', ['recentUsers' => $recentUsers], ['recentCrimes' => $recentCrimes]);
    }
    public function addCrimeType(){
        return view('admin_page/addCrimeType');
    }
    public function storeCrimeType(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName); // Move uploaded file to public/images directory
        }

        $crimeType = new CrimeType;
        $crimeType->crime_type_name = $request->input('title');
        $crimeType->image = $imageName; // Save file name to database
        $crimeType->save();

        // Redirect to showCrimeType to fetch the latest data
        return redirect()->route('displayCrimeType');
    }

    public function showCrimeType()
    {
        $crimeTypes = CrimeType::all();
        return view('admin_page.showcrimetype', compact('crimeTypes')); // Referencing the correct folder
    }
    public function deleteCrimetype($id)
    {
        $crimeType = CrimeType::find($id);
        if ($crimeType) {
            $crimeType->delete();
        }
        return redirect()->route('displayCrimeType'); // Redirect to fetch the latest data
    }
    public function displayContacts(){
        $contacts = Contact::all();
        return view('admin_page/contacts', ['contacts' => $contacts]);
    }


}
