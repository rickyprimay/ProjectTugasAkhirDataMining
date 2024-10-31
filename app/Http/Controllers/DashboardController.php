<?php

namespace App\Http\Controllers;

use App\Models\Trash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
{
    $userId = Auth::id();

    $trashes = Trash::where('user_id', $userId)->get();

    $totalTrash = $trashes->count();
    
    $totalOrganic = $trashes->where('label', 'organic')->count();
    $totalAnorganic = $trashes->where('label', 'anorganic')->count();

    $totalCO = $trashes->sum('co');

    return view('dashboard.index', compact('totalTrash', 'totalOrganic', 'totalAnorganic', 'totalCO'));
}

}
