@extends('layouts.app')

@section('content')
<div class="container-fluid p-4">
    <!-- Header Section -->
    <div class="d-flex align-items-center mb-4">
        <button class="btn btn-text me-2" title="بازگشت" onclick="history.back()">
            <i class="fas fa-arrow-right"></i>
        </button>
        <h2 class="mb-0">دریافت</h2>
        
        <div class="ms-auto">
            <button class="btn btn-success ms-2" id="saveBtn" title="ذخیره">
                <i class="fas fa-save"></i>
                <span class="d-none d-md-inline me-1">ذخیره</span>
            </button>
            <button class="btn btn-orange ms-2" id="newBtn" title="جدید">
                <i class="fas fa-file"></i>
                <span class="d-none d-md-inline me-1">جدید</span>
            </button>
        </div>
    </div>

    <!-- Main Form -->
    <form id="receiptForm" class="needs-validation" novalidate>
        @csrf
        <div class="row mb-4">
            <!-- شماره و تاریخ -->
            <div class="col-md-3 col-sm-6 mb-3">
                <label class="form-label required">شماره</label>
                <div class="input-group">
                    <input type="text" id="receiptNumber" name="number" class="form-control text-left" required readonly>
                    <button class="btn btn-outline-secondary" type="button" id="toggleAutoNumber">
                        <i class="fas fa-lock"></i>
                    </button>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <label class="form-label required">تاریخ</label>
                <input type="text" id="datePicker" name="date" class="form-control" required readonly>
            </div>

            <!-- پروژه -->
            <div class="col-md-4 mb-3">
                <label class="form-label">پروژه</label>
                <div class="input-group">
                    <select class="form-select" id="projectSelect" name="project_id">
                        <option value="">انتخاب کنید...</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-success" type="button" id="addProjectBtn">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- شرح و واحد پول -->
        <div class="row mb-4">
            <div class="col-sm-8 mb-3">
                <label class="form-label">شرح</label>
                <div class="input-group">
                    <input type="text" id="description" name="description" class="form-control" maxlength="200">
                    <button class="btn btn-outline-secondary" type="button" id="commonDescBtn">
                        <i class="fas fa-bars"></i>
                    </button>
                    <button class="btn btn-outline-secondary" type="button" id="copyDescBtn" title="کپی">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label required">واحد پول</label>
                <select class="form-select" id="currencySelect" name="currency" required>
                    <option value="IRR">ریال</option>
                    <option value="USD">دلار</option>
                    <option value="EUR">یورو</option>
                    <option value="AED">درهم امارات</option>
                    <option value="GBP">پوند</option>
                    <option value="TRY">لیر ترکیه</option>
                    <option value="CHF">فرانک سوئیس</option>
                    <option value="CNY">یوان چین</option>
                    <option value="JPY">ین ژاپن</option>
                    <option value="CAD">دلار کانادا</option>
                </select>
            </div>
        </div>

        <!-- آیتم‌های دریافت -->
        <div id="receiptItems">
            <!-- Template for receipt items will be added dynamically -->
        </div>

        <!-- دکمه افزودن آیتم -->
        <div class="text-center mb-4">
            <button type="button" class="btn btn-outline-success" id="addItemBtn">
                <i class="fas fa-plus me-1"></i>
                افزودن آیتم
            </button>
        </div>

        <!-- پنل دریافت وجه -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="dropdown">
                        <button type="button" class="btn btn-success" id="addReceiptBtn">
                            <i class="fas fa-plus me-1"></i>
                            افزودن دریافت
                        </button>
                        <div class="payment-methods-menu d-none" id="paymentMethodsMenu">
                            <div class="list-group">
                                <a href="#" class="list-group-item" data-type="cash">
                                    <i class="fas fa-money-bill-wave me-2"></i>
                                    صندوق
                                </a>
                                <a href="#" class="list-group-item" data-type="petty-cash">
                                    <i class="fas fa-wallet me-2"></i>
                                    تنخواه گردان
                                </a>
                                <a href="#" class="list-group-item" data-type="bank">
                                    <i class="fas fa-university me-2"></i>
                                    بانک
                                </a>
                                <a href="#" class="list-group-item" data-type="check">
                                    <i class="fas fa-money-check-alt me-2"></i>
                                    چک
                                </a>
                                <a href="#" class="list-group-item" data-type="contact">
                                    <i class="fas fa-user me-2"></i>
                                    شخص
                                </a>
                                <a href="#" class="list-group-item" data-type="account">
                                    <i class="fas fa-file-invoice-dollar me-2"></i>
                                    حساب
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-end">
                        <div class="mb-1">
                            <span>مجموع:</span>
                            <strong class="text-primary ms-2" id="totalAmount">۰ ریال</strong>
                        </div>
                        <div>
                            <span>باقیمانده:</span>
                            <strong class="text-danger ms-2" id="remainingAmount">۰ ریال</strong>
                        </div>
                    </div>
                </div>

                <!-- محل نمایش آیتم‌های دریافت -->
                <div id="paymentItems" class="mt-3">
                    <!-- Payment items will be added here dynamically -->
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal for Projects -->
<div class="modal fade" id="projectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">مدیریت پروژه‌ها</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="projectForm" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label class="form-label required">نام پروژه</label>
                        <input type="text" class="form-control" id="projectName" required>
                        <div class="invalid-feedback">لطفاً نام پروژه را وارد کنید</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">توضیحات</label>
                        <textarea class="form-control" id="projectDescription" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">ذخیره</button>
                </form>
                <hr>
                <div class="mb-3">
                    <input type="text" class="form-control" id="projectSearch" placeholder="جستجو...">
                </div>
                <div class="list-group" id="projectsList">
                    @foreach($projects as $project)
                        <div class="list-group-item">
                            {{ $project->name }}
                            <button class="btn btn-sm btn-danger float-end delete-project" data-id="{{ $project->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button class="btn btn-sm btn-primary float-end me-1 edit-project" data-id="{{ $project->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Common Descriptions -->
<div class="modal fade" id="descriptionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">شرح‌های پرتکرار</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="descriptionForm" class="needs-validation" novalidate>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="newDescription" placeholder="شرح جدید..." required>
                        <button class="btn btn-success" type="submit">
                            <i class="fas fa-plus"></i>
                        </button>
                        <div class="invalid-feedback">لطفاً شرح را وارد کنید</div>
                    </div>
                </form>
                <div class="mb-3">
                    <input type="text" class="form-control" id="descriptionSearch" placeholder="جستجو...">
                </div>
                <div class="list-group" id="descriptionsList">
                    @foreach($commonDescriptions as $desc)
                        <div class="list-group-item">
                            {{ $desc->description }}
                            <button class="btn btn-sm btn-danger float-end delete-desc" data-id="{{ $desc->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button class="btn btn-sm btn-primary float-end me-1 edit-desc" data-id="{{ $desc->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Persons -->
<div class="modal fade" id="personModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">شخص جدید</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="personForm" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label class="form-label required">نام</label>
                        <input type="text" class="form-control" id="personFirstName" required>
                        <div class="invalid-feedback">لطفاً نام را وارد کنید</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">نام خانوادگی</label>
                        <input type="text" class="form-control" id="personLastName" required>
                        <div class="invalid-feedback">لطفاً نام خانوادگی را وارد کنید</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">شماره تماس</label>
                        <input type="text" class="form-control" id="personPhone" dir="ltr" pattern="[0-9۰-۹]{11}">
                        <div class="invalid-feedback">لطفاً شماره تماس معتبر وارد کنید</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">آدرس</label>
                        <textarea class="form-control" id="personAddress" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">ذخیره</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css">
<style>
.required:after {
    content: " *";
    color: red;
}

.payment-methods-menu {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    background: white;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    width: 250px;
}

.payment-methods-menu .list-group-item {
    display: flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border: none;
    border-bottom: 1px solid #eee;
}

.payment-methods-menu .list-group-item:last-child {
    border-bottom: none;
}

.payment-methods-menu .list-group-item:hover {
    background-color: #f8f9fa;
    text-decoration: none;
}

.receipt-item {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
    position: relative;
}

.amount-wrapper {
    position: relative;
}

.currency-label {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    pointer-events: none;
}

.number-input {
    text-align: left;
    direction: ltr;
}

.row-number {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #e9ecef;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 0.9em;
}

.delete-btn {
    position: absolute;
    top: 10px;
    left: 10px;
}
</style>
@endpush

@push('scripts')
<!-- jQuery (اگر قبلاً در app.blade.php لود نشده است) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Persian Date -->
<script src="https://unpkg.com/persian-date@1.1.0/dist/persian-date.min.js"></script>

<!-- Persian Datepicker -->
<script src="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // تابع تبدیل اعداد انگلیسی به فارسی
    const toFarsiNumbers = (n) => {
        const farsiDigits = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
        return n.toString().replace(/\d/g, x => farsiDigits[x]);
    };

    // تابع تبدیل اعداد فارسی به انگلیسی
    const toEnglishNumbers = (str) => {
        const persianNumbers = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
        const arabicNumbers  = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
        const englishNumbers = ['0','1','2','3','4','5','6','7','8','9'];
        
        return str.split('').map(c => {
            if (persianNumbers.includes(c)) return englishNumbers[persianNumbers.indexOf(c)];
            if (arabicNumbers.includes(c)) return englishNumbers[arabicNumbers.indexOf(c)];
            return c;
        }).join('');
    };

    // فرمت‌کننده اعداد با جداکننده هزارتایی
    const formatNumber = (num) => {
        return toFarsiNumbers(new Intl.NumberFormat().format(num));
    };

    // تنظیم تاریخ شمسی
    $('#datePicker').persianDatepicker({
        format: 'YYYY/MM/DD',
        initialValue: true,
        autoClose: true
    });

    // تنظیمات اولیه Axios
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.getAttribute('content');
    }
    axios.defaults.headers.common['Accept'] = 'application/json'; 
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    axios.defaults.withCredentials = true;
    // مدیریت شماره خودکار
    let autoNumber = true;
    const receiptNumber = document.getElementById('receiptNumber');
    const toggleAutoNumber = document.getElementById('toggleAutoNumber');
    
    // دریافت شماره اولیه
    fetch('/api/receipts/next-number', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        receiptNumber.value = data.number;
    })
    .catch(error => {
        console.error('خطا در دریافت شماره:', error);
        Swal.fire({
            icon: 'error',
            title: 'خطا',
            text: 'خطا در دریافت شماره سند',
            confirmButtonText: 'باشه'
        });
    });

    toggleAutoNumber.addEventListener('click', function() {
        autoNumber = !autoNumber;
        receiptNumber.readOnly = autoNumber;
        this.innerHTML = `<i class="fas fa-${autoNumber ? 'lock' : 'lock-open'}"></i>`;
    });

    // مدیریت پروژه‌ها
    const projectModal = new bootstrap.Modal(document.getElementById('projectModal'));
    const projectForm = document.getElementById('projectForm');
    const addProjectBtn = document.getElementById('addProjectBtn');
    
    addProjectBtn.addEventListener('click', () => projectModal.show());
    
    projectForm.addEventListener('submit', function(e) {
        e.preventDefault();
        if (!this.checkValidity()) {
            e.stopPropagation();
            this.classList.add('was-validated');
            return;
        }

        const data = {
            name: document.getElementById('projectName').value,
            description: document.getElementById('projectDescription').value
        };
        
        axios.post('/api/projects', data)
            .then(response => {
                const project = response.data;
                const option = new Option(project.name, project.id);
                document.getElementById('projectSelect').add(option);
                document.getElementById('projectSelect').value = project.id;
                projectModal.hide();
                projectForm.reset();
                projectForm.classList.remove('was-validated');
                Swal.fire({
                    icon: 'success',
                    title: 'موفق',
                    text: 'پروژه با موفقیت ایجاد شد',
                    confirmButtonText: 'باشه'
                });
            })
            .catch(error => {
                console.error('خطا در ایجاد پروژه:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'خطا',
                    text: error.response?.data?.message || 'خطا در ایجاد پروژه',
                    confirmButtonText: 'باشه'
                });
            });
    });

    // مدیریت شرح‌های پرتکرار
    const descriptionModal = new bootstrap.Modal(document.getElementById('descriptionModal'));
    const descriptionForm = document.getElementById('descriptionForm');
    const commonDescBtn = document.getElementById('commonDescBtn');
    
    commonDescBtn.addEventListener('click', () => descriptionModal.show());
    
    descriptionForm.addEventListener('submit', function(e) {
        e.preventDefault();
        if (!this.checkValidity()) {
            e.stopPropagation();
            this.classList.add('was-validated');
            return;
        }

        const data = {
            description: document.getElementById('newDescription').value
        };
        
        axios.post('/api/common-descriptions', data)
            .then(response => {
                const desc = response.data;
                const item = document.createElement('div');
                item.className = 'list-group-item';
                item.textContent = desc.description;
                item.innerHTML += `
                    <button class="btn btn-sm btn-danger float-end delete-desc" data-id="${desc.id}">
                        <i class="fas fa-trash"></i>
                    </button>
                    <button class="btn btn-sm btn-primary float-end me-1 edit-desc" data-id="${desc.id}">
                        <i class="fas fa-edit"></i>
                    </button>
                `;
                document.getElementById('descriptionsList').prepend(item);
                descriptionForm.reset();
                descriptionForm.classList.remove('was-validated');
                Swal.fire({
                    icon: 'success',
                    title: 'موفق',
                    text: 'شرح با موفقیت اضافه شد',
                    confirmButtonText: 'باشه'
                });
            })
            .catch(error => {
                console.error('خطا در ایجاد شرح:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'خطا',
                    text: error.response?.data?.message || 'خطا در ایجاد شرح',
                    confirmButtonText: 'باشه'
                });
            });
    });

    // کپی شرح
    document.getElementById('copyDescBtn').addEventListener('click', function() {
        const description = document.getElementById('description').value;
        navigator.clipboard.writeText(description)
            .then(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'موفق',
                    text: 'متن کپی شد',
                    confirmButtonText: 'باشه',
                    timer: 2000,
                    timerProgressBar: true
                });
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'خطا',
                    text: 'خطا در کپی متن',
                    confirmButtonText: 'باشه'
                });
            });
    });

    // مدیریت واحد پول
    const currencySelect = document.getElementById('currencySelect');
    const currencySymbols = {
        'IRR': 'ریال',
        'USD': 'دلار',
        'EUR': 'یورو',
        'AED': 'درهم',
        'GBP': 'پوند',
        'TRY': 'لیر',
        'CHF': 'فرانک',
        'CNY': 'یوان',
        'JPY': 'ین',
        'CAD': 'دلار کانادا'
    };

    currencySelect.addEventListener('change', function() {
        document.querySelectorAll('.currency-label').forEach(label => {
            label.textContent = currencySymbols[this.value];
        });
        updateTotals();
    });

    // الگوی آیتم دریافت
    function createReceiptItemTemplate(index) {
        return `
            <div class="receipt-item">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label required">شخص</label>
                        <div class="input-group">
                            <select class="form-select person-select" name="items[${index}][person_id]" required>
                                <option value="">انتخاب کنید...</option>
                            </select>
                            <button class="btn btn-success add-person-btn" type="button">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback">لطفاً شخص را انتخاب کنید</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label required">مبلغ</label>
                        <div class="amount-wrapper">
                            <input type="text" 
                                class="form-control number-input amount-input" 
                                name="items[${index}][amount]"
                                value="۰"
                                required>
                            <span class="currency-label">${currencySymbols[currencySelect.value]}</span>
                            <div class="invalid-feedback">لطفاً مبلغ را وارد کنید</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">شرح</label>
                        <div class="input-group">
                            <input type="text" class="form-control item-description" name="items[${index}][description]">
                            <button class="btn btn-outline-secondary common-desc-btn" type="button">
                                <i class="fas fa-bars"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-danger delete-btn">
                    <i class="fas fa-trash"></i>
                </button>
                <div class="row-number">${toFarsiNumbers(index + 1)}</div>
            </div>
        `;
    }

    // دریافت لیست اشخاص
    function loadPersons(select) {
        axios.get('/api/persons')
            .then(response => {
                const persons = response.data;
                persons.forEach(person => {
                    const option = new Option(person.full_name, person.id);
                    select.add(option);
                });
            })
            .catch(error => {
                console.error('خطا در دریافت لیست اشخاص:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'خطا',
                    text: 'خطا در دریافت لیست اشخاص',
                    confirmButtonText: 'باشه'
                });
            });
    }

    // فرمت‌بندی مبلغ
    function formatAmount(input) {
        const value = toEnglishNumbers(input.value.replace(/[^\d]/g, ''));
        if (value) {
            input.value = formatNumber(parseInt(value));
            updateTotals();
        }
    }

    // اضافه کردن آیتم جدید
    let itemIndex = 0;
    document.getElementById('addItemBtn').addEventListener('click', function() {
        const template = createReceiptItemTemplate(itemIndex++);
        document.getElementById('receiptItems').insertAdjacentHTML('beforeend', template);
        const newItem = document.querySelector('.receipt-item:last-child');
        initializeNewItem(newItem);
        loadPersons(newItem.querySelector('.person-select'));
    });

    // راه‌اندازی آیتم جدید
    function initializeNewItem(item) {
        const amountInput = item.querySelector('.amount-input');
        const personSelect = item.querySelector('.person-select');
        const personBtn = item.querySelector('.add-person-btn');
        const descBtn = item.querySelector('.common-desc-btn');
        const deleteBtn = item.querySelector('.delete-btn');
        const itemDesc = item.querySelector('.item-description');

        // مدیریت مبلغ
        amountInput.addEventListener('input', function() {
            formatAmount(this);
        });
        amountInput.addEventListener('focus', function() {
            if (this.value === '۰') {
                this.value = '';
            }
        });
        amountInput.addEventListener('blur', function() {
            if (!this.value) {
                this.value = '۰';
                updateTotals();
            }
        });

        // مدیریت شخص
        personSelect.addEventListener('change', function() {
            this.classList.remove('is-invalid');
        });
        personBtn.addEventListener('click', function() {
            const personModal = new bootstrap.Modal(document.getElementById('personModal'));
            personModal._targetSelect = personSelect;
            personModal.show();
        });

        // مدیریت شرح
        descBtn.addEventListener('click', function() {
            const descModal = new bootstrap.Modal(document.getElementById('descriptionModal'));
            descModal._targetInput = itemDesc;
            descModal.show();
        });

        // دکمه حذف
        deleteBtn.addEventListener('click', function() {
            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: 'این آیتم حذف خواهد شد',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'بله، حذف شود',
                cancelButtonText: 'خیر'
            }).then((result) => {
                if (result.isConfirmed) {
                    item.remove();
                    updateTotals();
                    updateRowNumbers();
                }
            });
        });
    }

    // به‌روزرسانی شماره ردیف‌ها
    function updateRowNumbers() {
        document.querySelectorAll('.receipt-item').forEach((item, index) => {
            item.querySelector('.row-number').textContent = toFarsiNumbers(index + 1);
        });
    }

    // مدیریت فرم اشخاص
    const personForm = document.getElementById('personForm');
    personForm?.addEventListener('submit', function(e) {
        e.preventDefault();
        if (!this.checkValidity()) {
            e.stopPropagation();
            this.classList.add('was-validated');
            return;
        }

        const data = {
            first_name: document.getElementById('personFirstName').value,
            last_name: document.getElementById('personLastName').value,
            phone: toEnglishNumbers(document.getElementById('personPhone').value),
            address: document.getElementById('personAddress').value
        };
        
        axios.post('/api/persons', data)
            .then(response => {
                const person = response.data.person;
                const option = new Option(`${person.first_name} ${person.last_name}`, person.id);
                
                // اضافه کردن به همه select های موجود
                document.querySelectorAll('.person-select').forEach(select => {
                    select.add(option.cloneNode(true));
                });

                // انتخاب در select هدف
                const targetSelect = document.getElementById('personModal')._targetSelect;
                if (targetSelect) {
                    targetSelect.value = person.id;
                    targetSelect.classList.remove('is-invalid');
                }

                bootstrap.Modal.getInstance(document.getElementById('personModal')).hide();
                this.reset();
                this.classList.remove('was-validated');

                Swal.fire({
                    icon: 'success',
                    title: 'موفق',
                    text: 'شخص جدید با موفقیت اضافه شد',
                    confirmButtonText: 'باشه',
                    timer: 2000,
                    timerProgressBar: true
                });
            })
            .catch(error => {
                console.error('خطا در ایجاد شخص:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'خطا',
                    text: error.response?.data?.message || 'خطا در ایجاد شخص',
                    confirmButtonText: 'باشه'
                });
            });
    });

    // مدیریت کلیک روی شرح‌های پرتکرار
    document.getElementById('descriptionsList').addEventListener('click', function(e) {
        const item = e.target.closest('.list-group-item');
        if (!item) return;

        const descModal = bootstrap.Modal.getInstance(document.getElementById('descriptionModal'));
        if (!e.target.closest('button')) {
            const description = item.textContent.trim();
            const targetInput = descModal._targetInput;
            if (targetInput) {
                targetInput.value = description;
            }
            descModal.hide();
        }
    });

    // به‌روزرسانی جمع مبالغ
    function updateTotals() {
        let total = 0;
        document.querySelectorAll('.amount-input').forEach(input => {
            const value = toEnglishNumbers(input.value.replace(/[^\d]/g, ''));
            total += parseInt(value) || 0;
        });
        
        let payments = 0;
        document.querySelectorAll('.payment-amount').forEach(input => {
            const value = toEnglishNumbers(input.value.replace(/[^\d]/g, ''));
            payments += parseInt(value) || 0;
        });
        
        const remaining = total - payments;
        const currency = currencySymbols[currencySelect.value];
        
        document.getElementById('totalAmount').textContent = `${formatNumber(total)} ${currency}`;
        document.getElementById('remainingAmount').textContent = `${formatNumber(remaining)} ${currency}`;
        
        // تغییر رنگ مبلغ باقیمانده بر اساس مقدار
        const remainingElement = document.getElementById('remainingAmount');
        if (remaining === 0) {
            remainingElement.classList.remove('text-danger', 'text-success');
            remainingElement.classList.add('text-primary');
        } else if (remaining > 0) {
            remainingElement.classList.remove('text-primary', 'text-success');
            remainingElement.classList.add('text-danger');
        } else {
            remainingElement.classList.remove('text-primary', 'text-danger');
            remainingElement.classList.add('text-success');
        }
    }

    // مدیریت منوی روش‌های پرداخت
    const addReceiptBtn = document.getElementById('addReceiptBtn');
    const paymentMethodsMenu = document.getElementById('paymentMethodsMenu');

    addReceiptBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        paymentMethodsMenu.classList.toggle('d-none');
    });

    document.addEventListener('click', function(e) {
        if (!paymentMethodsMenu.contains(e.target) && !addReceiptBtn.contains(e.target)) {
            paymentMethodsMenu.classList.add('d-none');
        }
    });

    // تبدیل نوع پرداخت به نام فارسی
    function getPaymentTypeName(type) {
        const types = {
            'cash': 'نقدی',
            'petty-cash': 'تنخواه',
            'bank': 'بانک',
            'check': 'چک',
            'contact': 'شخص',
            'account': 'حساب'
        };
        return types[type] || type;
    }

    // تبدیل نوع پرداخت به آیکون
    function getPaymentIcon(type) {
        const icons = {
            'cash': 'fa-money-bill-wave',
            'petty-cash': 'fa-wallet',
            'bank': 'fa-university',
            'check': 'fa-money-check-alt',
            'contact': 'fa-user',
            'account': 'fa-file-invoice-dollar'
        };
        return icons[type] || 'fa-circle';
    }

    // انتخاب روش پرداخت
    document.querySelectorAll('.payment-methods-menu .list-group-item').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const type = this.dataset.type;
            addPaymentItem(type);
            paymentMethodsMenu.classList.add('d-none');
        });
    });

    // اضافه کردن آیتم پرداخت
    function addPaymentItem(type) {
        const paymentItem = document.createElement('div');
        paymentItem.className = 'payment-item border rounded p-3 mb-2';
        paymentItem.innerHTML = `
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="fas ${getPaymentIcon(type)} me-2"></i>
                    <span>${getPaymentTypeName(type)}</span>
                </div>
                <button type="button" class="btn btn-sm btn-danger delete-payment">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mt-2">
                <input type="text" class="form-control payment-amount" 
                       placeholder="مبلغ" value="۰" 
                       name="payments[]" required>
                <div class="invalid-feedback">لطفاً مبلغ را وارد کنید</div>
            </div>
            <input type="hidden" name="payment_types[]" value="${type}">
        `;
        
        document.getElementById('paymentItems').appendChild(paymentItem);
        
        const amountInput = paymentItem.querySelector('.payment-amount');
        
        // مدیریت مبلغ
        amountInput.addEventListener('input', function() {
            formatAmount(this);
        });
        
        amountInput.addEventListener('focus', function() {
            if (this.value === '۰') {
                this.value = '';
            }
        });
        
        amountInput.addEventListener('blur', function() {
            if (!this.value) {
                this.value = '۰';
                updateTotals();
            }
        });

        // دکمه حذف
        paymentItem.querySelector('.delete-payment').addEventListener('click', function() {
            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: 'این پرداخت حذف خواهد شد',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'بله، حذف شود',
                cancelButtonText: 'خیر'
            }).then((result) => {
                if (result.isConfirmed) {
                    paymentItem.remove();
                    updateTotals();
                }
            });
        });
    }

    // ذخیره فرم
    document.getElementById('saveBtn').addEventListener('click', function() {
        const form = document.getElementById('receiptForm');
        
        // بررسی اعتبارسنجی فرم
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            Swal.fire({
                icon: 'error',
                title: 'خطا',
                text: 'لطفاً همه فیلدهای ضروری را پر کنید',
                confirmButtonText: 'باشه'
            });
            return;
        }

        // بررسی وجود حداقل یک آیتم
        if (document.querySelectorAll('.receipt-item').length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'خطا',
                text: 'حداقل یک آیتم دریافت باید وجود داشته باشد',
                confirmButtonText: 'باشه'
            });
            return;
        }

        // تأیید نهایی
        Swal.fire({
            title: 'ذخیره دریافت',
            text: 'آیا از ذخیره این دریافت اطمینان دارید؟',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'بله، ذخیره شود',
            cancelButtonText: 'خیر'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData(form);
                
                axios.post('/api/receipts', formData)
                    .then(response => {
                        Swal.fire({
                            icon: 'success',
                            title: 'موفق',
                            text: 'دریافت با موفقیت ذخیره شد',
                            confirmButtonText: 'باشه'
                        }).then(() => {
                            window.location.reload();
                        });
                    })
                    .catch(error => {
                        console.error('خطا در ذخیره دریافت:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'خطا',
                            text: error.response?.data?.message || 'خطا در ذخیره دریافت',
                            confirmButtonText: 'باشه'
                        });
                    });
            }
        });
    });

    // دکمه جدید
    document.getElementById('newBtn').addEventListener('click', function() {
        window.location.reload();
    });

    // اضافه کردن اولین آیتم به صورت خودکار
    document.getElementById('addItemBtn').click();
});
</script>
@endpush
        