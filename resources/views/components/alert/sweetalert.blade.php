@once
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.body.addEventListener('click', function(e) {
                const trigger = e.target.closest('[data-confirm]');

                if (!trigger) return;

                e.preventDefault();
                showConfirm(trigger);
            });

            document.body.addEventListener('submit', function(e) {
                const form = e.target;

                if (!form.matches('.form-delete, [data-confirm-form]')) return;
                if (form.dataset.confirmed === '1') return;

                e.preventDefault();
                showConfirm(form);
            });

            function showConfirm(target) {
                const title = target.dataset.confirmTitle || 'Apakah Anda yakin?';

                const text = target.dataset.confirmText ||
                    'Pastikan seluruh data sudah benar sebelum melanjutkan.';

                const icon = target.dataset.confirmIcon || 'warning';

                const confirmButtonText = target.dataset.confirmButtonText || 'Ya, lanjutkan';

                const cancelButtonText = target.dataset.confirmCancelText || 'Batal';

                Swal.fire({
                    title: title,
                    text: text,
                    icon: icon,
                    showCancelButton: true,
                    confirmButtonText: confirmButtonText,
                    cancelButtonText: cancelButtonText,
                    reverseButtons: true,
                    confirmButtonColor: '#7c3aed',
                    cancelButtonColor: '#64748b',
                    customClass: {
                        popup: 'rounded-3xl',
                        confirmButton: 'rounded-xl',
                        cancelButton: 'rounded-xl',
                    }
                }).then((result) => {
                    if (!result.isConfirmed) return;

                    if (target.tagName === 'FORM') {
                        target.dataset.confirmed = '1';
                        target.submit();
                        return;
                    }

                    const form = target.closest('form');

                    if (form) {
                        form.dataset.confirmed = '1';
                        form.submit();
                        return;
                    }

                    if (target.tagName === 'A' && target.href) {
                        window.location.href = target.href;
                    }
                });
            }

        });
    </script>
@endonce
