<?php

namespace App\Http\Controllers;

use App\Models\Shareholder;
use Illuminate\Http\Request;

class ShareholderController extends Controller
{
    public function index()
    {
        $shareholders = Shareholder::with('person')->get();
        return view('shareholders.index', compact('shareholders'));
    }

    public function create()
    {
        return view('shareholders.create');
    }

    public function store(Request $request)
    {
        // اعتبارسنجی و ذخیره
    }

    public function show(Shareholder $shareholder)
    {
        return view('shareholders.show', compact('shareholder'));
    }

    public function edit(Shareholder $shareholder)
    {
        return view('shareholders.edit', compact('shareholder'));
    }

    public function update(Request $request, Shareholder $shareholder)
    {
        // اعتبارسنجی و به‌روزرسانی
    }

    public function destroy(Shareholder $shareholder)
    {
        $shareholder->delete();
        return response()->json(['message' => 'سهامدار با موفقیت حذف شد']);
    }
}