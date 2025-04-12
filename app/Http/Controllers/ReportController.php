<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function balanceSheet()
    {
        $data = [
            'current_datetime' => Carbon::now()->format('Y-m-d H:i:s'),
            'user_login' => Auth::user()->name ?? Auth::user()->email
        ];
        
        return view('reports.balance-sheet', $data);
    }

    public function debtorsCreditors()
    {
        $data = [
            'current_datetime' => Carbon::now()->format('Y-m-d H:i:s'),
            'user_login' => Auth::user()->name ?? Auth::user()->email
        ];
        
        return view('reports.debtors-creditors', $data);
    }
}