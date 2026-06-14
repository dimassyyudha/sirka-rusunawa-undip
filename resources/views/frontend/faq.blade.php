<section id="faq" class="py-24 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="mb-16 text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900">
                {{ $faq['title'] ?? 'Pertanyaan yang Sering Diajukan' }}
            </h2>
            <p class="mt-4 text-gray-500 text-base md:text-lg">
                {{ $faq['subtitle'] ?? 'Temukan jawaban seputar Rusunawa.' }}
            </p>
        </div>

        <div class="space-y-8">
            @forelse($faqItemsHome as $i => $item)
                {{-- <div class="accordion border border-gray-300 rounded-2xl px-6 py-5 transition-all duration-300 bg-white"> --}}
                <div
                    class="accordion border border-gray-300 rounded-2xl px-6 py-5 transition-all duration-500 bg-white hover:bg-indigo-50">

                    <button
                        type="button"class="accordion-toggle group w-full flex items-start justify-between text-left text-2xl font-normal">

                        <span class="question pr-6 text-gray-900 transition group-hover:text-blue-700">
                            {{ $item['question'] ?? '-' }}
                        </span>

                        <svg class="icon w-6 h-6 text-gray-900 transition-all duration-300 group-hover:text-blue-700"
                            xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"
                            fill="none">
                            <path
                                d="M16.5 8.25L12.4142 12.3358C11.7475 13.0025 11.4142 13.3358 11 13.3358C10.5858 13.3358 10.2525 13.0025 9.58579 12.3358L5.5 8.25"
                                stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>

                    <div class="accordion-content overflow-hidden max-h-0 transition-all duration-500">
                        <p class="pt-3 text-xl leading-relaxed text-black">
                            {{ $item['answer'] ?? '-' }}
                        </p>
                    </div>

                </div>

            @empty
                <div class="text-center text-gray-500">
                    Belum ada FAQ.
                </div>
            @endforelse
        </div>
        <div class="mt-10 text-center">

        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('page.faq') }}"
                class="group relative inline-flex items-center px-6 py-3 rounded-2xl 
               border border-blue-700 text-blue-700 font-semibold 
               transition hover:bg-blue-700 hover:text-white">

                Lihat Semua FAQ

                <span
                    class="absolute left-1/2 bottom-2 h-[2px] w-0 bg-[#070b54] 
                     transition-all duration-300 -translate-x-1/2 
                     group-hover:w-3/4 group-hover:bg-white">
                </span>
            </a>
        </div>

    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const items = document.querySelectorAll("#faq .accordion");

        items.forEach((item, index) => {
            const btn = item.querySelector(".accordion-toggle");
            const content = item.querySelector(".accordion-content");
            const icon = item.querySelector(".icon");
            const question = item.querySelector(".question");

            function openItem() {
                item.classList.remove("bg-white", "border-gray-300");
                item.classList.add("bg-indigo-50", "border-blue-700");

                question.classList.remove("text-gray-900");
                question.classList.add("text-blue-700");

                icon.classList.add("rotate-180");
                icon.classList.remove("text-gray-900");
                icon.classList.add("text-blue-700");

                content.style.maxHeight = content.scrollHeight + "px";
            }

            function closeItem() {
                item.classList.remove("bg-indigo-50", "border-blue-700");
                item.classList.add("bg-white", "border-gray-300");

                question.classList.remove("text-blue-700");
                question.classList.add("text-gray-900");

                icon.classList.remove("rotate-180");
                icon.classList.remove("text-blue-700");
                icon.classList.add("text-gray-900");

                content.style.maxHeight = null;
            }

            if (index === 0) openItem();

            btn.addEventListener("click", () => {
                const isOpen = content.style.maxHeight;

                items.forEach(other => {
                    const otherContent = other.querySelector(".accordion-content");
                    const otherIcon = other.querySelector(".icon");
                    const otherQuestion = other.querySelector(".question");

                    other.classList.remove("bg-indigo-50", "border-blue-700");
                    other.classList.add("bg-white", "border-gray-300");

                    otherQuestion.classList.remove("text-blue-700");
                    otherQuestion.classList.add("text-gray-900");

                    otherIcon.classList.remove("rotate-180");
                    otherIcon.classList.remove("text-blue-700");
                    otherIcon.classList.add("text-gray-900");

                    otherContent.style.maxHeight = null;
                });

                if (!isOpen) openItem();
            });
        });
    });
</script>
