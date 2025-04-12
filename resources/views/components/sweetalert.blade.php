@once
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            @if (Session::has('success'))
                Toast.fire({
                    icon: 'success',
                    title: "{{ Session::get('success') }}"
                });
            @endif

            @if (Session::has('error'))
                Toast.fire({
                    icon: 'error',
                    title: "{{ Session::get('error') }}"
                });
            @endif

            window.showLoading = () => {
                Swal.fire({
                    title: 'در حال پردازش...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            };

            window.showSuccess = (message, callback = null) => {
                Swal.fire({
                    icon: 'success',
                    title: 'موفق',
                    text: message,
                    confirmButtonText: 'تایید'
                }).then((result) => {
                    if (callback && result.isConfirmed) {
                        callback();
                    }
                });
            };

            window.showError = (message) => {
                Swal.fire({
                    icon: 'error',
                    title: 'خطا',
                    text: message,
                    confirmButtonText: 'تایید'
                });
            };

            window.showConfirm = (message, callback) => {
                Swal.fire({
                    icon: 'warning',
                    title: 'آیا مطمئن هستید؟',
                    text: message,
                    showCancelButton: true,
                    confirmButtonText: 'بله',
                    cancelButtonText: 'خیر'
                }).then((result) => {
                    if (result.isConfirmed && callback) {
                        callback();
                    }
                });
            };
        </script>
    @endpush
@endonce