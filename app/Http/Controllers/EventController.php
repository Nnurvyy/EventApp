<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Display a listing of the resource for regular users.
     */
    public function index(Request $request): View
    {
        $query = Event::query();

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $events = $query->orderBy('event_date', 'asc')->paginate(6)->withQueryString();
        return view('events.index', compact('events'));
    }

    /**
     * Display the specified resource for regular users.
     */
    public function show(Event $event): View
    {
        // Check registration status using Query Builder
        $registration = DB::table('event_registrations')
            ->where('user_id', auth()->id())
            ->where('event_id', $event->id)
            ->first();

        $isRegistered = false;
        $pendingRegistration = null;

        if ($registration) {
            if (in_array($registration->status, ['registered', 'confirmed'])) {
                $isRegistered = true;
            } elseif ($registration->status === 'pending') {
                $pendingRegistration = $registration;
            }
        }

        return view('events.show', compact('event', 'isRegistered', 'pendingRegistration'));
    }
}
