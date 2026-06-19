<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Display a listing of the resource for regular users.
     */
    public function index(): View
    {
        $events = Event::orderBy('event_date', 'asc')->get();
        return view('events.index', compact('events'));
    }

    /**
     * Display the specified resource for regular users.
     */
    public function show(Event $event): View
    {
        return view('events.show', compact('event'));
    }
}
