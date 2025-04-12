<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Requests\PersonRequest;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PersonController extends Controller
{
    /**
     * نمایش لیست اشخاص
     */
    public function index(Request $request)
    {
        $query = Person::query();

        // اعمال فیلترها
        if ($request->has('type')) {
            $query->ofType($request->type);
        }

        if ($request->has('status')) {
            $query->withStatus($request->status);
        }

        if ($request->has('search')) {
            $query->search($request->search);
        }

        // مرتب‌سازی
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $people = $query->paginate(15)->withQueryString();

        return view('people.index', [
            'people' => $people,
            'types' => Person::getTypes(),
            'statuses' => Person::getStatuses(),
            'filters' => $request->all()
        ]);
    }

    /**
     * نمایش فرم ایجاد شخص جدید
     */
    public function create()
    {
        // تولید کد حسابداری جدید
        $lastCode = Person::max('code') ?? 1000;
        $nextCode = $lastCode + 1;

        return view('people.create', [
            'types' => Person::getTypes(),
            'statuses' => Person::getStatuses(),
            'nextCode' => $nextCode
        ]);
    }

    /**
     * ذخیره شخص جدید
     */
    public function store(PersonRequest $request)
    {
        try {
            DB::beginTransaction();

            $person = Person::create([
                ...$request->validated(),
                'created_by' => auth()->id()
            ]);

            // ایجاد تراکنش اولیه در صورت وجود
            if ($request->filled('initial_balance')) {
                $transactionType = $request->initial_balance >= 0 
                    ? Transaction::TYPE_RECEIPT 
                    : Transaction::TYPE_PAYMENT;

                Transaction::create([
                    'date' => now(),
                    'type' => $transactionType,
                    'amount' => abs($request->initial_balance),
                    'description' => 'مانده اولیه',
                    'person_id' => $person->id,
                    'payment_method' => Transaction::METHOD_CASH,
                    'status' => Transaction::STATUS_COMPLETED,
                    'created_by' => auth()->id()
                ]);
            }

            DB::commit();
            Alert::success('موفق', 'شخص جدید با موفقیت ایجاد شد');
            return redirect()->route('people.index');

        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('خطا', 'مشکلی در ایجاد شخص رخ داد');
            return back()->withInput();
        }
    }

    /**
     * نمایش اطلاعات شخص
     */
    public function show(Person $person)
    {
        $person->load(['transactions' => function ($query) {
            $query->latest('date')->take(10);
        }, 'sales' => function ($query) {
            $query->latest()->take(5);
        }, 'purchases' => function ($query) {
            $query->latest()->take(5);
        }]);

        $balance = $person->calculateBalance();

        return view('people.show', [
            'person' => $person,
            'balance' => $balance
        ]);
    }

    /**
     * نمایش فرم ویرایش شخص
     */
    public function edit(Person $person)
    {
        return view('people.edit', [
            'person' => $person,
            'types' => Person::getTypes(),
            'statuses' => Person::getStatuses()
        ]);
    }

    /**
     * بروزرسانی اطلاعات شخص
     */
    public function update(PersonRequest $request, Person $person)
    {
        try {
            $person->update([
                ...$request->validated(),
                'updated_by' => auth()->id()
            ]);

            Alert::success('موفق', 'اطلاعات شخص با موفقیت بروزرسانی شد');
            return redirect()->route('people.index');

        } catch (\Exception $e) {
            Alert::error('خطا', 'مشکلی در بروزرسانی اطلاعات رخ داد');
            return back()->withInput();
        }
    }

    /**
     * حذف شخص
     */
    public function destroy(Person $person)
    {
        try {
            // بررسی وجود تراکنش‌های مرتبط
            if ($person->transactions()->exists()) {
                Alert::warning('هشدار', 'این شخص دارای تراکنش است و قابل حذف نیست');
                return back();
            }

            $person->delete();
            Alert::success('موفق', 'شخص با موفقیت حذف شد');
            return redirect()->route('people.index');

        } catch (\Exception $e) {
            Alert::error('خطا', 'مشکلی در حذف شخص رخ داد');
            return back();
        }
    }

    /**
     * نمایش گزارش مالی شخص
     */
    public function report(Person $person, Request $request)
    {
        $query = $person->transactions();

        // اعمال فیلتر تاریخ
        if ($request->has(['start_date', 'end_date'])) {
            $query->betweenDates($request->start_date, $request->end_date);
        }

        $transactions = $query->latest('date')->paginate(20);
        $balance = $person->calculateBalance();

        return view('people.report', [
            'person' => $person,
            'transactions' => $transactions,
            'balance' => $balance,
            'filters' => $request->all()
        ]);
    }
}