// تنظیمات عمومی
const Toast = Swal.mixin({
    toast: true,
    position: 'bottom-left',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
});

// تنظیمات DataTables
$.extend(true, $.fn.dataTable.defaults, {
    language: {
        url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/fa.json'
    },
    responsive: true
});

$(document).ready(function() {
    // تعریف جدول
    const table = $('#peopleTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'collection',
                text: '<i class="fas fa-download"></i> خروجی',
                buttons: [
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> اکسل',
                        exportOptions: { columns: ':visible' }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        exportOptions: { columns: ':visible' }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> چاپ',
                        exportOptions: { columns: ':visible' }
                    }
                ]
            },
            {
                extend: 'colvis',
                text: '<i class="fas fa-columns"></i> ستون‌ها'
            }
        ],
        select: {
            style: 'multi',
            selector: 'td:first-child'
        },
        order: [[1, 'desc']],
        columnDefs: [
            {
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            },
            {
                orderable: false,
                targets: [-1]
            }
        ]
    });

    // حذف تکی
    $(document).on('click', '.delete-person', function() {
        const personId = $(this).data('id');
        
        Swal.fire({
            title: 'آیا مطمئن هستید؟',
            text: 'این عملیات قابل بازگشت نیست!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'بله، حذف شود',
            cancelButtonText: 'انصراف',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/persons/${personId}`,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        table.row($(`[data-id="${personId}"]`)).remove().draw();
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                    },
                    error: function(xhr) {
                        Toast.fire({
                            icon: 'error',
                            title: xhr.responseJSON.message || 'خطا در حذف شخص'
                        });
                    }
                });
            }
        });
    });

    // حذف گروهی
    $('.delete-selected').click(function() {
        const selectedRows = table.rows({ selected: true });
        const ids = selectedRows.data().map(function(data) {
            return $(data[0]).data('id');
        }).toArray();

        if (ids.length === 0) {
            Toast.fire({
                icon: 'warning',
                title: 'لطفاً حداقل یک مورد را انتخاب کنید'
            });
            return;
        }

        Swal.fire({
            title: 'آیا مطمئن هستید؟',
            text: `${ids.length} مورد انتخاب شده حذف خواهد شد!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'بله، حذف شود',
            cancelButtonText: 'انصراف',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/persons/bulk-delete',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        ids: ids
                    },
                    success: function(response) {
                        selectedRows.remove().draw();
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                    },
                    error: function(xhr) {
                        Toast.fire({
                            icon: 'error',
                            title: xhr.responseJSON.message || 'خطا در حذف اشخاص'
                        });
                    }
                });
            }
        });
    });

    // تغییر وضعیت گروهی
    $('.change-status').click(function() {
        const status = $(this).data('status');
        const selectedRows = table.rows({ selected: true });
        const ids = selectedRows.data().map(function(data) {
            return $(data[0]).data('id');
        }).toArray();

        if (ids.length === 0) {
            Toast.fire({
                icon: 'warning',
                title: 'لطفاً حداقل یک مورد را انتخاب کنید'
            });
            return;
        }

        $.ajax({
            url: '/persons/bulk-status',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                ids: ids,
                status: status
            },
            success: function(response) {
                table.ajax.reload();
                Toast.fire({
                    icon: 'success',
                    title: response.message
                });
            },
            error: function(xhr) {
                Toast.fire({
                    icon: 'error',
                    title: xhr.responseJSON.message || 'خطا در تغییر وضعیت'
                });
            }
        });
    });

    // ورود اطلاعات از اکسل
    $('#importForm').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        Swal.fire({
            title: 'در حال پردازش...',
            text: 'لطفاً منتظر بمانید',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#importModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'موفق',
                    text: response.message,
                    confirmButtonText: 'تایید'
                }).then(() => {
                    table.ajax.reload();
                });
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'خطا',
                    text: xhr.responseJSON.message || 'خطا در ورود اطلاعات',
                    confirmButtonText: 'تایید'
                });
            }
        });
    });

    // فیلتر پیشرفته
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        table.ajax.reload();
    });

    // پاک کردن فیلترها
    $('#clearFilters').click(function() {
        $('#filterForm')[0].reset();
        table.ajax.reload();
    });
});