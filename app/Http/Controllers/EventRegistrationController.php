<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventRegistrationController extends Controller
{
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

        return redirect()->back()->with('success', 'Pendaftaran Anda berhasil! Sampai jumpa di acara! 🎉');
    }
}
