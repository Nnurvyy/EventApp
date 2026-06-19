<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Event::query();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by Date Status
        if ($filter = $request->input('filter')) {
            if ($filter === 'upcoming') {
                $query->where('event_date', '>=', now()->toDateString());
            } elseif ($filter === 'past') {
                $query->where('event_date', '<', now()->toDateString());
            }
        }

        // Sorting
        $sort = $request->input('sort', 'event_date');
        $direction = $request->input('direction', 'asc');

        // Prevent SQL injection by validating sort columns
        if (in_array($sort, ['title', 'event_date', 'created_at'])) {
            $query->orderBy($sort, $direction);
        } else {
            $query->orderBy('event_date', 'asc');
        }

        $events = $query->paginate(10)->withQueryString();

        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date|after_or_equal:today',
            'event_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'price_type' => 'required|in:free,paid',
            'price' => 'required_if:price_type,paid|nullable|numeric|min:0',
        ], [
            'title.required' => 'Judul acara wajib diisi.',
            'description.required' => 'Deskripsi acara wajib diisi.',
            'event_date.required' => 'Tanggal acara wajib diisi.',
            'event_date.after_or_equal' => 'Tanggal acara tidak boleh di masa lampau.',
            'event_picture.image' => 'File harus berupa gambar.',
            'event_picture.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
            'event_picture.max' => 'Ukuran gambar maksimal adalah 2MB.',
            'price_type.required' => 'Tipe harga wajib dipilih.',
            'price_type.in' => 'Tipe harga tidak valid.',
            'price.required_if' => 'Nominal harga wajib diisi untuk acara berbayar.',
            'price.numeric' => 'Nominal harga harus berupa angka.',
            'price.min' => 'Nominal harga tidak boleh kurang dari 0.',
        ]);

        if ($request->hasFile('event_picture')) {
            $path = $request->file('event_picture')->store('events', 'public');
            $validated['event_picture'] = $path;
        }

        $validated['price'] = $request->input('price_type') === 'free' ? 0 : $request->input('price');

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Acara berhasil ditambahkan! 🎉');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event): View
    {
        return view('admin.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event): View
    {
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date|after_or_equal:today',
            'event_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'price_type' => 'required|in:free,paid',
            'price' => 'required_if:price_type,paid|nullable|numeric|min:0',
        ], [
            'title.required' => 'Judul acara wajib diisi.',
            'description.required' => 'Deskripsi acara wajib diisi.',
            'event_date.required' => 'Tanggal acara wajib diisi.',
            'event_date.after_or_equal' => 'Tanggal acara tidak boleh di masa lampau.',
            'event_picture.image' => 'File harus berupa gambar.',
            'event_picture.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
            'event_picture.max' => 'Ukuran gambar maksimal adalah 2MB.',
            'price_type.required' => 'Tipe harga wajib dipilih.',
            'price_type.in' => 'Tipe harga tidak valid.',
            'price.required_if' => 'Nominal harga wajib diisi untuk acara berbayar.',
            'price.numeric' => 'Nominal harga harus berupa angka.',
            'price.min' => 'Nominal harga tidak boleh kurang dari 0.',
        ]);

        if ($request->hasFile('event_picture')) {
            // Delete old picture if exists
            if ($event->event_picture) {
                Storage::disk('public')->delete($event->event_picture);
            }
            $path = $request->file('event_picture')->store('events', 'public');
            $validated['event_picture'] = $path;
        }

        $validated['price'] = $request->input('price_type') === 'free' ? 0 : $request->input('price');

        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Acara berhasil diperbarui! 📝');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event): RedirectResponse
    {
        // Delete picture from storage if exists
        if ($event->event_picture) {
            Storage::disk('public')->delete($event->event_picture);
        }

        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Acara berhasil dihapus! 🗑️');
    }
}
