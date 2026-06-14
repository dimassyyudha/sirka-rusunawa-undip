<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class SiteSettingController extends Controller
{
    private function defaultBeranda(): array
    {
        return [
            'headline' => 'Reservasi Rusunawa UNDIP',
            'subheadline' => 'Mudah, cepat, transparan.',
            'cta_text' => 'Reservasi Kamar',
            'background_images' => [
                [
                    'id' => 'default_hero_1',
                    'image' => 'assets-admin/images/hero-1.jpg',
                    'is_active' => true,
                    'is_featured' => true,
                    'sort_order' => 1,
                ],
                [
                    'id' => 'default_hero_2',
                    'image' => 'assets-admin/images/hero-2.jpg',
                    'is_active' => true,
                    'is_featured' => true,
                    'sort_order' => 2,
                ],
                [
                    'id' => 'default_hero_3',
                    'image' => 'assets-admin/images/hero-3.jpg',
                    'is_active' => true,
                    'is_featured' => true,
                    'sort_order' => 3,
                ],
            ],
        ];
    }

    public function berandaIndex()
    {
        $data = SiteSetting::getValue('beranda', $this->defaultBeranda());

        $backgrounds = collect($data['background_images'] ?? [])
            ->map(function ($item, $index) {
                $item['id'] = $item['id'] ?? 'bg_' . $index;
                $item['is_active'] = $item['is_active'] ?? true;
                $item['sort_order'] = $item['sort_order'] ?? ($index + 1);

                return $item;
            })
            ->sortBy('sort_order')
            ->values()
            ->all();

        return view('pages.admin.settings.beranda.index', [
            'data' => $data,
            'backgrounds' => $backgrounds,
        ]);
    }

    public function berandaEdit()
    {
        $data = SiteSetting::getValue('beranda', $this->defaultBeranda());

        $backgrounds = collect($data['background_images'] ?? [])
            ->map(function ($item, $index) {
                $item['id'] = $item['id'] ?? 'bg_' . $index;
                $item['is_active'] = $item['is_active'] ?? true;
                $item['sort_order'] = $item['sort_order'] ?? ($index + 1);

                return $item;
            })
            ->sortBy('sort_order')
            ->values()
            ->all();

        return view('pages.admin.settings.beranda.edit', [
            'data' => $data,
            'backgrounds' => $backgrounds,
        ]);
    }

    public function berandaUpdate(Request $request)
    {
        $request->validate([
            'headline' => 'required|string|max:255',
            'subheadline' => 'nullable|string|max:500',
            'cta_text' => 'nullable|string|max:100',

            'existing_id' => 'nullable|array',
            'existing_sort_order' => 'nullable|array',
            'existing_is_active' => 'nullable|array',
            'existing_delete' => 'nullable|array',
            'existing_image' => 'nullable|array',
            'existing_image.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

            'new_image' => 'nullable|array',
            'new_image.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'new_sort_order' => 'nullable|array',
            'new_is_active' => 'nullable|array',
        ]);

        $data = SiteSetting::getValue('beranda', $this->defaultBeranda());

        $backgrounds = collect($data['background_images'] ?? [])
            ->map(function ($item, $index) {
                $item['id'] = $item['id'] ?? 'bg_' . $index;
                $item['is_active'] = $item['is_active'] ?? true;
                $item['sort_order'] = $item['sort_order'] ?? ($index + 1);

                return $item;
            })
            ->values()
            ->all();

        $byId = [];

        foreach ($backgrounds as $bg) {
            $byId[$bg['id']] = $bg;
        }

        foreach ($request->input('existing_id', []) as $id) {
            if (!isset($byId[$id])) {
                continue;
            }

            if ($request->boolean("existing_delete.$id")) {
                $oldImage = $byId[$id]['image'] ?? null;

                if (
                    $oldImage &&
                    !str_starts_with($oldImage, 'assets-admin/') &&
                    !str_starts_with($oldImage, 'storage/') &&
                    !str_starts_with($oldImage, 'http')
                ) {
                    Storage::disk('public')->delete($oldImage);
                }

                unset($byId[$id]);
                continue;
            }

            $byId[$id]['sort_order'] = (int) $request->input("existing_sort_order.$id", 1);
            $byId[$id]['is_active'] = $request->has("existing_is_active.$id");
            $byId[$id]['is_featured'] = true;

            if ($request->hasFile("existing_image.$id")) {
                $oldImage = $byId[$id]['image'] ?? null;

                if (
                    $oldImage &&
                    !str_starts_with($oldImage, 'assets-admin/') &&
                    !str_starts_with($oldImage, 'storage/') &&
                    !str_starts_with($oldImage, 'http')
                ) {
                    Storage::disk('public')->delete($oldImage);
                }

                $byId[$id]['image'] = $request->file("existing_image.$id")
                    ->store('hero-backgrounds', 'public');
            }
        }

        foreach ($request->file('new_image', []) as $i => $file) {
            if (!$file) {
                continue;
            }

            $id = (string) Str::ulid();

            $byId[$id] = [
                'id' => $id,
                'image' => $file->store('hero-backgrounds', 'public'),
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => (int) ($request->input("new_sort_order.$i") ?? 9999),
            ];
        }

        $finalBackgrounds = collect(array_values($byId))
            ->filter(fn($item) => !empty($item['image']))
            ->sortBy('sort_order')
            ->values()
            ->map(function ($item, $index) {
                return [
                    'id' => $item['id'] ?? (string) Str::ulid(),
                    'image' => $item['image'],
                    'is_active' => (bool) ($item['is_active'] ?? true),
                    'is_featured' => (bool) ($item['is_featured'] ?? true),
                    'sort_order' => $index + 1,
                ];
            })
            ->all();

        SiteSetting::putValue('beranda', [
            'headline' => $request->headline,
            'subheadline' => $request->subheadline,
            'cta_text' => $request->cta_text,
            'background_images' => $finalBackgrounds,
        ]);

        return redirect()
            ->route('admin.settings.beranda.index')
            ->with('success', 'Pengaturan beranda berhasil diperbarui.');
    }

    // ===================== TENTANG KAMI =====================
    private function defaultTentangKami(): array
    {
        return [
            'badge' => 'Tentang Kami',
            'title' => 'Mengenal Rusunawa UNDIP Lebih Dekat',
            'description' => 'Rusunawa UNDIP hadir sebagai hunian nyaman dan terjangkau bagi mahasiswa Universitas Diponegoro.',
            'blocks' => [
                [
                    'id' => 'profil',
                    'type' => 'Profil',
                    'title' => 'Profil Rusunawa UNDIP',
                    'body' => 'Rusunawa Universitas Diponegoro merupakan hunian resmi bagi mahasiswa.',
                    'image' => null,
                    'items' => [
                        'Lokasi strategis dekat kampus.',
                        'Lingkungan nyaman dan aman.',
                        'Pengelolaan penghuni tercatat rapi.',
                    ],
                ],
                [
                    'id' => 'visi_misi',
                    'type' => 'Visi Misi',
                    'title' => 'Visi & Misi Pengelolaan Rusunawa',
                    'body' => 'Menjadi hunian mahasiswa yang aman, nyaman, tertib, dan mendukung kegiatan akademik.',
                    'image' => null,
                    'items' => [
                        'Menyediakan hunian yang layak bagi mahasiswa.',
                        'Mengelola data penghuni secara terintegrasi.',
                        'Meningkatkan kualitas pelayanan Rusunawa.',
                    ],
                ],
                [
                    'id' => 'aturan',
                    'type' => 'Aturan',
                    'title' => 'Aturan Umum Penghuni',
                    'body' => 'Setiap penghuni wajib mematuhi aturan yang berlaku di lingkungan Rusunawa UNDIP.',
                    'image' => null,
                    'items' => [
                        'Menjaga kebersihan dan ketertiban.',
                        'Mematuhi jam kunjung dan jam tenang.',
                        'Menghargai sesama penghuni.',
                    ],
                ],
            ],
        ];
    }

    private function normalizeTentangKami(array $data): array
    {
        if (!isset($data['blocks'])) {
            $data['blocks'] = [
                [
                    'id' => 'profil',
                    'type' => 'Profil',
                    'title' => $data['blok1_title'] ?? 'Profil Rusunawa UNDIP',
                    'body' => $data['blok1_body'] ?? '',
                    'image' => $data['blok1_image'] ?? null,
                    'items' => $data['blok1_points'] ?? [],
                ],
                [
                    'id' => 'visi_misi',
                    'type' => 'Visi Misi',
                    'title' => $data['blok2_title'] ?? 'Visi & Misi',
                    'body' => $data['blok2_visi'] ?? '',
                    'image' => $data['blok2_image'] ?? null,
                    'items' => $data['blok2_misi'] ?? [],
                ],
                [
                    'id' => 'aturan',
                    'type' => 'Aturan',
                    'title' => $data['blok4_rules_title'] ?? 'Aturan Umum Penghuni',
                    'body' => $data['blok4_rules_body'] ?? '',
                    'image' => null,
                    'items' => $data['blok4_rules'] ?? [],
                ],
            ];
        }

        return $data;
    }

    public function tentangKamiIndex()
    {
        $data = SiteSetting::getValue('tentang_kami', $this->defaultTentangKami());
        $data = $this->normalizeTentangKami($data);

        return view('pages.admin.settings.tentang-kami.index', compact('data'));
    }

    public function tentangKamiEdit()
    {
        $data = SiteSetting::getValue('tentang_kami', $this->defaultTentangKami());
        $data = $this->normalizeTentangKami($data);

        return view('pages.admin.settings.tentang-kami.edit', compact('data'));
    }

    public function tentangKamiUpdate(Request $request)
    {
        $request->validate([
            'badge' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',

            'blocks' => 'nullable|array',
            'blocks.*.id' => 'nullable|string',
            'blocks.*.type' => 'nullable|string|max:100',
            'blocks.*.title' => 'required|string|max:255',
            'blocks.*.body' => 'nullable|string|max:5000',
            'blocks.*.items' => 'nullable|array',
            'blocks.*.items.*' => 'nullable|string|max:255',

            'block_images' => 'nullable|array',
            'block_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'delete_block' => 'nullable|array',
        ]);

        $oldData = SiteSetting::getValue('tentang_kami', $this->defaultTentangKami());
        $oldData = $this->normalizeTentangKami($oldData);

        $oldBlocksById = collect($oldData['blocks'] ?? [])
            ->keyBy('id')
            ->toArray();

        $blocks = [];

        foreach ($request->input('blocks', []) as $i => $block) {
            if (!empty($request->input("delete_block.$i"))) {
                continue;
            }

            $id = $block['id'] ?? (string) Str::ulid();

            $oldImage = $oldBlocksById[$id]['image'] ?? null;
            $image = $oldImage;

            if ($request->hasFile("block_images.$i")) {
                if (
                    $oldImage &&
                    !str_starts_with($oldImage, 'assets-admin/') &&
                    !str_starts_with($oldImage, 'storage/') &&
                    !str_starts_with($oldImage, 'http')
                ) {
                    Storage::disk('public')->delete($oldImage);
                }

                $image = $request->file("block_images.$i")->store('tentang-kami', 'public');
            }

            $items = array_values(array_filter(
                $block['items'] ?? [],
                fn($item) => trim((string) $item) !== ''
            ));

            $blocks[] = [
                'id' => $id,
                'type' => $block['type'] ?? 'Custom',
                'title' => $block['title'] ?? '',
                'body' => $block['body'] ?? '',
                'image' => $image,
                'items' => $items,
            ];
        }

        SiteSetting::putValue('tentang_kami', [
            'badge' => $request->badge,
            'title' => $request->title,
            'description' => $request->description,
            'blocks' => $blocks,
        ]);

        return redirect()
            ->route('admin.settings.tentang-kami.index')
            ->with('success', 'Pengaturan Tentang Kami berhasil diperbarui.');
    }
    private function defaultCariKamar(): array
    {
        return [
            'title' => 'Reservasi Kamar',
            'subtitle' => 'Temukan kamar yang sesuai kebutuhanmu.',
            'show_filter_gedung' => true,
            'show_filter_status' => true,
            'show_filter_lantai' => true,
        ];
    }

    public function cariKamar()
    {
        $data = SiteSetting::getValue('cari_kamar', $this->defaultCariKamar());

        return view('pages.admin.settings.cari-kamar.index', compact('data'));
    }


    public function editCariKamar()
    {
        $data = SiteSetting::getValue('cari_kamar', $this->defaultCariKamar());
        return view('pages.admin.settings.cari-kamar.edit', compact('data'));
    }

    public function updateCariKamar(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
        ]);

        SiteSetting::putValue('cari_kamar', [
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'],
            'show_filter_gedung' => $request->boolean('show_filter_gedung'),
            'show_filter_status' => $request->boolean('show_filter_status'),
            'show_filter_lantai' => $request->boolean('show_filter_lantai'),
        ]);

        return redirect()
            ->route('cari-kamar.index')
            ->with('success', 'Pengaturan Reservasi Kamar berhasil diperbarui.');
    }

    private function defaultFaq(): array
    {
        return [
            'title' => 'Pertanyaan yang sering diajukan',
            'subtitle' => 'Klik salah satu pertanyaan di bawah untuk melihat jawabannya.',
            'items' => [
                [
                    'id' => (string) Str::ulid(),
                    'question' => 'Bisa 1 orang 1 kamar?',
                    'answer' => 'Bisa. Satu orang dapat menempati satu kamar, namun biaya yang dikenakan tetap sesuai harga kamar penuh berdasarkan ketentuan Rusunawa.',
                    'is_active' => true,
                    'sort_order' => 1,
                ],
                [
                    'id' => (string) Str::ulid(),
                    'question' => 'Kamar tersedia itu apa?',
                    'answer' => 'Kamar tersedia berarti status kamar aktif dan masih memiliki slot kosong (jumlah penghuni lebih sedikit dari kapasitas kamar).',
                    'is_active' => true,
                    'sort_order' => 2,
                ],
            ],
        ];
    }

    public function faqIndex()
    {
        $data = SiteSetting::getValue('faq', $this->defaultFaq());

        $items = collect($data['items'] ?? [])
            ->sortBy('sort_order')
            ->values()
            ->all();

        return view('pages.admin.settings.faq.index', [
            'data' => $data,
            'items' => $items,
        ]);
    }

    public function faqEdit()
    {
        $data = SiteSetting::getValue('faq', $this->defaultFaq());

        $items = collect($data['items'] ?? [])
            ->sortBy('sort_order')
            ->values()
            ->all();

        return view('pages.admin.settings.faq.edit', [
            'data' => $data,
            'items' => $items,
        ]);
    }

    public function faqUpdate(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string'],
            'question' => ['array'],
            'answer' => ['array'],
            'sort_order' => ['array'],
        ]);

        $questions = $request->question ?? [];
        $answers = $request->answer ?? [];
        $sortOrders = $request->sort_order ?? [];
        $itemIds = $request->item_id ?? [];

        $items = [];

        foreach ($questions as $i => $question) {
            if (!empty($request->delete[$i])) {
                continue;
            }

            if (blank($question) && blank($answers[$i] ?? null)) {
                continue;
            }

            $items[] = [
                'id' => $itemIds[$i] ?? null,
                'question' => $question,
                'answer' => $answers[$i] ?? '',
                'sort_order' => (int) ($sortOrders[$i] ?? ($i + 1)),
                'is_active' => isset($request->is_active[$i]),
                'is_featured' => isset($request->is_featured[$i]),
            ];
        }

        $items = collect($items)
            ->sortBy('sort_order')
            ->values()
            ->map(function ($item, $index) {
                $item['sort_order'] = $index + 1;
                $item['id'] = $item['id'] ?: uniqid('faq_');
                return $item;
            })
            ->all();

        $payload = [
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'items' => $items,
        ];

        SiteSetting::setValue('faq', $payload);

        return redirect()
            ->route('admin.settings.faq.index')
            ->with('success', 'FAQ berhasil diperbarui.');
    }

    // ===================== KENAPA RUSUNAWA =====================

    private function defaultKenapaRusunawa(): array
    {
        return [
            'badge' => 'Kenapa Rusunawa?',
            'title' => 'Bukan sekadar tempat tinggal, tapi lingkungan belajar yang nyaman',
            'description' => 'Rusunawa UNDIP dirancang untuk mahasiswa: strategis, aman, dan tertib.',
            'cards' => [
                [
                    'id' => (string) Str::ulid(),
                    'icon' => 'bi-geo-alt-fill',
                    'title' => 'Dekat Kampus',
                    'desc' => 'Akses cepat ke fakultas dan fasilitas kampus.',
                    'is_active' => true,
                    'sort_order' => 1,
                ],
                [
                    'id' => (string) Str::ulid(),
                    'icon' => 'bi-shield-lock-fill',
                    'title' => 'Aman',
                    'desc' => 'Lingkungan terkontrol untuk kenyamanan penghuni.',
                    'is_active' => true,
                    'sort_order' => 2,
                ],
                [
                    'id' => (string) Str::ulid(),
                    'icon' => 'bi-cash-coin',
                    'title' => 'Terjangkau',
                    'desc' => 'Biaya jelas dan transparan, cocok untuk mahasiswa.',
                    'is_active' => true,
                    'sort_order' => 3,
                ],
                [
                    'id' => (string) Str::ulid(),
                    'icon' => 'bi-bar-chart-fill',
                    'title' => 'Realtime',
                    'desc' => 'Cek slot dan status kamar secara langsung lewat sistem.',
                    'is_active' => true,
                    'sort_order' => 4,
                ],
            ],
        ];
    }

    public function kenapaIndex()
    {
        $data = SiteSetting::getValue('kenapa_rusunawa', $this->defaultKenapaRusunawa());

        $cards = collect($data['cards'] ?? [])
            ->sortBy('sort_order')
            ->values()
            ->all();

        return view('pages.admin.settings.kenapa.index', [
            'data' => $data,
            'cards' => $cards,
        ]);
    }

    public function kenapaEdit()
    {
        $data = SiteSetting::getValue('kenapa_rusunawa', $this->defaultKenapaRusunawa());

        $cards = collect($data['cards'] ?? [])
            ->sortBy('sort_order')
            ->values()
            ->all();

        return view('pages.admin.settings.kenapa.edit', [
            'data' => $data,
            'cards' => $cards,
        ]);
    }

    public function kenapaUpdate(Request $request)
    {
        $request->validate([
            'badge' => 'required|string|max:120',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:800',

            'card_id' => 'nullable|array',
            'icon' => 'nullable|array',
            'title_card' => 'nullable|array',
            'desc' => 'nullable|array',
            'sort_order' => 'nullable|array',
            'is_active' => 'nullable|array',
            'delete' => 'nullable|array',
        ]);

        $ids   = $request->input('card_id', []);
        $icons = $request->input('icon', []);
        $titles = $request->input('title_card', []);
        $descs = $request->input('desc', []);
        $sorts = $request->input('sort_order', []);
        $actives = $request->input('is_active', []);
        $deletes = $request->input('delete', []);

        $cards = [];

        foreach ($titles as $i => $t) {
            if (!empty($deletes[$i])) continue;

            $t = trim((string)$t);
            $d = trim((string)($descs[$i] ?? ''));
            $ic = trim((string)($icons[$i] ?? ''));

            if ($t === '' && $d === '') continue;

            $cards[] = [
                'id' => !empty($ids[$i]) ? (string)$ids[$i] : (string) Str::ulid(),
                'icon' => $ic !== '' ? $ic : 'bi-stars',
                'title' => $t,
                'desc' => $d,
                'is_active' => isset($actives[$i]),
                'sort_order' => (int)($sorts[$i] ?? 9999),
            ];
        }

        // rapikan urutan 1..N
        $cards = collect($cards)
            ->sortBy('sort_order')
            ->values()
            ->map(function ($c, $idx) {
                $c['sort_order'] = $idx + 1;
                return $c;
            })
            ->all();

        SiteSetting::putValue('kenapa_rusunawa', [
            'badge' => $request->badge,
            'title' => $request->title,
            'description' => $request->description,
            'cards' => $cards,
        ]);

        return redirect()
            ->route('admin.settings.kenapa.index')
            ->with('success', 'Pengaturan Kenapa Rusunawa berhasil diperbarui.');
    }

    public function alurIndex()
    {
        $data = SiteSetting::getValue('alur', [
            'badge' => 'Cara Reservasi',
            'title' => 'Alur Reservasi Kamar Rusunawa',
            'description' => 'Ikuti langkah-langkah berikut untuk melakukan reservasi kamar di Rusunawa UNDIP secara mudah, transparan, dan terstruktur.',
            'steps' => [],
        ]);

        $items = collect($data['steps'] ?? [])
            ->sortBy('sort_order')
            ->values()
            ->all();

        return view('pages.admin.settings.alur.index', compact('data', 'items'));
    }

    public function alurEdit()
    {
        $data = SiteSetting::getValue('alur', [
            'badge' => 'Cara Reservasi',
            'title' => 'Alur Reservasi Kamar Rusunawa',
            'description' => 'Ikuti langkah-langkah berikut untuk melakukan reservasi kamar di Rusunawa UNDIP secara mudah, transparan, dan terstruktur.',
            'steps' => [],
        ]);

        $items = collect($data['steps'] ?? [])
            ->sortBy('sort_order')
            ->values()
            ->all();

        return view('pages.admin.settings.alur.edit', compact('data', 'items'));
    }
    public function alurUpdate(Request $request)
    {
        $request->validate([
            'badge' => ['nullable', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'step_title' => ['array'],
            'step_desc' => ['array'],
            'sort_order' => ['array'],
        ]);

        $titles = $request->step_title ?? [];
        $descs  = $request->step_desc ?? [];
        $sorts  = $request->sort_order ?? [];

        $steps = [];

        foreach ($titles as $i => $title) {
            if (!empty($request->delete[$i])) {
                continue;
            }

            if (blank($title) && blank($descs[$i] ?? null)) {
                continue;
            }

            $steps[] = [
                'title' => $title,
                'desc' => $descs[$i] ?? '',
                'sort_order' => (int) ($sorts[$i] ?? ($i + 1)),
                'is_active' => isset($request->is_active[$i]),
            ];
        }

        $steps = collect($steps)
            ->sortBy('sort_order')
            ->values()
            ->map(function ($step, $index) {
                $step['sort_order'] = $index + 1;
                return $step;
            })
            ->all();

        $payload = [
            'badge' => $request->badge,
            'title' => $request->title,
            'description' => $request->description,
            'steps' => $steps,
        ];

        SiteSetting::setValue('alur', $payload);

        return redirect()
            ->route('admin.settings.alur.index')
            ->with('success', 'Pengaturan alur berhasil diperbarui.');
    }

    // T&C

    private function defaultsyaratKetentuan(): array
    {
        return [

            'title' => 'Perjanjian Sewa Hunian Rusunawa UNDIP',

            'sections' => [

                [
                    'number' => 1,
                    'title' => 'Ketentuan dan Tata Cara Pembayaran Sewa Hunian',

                    'items' => [

                        'Mahasiswa penghuni Rusunawa wajib melakukan sewa hunian selama 1 tahun (dan bisa diperpanjang), dengan termin pembayaran per 6 bulan.',

                        'Periode pembayaran hunian rusunawa adalah per 6 bulan (Januari–Juni dan Juli–Desember).',

                        'Khusus untuk penghuni baru yang mendaftar sebelum bulan Juli, pada saat pendaftaran harus membayar sampai bulan Juli, sedangkan yang mendaftar bulan Juli atau setelahnya harus membayar sampai bulan Desember setiap tahunnya.',

                        'Mahasiswa penerima bidik misi, pembayaran biaya dilakukan setiap 3 bulan.',

                        'Calon penghuni harus membuat Surat Pernyataan bermeterai Rp10.000,- siap tinggal selama setahun dan dapat diperpanjang.',

                        'Pembayaran dan perpanjangan sewa hunian harus dilakukan tepat waktu sebelum masa hunian berakhir.',
                    ],
                ],

                [
                    'number' => 2,
                    'title' => 'Melengkapi Kebutuhan Pribadi',

                    'items' => [

                        'Perlengkapan tidur: bantal, guling, sprei, sarung bantal, selimut, dan perlengkapan tidur lainnya.',

                        'Perlengkapan kamar: kaca rias, kastok, gantungan baju, keset, korden, tempat sampah ruangan, dan alat kebersihan.',

                        'Perlengkapan kamar mandi: ember, gayung, handuk, perlengkapan mandi dan cuci.',

                        'Perlengkapan dan penyediaan peralatan makan dan minum.',

                        'Perlengkapan belajar, transportasi, dan kebutuhan sehari-hari lainnya.',
                    ],
                ],

                [
                    'number' => 3,
                    'title' => 'Kewajiban Penghuni Rusunawa UNDIP',

                    'items' => [

                        'Menjaga kesopanan, kebersihan, ketertiban, keindahan dan keamanan lingkungan.',

                        'Menggunakan dan merawat fasilitas yang diterima dari Badan Pengelola Rusunawa.',

                        'Menjaga dan mengamankan barang-barang milik pribadi, kehilangan barang pribadi di luar tanggung jawab Pengelola Rusunawa.',

                        'Melaporkan dan menyerahkan fotokopi STNK bagi yang membawa kendaraan bermotor roda dua dan/atau roda empat.',

                        'Membayar uang sewa tepat pada waktunya.',

                        'Penghuni harus mengganti biaya perbaikan atas kerusakan yang dilakukan penghuni, misalnya mencoret atau merusak tembok, almari, meja belajar, dan inventaris lainnya.',

                        'Jika terjadi kerusakan kran air, lampu penerangan, dan fasilitas lain (termasuk AC dan kipas angin) yang berada di kamar masing-masing sebagai akibat penggunaan penghuni, maka perbaikan atau penggantiannya menjadi tanggung jawab penghuni.',

                        'Ruang kamar hanya untuk belajar dan tidur penghuni.',

                        'Penghuni boleh menerima tamu hanya di hall/lobby umum pada pukul 06.00 WIB s/d 21.00 WIB.',

                        'Tamu (termasuk orang tua/keluarga) dilarang masuk dan menginap di kamar penghuni.',

                        'Tamu wajib menunjukkan identitas dan mengisi buku tamu pada petugas keamanan.',
                    ],
                ],

                [
                    'number' => 4,
                    'title' => 'Larangan Penghuni Rusunawa UNDIP',

                    'items' => [

                        'Memindahkan hak sewa kepada pihak lain.',

                        'Menggunakan kamar hunian sebagai tempat usaha atau gudang.',

                        'Berjudi, mengedarkan atau memakai narkoba, minuman keras, obat-obat terlarang, serta kegiatan yang menimbulkan suara keras, bising, bau menyengat yang mengganggu keamanan, kenyamanan dan ketertiban lingkungan.',

                        'Mengadakan kegiatan organisasi terlarang sebagaimana peraturan perundang-undangan yang berlaku.',

                        'Merokok di kamar, ruang lobby, hall, serta memasak menggunakan kayu, arang, kompor gas atau bahan lain yang dapat mengotori dan menimbulkan bahaya kebakaran.',

                        'Mengubah konstruksi bangunan rusunawa dan membuang benda-benda ke dalam saluran air kamar mandi/WC yang dapat menyumbat saluran pembuangan.',

                        'Menyimpan segala jenis bahan peledak, bahan kimia, bahan bakar atau bahan terlarang lainnya yang dapat menimbulkan kebakaran atau bahaya lain.',

                        'Membawa dan memelihara hewan piaraan.',

                        'Membawa keluar barang-barang inventaris BP Rusunawa (tempat tidur, almari, spring bed/kasur, kursi) kecuali barang milik pribadi.',
                    ],
                ],

                [
                    'number' => 5,
                    'title' => 'Masa Hunian',

                    'items' => [

                        'Sanggup tinggal di Rusunawa UNDIP minimal selama 12 (dua belas) bulan dan apabila terjadi pembatalan, uang yang sudah dibayarkan tidak bisa ditarik kembali.',
                    ],
                ],

                [
                    'number' => 6,
                    'title' => 'Perpanjangan Hunian',

                    'items' => [

                        'Periode hunian dimulai pada bulan Juli tahun berjalan sampai dengan Juni tahun berikutnya, apabila ingin melanjutkan ke periode selanjutnya penghuni wajib mendaftar ulang.',
                    ],
                ],

                [
                    'number' => 7,
                    'title' => 'Sanksi',

                    'items' => [

                        'Apabila terjadi pelanggaran terhadap perjanjian dan ketentuan di atas, penghuni bersedia menerima peringatan, sanksi, dan pemutusan sepihak oleh Pengelola Rusunawa dan Universitas Diponegoro sesuai tingkat pelanggaran.',
                    ],
                ],

            ],
        ];
    }

    public function syaratKetentuanIndex()
    {
        $default = $this->defaultsyaratKetentuan();

        // otomatis buat record jika belum ada
        if (!SiteSetting::where('key', 'syarat-ketentuan')->exists()) {

            SiteSetting::putValue(
                'syarat-ketentuan',
                $default
            );
        }

        $data = SiteSetting::getValue(
            'syarat-ketentuan',
            $default
        );

        foreach ($default['sections'] as $i => $section) {

            if (!isset($data['sections'][$i])) {
                $data['sections'][$i] = $section;
            }
        }

        $sections = collect($data['sections'])
            ->map(function ($item, $index) {

                $item['id'] =
                    $item['id']
                    ?? 'section_' . $index;

                $item['number'] =
                    $item['number']
                    ?? ($index + 1);

                $item['sort_order'] =
                    $item['sort_order']
                    ?? ($index + 1);

                $item['is_active'] =
                    $item['is_active']
                    ?? true;

                $item['items'] =
                    $item['items']
                    ?? [];

                return $item;
            })
            ->sortBy('sort_order')
            ->values()
            ->all();

        return view(
            'pages.admin.settings.syarat-ketentuan.index',
            compact('data', 'sections')
        );
    }
    public function syaratKetentuanEdit()
    {
        $default = $this->defaultsyaratKetentuan();

        $data = SiteSetting::getValue(
            'syarat-ketentuan',
            $default
        );

        foreach ($default['sections'] as $i => $section) {

            if (!isset($data['sections'][$i])) {
                $data['sections'][$i] = $section;
            }
        }

        $sections = collect($data['sections'])
            ->map(function ($item, $index) {

                $item['id'] =
                    $item['id']
                    ?? 'section_' . $index;

                $item['number'] =
                    $item['number']
                    ?? ($index + 1);

                $item['sort_order'] =
                    $item['sort_order']
                    ?? ($index + 1);

                $item['is_active'] =
                    $item['is_active']
                    ?? true;

                $item['items'] =
                    $item['items']
                    ?? [];

                return $item;
            })
            ->sortBy('sort_order')
            ->values()
            ->all();

        return view(
            'pages.admin.settings.syarat-ketentuan.edit',
            compact('data', 'sections')
        );
    }
    public function syaratKetentuanUpdate(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $sections = [];

        foreach ($request->sections ?? [] as $i => $section) {

            $items = collect($section['items'] ?? [])
                ->filter(fn($item) => trim((string) $item) !== '')
                ->values()
                ->all();

            if (
                blank($section['title'] ?? '') &&
                empty($items)
            ) {
                continue;
            }

            $sections[] = [
                'id' => $section['id']
                    ?? (string) Str::ulid(),

                'number' => count($sections) + 1,

                'title' => trim(
                    $section['title'] ?? ''
                ),

                'items' => $items,

                'is_active' => true,

                'sort_order' => count($sections) + 1,
            ];
        }

        // fallback jika form kosong atau pasal terpotong
        $default = $this->defaultsyaratKetentuan();

        foreach ($default['sections'] as $index => $defaultSection) {

            if (!isset($sections[$index])) {

                $sections[$index] = [
                    'id' => (string) Str::ulid(),
                    'number' => $defaultSection['number'],
                    'title' => $defaultSection['title'],
                    'items' => $defaultSection['items'],
                    'is_active' => true,
                    'sort_order' => $defaultSection['number'],
                ];
            }
        }

        usort($sections, function ($a, $b) {
            return $a['number'] <=> $b['number'];
        });

        SiteSetting::putValue(
            'syarat-ketentuan',
            [
                'title' => $request->title,
                'sections' => array_values($sections),
            ]
        );

        return redirect()
            ->route('admin.settings.syarat-ketentuan.index')
            ->with(
                'success',
                'syarat ketentuan berhasil diperbarui.'
            );
    }
}
