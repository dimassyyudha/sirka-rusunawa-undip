document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-hamburger-target]').forEach((button) => {
        const targetId = button.dataset.hamburgerTarget;
        const target = document.getElementById(targetId);

        if (!target) return;

        const line1 = button.querySelector('.line-1');
        const line2 = button.querySelector('.line-2');
        const line3 = button.querySelector('.line-3');

        button.addEventListener('click', () => {
            const isOpen = button.classList.toggle('is-open');

            target.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden', isOpen);

            line1.classList.toggle('-translate-y-[6px]', !isOpen);
            line1.classList.toggle('rotate-45', isOpen);

            line2.classList.toggle('opacity-0', isOpen);

            line3.classList.toggle('translate-y-[6px]', !isOpen);
            line3.classList.toggle('-rotate-45', isOpen);
        });
    });
});