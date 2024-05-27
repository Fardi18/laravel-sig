<?php

namespace App\Http\Controllers;

use App\Models\Spot;

class HomeController extends Controller
{
    public function maps()
    {
        $spots = Spot::all();
        return view('welcome', ['spots' => $spots]);
    }

    public function getRoute($id)
    {
        /**
         * Menampilkan rute spot berdasarkan lokasi spot yang dipilih
         */
        $spots = Spot::where('id', $id)->first();
        return view('route', [
            'spots' => $spots,
        ]);
    }

    public function detailSpot($id)
    {
        $spot = Spot::findOrFail($id);

        return view('detailspot', ['spot' => $spot]);
    }
}
