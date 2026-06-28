@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {

                const form = document.getElementById('filterForm');

                if (!form) return;

                let timeout;

                const searchInput = document.getElementById('searchInput');

                if (searchInput) {

                    searchInput.addEventListener('input', () => {

                        clearTimeout(timeout);

                        timeout = setTimeout(() => {

                            const keyword = searchInput.value.trim();

                            if (keyword.length >= 3 || keyword.length === 0) {
                                form.submit();
                            }

                        }, 1000);

                    });

                }

                document.querySelectorAll('.auto-filter')
                    .forEach(el => {

                        el.addEventListener('change', () => {
                            form.submit();
                        });

                    });

            });
        </script>
    @endpush
@endonce
