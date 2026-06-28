<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Occupant;
use App\Models\Room;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function indexMahasiswa(Request $request)
    {
        $perPage = $request->integer('per_page', 10);
        $testimonials = Testimonial::with([
            'room.floor.building'
        ])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate($perPage);

        return view(
            'pages.mahasiswa.testimonials.index',
            compact('testimonials')
        );
    }

    public function indexAdmin(Request $request)
    {

        $perPage = $request->integer('per_page', 10);
        $query = Testimonial::with([
            'user',
            'room.floor.building'
        ]);

        if (request('search')) {

            $search = request('search');

            $query->where(function ($q) use ($search) {

                $q->where('comment', 'like', "%{$search}%")

                    ->orWhereHas('user', function ($user) use ($search) {

                        $user->where('name', 'like', "%{$search}%");
                    })

                    ->orWhereHas('room', function ($room) use ($search) {

                        $room->where('kode_kamar', 'like', "%{$search}%");
                    });
            });
        }

        if (request('rating')) {

            $query->where(
                'rating',
                request('rating')
            );
        }

        if (request()->filled('visible')) {

            $query->where(
                'is_visible',
                request('visible')
            );
        }

        switch (request('sort')) {

            case 'oldest':
                $query->oldest();
                break;

            case 'rating_desc':
                $query->orderByDesc('rating');
                break;

            case 'rating_asc':
                $query->orderBy('rating');
                break;

            default:
                $query->latest();
                break;
        }



        $totalTestimonials = Testimonial::count();

        $averageRating = round(
            Testimonial::avg('rating'),
            1
        );

        $visibleCount = Testimonial::where(
            'is_visible',
            true
        )->count();

        $hiddenCount = Testimonial::where(
            'is_visible',
            false
        )->count();
        $testimonials = Testimonial::with([
            'user',
            'room.floor.building',
        ]);

        if ($search = request('search')) {

            $testimonials->where(function ($q) use ($search) {

                $q->where('comment', 'like', "%{$search}%")

                    ->orWhereHas('user', function ($user) use ($search) {

                        $user->where('name', 'like', "%{$search}%");
                    })

                    ->orWhereHas('room', function ($room) use ($search) {

                        $room->where('kode_kamar', 'like', "%{$search}%");
                    });
            });
        }

        if (request('building_id')) {

            $testimonials->whereHas(
                'room.floor.building',
                fn($q) => $q->where('id', request('building_id'))
            );
        }

        if (request()->filled('rating')) {

            $testimonials->where(
                'rating',
                request('rating')
            );
        }

        if (request()->filled('visibility')) {

            $testimonials->where(
                'is_visible',
                request('visibility')
            );
        }

        switch (request('sort')) {

            case 'oldest':
                $testimonials->oldest();
                break;

            case 'rating_desc':
                $testimonials->orderByDesc('rating');
                break;

            case 'rating_asc':
                $testimonials->orderBy('rating');
                break;

            default:
                $testimonials->latest();
                break;
        }

        $testimonials = $query
            ->paginate($perPage)
            ->withQueryString();
        $buildings = Building::orderBy('code')->get();
        return view(
            'pages.admin.testimonials.index',
            compact(
                'testimonials',
                'buildings',
                'totalTestimonials',
                'averageRating',
                'visibleCount',
                'hiddenCount'
            )
        );
    }

    public function show(Testimonial $testimonial)
    {
        $testimonial->load([
            'user',
            'room.floor.building'
        ]);

        return view(
            'pages.admin.testimonials.show',
            compact('testimonial')
        );
    }
    public function create()
    {
        $occupant = Occupant::with([
            'room.floor.building'
        ])
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();

        if (!$occupant) {

            return redirect()
                ->route('mahasiswa.testimoni.index')
                ->with(
                    'error',
                    'Anda belum memiliki kamar aktif.'
                );
        }

        $alreadyExists = Testimonial::where(
            'user_id',
            auth()->id()
        )
            ->where(
                'room_id',
                $occupant->room_id
            )
            ->exists();

        return view(
            'pages.mahasiswa.testimonials.create',
            compact(
                'occupant',
                'alreadyExists'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => [
                'required',
                'exists:rooms,room_id'
            ],
            'rating' => [
                'required',
                'integer',
                'min:1',
                'max:5'
            ],
            'comment' => [
                'nullable',
                'string'
            ],
        ]);

        $hasOccupied = Occupant::where(
            'user_id',
            auth()->id()
        )
            ->where(
                'room_id',
                $request->room_id
            )
            ->exists();

        if (!$hasOccupied) {

            return back()->with(
                'error',
                'Hanya penghuni yang pernah atau sedang menempati kamar ini yang dapat memberikan testimoni.'
            );
        }

        $alreadyExists = Testimonial::where(
            'user_id',
            auth()->id()
        )
            ->where(
                'room_id',
                $request->room_id
            )
            ->exists();

        if ($alreadyExists) {

            return back()->with(
                'error',
                'Anda sudah memberikan testimoni untuk kamar ini.'
            );
        }

        Testimonial::create([
            'room_id' => $request->room_id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_visible' => true,
        ]);

        return redirect()
            ->route('mahasiswa.testimoni.index')
            ->with(
                'success',
                'Terima kasih atas testimoni yang telah diberikan.'
            );
    }



    public function edit(Testimonial $testimonial)
    {
        $rooms = Room::orderBy(
            'kode_kamar'
        )->get();

        return view(
            'pages.testimonials.edit',
            compact(
                'testimonial',
                'rooms'
            )
        );
    }

    public function update(
        Request $request,
        Testimonial $testimonial
    ) {
        $validated = $request->validate([
            'rating' => [
                'required',
                'integer',
                'min:1',
                'max:5'
            ],
            'comment' => [
                'nullable',
                'string'
            ],
            'is_visible' => [
                'nullable',
                'boolean'
            ],
        ]);

        $testimonial->update([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
            'is_visible' => $request->boolean('is_visible'),
        ]);

        return redirect()
            ->route('admin.testimoni.index')
            ->with(
                'success',
                'Testimoni berhasil diperbarui.'
            );
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return redirect()
            ->route('admin.testimoni.index')
            ->with(
                'success',
                'Testimoni berhasil dihapus.'
            );
    }
}
