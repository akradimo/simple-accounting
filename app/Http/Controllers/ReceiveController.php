<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Person;
use App\Models\CommonDescription;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ReceiveController extends Controller
{
    public function index()
    {
        $data = [
            'projects' => Project::active()->get(),
            'contacts' => Person::active()->customers()->get(),
            'commonDescriptions' => CommonDescription::active()->latest()->get(),
            'current_datetime' => Carbon::now()->format('Y-m-d H:i:s'),
            'user_login' => Auth::user()->name ?? 'esmeeilir1'
        ];
        
        return view('receive', $data);
    }

    public function getProjects()
    {
        $projects = Project::active()->get();
        return response()->json($projects);
    }

    public function storeProject(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|unique:projects,code',
            'description' => 'nullable|string'
        ]);

        $project = Project::create($validated + [
            'created_by' => Auth::id(),
            'status' => 'active'
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'project' => $project,
                'message' => 'پروژه جدید با موفقیت ایجاد شد'
            ]);
        }

        Alert::success('موفق', 'پروژه جدید با موفقیت ایجاد شد');
        return back();
    }

    public function getPersons()
    {
        $persons = Person::active()->customers()->get();
        return response()->json($persons);
    }

    public function storePerson(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile' => 'nullable|string|max:11',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string'
        ]);

        $code = Person::max('code');
        $nextCode = $code ? str_pad((intval($code) + 1), 6, '0', STR_PAD_LEFT) : '000001';

        $person = Person::create($validated + [
            'code' => $nextCode,
            'type' => 'individual',
            'is_customer' => true,
            'is_active' => true,
            'created_by' => Auth::id()
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'person' => $person,
                'message' => 'شخص جدید با موفقیت ایجاد شد'
            ]);
        }

        Alert::success('موفق', 'شخص جدید با موفقیت ایجاد شد');
        return back();
    }

    public function getCommonDescriptions()
    {
        $descriptions = CommonDescription::active()->latest()->get();
        return response()->json($descriptions);
    }

    public function storeCommonDescription(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:500'
        ]);

        $description = CommonDescription::create($validated + [
            'created_by' => Auth::id(),
            'is_active' => true
        ]);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'description' => $description,
                'message' => 'شرح جدید با موفقیت ایجاد شد'
            ]);
        }

        Alert::success('موفق', 'شرح جدید با موفقیت ایجاد شد');
        return back();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:8|unique:receipts,number',
            'date' => 'required|date',
            'project_id' => 'nullable|exists:projects,id',
            'description' => 'nullable|string',
            'currency' => 'required|string|size:3',
            'items' => 'required|array|min:1',
            'items.*.person_id' => 'required|exists:people,id',
            'items.*.amount' => 'required|numeric|min:0',
            'items.*.description' => 'nullable|string',
            'payments' => 'required|array|min:1',
            'payments.*.type' => 'required|in:cash,petty-cash,bank,check,person,account',
            'payments.*.amount' => 'required|numeric|min:0',
            'payments.*.reference' => 'nullable|string',
            'payments.*.details' => 'nullable|array'
        ]);

        // محاسبه مجموع مبالغ آیتم‌ها
        $totalAmount = collect($validated['items'])->sum('amount');

        $receipt = Receipt::create([
            'number' => $validated['number'],
            'date' => $validated['date'],
            'project_id' => $validated['project_id'],
            'description' => $validated['description'],
            'currency' => $validated['currency'],
            'amount' => $totalAmount,
            'is_active' => true,
            'status' => false, // وضعیت پرداخت نشده
            'created_by' => Auth::id()
        ]);

        // ایجاد آیتم‌ها
        $receipt->items()->createMany($validated['items']);

        // ایجاد پرداخت‌ها
        $receipt->payments()->createMany($validated['payments']);

        // بررسی وضعیت پرداخت
        $receipt->updatePaymentStatus();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'receipt' => $receipt->load(['items.person', 'payments']),
                'message' => 'دریافت با موفقیت ثبت شد'
            ]);
        }

        Alert::success('موفق', 'دریافت با موفقیت ثبت شد');
        return redirect()->route('receipts.index');
    }

    public function show(Receipt $receipt)
    {
        $receipt->load(['project', 'items.person', 'payments', 'creator', 'updater']);
        
        return view('receipts.show', compact('receipt'));
    }

    public function print(Receipt $receipt)
    {
        $receipt->load(['project', 'items.person', 'payments']);
        
        return view('receipts.print', compact('receipt'));
    }

    public function getNextNumber()
    {
        $lastNumber = Receipt::max('number');
        $nextNumber = $lastNumber ? str_pad((intval($lastNumber) + 1), 8, '0', STR_PAD_LEFT) : '00000001';
        
        return response()->json(['number' => $nextNumber]);
    }
}