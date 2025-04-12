<?php

namespace App\Http\Controllers;

use App\Models\PersonCategory;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PersonCategoryController extends Controller
{
    /**
     * نمایش لیست دسته‌بندی‌ها
     */
    public function index()
    {
        $data = [
            'current_datetime' => Carbon::now()->format('Y-m-d H:i:s'),
            'user_login' => Auth::user()->name ?? Auth::user()->email,
            'categories' => PersonCategory::orderBy('order')->get()
        ];
        
        return view('person-categories.index', $data);
    }

    /**
     * دریافت لیست دسته‌بندی‌ها به صورت JSON
     */
    public function list()
    {
        $categories = PersonCategory::orderBy('order')->get();
        return response()->json($categories);
    }

    /**
     * نمایش فرم ایجاد دسته‌بندی جدید
     */
    public function create()
    {
        $data = [
            'current_datetime' => Carbon::now()->format('Y-m-d H:i:s'),
            'user_login' => Auth::user()->name ?? Auth::user()->email
        ];
        
        return view('person-categories.create', $data);
    }

    /**
     * ذخیره دسته‌بندی جدید
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:7',
            'icon' => 'required|string|max:50',
            'order' => 'required|integer|min:0',
            'description' => 'nullable|string'
        ]);

        $category = PersonCategory::create($validated);

        if ($request->wantsJson()) {
            return response()->json($category);
        }

        return redirect()->route('person-categories.index')
            ->with('success', 'دسته‌بندی جدید با موفقیت ایجاد شد.');
    }

    /**
     * نمایش جزئیات دسته‌بندی
     */
    public function show(PersonCategory $personCategory)
    {
        $data = [
            'current_datetime' => Carbon::now()->format('Y-m-d H:i:s'),
            'user_login' => Auth::user()->name ?? Auth::user()->email,
            'category' => $personCategory
        ];
        
        return view('person-categories.show', $data);
    }

    /**
     * نمایش فرم ویرایش دسته‌بندی
     */
    public function edit(PersonCategory $personCategory)
    {
        $data = [
            'current_datetime' => Carbon::now()->format('Y-m-d H:i:s'),
            'user_login' => Auth::user()->name ?? Auth::user()->email,
            'category' => $personCategory
        ];
        
        return view('person-categories.edit', $data);
    }

    /**
     * به‌روزرسانی دسته‌بندی
     */
    public function update(Request $request, PersonCategory $personCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:7',
            'icon' => 'required|string|max:50',
            'order' => 'required|integer|min:0',
            'description' => 'nullable|string'
        ]);

        $personCategory->update($validated);

        if ($request->wantsJson()) {
            return response()->json($personCategory);
        }

        return redirect()->route('person-categories.index')
            ->with('success', 'دسته‌بندی با موفقیت به‌روزرسانی شد.');
    }

    /**
     * حذف دسته‌بندی
     */
    public function destroy(PersonCategory $personCategory)
    {
        $personCategory->delete();

        if (request()->wantsJson()) {
            return response()->json(['message' => 'دسته‌بندی با موفقیت حذف شد.']);
        }

        return redirect()->route('person-categories.index')
            ->with('success', 'دسته‌بندی با موفقیت حذف شد.');
    }
}