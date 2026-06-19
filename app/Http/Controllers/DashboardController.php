<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Redirect the user based on their role.
     */
    public function index(Request $request): RedirectResponse|View
    {
        if ($request->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return $this->user($request);
    }

    /**
     * Show the Admin Dashboard.
     */
    public function admin(): View
    {
        // Fetch Admin stats using Query Builder
        $totalEvents = DB::table('events')->count();
        $totalUsers = DB::table('users')->where('role', 'user')->count();
        $totalRegistrations = DB::table('event_registrations')->count();

        // Fetch 5 recent registrations using Query Builder (no pagination)
        $recentRegistrations = DB::table('event_registrations')
            ->join('users', 'event_registrations.user_id', '=', 'users.id')
            ->join('events', 'event_registrations.event_id', '=', 'events.id')
            ->select(
                'users.name as user_name', 
                'events.title as event_title', 
                'events.event_picture as event_picture',
                'event_registrations.registered_at', 
                'event_registrations.status'
            )
            ->orderBy('event_registrations.created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('totalEvents', 'totalUsers', 'totalRegistrations', 'recentRegistrations'));
    }

    /**
     * Show the User Dashboard.
     */
    public function user(Request $request): View
    {
        $userId = $request->user()->id;

        // Fetch count using Query Builder
        $registeredCount = DB::table('event_registrations')
            ->where('user_id', $userId)
            ->count();

        // Fetch 5 registered events list using Query Builder (no pagination)
        $registeredEvents = DB::table('event_registrations')
            ->join('events', 'event_registrations.event_id', '=', 'events.id')
            ->where('event_registrations.user_id', $userId)
            ->select('events.*', 'event_registrations.registered_at', 'event_registrations.status', 'event_registrations.id as registration_id', 'event_registrations.snap_token')
            ->orderBy('event_registrations.created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact('registeredCount', 'registeredEvents'));
    }
}
