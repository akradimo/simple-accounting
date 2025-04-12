<?php

namespace App\Http\Controllers;
use App\Models\Person;
use App\Models\Category;
use App\Models\PersonCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; // اضافه شد
use RealRashid\SweetAlert\Facades\Alert;
class PersonController extends Controller
{
    public function index()
    {
        // دریافت اطلاعات اشخاص
        $persons = Person::query()
            ->with('category')
            ->get()
            ->map(function ($person) {
                return [
                    'id' => $person->id,
                    'code' => $person->code,
                    'type' => $person->type,
                    'full_name' => $person->type === 'individual' 
                        ? "{$person->first_name} {$person->last_name}"
                        : $person->company_name,
                    'category_name' => $person->category?->name,
                    'category_id' => $person->category_id,
                    'mobile' => $person->mobile,
                    'phone' => $person->phone,
                    'status' => $person->is_active,
                    'credit_limit' => (float) $person->credit_limit,
                    'balance' => (float) $person->opening_balance,
                ];
            });

        // دریافت دسته‌بندی‌ها
        $categories = PersonCategory::orderBy('name')->get();

        // دریافت تاریخ و نام کاربر
        $data = [
            'persons' => $persons,
            'categories' => $categories,
            'current_datetime' => Carbon::now()->format('Y-m-d H:i:s'),
            'user_login' => Auth::user()->name ?? 'esmeeilir1'
        ];

        return view('persons.index', $data);
    }

    public function create()
    {
        $lastCode = Person::max('code');
        $nextCode = $lastCode ? str_pad((intval($lastCode) + 1), 6, '0', STR_PAD_LEFT) : '000001';
        $categories = PersonCategory::where('is_active', true)->orderBy('order')->get();

        return view('people.create', compact('nextCode', 'categories'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'code' => 'required|string|unique:people,code',
                'type' => 'required|in:individual,company',
                'title' => 'nullable|string',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'mobile' => 'nullable|string|max:11',
                'phone' => 'nullable|string|max:11',
                'email' => 'nullable|email',
                'address' => 'nullable|string',
                'category_id' => 'required|exists:person_categories,id',
                'credit_limit' => 'nullable|numeric|min:0',
                'opening_balance' => 'nullable|numeric',
                'status' => 'boolean'
            ]);

            $person = Person::create($validated);
            DB::commit();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'شخص جدید با موفقیت ایجاد شد'
                ]);
            }

            Alert::success('موفق', 'شخص جدید با موفقیت ایجاد شد');
            return redirect()->route('persons.index');

        } catch (ValidationException $e) {
            DB::rollBack();
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors()
                ], 422);
            }

            Alert::error('خطا', 'لطفاً اطلاعات را به درستی وارد کنید');
            return back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'خطا در ذخیره اطلاعات'
                ], 500);
            }

            Alert::error('خطا', 'خطا در ذخیره اطلاعات');
            return back()->withInput();
        }
    }


    // سایر متدها بدون تغییر...
    // تمام متدهای دیگر کنترلر بدون تغییر باقی می‌مانند
    
    public function show(Person $person)
    {
        $person->load(['category', 'bankAccounts', 'transactions']);
        return view('people.show', compact('person'));
    }

    public function edit(Person $person)
    {
        $categories = PersonCategory::where('is_active', true)->orderBy('order')->get();
        $person->load('bankAccounts');
        return view('people.edit', compact('person', 'categories'));
    }

    public function update(Request $request, Person $person)
    {
        $validated = $this->validatePerson($request, $person->id);

        if ($request->hasFile('image')) {
            if ($person->image) {
                Storage::disk('public')->delete($person->image);
            }
            $validated['image'] = $this->handleImageUpload($request->file('image'));
        }

        $person->update($validated);

        if ($request->has('bank_accounts')) {
            $this->saveBankAccounts($person, $request->bank_accounts);
        }

        return response()->json([
            'message' => 'اطلاعات با موفقیت به‌روزرسانی شد',
            'redirect' => route('persons.index')
        ]);
    }

    public function destroy(Person $person)
    {
        try {
            if ($person->transactions()->exists()) {
                return response()->json([
                    'message' => 'این شخص دارای تراکنش است و قابل حذف نیست'
                ], 422);
            }

            if ($person->image) {
                Storage::disk('public')->delete($person->image);
            }

            $person->delete();

            return response()->json([
                'message' => 'شخص با موفقیت حذف شد'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'خطا در حذف شخص'
            ], 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        $hasTransactions = Person::whereIn('id', $ids)->whereHas('transactions')->exists();

        if ($hasTransactions) {
            return response()->json([
                'message' => 'برخی از اشخاص انتخابی دارای تراکنش هستند و قابل حذف نیستند'
            ], 422);
        }

        Person::whereIn('id', $ids)->get()->each(function($person) {
            if ($person->image) {
                Storage::disk('public')->delete($person->image);
            }
        });

        Person::whereIn('id', $ids)->delete();

        return response()->json([
            'message' => 'اشخاص انتخاب شده با موفقیت حذف شدند'
        ]);
    }

    public function bulkStatus(Request $request)
    {
        $status = $request->status === 'enable';
        Person::whereIn('id', $request->ids)->update(['is_active' => $status]);

        return response()->json([
            'message' => 'وضعیت اشخاص انتخاب شده با موفقیت تغییر کرد'
        ]);
    }

    public function export()
    {
        return Excel::download(new PeopleExport, 'people.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls'
        ]);

        try {
            Excel::import(new PeopleImport, $request->file('excel_file'));

            return response()->json([
                'message' => 'اطلاعات با موفقیت وارد شد'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'خطا در ورود اطلاعات: ' . $e->getMessage()
            ], 422);
        }
    }

    public function getCurrentInfo()
    {
        return response()->json([
            'current_datetime' => now()->format('Y-m-d H:i:s'),
            'user_login' => auth()->user()->name ?? auth()->user()->email
        ]);
    }

    private function validatePerson(Request $request, $id = null)
    {
        return $request->validate([
            'code' => 'required|string|unique:people,code,' . $id,
            'type' => 'required|in:individual,company',
            'title' => 'nullable|string|max:50',
            'first_name' => 'required_if:type,individual|nullable|string|max:255',
            'last_name' => 'required_if:type,individual|nullable|string|max:255',
            'display_name' => 'nullable|string|max:255',
            'company_name' => 'required_if:type,company|nullable|string|max:255',
            'national_code' => 'nullable|string|unique:people,national_code,' . $id,
            'economic_code' => 'nullable|string',
            'registration_number' => 'nullable|string',
            'mobile' => 'nullable|string|max:11',
            'phone' => 'nullable|string|max:11',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'country' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'postal_code' => 'nullable|string|max:10',
            'category_id' => 'required|exists:person_categories,id',
            'is_customer' => 'boolean',
            'is_supplier' => 'boolean',
            'is_employee' => 'boolean',
            'is_shareholder' => 'boolean',
            'is_active' => 'boolean',
            'credit_limit' => 'nullable|numeric|min:0',
            'opening_balance' => 'nullable|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
    }

    private function handleImageUpload($file)
    {
        $fileName = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $path = 'people/' . $fileName;

        $image = Image::make($file)
            ->fit(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->encode('jpg', 80);

        Storage::disk('public')->put($path, $image);

        return $path;
    }

    private function saveBankAccounts($person, $accounts)
    {
        $person->bankAccounts()->delete();

        foreach ($accounts as $account) {
            if (!empty($account['bank']) && !empty($account['account_number'])) {
                $person->bankAccounts()->create($account);
            }
        }
    }
}