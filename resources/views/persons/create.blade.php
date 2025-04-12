@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="main-card">
        <div class="person-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4 class="mb-1">ایجاد شخص جدید</h4>
                    <p class="mb-0 text-white-50">اطلاعات شخص جدید را وارد کنید</p>
                    <small>{{ $current_datetime }} | {{ $user_login }}</small>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="{{ route('persons.index') }}" class="btn btn-light">
                        <i class="fas fa-arrow-right ml-1"></i>
                        بازگشت به لیست
                    </a>
                </div>
            </div>
        </div>

        <form action="{{ route('persons.store') }}" method="POST" enctype="multipart/form-data" id="personForm">
            @csrf
            <div class="tab-container">
                <!-- تب‌ها -->
                <ul class="nav nav-tabs" id="personTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">
                            <i class="fas fa-user"></i>
                            اطلاعات عمومی
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab">
                            <i class="fas fa-address-book"></i>
                            اطلاعات تماس
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="financial-tab" data-bs-toggle="tab" data-bs-target="#financial" type="button" role="tab">
                            <i class="fas fa-coins"></i>
                            اطلاعات مالی
                        </button>
                    </li>
                </ul>

                <!-- محتوای تب‌ها -->
                <div class="tab-content" id="personTabsContent">
                    <!-- تب اطلاعات عمومی -->
                    <div class="tab-pane fade show active" id="general" role="tabpanel">
                        <div class="section-card">
                            <div class="card-header">
                                <i class="fas fa-id-card"></i>
                                اطلاعات هویتی
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-3 text-center mb-4">
                                        <div class="image-upload-container">
                                            <img id="preview" src="{{ asset('images/avatar-placeholder.png') }}" alt="تصویر پروفایل">
                                            <div class="image-upload-overlay">
                                                <label for="image" class="mb-0">
                                                    <i class="fas fa-camera"></i>
                                                </label>
                                                <input type="file" id="image" name="image" class="d-none" accept="image/*" onchange="previewImage(event)">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <label for="code" class="form-label required">کد</label>
                                                <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                                       id="code" name="code" value="{{ old('code', $nextCode ?? '') }}" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="type" class="form-label required">نوع شخص</label>
                                                <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                                                    <option value="individual" {{ old('type') == 'individual' ? 'selected' : '' }}>شخص حقیقی</option>
                                                    <option value="company" {{ old('type') == 'company' ? 'selected' : '' }}>شخص حقوقی</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="title" class="form-label">عنوان</label>
                                                <select name="title" id="title" class="form-select">
                                                    <option value="">انتخاب کنید</option>
                                                    <option value="آقای">آقای</option>
                                                    <option value="خانم">خانم</option>
                                                    <option value="دکتر">دکتر</option>
                                                    <option value="مهندس">مهندس</option>
                                                    <option value="شرکت">شرکت</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="category" class="form-label required">دسته‌بندی</label>
                                                <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- اطلاعات شخص حقیقی -->
                                <div class="individual-fields mt-4">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label for="first_name" class="form-label required">نام</label>
                                            <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="last_name" class="form-label required">نام خانوادگی</label>
                                            <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="national_code" class="form-label">کد ملی</label>
                                            <input type="text" class="form-control" name="national_code" value="{{ old('national_code') }}"
                                                   pattern="\d{10}" title="کد ملی باید ۱۰ رقم باشد">
                                        </div>
                                    </div>
                                </div>

                                <!-- اطلاعات شخص حقوقی -->
                                <div class="company-fields d-none mt-4">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label for="company_name" class="form-label required">نام شرکت</label>
                                            <input type="text" class="form-control" name="company_name" value="{{ old('company_name') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="economic_code" class="form-label">کد اقتصادی</label>
                                            <input type="text" class="form-control" name="economic_code" value="{{ old('economic_code') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="registration_number" class="form-label">شماره ثبت</label>
                                            <input type="text" class="form-control" name="registration_number" value="{{ old('registration_number') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- تب اطلاعات تماس -->
                    <div class="tab-pane fade" id="contact" role="tabpanel">
                        <div class="section-card">
                            <div class="card-header">
                                <i class="fas fa-phone-alt"></i>
                                اطلاعات تماس
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label for="mobile" class="form-label">موبایل</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                            <input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}"
                                                   pattern="\d{11}" title="شماره موبایل باید ۱۱ رقم باشد">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="phone" class="form-label">تلفن ثابت</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="email" class="form-label">ایمیل</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="website" class="form-label">وب‌سایت</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                            <input type="url" class="form-control" name="website" value="{{ old('website') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="section-card">
                            <div class="card-header">
                                <i class="fas fa-map-marker-alt"></i>
                                آدرس
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="state" class="form-label">استان</label>
                                        <select name="state" class="form-select" id="state">
                                            <option value="">انتخاب کنید</option>
                                            <!-- لیست استان‌ها -->
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="city" class="form-label">شهر</label>
                                        <select name="city" class="form-select" id="city">
                                            <option value="">انتخاب کنید</option>
                                            <!-- لیست شهرها -->
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="postal_code" class="form-label">کد پستی</label>
                                        <input type="text" class="form-control" name="postal_code" value="{{ old('postal_code') }}"
                                               pattern="\d{10}" title="کد پستی باید ۱۰ رقم باشد">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="address" class="form-label">آدرس</label>
                                        <textarea class="form-control" name="address" rows="3">{{ old('address') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- تب اطلاعات مالی -->
                    <div class="tab-pane fade" id="financial" role="tabpanel">
                        <div class="section-card">
                            <div class="card-header">
                                <i class="fas fa-wallet"></i>
                                اطلاعات مالی
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="credit_limit" class="form-label">سقف اعتبار</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                            <input type="number" class="form-control" name="credit_limit" 
                                                   value="{{ old('credit_limit', 0) }}">
                                            <span class="input-group-text">ریال</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="opening_balance" class="form-label">مانده اول دوره</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                            <input type="number" class="form-control" name="opening_balance" 
                                                   value="{{ old('opening_balance', 0) }}">
                                            <span class="input-group-text">ریال</span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="description" class="form-label">توضیحات</label>
                                        <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- دکمه‌های فرم -->
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-save me-1"></i>
                        ذخیره اطلاعات
                    </button>
                    <a href="{{ route('persons.index') }}" class="btn btn-secondary" id="cancelBtn">
                        انصراف
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.main-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0,0,0,0.05);
}

.person-header {
    background: linear-gradient(45deg, #4F46E5, #3b82f6);
    padding: 2rem;
    border-radius: 15px 15px 0 0;
    color: white;
    margin-bottom: 2rem;
}

.required:after {
    content: " *";
    color: red;
}

.section-card {
    background: white;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    margin-bottom: 1.5rem;
}

.section-card .card-header {
    background: #f8fafc;
    padding: 1rem;
    border-bottom: 1px solid #e5e7eb;
    font-weight: 600;
}

.section-card .card-body {
    padding: 1.5rem;
}

.nav-tabs {
    border: none;
    margin-bottom: 1rem;
}

.nav-tabs .nav-link {
    border: none;
    color: #6b7280;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    margin-right: 0.5rem;
}

.nav-tabs .nav-link:hover {
    background: #f3f4f6;
}

.nav-tabs .nav-link.active {
    background: #4F46E5;
    color: white;
}

.form-label {
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.input-group-text {
    background: #f8fafc;
}

.card-footer {
    background: #f8fafc;
    border-top: 1px solid #e5e7eb;
    padding: 1rem;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('personForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const formData = new FormData(form);
    const submitBtn = form.querySelector('#submitBtn');
    submitBtn.disabled = true;

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'موفق',
                text: 'شخص با موفقیت ذخیره شد',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location.href = '{{ route("persons.index") }}';
            });
        } else {
            let errorMessage = '';
            if (data.errors) {
                errorMessage = Object.values(data.errors).flat().join('<br>');
            } else {
                errorMessage = data.message || 'خطا در ذخیره اطلاعات';
            }
            
            Swal.fire({
                icon: 'error',
                title: 'خطا',
                html: errorMessage,
                confirmButtonText: 'تلاش مجدد'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'خطا',
            text: 'خطا در ارتباط با سرور',
            confirmButtonText: 'تلاش مجدد'
        });
    })
    .finally(() => {
        submitBtn.disabled = false;
    });
});

// تغییر فیلدها بر اساس نوع شخص
document.getElementById('type').addEventListener('change', function() {
    const individualFields = document.querySelector('.individual-fields');
    const companyFields = document.querySelector('.company-fields');
    
    if (this.value === 'company') {
        individualFields.classList.add('d-none');
        companyFields.classList.remove('d-none');
        Swal.fire({
            icon: 'info',
            title: 'تغییر نوع شخص',
            text: 'شخص حقوقی انتخاب شد',
            showConfirmButton: false,
            timer: 1500
        });
    } else {
        individualFields.classList.remove('d-none');
        companyFields.classList.add('d-none');
        Swal.fire({
            icon: 'info',
            title: 'تغییر نوع شخص',
            text: 'شخص حقیقی انتخاب شد',
            showConfirmButton: false,
            timer: 1500
        });
    }
});

// اطلاع رسانی تغییر دسته‌بندی
document.getElementById('category_id').addEventListener('change', function() {
    const selectedCategory = this.options[this.selectedIndex].text;
    Swal.fire({
        icon: 'info',
        title: 'تغییر دسته‌بندی',
        text: `دسته‌بندی ${selectedCategory} انتخاب شد`,
        showConfirmButton: false,
        timer: 1500
    });
});

// اطلاع رسانی انصراف
document.getElementById('cancelBtn').addEventListener('click', function(e) {
    e.preventDefault();
    Swal.fire({
        icon: 'warning',
        title: 'انصراف',
        text: 'آیا مطمئن هستید که می‌خواهید انصراف دهید؟',
        showCancelButton: true,
        confirmButtonText: 'بله',
        cancelButtonText: 'خیر'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '{{ route("persons.index") }}';
        }
    });
});
</script>
@endpush

@endsection