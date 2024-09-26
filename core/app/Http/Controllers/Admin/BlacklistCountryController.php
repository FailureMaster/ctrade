<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlacklistCountry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlacklistCountryController extends Controller
{
    public function index()
    {
        $pageTitle = 'Blacklist Country Manager';
        $blacklistCountries = BlacklistCountry::query()->get();

        return view('admin.setting.blacklisted', compact('pageTitle', 'blacklistCountries'));
    }
    
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            BlacklistCountry::create([
                'name' => $request->get('country')
            ]);
        });
    
        return redirect()->back()->with('success', 'Country blacklisted successfully');
    }
    
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $country = BlacklistCountry::findOrFail($id);

            $country->delete();
        });
    
        return redirect()->back()->with('success', 'Country removed from blacklists successfully.');
    }
}