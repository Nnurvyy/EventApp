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

    public function show(Event $event): View
    {
        $userId = auth()->id();

        // Check registration status using Query Builder
        $registration = DB::table('event_registrations')
            ->where('user_id', $userId)
            ->where('event_id', $event->id)
            ->first();

        // Auto-sync pending payment status with Midtrans (workaround for webhook blocks)
        if ($registration && $registration->status === 'pending') {
            $orderId = 'REG-' . $registration->id . '-' . strtotime($registration->created_at);
            $status = \App\Services\MidtransService::getTransactionStatus($orderId);

            if ($status) {
                if ($status === 'settlement' || $status === 'capture') {
                    // Update status in DB
                    DB::table('event_registrations')->where('id', $registration->id)->update([
                        'status' => 'confirmed',
                        'updated_at' => now(),
                    ]);

                    // Send email
                    try {
                        $user = auth()->user();
                        \Illuminate\Support\Facades\Mail::to($user->email)->send(
                            new \App\Mail\EventRegisteredMail(
                                $user->name,
                                $event->title,
                                \Carbon\Carbon::parse($event->event_date)
                            )
                        );
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error('Event Registration Show Sync Email Failed: ' . $e->getMessage());
                    }

                    // Reload registration state
                    $registration = DB::table('event_registrations')->where('id', $registration->id)->first();
                } elseif (in_array($status, ['deny', 'expire', 'cancel'])) {
                    DB::table('event_registrations')->where('id', $registration->id)->update([
                        'status' => 'cancelled',
                        'updated_at' => now(),
                    ]);
                    // Reload registration state
                    $registration = DB::table('event_registrations')->where('id', $registration->id)->first();
                }
            }
        }

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
