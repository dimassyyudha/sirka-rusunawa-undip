<script>
    document.addEventListener('DOMContentLoaded', function() {

        /*
        |--------------------------------------------------------------------------
        | Reservation SUMMARY
        |--------------------------------------------------------------------------
        */

        const duration = 6;

        const summaryType = document.getElementById('summaryType');
        const summaryPrice = document.getElementById('summaryPrice');
        const summaryTotal = document.getElementById('summaryTotal');

        function formatRupiah(number) {
            return 'Rp ' + Number(number || 0).toLocaleString('id-ID');
        }

        document.querySelectorAll('input[name="occupancy_type"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                const price = parseInt(this.dataset.price || 0, 10);

                if (summaryType) {
                    summaryType.textContent =
                        this.value === 'private' ?
                        'Sekamar sendiri' :
                        'Sekamar berdua';
                }

                if (summaryPrice) {
                    summaryPrice.textContent = formatRupiah(price);
                }

                if (summaryTotal) {
                    summaryTotal.textContent = formatRupiah(price * duration);
                }
            });
        });



        /*
        |--------------------------------------------------------------------------
        | ADVANCED FILE PREVIEW
        |--------------------------------------------------------------------------
        */

        function setupAdvancedPreview(config) {

            const input =
                document.getElementById(config.input);

            const wrapper =
                document.getElementById(config.wrapper);

            const previewImage =
                document.getElementById(config.image);

            const previewPdf =
                document.getElementById(config.pdf);

            const previewName =
                document.getElementById(config.name);

            const previewSize =
                document.getElementById(config.size);

            const removeBtn =
                document.getElementById(config.remove);

            if (!input) return;

            input.addEventListener('change', function() {

                const file = this.files[0];

                if (!file) {

                    wrapper.classList.add('hidden');

                    return;
                }

                wrapper.classList.remove('hidden');

                previewName.textContent =
                    file.name;

                previewSize.textContent =
                    (
                        file.size /
                        1024 /
                        1024
                    ).toFixed(2) +
                    ' MB';

                if (
                    file.type.startsWith(
                        'image/'
                    )
                ) {

                    previewPdf.classList.add(
                        'hidden'
                    );

                    previewImage.classList.remove(
                        'hidden'
                    );

                    previewImage.src =
                        URL.createObjectURL(
                            file
                        );

                } else {

                    previewImage.classList.add(
                        'hidden'
                    );

                    previewPdf.classList.remove(
                        'hidden'
                    );

                }

            });

            removeBtn.addEventListener(
                'click',
                function() {

                    input.value = '';

                    previewImage.src = '';

                    wrapper.classList.add(
                        'hidden'
                    );

                }
            );
        }

        setupAdvancedPreview({
            input: 'profile_photo_file',
            wrapper: 'profilePhotoPreviewWrapper',
            image: 'profilePhotoPreviewImage',
            pdf: 'profilePhotoPdfPreview',
            name: 'profilePhotoPreviewName',
            size: 'profilePhotoPreviewSize',
            remove: 'removeProfilePhotoFile'
        });

        setupAdvancedPreview({
            input: 'ktm_file',
            wrapper: 'ktmPreviewWrapper',
            image: 'ktmPreviewImage',
            pdf: 'ktmPreviewPdf',
            name: 'ktmPreviewName',
            size: 'ktmPreviewSize',
            remove: 'removeKtmFile'
        });

        setupAdvancedPreview({
            input: 'kip_document',
            wrapper: 'kipPreviewWrapper',
            image: 'kipPreviewImage',
            pdf: 'kipPreviewPdf',
            name: 'kipPreviewName',
            size: 'kipPreviewSize',
            remove: 'removeKipFile'
        });

        setupAdvancedPreview({
            input: 'stnk_file',
            wrapper: 'stnkPreviewWrapper',
            image: 'stnkPreviewImage',
            pdf: 'stnkPreviewPdf',
            name: 'stnkPreviewName',
            size: 'stnkPreviewSize',
            remove: 'removeStnkFile'
        });
        /*
        |--------------------------------------------------------------------------
        | MOTORCYCLE
        |--------------------------------------------------------------------------
        */

        const vehicleRadios = document.querySelectorAll('input[name="has_motor"]');
        const vehicleWrapper = document.getElementById('vehicleWrapper');
        const plateInput = document.getElementById('vehicle_plate_number');
        const stnkInput = document.getElementById('stnk_file');
        const stnkPreviewWrapper = document.getElementById('stnkPreviewWrapper');
        const stnkPreviewName = document.getElementById('stnkPreviewName');

        function syncVehicle() {
            const checked = document.querySelector('input[name="has_motor"]:checked');
            const value = checked ? checked.value : '0';

            if (value === '1') {
                vehicleWrapper?.classList.remove('opacity-50');
                plateInput?.removeAttribute('disabled');
                stnkInput?.removeAttribute('disabled');
                return;
            }

            vehicleWrapper?.classList.add('opacity-50');

            if (plateInput) {
                plateInput.value = '';
                plateInput.setAttribute('disabled', 'disabled');
            }

            if (stnkInput) {
                stnkInput.value = '';
                stnkInput.setAttribute('disabled', 'disabled');
            }

            if (stnkPreviewName) {
                stnkPreviewName.textContent = '';
            }

            if (stnkPreviewWrapper) {
                stnkPreviewWrapper.classList.add('hidden');
            }
        }

        vehicleRadios.forEach(function(radio) {
            radio.addEventListener('change', syncVehicle);
        });

        syncVehicle();

        /*
        |--------------------------------------------------------------------------
        | PHONE INPUT
        |--------------------------------------------------------------------------
        */

        function initPhoneInput(selector) {
            const input = document.querySelector(selector);

            if (!input || !window.intlTelInput) return null;

            return window.intlTelInput(input, {
                initialCountry: 'id',
                preferredCountries: ['id', 'sg', 'my'],
                separateDialCode: true,
                nationalMode: false,
                autoPlaceholder: 'aggressive',
                utilsScript: 'https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/js/utils.js',
            });
        }

        const studentPhone = initPhoneInput('#phone');
        const parentPhone = initPhoneInput('#parent_phone');

        /*
        |--------------------------------------------------------------------------
        | FORM SUBMIT
        |--------------------------------------------------------------------------
        */

        const form = document.getElementById('ReservationForm');

        if (form) {
            form.addEventListener('submit', function() {
                const phoneInput = document.querySelector('#phone');
                const parentPhoneInput = document.querySelector('#parent_phone');

                if (studentPhone && phoneInput) {
                    phoneInput.value = studentPhone.getNumber();
                }

                if (parentPhone && parentPhoneInput) {
                    parentPhoneInput.value = parentPhone.getNumber();
                }
            });
        }

        /*
        |--------------------------------------------------------------------------
        | JALUR PEMBIAYAAN
        |--------------------------------------------------------------------------
        */

        const payment3 = document.getElementById('payment_3');
        const payment6 = document.getElementById('payment_6');
        const payment3Label = document.getElementById('payment3Label');

        function updatePaymentTerm() {

            const funding = document.querySelector(
                'input[name="jalur_pembiayaan"]:checked'
            );

            if (!funding) return;

            const isKip =
                funding.value === 'Bidikmisi/KIP-K';

            const payment3 =
                document.getElementById('payment_3');

            const payment6 =
                document.getElementById('payment_6');

            const payment3Label =
                document.getElementById('payment3Label');

            const kipInput =
                document.getElementById('kip_document');

            const kipSection =
                document.getElementById('kipDocumentSection');

            const kipWrapper =
                document.getElementById('kipPreviewWrapper');

            const kipImage =
                document.getElementById('kipPreviewImage');

            const kipName =
                document.getElementById('kipPreviewName');

            const kipSize =
                document.getElementById('kipPreviewSize');

            if (isKip) {

                payment3.disabled = false;

                kipInput?.removeAttribute('disabled');

                kipSection?.classList.remove(
                    'opacity-60',
                    'pointer-events-none'
                );

                payment3Label.classList.remove(
                    'opacity-60',
                    'cursor-not-allowed',
                    'bg-slate-50'
                );

            } else {

                payment3.disabled = true;

                payment6.checked = true;

                payment3Label.classList.add(
                    'opacity-60',
                    'cursor-not-allowed',
                    'bg-slate-50'
                );

                kipSection?.classList.add(
                    'opacity-60'
                );

                if (kipInput) {

                    kipInput.value = '';

                    kipInput.setAttribute(
                        'disabled',
                        'disabled'
                    );
                }

                if (kipWrapper) {
                    kipWrapper.classList.add('hidden');
                }

                if (kipImage) {
                    kipImage.src = '';
                }

                if (kipName) {
                    kipName.textContent = '';
                }

                if (kipSize) {
                    kipSize.textContent = '';
                }
            }

        }

        document
            .querySelectorAll(
                'input[name="jalur_pembiayaan"]'
            )
            .forEach(radio => {

                radio.addEventListener(
                    'change',
                    updatePaymentTerm
                );

            });

        updatePaymentTerm();
    });
</script>
