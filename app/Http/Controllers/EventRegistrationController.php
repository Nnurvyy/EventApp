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
    /**
     * Display a listing of the user's registered events (10 per page).
     */
    public function index(Request $request): \Illuminate\View\View
    {
        $userId = $request->user()->id;

        $query = DB::table('event_registrations')
            ->join('events', 'event_registrations.event_id', '=', 'events.id')
            ->where('event_registrations.user_id', $userId)
            ->select('events.*', 'event_registrations.registered_at', 'event_registrations.status', 'event_registrations.id as registration_id', 'event_registrations.snap_token');

        // Search
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('events.title', 'like', "%{$search}%")
                  ->orWhere('event_registrations.status', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sort = $request->input('sort', 'registered_at');
        $direction = $request->input('direction', 'desc');

        // Safe sort column mapping
        $allowedSorts = [
            'event_title' => 'events.title',
            'price' => 'events.price',
            'event_date' => 'events.event_date',
            'registered_at' => 'event_registrations.registered_at',
            'status' => 'event_registrations.status'
        ];

        if (array_key_exists($sort, $allowedSorts)) {
            $query->orderBy($allowedSorts[$sort], $direction);
        } else {
            $query->orderBy('event_registrations.created_at', 'desc');
        }

        $registeredEvents = $query->paginate(10)->withQueryString();

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
                'events.price as event_price',
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
            'event_price' => 'events.price',
            'registered_at' => 'event_registrations.registered_at',
            'status' => 'event_registrations.status'
        ];

        if (array_key_exists($sort, $allowedSorts)) {
            $query->orderBy($allowedSorts[$sort], $direction);
        } else {
            $query->orderBy('event_registrations.created_at', 'desc');
        }

        $recentRegistrations = $query->paginate(10)->withQueryString();

        // Calculate Grand Total Pemasukan from active/confirmed registrations
        $totalRevenue = DB::table('event_registrations')
            ->join('events', 'event_registrations.event_id', '=', 'events.id')
            ->whereIn('event_registrations.status', ['confirmed', 'registered'])
            ->sum('events.price');

        // Get list of events for filter dropdown
        $allEvents = DB::table('events')->select('id', 'title')->orderBy('title', 'asc')->get();

        return view('admin.registrations.index', compact('recentRegistrations', 'allEvents', 'totalRevenue'));
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
        $user = $request->user();
        $userId = $user->id;

        // Check if registration already exists
        $existing = DB::table('event_registrations')
            ->where('user_id', $userId)
            ->where('event_id', $event->id)
            ->first();

        if ($existing) {
            if ($existing->status === 'confirmed' || $existing->status === 'registered') {
                return redirect()->back()->with('error', 'Anda sudah terdaftar untuk mengikuti acara ini! 😊');
            }
            
            // If it is pending payment, we can reuse the snap token or regenerate if missing
            if ($existing->status === 'pending') {
                $snapToken = $existing->snap_token;
                if (!$snapToken) {
                    try {
                        $snapToken = \App\Services\MidtransService::getSnapToken($existing->id, $event->price, $user, $event->title);
                        DB::table('event_registrations')->where('id', $existing->id)->update([
                            'snap_token' => $snapToken,
                            'updated_at' => now(),
                        ]);
                    } catch (\Exception $e) {
                        return redirect()->back()->with('error', $e->getMessage());
                    }
                }
                return redirect()->back()
                    ->with('success', 'Silakan selesaikan pembayaran Anda! 💳')
                    ->with('payment_snap_token', $snapToken);
            }
        }

        // Handle paid event
        if ($event->price > 0) {
            // Insert with pending status using Query Builder
            $registrationId = DB::table('event_registrations')->insertGetId([
                'user_id' => $userId,
                'event_id' => $event->id,
                'status' => 'pending',
                'snap_token' => null,
                'registered_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            try {
                $snapToken = \App\Services\MidtransService::getSnapToken($registrationId, $event->price, $user, $event->title);
                DB::table('event_registrations')->where('id', $registrationId)->update([
                    'snap_token' => $snapToken,
                    'updated_at' => now(),
                ]);
            } catch (\Exception $e) {
                // Clean up registration on fail
                DB::table('event_registrations')->where('id', $registrationId)->delete();
                return redirect()->back()->with('error', $e->getMessage());
            }

            return redirect()->back()
                ->with('success', 'Pendaftaran berhasil dibuat! Menunggu pembayaran... 💳')
                ->with('payment_snap_token', $snapToken);
        }

        // Handle free event
        DB::table('event_registrations')->insert([
            'user_id' => $userId,
            'event_id' => $event->id,
            'status' => 'registered',
            'snap_token' => null,
            'registered_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Send Email confirmation
        try {
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

    /**
     * Handle webhook notification from Midtrans.
     */
    public function callback(Request $request): \Illuminate\Http\JsonResponse
    {
        $serverKey = config('services.midtrans.server_key');
        
        $json = $request->json()->all();
        
        $orderIdInput = $json['order_id'] ?? '';
        $statusCode = $json['status_code'] ?? '';
        $grossAmount = $json['gross_amount'] ?? '';
        $signatureKey = $json['signature_key'] ?? '';
        $transactionStatus = $json['transaction_status'] ?? '';

        // Verify signature to prevent fraud
        $localSignature = hash("sha512", $orderIdInput . $statusCode . $grossAmount . $serverKey);

        if ($localSignature !== $signatureKey) {
            Log::warning('Midtrans Callback Signature Mismatch: Local ' . $localSignature . ' vs Remote ' . $signatureKey);
            return response()->json(['message' => 'Invalid signature key'], 400);
        }

        // Parse registration ID from order_id: REG-{id}-{time}
        if (preg_match('/^REG-(\d+)/', $orderIdInput, $matches)) {
            $registrationId = (int)$matches[1];
        } else {
            return response()->json(['message' => 'Invalid Order ID format'], 400);
        }

        // Fetch registration and event/user details
        $registration = DB::table('event_registrations')->where('id', $registrationId)->first();
        if (!$registration) {
            return response()->json(['message' => 'Registration not found'], 404);
        }

        $event = DB::table('events')->where('id', $registration->event_id)->first();
        $user = DB::table('users')->where('id', $registration->user_id)->first();

        // Update status based on transaction status
        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            // Paid successfully
            DB::table('event_registrations')->where('id', $registrationId)->update([
                'status' => 'confirmed',
                'updated_at' => now(),
            ]);

            // Send Confirmation Email
            if ($user && $event) {
                try {
                    Mail::to($user->email)->send(
                        new EventRegisteredMail(
                            $user->name,
                            $event->title,
                            \Carbon\Carbon::parse($event->event_date)
                        )
                    );
                } catch (\Exception $e) {
                    Log::error('Event Registration Callback Email Failed: ' . $e->getMessage());
                }
            }
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            // Cancelled or expired payment
            DB::table('event_registrations')->where('id', $registrationId)->update([
                'status' => 'cancelled',
                'updated_at' => now(),
            ]);
        }

        return response()->json(['message' => 'Callback processed successfully']);
    }
}
