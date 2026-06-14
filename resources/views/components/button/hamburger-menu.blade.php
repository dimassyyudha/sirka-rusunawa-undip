@props([
    'buttonId' => 'mobileMenuButton',
    'menuId' => 'mobileMenu',
    'color' => 'bg-white',
    'hover' => 'hover:bg-white/10',
])

<button id="{{ $buttonId }}" type="button"
    class="relative w-11 h-11 rounded-full {{ $hover }} transition flex items-center justify-center">

    <span id="{{ $buttonId }}Line1"
        class="absolute w-5 h-[2px] {{ $color }} rounded-full transition-all duration-300 -translate-y-[6px]"></span>

    <span id="{{ $buttonId }}Line2"
        class="absolute w-5 h-[2px] {{ $color }} rounded-full transition-all duration-300"></span>

    <span id="{{ $buttonId }}Line3"
        class="absolute w-5 h-[2px] {{ $color }} rounded-full transition-all duration-300 translate-y-[6px]"></span>
</button>

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                document.querySelectorAll('[id$="mobileMenuButton"], #mobileMenuButton')
                    .forEach(function(button) {

                        const buttonId = button.id;
                        const menuId = button.dataset.menuTarget || 'mobileMenu';

                        const menu = document.getElementById(menuId);

                        const line1 = document.getElementById(buttonId + 'Line1');
                        const line2 = document.getElementById(buttonId + 'Line2');
                        const line3 = document.getElementById(buttonId + 'Line3');

                        if (!menu || !line1 || !line2 || !line3) return;

                        button.addEventListener('click', function(e) {

                            e.stopPropagation();

                            const isOpen = menu.classList.contains('hidden');

                            if (isOpen) {
                                menu.classList.remove('hidden');

                                line1.classList.remove('-translate-y-[6px]');
                                line1.classList.add('rotate-45');

                                line2.classList.add('opacity-0');

                                line3.classList.remove('translate-y-[6px]');
                                line3.classList.add('-rotate-45');

                            } else {
                                menu.classList.add('hidden');

                                line1.classList.remove('rotate-45');
                                line1.classList.add('-translate-y-[6px]');

                                line2.classList.remove('opacity-0');

                                line3.classList.remove('-rotate-45');
                                line3.classList.add('translate-y-[6px]');
                            }
                        });

                    });

            });
        </script>
    @endpush
@endonce
