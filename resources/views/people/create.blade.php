@extends('layouts.app')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<style>
.image-upload-container {
    position: relative;
    width: 150px;
    height: 150px;
    margin: 0 auto;
    border-radius: 50%;
    overflow: hidden;
}

.image-upload-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.image-upload-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.5);
    padding: 8px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.image-upload-overlay i {
    color: white;
    font-size: 20px;
}

.required:after {
    content: " *";
    color: red;
}

.nav-tabs .nav-link {
    color: #6c757d;
}

.nav-tabs .nav-link.active {
    color: #206bc4;
    font-weight: 600;
}

.btn-check:checked + .btn-outline-primary {
    background-color: #206bc4;
    border-color: #206bc4;
    color: white;
}

.form-control:disabled, .form-control[readonly] {
    background-color: #f8fafc;
}
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <div class="card-title h4 mb-0">ایجاد شخص جدید</div>
                </div>
                <div class="col-auto">
                    <a href="{{ route('persons.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-right me-2"></i>
                        بازگشت به لیست
                    </a>
                </div>
            </div>
        </div>

        <form action="{{ route('persons.store') }}" method="POST" enctype="multipart/form-data" id="personForm">
            @csrf
            
            <!-- اطلاعات اصلی - خارج از تب‌ها -->
            <div class="card-body border-bottom">
                <div class="row align-items-center g-4">
                    <!-- تصویر پروفایل -->
                    <div class="col-auto">
                        <div class="image-upload-container">
                            <img id="preview" src="{{ asset('images/avatar-placeholder.png') }}" alt="تصویر پروفایل">
                            <div class="image-upload-overlay">
                                <label for="image" class="mb-0">
                                    <i class="fas fa-camera"></i>
                                </label>
                                <input type="file" id="image" name="image" class="d-none" accept="image/*" onchange="previewImage(this)">
                            </div>
                        </div>
                    </div>

                    <!-- اطلاعات اصلی -->
                    <div class="col">
                        <div class="row g-3">
                            <!-- کد حسابداری -->
                            <div class="col-md-3">
                                <label class="form-label required">کد حسابداری</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                           id="accounting_code" name="code" value="{{ old('code', $nextCode) }}" 
                                           readonly required>
                                    <button type="button" class="btn btn-outline-secondary" id="toggleEditCode"
                                            data-bs-toggle="tooltip" title="فعال/غیرفعال کردن ویرایش کد">
                                        <i class="fas fa-lock"></i>
                                    </button>
                                </div>
                                @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- وضعیت -->
                            <div class="col-md-3">
                                <label class="form-label">وضعیت</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" id="is_active" 
                                           name="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">فعال</label>
                                </div>
                            </div>

                            <!-- نوع شخص -->
                            <div class="col-md-3">
                                <label class="form-label required">نوع شخص</label>
                                <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                                    <option value="">انتخاب کنید</option>
                                    <option value="individual" {{ old('type') == 'individual' ? 'selected' : '' }}>شخص حقیقی</option>
                                    <option value="company" {{ old('type') == 'company' ? 'selected' : '' }}>شخص حقوقی</option>
                                </select>
                                @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- عنوان -->
                            <div class="col-md-3">
                                <label class="form-label">عنوان</label>
                                <select name="title" id="title" class="form-select @error('title') is-invalid @enderror">
                                    <option value="">انتخاب کنید</option>
                                    <option value="آقای" {{ old('title') == 'آقای' ? 'selected' : '' }}>آقای</option>
                                    <option value="خانم" {{ old('title') == 'خانم' ? 'selected' : '' }}>خانم</option>
                                    <option value="دکتر" {{ old('title') == 'دکتر' ? 'selected' : '' }}>دکتر</option>
                                    <option value="مهندس" {{ old('title') == 'مهندس' ? 'selected' : '' }}>مهندس</option>
                                    <option value="شرکت" {{ old('title') == 'شرکت' ? 'selected' : '' }}>شرکت</option>
                                    <option value="سازمان" {{ old('title') == 'سازمان' ? 'selected' : '' }}>سازمان</option>
                                </select>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- نام و نام خانوادگی -->
                            <div class="col-md-3">
                                <label class="form-label required">نام</label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                       name="first_name" value="{{ old('first_name') }}" required>
                                @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label required">نام خانوادگی</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                       name="last_name" value="{{ old('last_name') }}" required>
                                @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">نام مستعار</label>
                                <input type="text" class="form-control @error('display_name') is-invalid @enderror"
                                       name="display_name" value="{{ old('display_name') }}">
                                @error('display_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- دسته‌بندی -->
                            <div class="col-md-3">
                                <label class="form-label required">دسته‌بندی</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('category_id') is-invalid @enderror" 
                                           id="selected_category" value="{{ old('category_name') }}" readonly required>
                                    <input type="hidden" name="category_id" id="category_id" value="{{ old('category_id') }}">
                                    <button type="button" class="btn btn-outline-secondary" id="select_category">
                                        <i class="fas fa-folder-open"></i>
                                    </button>
                                </div>
                                @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- نوع همکاری -->
                            <div class="col-12">
                                <label class="form-label d-block">نوع همکاری</label>
                                <div class="btn-group" role="group">
                                    <input type="checkbox" class="btn-check" id="is_customer" name="is_customer" 
                                           {{ old('is_customer') ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary" for="is_customer">
                                        <i class="fas fa-shopping-cart me-1"></i>
                                        مشتری
                                    </label>

                                    <input type="checkbox" class="btn-check" id="is_supplier" name="is_supplier"
                                           {{ old('is_supplier') ? 'checked' : '' }}>
                                    <label class="btn btn-outline-success" for="is_supplier">
                                        <i class="fas fa-truck me-1"></i>
                                        تامین کننده
                                    </label>

                                    <input type="checkbox" class="btn-check" id="is_employee" name="is_employee"
                                           {{ old('is_employee') ? 'checked' : '' }}>
                                    <label class="btn btn-outline-info" for="is_employee">
                                        <i class="fas fa-user-tie me-1"></i>
                                        کارمند
                                    </label>

                                    <input type="checkbox" class="btn-check" id="is_shareholder" name="is_shareholder"
                                           {{ old('is_shareholder') ? 'checked' : '' }}>
                                    <label class="btn btn-outline-warning" for="is_shareholder">
                                        <i class="fas fa-user-shield me-1"></i>
                                        سهامدار
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- تب‌ها -->
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#general" type="button">
                            <i class="fas fa-info-circle me-1"></i>
                            عمومی
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#address" type="button">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            آدرس
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#contact" type="button">
                            <i class="fas fa-phone me-1"></i>
                            اطلاعات تماس
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#bank" type="button">
                            <i class="fas fa-university me-1"></i>
                            اطلاعات بانکی
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#other" type="button">
                            <i class="fas fa-cog me-1"></i>
                            سایر
                        </button>
                    </li>
                </ul>

                <div class="tab-content mt-3">
                    <!-- تب عمومی -->
                    <div class="tab-pane fade show active" id="general">
                        <div class="row g-3">
                            <!-- اطلاعات هویتی -->
                            <div class="col-md-4">
                                <label class="form-label">کد ملی</label>
                                <input type="text" class="form-control @error('national_code') is-invalid @enderror" 
                                       name="national_code" value="{{ old('national_code') }}"
                                       pattern="\d{10}" maxlength="10">
                                @error('national_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">شماره شناسنامه</label>
                                <input type="text" class="form-control @error('birth_certificate_number') is-invalid @enderror"
                                       name="birth_certificate_number" value="{{ old('birth_certificate_number') }}">
                                @error('birth_certificate_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">تاریخ تولد</label>
                                <input type="text" class="form-control @error('birth_date') is-invalid @enderror"
                                       name="birth_date" value="{{ old('birth_date') }}">
                                @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- اطلاعات شرکت -->
                            <div class="col-md-4 company-fields d-none">
                                <label class="form-label">نام شرکت</label>
                                <input type="text" class="form-control @error('company_name') is-invalid @enderror"
                                       name="company_name" value="{{ old('company_name') }}">
                                @error('company_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 company-fields d-none">
                                <label class="form-label">شماره ثبت</label>
                                <input type="text" class="form-control @error('registration_number') is-invalid @enderror"
                                       name="registration_number" value="{{ old('registration_number') }}">
                                @error('registration_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 company-fields d-none">
                                <label class="form-label">کد اقتصادی</label>
                                <input type="text" class="form-control @error('economic_code') is-invalid @enderror"
                                       name="economic_code" value="{{ old('economic_code') }}">
                                @error('economic_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- تب آدرس -->
                    <div class="tab-pane fade" id="address">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">کشور</label>
                                <select name="country" class="form-select @error('country') is-invalid @enderror">
                                    <option value="ایران" {{ old('country') == 'ایران' ? 'selected' : '' }}>ایران</option>
                                </select>
                                @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">استان</label>
                                <select name="state" class="form-select @error('state') is-invalid @enderror">
                                    <option value="">انتخاب کنید</option>
                                    <!-- لیست استان‌ها -->
                                </select>
                                @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">شهر</label>
                                <select name="city" class="form-select @error('city') is-invalid @enderror">
                                    <option value="">انتخاب کنید</option>
                                    <!-- لیست شهرها -->
                                </select>
                                @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">کد پستی</label>
                                <input type="text" class="form-control @error('postal_code') is-invalid @enderror"
                                       name="postal_code" value="{{ old('postal_code') }}"
                                       pattern="\d{10}" maxlength="10">
                                @error('postal_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">آدرس محل سکونت</label>
                                <textarea class="form-control @error('home_address') is-invalid @enderror"
                                          name="home_address" rows="2">{{ old('home_address') }}</textarea>
                                @error('home_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">آدرس محل کار</label>
                                <textarea class="form-control @error('work_address') is-invalid @enderror"
                                          name="work_address" rows="2">{{ old('work_address') }}</textarea>
                                @error('work_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- تب اطلاعات تماس -->
                    <div class="tab-pane fade" id="contact">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">تلفن همراه</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                    <input type="tel" class="form-control @error('mobile') is-invalid @enderror"
                                           name="mobile" value="{{ old('mobile') }}"
                                           pattern="\d{11}" maxlength="11">
                                </div>
                                @error('mobile')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">تلفن ثابت</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                           name="phone" value="{{ old('phone') }}">
                                </div>
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">تلفن محل کار</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                    <input type="tel" class="form-control @error('work_phone') is-invalid @enderror"
                                           name="work_phone" value="{{ old('work_phone') }}">
                                </div>
                                @error('work_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">ایمیل شخصی</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email') }}">
                                </div>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">ایمیل سازمانی</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control @error('work_email') is-invalid @enderror"
                                           name="work_email" value="{{ old('work_email') }}">
                                </div>
                                @error('work_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">وب‌سایت</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                    <input type="url" class="form-control @error('website') is-invalid @enderror"
                                           name="website" value="{{ old('website') }}">
                                </div>
                                @error('website')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- شبکه‌های اجتماعی -->
                            <div class="col-12">
                                <label class="form-label">شبکه‌های اجتماعی</label>
                                <div class="row g-2">
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-telegram"></i></span>
                                            <input type="text" class="form-control" name="telegram" 
                                                   value="{{ old('telegram') }}" placeholder="آیدی تلگرام">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                                            <input type="text" class="form-control" name="whatsapp"
                                                   value="{{ old('whatsapp') }}" placeholder="شماره واتساپ">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                            <input type="text" class="form-control" name="instagram"
                                                   value="{{ old('instagram') }}" placeholder="آیدی اینستاگرام">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-linkedin"></i></span>
                                            <input type="text" class="form-control" name="linkedin"
                                                   value="{{ old('linkedin') }}" placeholder="آیدی لینکدین">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- تب اطلاعات بانکی -->
                    <div class="tab-pane fade" id="bank">
                        <div class="row g-3">
                            <div class="col-12">
                                <button type="button" class="btn btn-primary mb-3" id="addBankAccount">
                                    <i class="fas fa-plus me-1"></i>
                                    افزودن حساب بانکی
                                </button>
                                <div id="bankAccounts">
                                    <!-- الگوی حساب بانکی -->
                                    <div class="bank-account-template d-none">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="row g-3">
                                                    <div class="col-md-3">
                                                        <label class="form-label">نام بانک</label>
                                                        <select class="form-select" name="bank_accounts[0][bank]">
                                                            <option value="">انتخاب کنید</option>
                                                            <option value="mellat">بانک ملت</option>
                                                            <option value="melli">بانک ملی</option>
                                                            <option value="saderat">بانک صادرات</option>
                                                            <option value="tejarat">بانک تجارت</option>
                                                            <option value="sepah">بانک سپه</option>
                                                            <!-- سایر بانک‌ها -->
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">شماره حساب</label>
                                                        <input type="text" class="form-control" 
                                                               name="bank_accounts[0][account_number]">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">شماره شبا</label>
                                                        <input type="text" class="form-control" 
                                                               name="bank_accounts[0][iban]"
                                                               pattern="IR\d{24}" maxlength="26">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">شماره کارت</label>
                                                        <input type="text" class="form-control" 
                                                               name="bank_accounts[0][card_number]"
                                                               pattern="\d{16}" maxlength="16">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label class="form-label">&nbsp;</label>
                                                        <button type="button" class="btn btn-danger d-block w-100 remove-bank-account">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- تب سایر -->
                    <div class="tab-pane fade" id="other">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">سقف اعتبار</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                    <input type="text" class="form-control money @error('credit_limit') is-invalid @enderror" 
                                           name="credit_limit" value="{{ old('credit_limit', 0) }}">
                                    <span class="input-group-text">ریال</span>
                                </div>
                                @error('credit_limit')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">مانده حساب اول دوره</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                    <input type="text" class="form-control money @error('opening_balance') is-invalid @enderror" 
                                           name="opening_balance" value="{{ old('opening_balance', 0) }}">
                                    <span class="input-group-text">ریال</span>
                                </div>
                                @error('opening_balance')
                                <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">توضیحات</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          name="description" rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">تگ‌ها</label>
                                <input type="text" class="form-control" name="tags" data-role="tagsinput"
                                       value="{{ old('tags') }}" placeholder="تگ‌ها را با کاما جدا کنید">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">گروه‌های دسترسی</label>
                                <select class="form-select" name="groups[]" multiple>
                                    <option value="1">گروه فروش</option>
                                    <option value="2">گروه خرید</option>
                                    <option value="3">گروه مالی</option>
                                    <option value="4">گروه انبار</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- دکمه‌های فرم -->
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>
                    ذخیره اطلاعات
                </button>
                <a href="{{ route('persons.index') }}" class="btn btn-secondary">
                    انصراف
                </a>
            </div>
        </form>
    </div>
</div>

<!-- مودال انتخاب دسته‌بندی -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">مدیریت دسته‌بندی‌ها</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- فرم افزودن دسته‌بندی -->
                <form id="categoryForm" class="mb-3">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">نام دسته‌بندی</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">رنگ</label>
                            <input type="color" class="form-control form-control-color w-100" 
                                   name="color" value="#4F46E5">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">آیکون</label>
                            <select class="form-select" name="icon">
                                <option value="users">👥 کاربران</option>
                                <option value="building">🏢 شرکت</option>
                                <option value="user-tie">👔 کارمند</option>
                                <option value="handshake">🤝 همکار</option>
                                <option value="money-bill">💰 مالی</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">ترتیب</label>
                            <input type="number" class="form-control" name="order" value="0">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                ذخیره دسته‌بندی
                            </button>
                        </div>
                    </div>
                </form>

                <!-- جدول دسته‌بندی‌ها -->
                <div class="table-responsive">
                    <table class="table table-hover" id="categoriesTable">
                        <thead>
                            <tr>
                                <th>نام</th>
                                <th>رنگ</th>
                                <th>آیکون</th>
                                <th>ترتیب</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // تنظیمات Toastr
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-bottom-left",
        "timeOut": "3000"
    };

    // مدیریت کد حسابداری
    document.getElementById('toggleEditCode').addEventListener('click', function() {
        const input = document.getElementById('accounting_code');
        const icon = this.querySelector('i');
        
        if (input.readOnly) {
            if (confirm('آیا از ویرایش دستی کد اطمینان دارید؟')) {
                input.readOnly = false;
                icon.classList.remove('fa-lock');
                icon.classList.add('fa-lock-open');
                this.classList.add('btn-warning');
            }
        } else {
            input.readOnly = true;
            icon.classList.remove('fa-lock-open');
            icon.classList.add('fa-lock');
            this.classList.remove('btn-warning');
        }
    });

    // مدیریت نوع شخص
    document.getElementById('type').addEventListener('change', function() {
        const companyFields = document.querySelectorAll('.company-fields');
        if (this.value === 'company') {
            companyFields.forEach(el => el.classList.remove('d-none'));
        } else {
            companyFields.forEach(el => el.classList.add('d-none'));
        }
    });

    // مدیریت دسته‌بندی‌ها
    document.getElementById('select_category').addEventListener('click', function() {
        loadCategories();
        const modal = new bootstrap.Modal(document.getElementById('categoryModal'));
        modal.show();
    });

    function loadCategories() {
        fetch('{{ route("person-categories.list") }}')
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('#categoriesTable tbody');
                tbody.innerHTML = '';
                
                data.forEach(category => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="badge rounded-pill me-2" style="background-color: ${category.color}">&nbsp;&nbsp;&nbsp;</span>
                                <span>${category.name}</span>
                            </div>
                        </td>
                        <td>${category.color}</td>
                        <td><i class="fas fa-${category.icon}"></i></td>
                        <td>${category.order}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary select-category" 
                                    data-id="${category.id}" data-name="${category.name}">
                                انتخاب
                            </button>
                            <button type="button" class="btn btn-sm btn-info edit-category" 
                                    data-id="${category.id}" data-name="${category.name}"
                                    data-color="${category.color}" data-icon="${category.icon}"
                                    data-order="${category.order}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger delete-category" 
                                    data-id="${category.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
                
                // اضافه کردن event listener ها
                addCategoryEventListeners();
            })
            .catch(error => {
                console.error('Error loading categories:', error);
                toastr.error('خطا در بارگذاری دسته‌بندی‌ها');
            });
    }

    function addCategoryEventListeners() {
        // انتخاب دسته‌بندی
        document.querySelectorAll('.select-category').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('selected_category').value = this.dataset.name;
                document.getElementById('category_id').value = this.dataset.id;
                bootstrap.Modal.getInstance(document.getElementById('categoryModal')).hide();
            });
        });

        // ویرایش دسته‌بندی
        document.querySelectorAll('.edit-category').forEach(btn => {
            btn.addEventListener('click', function() {
                const form = document.getElementById('categoryForm');
                form.dataset.id = this.dataset.id;
                form.querySelector('[name="name"]').value = this.dataset.name;
                form.querySelector('[name="color"]').value = this.dataset.color;
                form.querySelector('[name="icon"]').value = this.dataset.icon;
                form.querySelector('[name="order"]').value = this.dataset.order;
                form.querySelector('button[type="submit"]').innerHTML = '<i class="fas fa-save me-1"></i> بروزرسانی دسته‌بندی';
            });
        });

        // حذف دسته‌بندی
        document.querySelectorAll('.delete-category').forEach(btn => {
            btn.addEventListener('click', function() {
                if (!confirm('آیا از حذف این دسته‌بندی اطمینان دارید؟')) return;

                const categoryId = this.dataset.id;
                fetch(`/person-categories/${categoryId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        loadCategories();
                        toastr.success(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error deleting category:', error);
                    toastr.error('خطا در حذف دسته‌بندی');
                });
            });
        });
    }

    // ذخیره یا بروزرسانی دسته‌بندی
    document.getElementById('categoryForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const categoryId = this.dataset.id;
        const url = categoryId 
            ? `/person-categories/${categoryId}` 
            : '{{ route("person-categories.store") }}';
        const method = categoryId ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(Object.fromEntries(formData))
        })
        .then(response => response.json())
        .then(data => {
            loadCategories();
            this.reset();
            delete this.dataset.id;
            this.querySelector('button[type="submit"]').innerHTML = '<i class="fas fa-save me-1"></i> ذخیره دسته‌بندی';
            toastr.success(categoryId ? 'دسته‌بندی با موفقیت بروزرسانی شد' : 'دسته‌بندی جدید با موفقیت ایجاد شد');
        })
        .catch(error => {
            console.error('Error saving category:', error);
            toastr.error('خطا در ذخیره دسته‌بندی');
        });
    });

    // مدیریت حساب‌های بانکی
    let bankAccountCounter = 0;
    document.getElementById('addBankAccount').addEventListener('click', function() {
        const template = document.querySelector('.bank-account-template').cloneNode(true);
        template.classList.remove('d-none', 'bank-account-template');
        
        template.querySelectorAll('[name]').forEach(input => {
            input.name = input.name.replace('[0]', `[${bankAccountCounter}]`);
        });
        
        document.getElementById('bankAccounts').appendChild(template);
        bankAccountCounter++;
    });

    // حذف حساب بانکی
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-bank-account')) {
            e.target.closest('.card').remove();
        }
    });

    // فرمت‌بندی اعداد پولی
    document.querySelectorAll('.money').forEach(input => {
        input.addEventListener('input', function(e) {
            let value = this.value.replace(/[^\d]/g, '');
            this.value = Number(value).toLocaleString();
        });
    });
});
</script>
@endpush

@endsection