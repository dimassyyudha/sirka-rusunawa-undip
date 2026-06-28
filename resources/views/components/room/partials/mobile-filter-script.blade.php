<script>
    window.floorInfo = @json($floorInfo);

    document.addEventListener('DOMContentLoaded', () => {


        const filterModal = document.getElementById('filterModal');
        const sortModal = document.getElementById('sortModal');

        const openFilter = document.getElementById('openFilter');
        const openSort = document.getElementById('openSort');

        const closeFilter = document.getElementById('closeFilter');
        const closeSort = document.getElementById('closeSort');

        const closeFilterBtn = document.getElementById('closeFilterBtn');
        const closeSortBtn = document.getElementById('closeSortBtn');

        const lantaiContainer =
            document.getElementById('lantaiContainer');

        /*
        |--------------------------------------------------------------------------
        | MODAL
        |--------------------------------------------------------------------------
        */

        function hideFilter() {
            filterModal?.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function hideSort() {
            sortModal?.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        if (openFilter) {

            openFilter.addEventListener('click', () => {

                filterModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');

                setTimeout(() => {

                    const selectedGender =
                        document.querySelector(
                            '#mobileFilterForm input[name="gender"]:checked'
                        )?.value;

                    if (selectedGender) {
                        filterGedung(selectedGender);
                    }

                    const currentGedung =
                        document.querySelector(
                            '#mobileFilterForm input[name="gedung"]:checked'
                        );

                    if (currentGedung) {
                        loadLantai(currentGedung.value);
                    }

                    updateActiveStyles();

                }, 100);

            });

        }

        if (openSort) {

            openSort.addEventListener('click', () => {

                sortModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');

            });

        }

        closeFilter?.addEventListener('click', hideFilter);
        closeFilterBtn?.addEventListener('click', hideFilter);

        closeSort?.addEventListener('click', hideSort);
        closeSortBtn?.addEventListener('click', hideSort);

        /*
        |--------------------------------------------------------------------------
        | FILTER GEDUNG
        |--------------------------------------------------------------------------
        */

        function filterGedung(gender = null) {

            document
                .querySelectorAll('.mobile-gedung')
                .forEach(item => {

                    const tipe =
                        String(item.dataset.gender || '')
                        .trim()
                        .toLowerCase();

                    item.classList.remove('hidden');

                    // BELUM PILIH GENDER = TAMPILKAN SEMUA
                    if (!gender) {
                        return;
                    }

                    if (gender === 'laki-laki' && tipe !== 'laki-laki') {
                        item.classList.add('hidden');
                    }

                    if (gender === 'perempuan' && tipe !== 'perempuan') {
                        item.classList.add('hidden');
                    }

                });

        }

        /*
        |--------------------------------------------------------------------------
        | LOAD LANTAI
        |--------------------------------------------------------------------------
        */

        function loadLantai(kode) {

            lantaiContainer.innerHTML = '';

            if (!window.floorInfo[kode]) return;

            Object.keys(window.floorInfo[kode]).forEach(lantai => {

                lantaiContainer.insertAdjacentHTML(
                    'beforeend',
                    `
                <label
                    class="lantai-option cursor-pointer rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 transition-all duration-200">

                    <input
    type="radio"
    name="lantai"
    value="${lantai}"
    class="hidden">

                    

                    Lt ${lantai}

                </label>
                `
                );

            });

            updateActiveStyles();

        }

        /*
        |--------------------------------------------------------------------------
        | ACTIVE STYLE
        |--------------------------------------------------------------------------
        */

        function updateActiveStyles() {

            document.querySelectorAll('.gender-option')
                .forEach(el => {

                    el.classList.remove(
                        'mobile-gender-Laki-Laki',
                        'mobile-gender-Perempuan'
                    );

                    const input = el.querySelector('input');

                    if (!input) return;

                    if (input.checked) {

                        if (input.value === 'laki-laki') {
                            el.classList.add('mobile-gender-Laki-Laki');
                        }

                        if (input.value === 'perempuan') {
                            el.classList.add('mobile-gender-Perempuan');
                        }

                    }

                });

            document.querySelectorAll('.mobile-gedung')
                .forEach(el => {

                    el.classList.remove(
                        'mobile-gedung-active'
                    );

                    const input = el.querySelector('input');

                    if (input?.checked) {
                        el.classList.add(
                            'mobile-gedung-active'
                        );
                    }

                });

            document.querySelectorAll('.lantai-option')
                .forEach(el => {

                    el.classList.remove(
                        'mobile-lantai-active'
                    );

                    const input = el.querySelector('input');

                    if (input?.checked) {
                        el.classList.add(
                            'mobile-lantai-active'
                        );
                    }

                });

        }

        /*
        |--------------------------------------------------------------------------
        | GENDER CHANGE
        |--------------------------------------------------------------------------
        */

        document.querySelectorAll(
            '#mobileFilterForm input[name="gender"]'
        ).forEach(input => {

            input.addEventListener('change', () => {

                // reset semua gedung
                document.querySelectorAll(
                    '#mobileFilterForm input[name="gedung"]'
                ).forEach(x => {

                    x.checked = false;

                    x.removeAttribute('checked');

                });

                // reset semua lantai
                document.querySelectorAll(
                    '#mobileFilterForm input[name="lantai"]'
                ).forEach(x => {

                    x.checked = false;

                    x.removeAttribute('checked');

                });

                lantaiContainer.innerHTML = '';

                filterGedung(input.value);

                updateActiveStyles();

            });

        });

        /*
        |--------------------------------------------------------------------------
        | GEDUNG CHANGE
        |--------------------------------------------------------------------------
        */

        document.addEventListener('change', e => {

            if (e.target.name === 'gedung') {



                loadLantai(e.target.value);

                updateActiveStyles();

            }

            if (e.target.name === 'lantai') {

                updateActiveStyles();

            }

        });

        /*
        |--------------------------------------------------------------------------
        | INIT
        |--------------------------------------------------------------------------
        */


        const initialGender =
            document.querySelector(
                '#mobileFilterForm input[name="gender"]:checked'
            )?.value ?? null;

        filterGedung(initialGender);

        const currentGedung =
            document.querySelector(
                '#mobileFilterForm input[name="gedung"]:checked'
            );

        if (currentGedung) {
            loadLantai(currentGedung.value);
        }
        document.getElementById('mobileFilterForm')
            ?.addEventListener('submit', function() {

                const gender =
                    this.querySelector(
                        'input[name="gender"]:checked'
                    )?.value;

                const gedung =
                    this.querySelector(
                        'input[name="gedung"]:checked'
                    );

                if (gedung) {

                    const tipe =
                        gedung.closest('.mobile-gedung')
                        ?.dataset.gender
                        ?.toLowerCase();

                    if (
                        (gender === 'laki-laki' && tipe !== 'laki-laki') ||
                        (gender === 'perempuan' && tipe !== 'perempuan')
                    ) {

                        gedung.checked = false;
                        gedung.disabled = true;

                    }

                }

            });
        updateActiveStyles();

    });

    function updateMobileBarOffset() {

        const header =
            document.querySelector('header');

        if (!header) return;

        document.documentElement.style.setProperty(
            '--mobile-header-height',
            `${header.offsetHeight}px`
        );
    }

    window.addEventListener('load', updateMobileBarOffset);
    window.addEventListener('resize', updateMobileBarOffset);

    function updateMobileSpacer() {

        const bar =
            document.querySelector('.mobile-filter-bar');

        const spacer =
            document.getElementById('mobileBarSpacer');

        if (!bar || !spacer) return;

        spacer.style.height =
            `${bar.offsetHeight}px`;
    }

    window.addEventListener('load', () => {
        updateMobileBarOffset();
        updateMobileSpacer();
    });

    window.addEventListener('resize', () => {
        updateMobileBarOffset();
        updateMobileSpacer();
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const btn = document.getElementById('gedungDropdownBtn');
        const dropdown = document.getElementById('gedungDropdown');

        if (btn && dropdown) {

            btn.addEventListener('click', function(e) {

                e.preventDefault();
                e.stopPropagation();

                dropdown.classList.toggle('hidden');

            });

        }

        document.addEventListener('click', function(e) {

            if (
                btn &&
                dropdown &&
                !btn.contains(e.target) &&
                !dropdown.contains(e.target)
            ) {
                dropdown.classList.add('hidden');
            }

        });

    });
</script>
