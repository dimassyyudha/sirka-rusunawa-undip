<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roomsList = document.getElementById('rooms-list');
        const trigger = document.getElementById('infinite-scroll-trigger');
        const loading = document.getElementById('rooms-loading');

        if (!roomsList || !trigger || !loading) {
            return;
        }

        let isLoading = false;

        async function loadMoreRooms() {
            if (isLoading) return;

            const nextPage = Number(trigger.dataset.nextPage);
            const lastPage = Number(trigger.dataset.lastPage);

            if (nextPage > lastPage) {
                trigger.remove();
                return;
            }

            isLoading = true;
            loading.classList.remove('hidden');

            const url = new URL(window.location.href);
            url.searchParams.set('page', nextPage);

            try {
                const response = await fetch(url.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    }
                });

                if (!response.ok) {
                    throw new Error('Gagal mengambil data kamar.');
                }

                const html = await response.text();

                if (html.trim() !== '') {
                    roomsList.insertAdjacentHTML('beforeend', html);
                    trigger.dataset.nextPage = nextPage + 1;
                }

                if (nextPage >= lastPage) {
                    trigger.remove();

                    loading.outerHTML = `
                        <div class="py-8 text-center text-sm font-bold text-slate-400">
                            Semua kamar sudah ditampilkan.
                        </div>
                    `;
                }
            } catch (error) {
                loading.innerHTML = `
                    <div class="py-6 text-center text-sm font-bold text-red-500">
                        Gagal memuat data. Scroll lagi untuk mencoba.
                    </div>
                `;
            } finally {
                if (document.body.contains(loading)) {
                    loading.classList.add('hidden');
                }

                isLoading = false;
            }
        }

        const observer = new IntersectionObserver(function (entries) {
            if (entries[0].isIntersecting) {
                loadMoreRooms();
            }
        }, {
            root: null,
            rootMargin: '800px 0px',
            threshold: 0
        });

        observer.observe(trigger);

        window.addEventListener('scroll', function () {
            const nearBottom = window.innerHeight + window.scrollY >= document.body.offsetHeight - 900;

            if (nearBottom) {
                loadMoreRooms();
            }
        }, {
            passive: true
        });
    });
</script>