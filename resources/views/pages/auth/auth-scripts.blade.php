<script>
    document.addEventListener('DOMContentLoaded', function() {

        function initPhoneInput(selector) {

            const input = document.querySelector(selector);

            if (!input || !window.intlTelInput) {
                return null;
            }

            return window.intlTelInput(input, {
                initialCountry: 'id',
                preferredCountries: ['id', 'sg', 'my'],
                separateDialCode: true,
                nationalMode: false,
                autoPlaceholder: 'aggressive',
                utilsScript: 'https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/js/utils.js',
            });

        }

        const phone = initPhoneInput('#number_phone');

        const form = document.querySelector('form');

        if (form) {
            form.addEventListener('submit', function() {

                const input = document.querySelector('#number_phone');

                if (phone && input) {
                    input.value = phone.getNumber();
                }

            });
        }

    });


    function togglePassword(inputId, eyeOpenId, eyeClosedId) {

        const input = document.getElementById(inputId);
        const eyeOpen = document.getElementById(eyeOpenId);
        const eyeClosed = document.getElementById(eyeClosedId);

        if (input.type === 'password') {

            input.type = 'text';

            eyeClosed.classList.add('hidden');
            eyeOpen.classList.remove('hidden');

        } else {

            input.type = 'password';

            eyeOpen.classList.add('hidden');
            eyeClosed.classList.remove('hidden');

        }
    }
</script>
