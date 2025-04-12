@extends('layouts.app')

@section('styles')
<style>
    .context-menu {
        position: fixed;
        z-index: 1501;
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        min-width: 200px;
        display: none;
    }
    .context-menu ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .context-menu li {
        padding: 8px 15px;
        cursor: pointer;
        display: flex;
        align-items: center;
    }
    .context-menu li:hover {
        background-color: #f5f5f5;
    }
    .context-menu li.separator {
        border-top: 1px solid #ddd;
        margin: 5px 0;
        padding: 0;
    }
    .context-menu li i {
        margin-left: 8px;
        width: 20px;
    }
    .context-menu li.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .table th {
        position: relative;
    }
    .table th .sort-icon {
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
    }
    .filter-active {
        background-color: #e3f2fd;
    }
    .select-checkbox {
        width: 18px;
        height: 18px;
    }
    .person-link {
        color: #2196F3;
        text-decoration: none;
    }
    .person-link:hover {
        text-decoration: underline;
    }
    .info-bar {
        background: #f8f9fa;
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 20px;
    }
    .info-item {
        display: inline-block;
        margin-right: 20px;
    }
    .info-label {
        font-weight: bold;
        margin-right: 5px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- نوار اطلاعات -->
    <div class="info-bar">
        <div class="info-item">
            <i class="fas fa-clock"></i>
            <span class="info-label">تاریخ و ساعت:</span>
            <span id="currentDateTime">{{ $current_datetime }}</span>
        </div>
        <div class="info-item">
            <i class="fas fa-user"></i>
            <span class="info-label">کاربر:</span>
            <span>{{ $user_login }}</span>
        </div>
    </div>

    <!-- هدر صفحه -->
    <div class="row mb-3">
        <div class="col-md-6">
            <h2 class="mb-0">
                <i class="fas fa-users ml-2"></i>
                اشخاص
            </h2>
        </div>
        <div class="col-md-6 text-left">
            <div class="btn-group">
                <button class="btn btn-primary" onclick="location.href='{{ route('persons.create') }}'">
                    <i class="fas fa-plus ml-1"></i>جدید
                </button>
                <button class="btn btn-success" id="exportBtn">
                    <i class="fas fa-file-export ml-1"></i>خروجی اکسل
                </button>
                <button class="btn btn-info" data-toggle="modal" data-target="#importModal">
                    <i class="fas fa-file-import ml-1"></i>ورود از اکسل
                </button>
            </div>
        </div>
    </div>

    <!-- تب‌های فیلتر -->
    <div class="card mb-3">
        <div class="card-header p-2">
            <ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" data-filter="all">
            همه
            <span class="badge badge-primary">{{ $totalCount }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-filter="is_customer">
            مشتریان
            <span class="badge badge-info">{{ $customerCount }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-filter="is_supplier">
            تامین‌کنندگان
            <span class="badge badge-success">{{ $supplierCount }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-filter="is_employee">
            کارمندان
            <span class="badge badge-warning">{{ $employeeCount }}</span>
        </a>
    </li>
</ul>
                <li class="nav-item">
                    <a class="nav-link" data-filter="no_transactions">
                        بدون تراکنش
                        <span class="badge badge-secondary">{{ $noTransactionCount }}</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="peopleTable">
                    <thead>
                        <tr>
                            <th width="40px">
                                <input type="checkbox" class="select-all-checkbox">
                            </th>
                            <th>کد</th>
                            <th>نوع</th>
                            <th>نام/شرکت</th>
                            <th>موبایل</th>
                            <th>تلفن</th>
                            <th>ایمیل</th>
                            <th>دسته‌بندی</th>
                            <th>مانده حساب</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($people as $person)
                        <tr data-id="{{ $person->id }}" 
                            data-is_customer="{{ $person->is_customer }}"
                            data-is_supplier="{{ $person->is_supplier }}"
                            data-is_employee="{{ $person->is_employee }}"
                            class="person-row">
                            <td>
                                <input type="checkbox" class="select-checkbox">
                            </td>
                            <td>{{ $person->code }}</td>
                            <td>{{ $person->type === 'individual' ? 'حقیقی' : 'حقوقی' }}</td>
                            <td>
                                <a href="{{ route('persons.show', $person) }}" class="person-link">
                                    {{ $person->display_name }}
                                </a>
                            </td>
                            <td>{{ $person->mobile }}</td>
                            <td>{{ $person->phone }}</td>
                            <td>{{ $person->email }}</td>
                            <td>{{ $person->category }}</td>
                            <td class="text-left">{{ number_format($person->opening_balance) }}</td>
                            <td>
                                <span class="badge badge-{{ $person->is_active ? 'success' : 'danger' }}">
                                    {{ $person->is_active ? 'فعال' : 'غیرفعال' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('persons.edit', $person) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{ $person->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- منوی راست کلیک -->
<div class="context-menu" id="contextMenu">
    <ul>
        <li class="view-person">
            <i class="fas fa-eye"></i>
            نمایش جزئیات
        </li>
        <li class="edit-person">
            <i class="fas fa-edit"></i>
            ویرایش
        </li>
        <li class="separator"></li>
        <li class="copy-row">
            <i class="fas fa-copy"></i>
            کپی اطلاعات
        </li>
        <li class="separator"></li>
        <li class="delete-person">
            <i class="fas fa-trash"></i>
            حذف
        </li>
    </ul>
</div>

<!-- مودال ورود از اکسل -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ورود اطلاعات از اکسل</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="importForm" action="{{ route('persons.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>انتخاب فایل اکسل</label>
                        <input type="file" name="excel_file" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                    <button type="submit" class="btn btn-primary">بارگذاری</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // آپدیت خودکار تاریخ و زمان
    function updateDateTime() {
        $.ajax({
            url: '{{ route("persons.current-info") }}',
            type: 'GET',
            success: function(response) {
                $('#currentDateTime').text(response.current_datetime);
            }
        });
    }
    
    // هر 60 ثانیه تاریخ رو آپدیت کن
    setInterval(updateDateTime, 60000);

    // منوی راست کلیک
    let selectedRow = null;
    
    $(document).on('contextmenu', '.person-row', function(e) {
        e.preventDefault();
        selectedRow = $(this);
        const menu = $('#contextMenu');
        menu.css({
            display: 'block',
            left: e.pageX,
            top: e.pageY
        });
    });

    $(document).on('click', function() {
        $('#contextMenu').hide();
    });

    // عملیات منوی راست کلیک
    $('.view-person').click(function() {
        if (selectedRow) {
            const id = selectedRow.data('id');
            window.location.href = `/persons/${id}`;
        }
    });

    $('.edit-person').click(function() {
        if (selectedRow) {
            const id = selectedRow.data('id');
            window.location.href = `/persons/${id}/edit`;
        }
    });

    $('.delete-person').click(function() {
        if (selectedRow) {
            const id = selectedRow.data('id');
            if (confirm('آیا از حذف این شخص اطمینان دارید؟')) {
                $.ajax({
                    url: `/persons/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        selectedRow.remove();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON.message);
                    }
                });
            }
        }
    });

    $('.copy-row').click(function() {
        if (selectedRow) {
            const text = selectedRow.find('td').map(function() {
                return $(this).text().trim();
            }).get().join('\t');
            
            navigator.clipboard.writeText(text).then(function() {
                toastr.success('اطلاعات با موفقیت کپی شد');
            });
        }
    });

    // انتخاب همه
    $('.select-all-checkbox').change(function() {
        $('.select-checkbox').prop('checked', $(this).prop('checked'));
    });

    // فیلتر تب‌ها
    $('[data-filter]').click(function(e) {
        e.preventDefault();
        const filter = $(this).data('filter');
        
        $('[data-filter]').removeClass('active');
        $(this).addClass('active');

        if (filter === 'all') {
            $('.person-row').show();
        } else {
            $('.person-row').hide();
            $(`.person-row[data-${filter}="1"]`).show();
        }
    });

    // ورود از اکسل
    $('#importForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#importModal').modal('hide');
                toastr.success(response.message);
                location.reload();
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON.message);
            }
        });
    });

    // خروجی اکسل
    $('#exportBtn').click(function() {
        window.location.href = '{{ route("persons.export") }}';
    });
});
</script>
@endsection