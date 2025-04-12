@extends('layouts.app')

@push('styles')
{{-- AG Grid Styles --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community@31.0.1/styles/ag-grid.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community@31.0.1/styles/ag-theme-material.min.css">
<style>
    .ag-theme-material {
        --ag-font-family: 'Vazirmatn', sans-serif;
        --ag-font-size: 14px;
        --ag-selected-row-background-color: rgba(63, 81, 181, 0.1);
        --ag-row-hover-color: rgba(63, 81, 181, 0.05);
        direction: rtl;
    }

    .main-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .header-card {
        background: linear-gradient(135deg, #3f51b5, #1a237e);
        color: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 25px;
    }

    .stats-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: transform 0.2s;
    }

    .stats-card:hover {
        transform: translateY(-5px);
    }

    .stats-icon {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-bottom: 15px;
    }

    .stats-value {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .stats-label {
        color: #6b7280;
        font-size: 0.9rem;
    }

    .search-box {
        background: #f8fafc;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .cell-number {
        direction: ltr !important;
        text-align: left !important;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-active {
        background-color: #dcfce7;
        color: #166534;
    }

    .status-inactive {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .btn-icon {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        margin: 0 2px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="header-card mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="mb-1">لیست اشخاص</h4>
                <p class="mb-0 opacity-75">مدیریت اشخاص حقیقی و حقوقی</p>
                <small class="opacity-75">{{ $current_datetime }} | {{ $user_login }}</small>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('persons.create') }}" class="btn btn-light">
                    <i class="fas fa-plus me-1"></i>
                    شخص جدید
                </a>
                <button class="btn btn-light ms-2" id="export-excel">
                    <i class="fas fa-file-excel me-1"></i>
                    خروجی اکسل
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon" style="background: #e0e7ff; color: #3730a3;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-value">{{ number_format(count($persons)) }}</div>
                <div class="stats-label">کل اشخاص</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon" style="background: #dcfce7; color: #166534;">
                    <i class="fas fa-building"></i>
                </div>
                <div class="stats-value">{{ number_format($persons->where('type', 'company')->count()) }}</div>
                <div class="stats-label">اشخاص حقوقی</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon" style="background: #fef9c3; color: #854d0e;">
                    <i class="fas fa-user"></i>
                </div>
                <div class="stats-value">{{ number_format($persons->where('type', 'individual')->count()) }}</div>
                <div class="stats-label">اشخاص حقیقی</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon" style="background: #f3e8ff; color: #6b21a8;">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="stats-value">{{ number_format($persons->sum('credit_limit')) }}</div>
                <div class="stats-label">مجموع اعتبار</div>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="search-box">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control" id="quick-filter" placeholder="جستجوی سریع...">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="type-filter">
                    <option value="">نوع شخص</option>
                    <option value="individual">حقیقی</option>
                    <option value="company">حقوقی</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="category-filter">
                    <option value="">دسته‌بندی</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="main-card">
        <div id="personsGrid" class="ag-theme-material" style="height: 600px; width: 100%;"></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/ag-grid-community@31.0.1/dist/ag-grid-community.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const gridOptions = {
        columnDefs: [
            { 
                field: 'code', 
                headerName: 'کد',
                width: 100,
                cellStyle: { direction: 'ltr' }
            },
            { 
                field: 'full_name', 
                headerName: 'نام/شرکت',
                flex: 1,
                cellRenderer: params => {
                    const type = params.data.type === 'individual' ? 'حقیقی' : 'حقوقی';
                    return `
                        <div>
                            <div style="font-weight: 500;">${params.value}</div>
                            <div style="color: #6b7280; font-size: 12px;">${type}</div>
                        </div>
                    `;
                }
            },
            { 
                field: 'category_name', 
                headerName: 'دسته‌بندی',
                width: 140
            },
            { 
                field: 'mobile', 
                headerName: 'موبایل',
                width: 130,
                cellClass: 'cell-number'
            },
            { 
                field: 'phone', 
                headerName: 'تلفن',
                width: 130,
                cellClass: 'cell-number'
            },
            { 
                field: 'balance', 
                headerName: 'مانده حساب',
                width: 150,
                cellClass: 'cell-number',
                cellRenderer: params => {
                    const value = new Intl.NumberFormat('fa-IR').format(params.value || 0);
                    const color = params.value >= 0 ? '#047857' : '#dc2626';
                    return `<span style="color: ${color}; font-weight: 500;">${value}</span>`;
                }
            },
            { 
                field: 'credit_limit', 
                headerName: 'سقف اعتبار',
                width: 150,
                cellClass: 'cell-number',
                valueFormatter: params => new Intl.NumberFormat('fa-IR').format(params.value || 0)
            },
            { 
                field: 'status', 
                headerName: 'وضعیت',
                width: 110,
                cellRenderer: params => {
                    const status = params.value ? 'فعال' : 'غیرفعال';
                    const className = params.value ? 'status-active' : 'status-inactive';
                    return `<span class="status-badge ${className}">${status}</span>`;
                }
            },
            {
                headerName: 'عملیات',
                width: 120,
                sortable: false,
                filter: false,
                cellRenderer: params => {
                    return `
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-icon btn-primary" onclick="editPerson(${params.data.id})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-icon btn-danger" onclick="deletePerson(${params.data.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        rowData: @json($persons),
        defaultColDef: {
            sortable: true,
            filter: true,
            resizable: true,
            suppressMenu: true,
            floatingFilter: true
        },
        enableRtl: true,
        pagination: true,
        paginationPageSize: 15,
        rowSelection: 'multiple',
        animateRows: true,
        suppressScrollOnNewData: true,
        overlayLoadingTemplate: 'در حال بارگذاری...',
        overlayNoRowsTemplate: 'موردی برای نمایش وجود ندارد'
    };

    // ایجاد گرید
    const gridDiv = document.querySelector('#personsGrid');
    new agGrid.Grid(gridDiv, gridOptions);

    // جستجوی سریع
    document.querySelector('#quick-filter')?.addEventListener('input', function() {
        gridOptions.api.setQuickFilter(this.value);
    });

    // فیلتر نوع شخص
    document.querySelector('#type-filter')?.addEventListener('change', function() {
        const filterModel = {};
        if (this.value) {
            filterModel.type = { filter: this.value, type: 'equals' };
        }
        gridOptions.api.setFilterModel(filterModel);
    });

    // فیلتر دسته‌بندی
    document.querySelector('#category-filter')?.addEventListener('change', function() {
        const filterModel = {};
        if (this.value) {
            filterModel.category_id = { filter: this.value, type: 'equals' };
        }
        gridOptions.api.setFilterModel(filterModel);
    });

    // خروجی اکسل
    document.querySelector('#export-excel')?.addEventListener('click', () => {
        gridOptions.api.exportDataAsCsv({
            fileName: `persons-list-${new Date().toLocaleDateString('fa-IR')}.csv`
        });
    });
});

// Helper Functions
function editPerson(id) {
    window.location.href = `/persons/${id}/edit`;
}

function deletePerson(id) {
    if (!confirm('آیا از حذف این شخص اطمینان دارید؟')) return;
    
    fetch(`/persons/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('خطا در حذف شخص');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('خطا در حذف شخص');
    });
}
</script>
@endpush