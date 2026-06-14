<style>
    :root {
        --navH: 92px;
        --gap: 16px;
        --offset: calc(var(--navH) + var(--gap));
    }
    html {
        scroll-behavior: smooth;
    }

    @media (min-width: 768px) {
        .filter-wrap {
            position: sticky;
            top: var(--offset);
            align-self: start;
            z-index: 30;
            max-height: calc(100vh - var(--offset) - 20px);
            overflow-y: auto;
            overscroll-behavior: contain;
        }

        .filter-wrap::-webkit-scrollbar {
            width: 6px;
        }

        .filter-wrap::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 999px;
        }
    }

    @media (max-width: 767px) {
        .filter-wrap {
            position: sticky;
            top: var(--navH);
            z-index: 40;
            background: #f8fafc;
            padding: 12px 0;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    }
</style>