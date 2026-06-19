<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Mail\EventRegisteredMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EventRegistrationController extends Controller
{
    /**
     * Display a listing of the user's registered events (10 per page).
     */
    public function index(Request $request): \Illuminate\View\View
    {
        $userId = $request->user()->id;

        $registeredEvents = DB::table('event_registrations')
            ->join('events', 'event_registrations.event_id', '=', 'events.id')
            ->where('event_registrations.user_id', $userId)
            ->select('events.*', 'event_registrations.registered_at', 'event_registrations.status', 'event_registrations.id as registration_id')
            ->orderBy('event_registrations.created_at', 'desc')
            ->paginate(10);

        return view('events.registered', compact('registeredEvents'));
    }

    /**
     * Display a listing of all event registrations for the admin (10 per page).
     */
    public function adminIndex(Request $request): \Illuminate\View\View
    {
        $query = DB::table('event_registrations')
            ->join('users', 'event_registrations.user_id', '=', 'users.id')
            ->join('events', 'event_registrations.event_id', '=', 'events.id')
            ->select(
                'event_registrations.id as registration_id',
                'users.name as user_name', 
                'events.title as event_title', 
                'events.event_picture as event_picture',
                'event_registrations.registered_at', 
                'event_registrations.status'
            );

        // Search
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                  ->orWhere('events.title', 'like', "%{$search}%");
            });
        }

        // Filter by Event
        if ($eventId = $request->input('event_id')) {
            $query->where('event_registrations.event_id', $eventId);
        }

        // Filter by Status
        if ($status = $request->input('status')) {
            $query->where('event_registrations.status', $status);
        }

        // Sorting
        $sort = $request->input('sort', 'registered_at');
        $direction = $request->input('direction', 'desc');

        // Safe sort column mapping
        $allowedSorts = [
            'user_name' => 'users.name',
            'event_title' => 'events.title',
            'registered_at' => 'event_registrations.registered_at',
            'status' => 'event_registrations.status'
        ];

        if (array_key_exists($sort, $allowedSorts)) {
            $query->orderBy($allowedSorts[$sort], $direction);
        } else {
            $query->orderBy('event_registrations.created_at', 'desc');
        }

        $recentRegistrations = $query->paginate(10)->withQueryString();

        // Get list of events for filter dropdown
        $allEvents = DB::table('events')->select('id', 'title')->orderBy('title', 'asc')->get();

        return view('admin.registrations.index', compact('recentRegistrations', 'allEvents'));
    }

    /**
     * Remove the specified registration from database (Admin action).
     */
    public function destroy(int $id): RedirectResponse
    {
        $deleted = DB::table('event_registrations')->where('id', $id)->delete();

        if ($deleted) {
            return redirect()->back()->with('success', 'Pendaftaran acara berhasil dihapus! 🗑️');
        }

        return redirect()->back()->with('error', 'Gagal menghapus pendaftaran acara.');
    }

    /**
     * Store a newly created event registration in database.
     */
    public function store(Request $request, Event $event): RedirectResponse
    {
        $userId = $request->user()->id;

        // Check if already registered
        $exists = DB::table('event_registrations')
            ->where('user_id', $userId)
            ->where('event_id', $event->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Anda sudah terdaftar untuk mengikuti acara ini! 😊');
        }

        // Insert using Query Builder
        DB::table('event_registrations')->insert([
            'user_id' => $userId,
            'event_id' => $event->id,
            'status' => 'registered',
            'registered_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Send Email confirmation
        try {
            $user = $request->user();
            Mail::to($user->email)->send(
                new EventRegisteredMail(
                    $user->name,
                    $event->title,
                    $event->event_date
                )
            );
        } catch (\Exception $e) {
            Log::error('Event Registration Email Failed: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Pendaftaran Anda berhasil! Sampai jumpa di acara! 🎉');
    }
}
