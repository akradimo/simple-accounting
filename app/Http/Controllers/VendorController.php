<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::with('person')->get();
        return view('vendors.index', compact('vendors'));
    }

    public function create()
    {
        return view('vendors.create');
    }

    public function store(Request $request)
    {
        // اعتبارسنجی و ذخیره
    }

    public function show(Vendor $vendor)
    {
        return view('vendors.show', compact('vendor'));
    }

    public function edit(Vendor $vendor)
    {
        return view('vendors.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        // اعتبارسنجی و به‌روزرسانی
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        return response()->json(['message' => 'فروشنده با موفقیت حذف شد']);
    }
}