<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AccountingController extends Controller
{
    public function index()
    {
        $data = [
            'current_datetime' => Carbon::now()->format('Y-m-d H:i:s'),
            'user_login' => Auth::user()->name ?? Auth::user()->email
        ];
        
        return view('accounting.index', $data);
    }

    public function entries()
    {
        $data = [
            'current_datetime' => Carbon::now()->format('Y-m-d H:i:s'),
            'user_login' => Auth::user()->name ?? Auth::user()->email
        ];
        
        return view('accounting.entries', $data);
    }

    public function chartAccounts()
    {
        $data = [
            'current_datetime' => Carbon::now()->format('Y-m-d H:i:s'),
            'user_login' => Auth::user()->name ?? Auth::user()->email
        ];
        
        return view('accounting.chart-accounts', $data);
    }

    public function create()
    {
        $data = [
            'current_datetime' => Carbon::now()->format('Y-m-d H:i:s'),
            'user_login' => Auth::user()->name ?? Auth::user()->email
        ];
        
        return view('accounting.create', $data);
    }

    public function store(Request $request)
    {
        // اعتبارسنجی و ذخیره سند حسابداری
        $validated = $request->validate([
            'date' => 'required|date',
            'description' => 'required|string',
            'entries' => 'required|array|min:2',
            'entries.*.account_id' => 'required|exists:accounts,id',
            'entries.*.debit' => 'required_without:entries.*.credit|numeric|min:0',
            'entries.*.credit' => 'required_without:entries.*.debit|numeric|min:0',
        ]);

        // منطق ذخیره سند

        return response()->json([
            'message' => 'سند حسابداری با موفقیت ثبت شد'
        ]);
    }
}