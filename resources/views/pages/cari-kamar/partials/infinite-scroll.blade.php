<script>
    document.addEventListener('DOMContentLoaded', () => {

        const roomsList = document.getElementById('rooms-list');
        const trigger = document.getElementById('infinite-scroll-trigger');
        const loading = document.getElementById('rooms-loading');

        if (!roomsList || !trigger || !loading) return;

        let isLoading = false;

        async function loadMoreRooms() {

            if (isLoading) return;

            let nextPage = parseInt(trigger.dataset.nextPage);
            const lastPage = parseInt(trigger.dataset.lastPage);

            if (nextPage > lastPage) {
                observer.disconnect();
                trigger.remove();
                return;
            }

            isLoading = true;

            observer.unobserve(trigger);

            loading.classList.remove('hidden');

            // LANGSUNG NAIKKAN PAGE
            trigger.dataset.nextPage = nextPage + 1;

            try {

                const url = new URL(window.location.href);
                url.searchParams.set('page', nextPage);

                console.log('LOAD PAGE =>', nextPage);

                const response = await fetch(url.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    }
                });

                if (!response.ok) {
                    throw new Error('Fetch gagal');
                }

                const html = await response.text();

                if (html.trim()) {
                    roomsList.insertAdjacentHTML('beforeend', html);
                }

                if (nextPage >= lastPage) {

                    observer.disconnect();

                    trigger.remove();

                    loading.outerHTML = `
                    <div class="py-8 text-center text-sm font-bold text-slate-400">
                        Semua kamar sudah ditampilkan.
                    </div>
                `;

                    return;
                }

            } catch (err) {

                console.error(err);

                // kalau gagal balikin page
                trigger.dataset.nextPage = nextPage;

            } finally {

                isLoading = false;

                if (document.body.contains(loading)) {
                    loading.classList.add('hidden');
                }

                if (document.body.contains(trigger)) {
                    observer.observe(trigger);
                }
            }
        }

        const observer = new IntersectionObserver(
            (entries) => {
                if (entries[0].isIntersecting) {
                    loadMoreRooms();
                }
            }, {
                root: null,
                rootMargin: '500px',
                threshold: 0
            }
        );

        observer.observe(trigger);

    });
</script>
