<?php

namespace App\Http\Controllers;

use App\Models\Spot;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $spotcounts = Spot::count();

        return view('admin.dashboard', ['spotcounts' => $spotcounts]);
    }
}
