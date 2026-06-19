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
    public function index(): View
    {
        $events = Event::orderBy('event_date', 'asc')->paginate(6);
        return view('events.index', compact('events'));
    }

    /**
     * Display the specified resource for regular users.
     */
    public function show(Event $event): View
    {
        // Check registration status using Query Builder
        $isRegistered = DB::table('event_registrations')
            ->where('user_id', auth()->id())
            ->where('event_id', $event->id)
            ->exists();

        return view('events.show', compact('event', 'isRegistered'));
    }
}
