@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('.room-detail-swiper', {
                loop: true,
                speed: 700,
                spaceBetween: 0,
                slidesPerView: 1,
                autoplay: {
                    delay: 3500,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.room-detail-swiper .swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.room-detail-swiper .swiper-button-next',
                    prevEl: '.room-detail-swiper .swiper-button-prev',
                },
            });

            const tabLinks = document.querySelectorAll('.tablink');
            const tabContents = document.querySelectorAll('.tabcontent');

            tabLinks.forEach(function(tab) {
                tab.addEventListener('click', function() {
                    const targetId = this.dataset.tab;

                    tabLinks.forEach(function(link) {
                        link.classList.remove('active', 'border-indigo-600',
                            'text-indigo-600');
                        link.classList.add('border-transparent', 'text-gray-500');
                    });

                    tabContents.forEach(function(content) {
                        content.classList.add('hidden');
                    });

                    this.classList.add('active', 'border-indigo-600', 'text-indigo-600');
                    this.classList.remove('border-transparent', 'text-gray-500');

                    const target = document.getElementById(targetId);
                    if (target) {
                        target.classList.remove('hidden');
                    }
                });
            });
        });
    </script>
@endpush