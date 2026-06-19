<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

        return $this->user();
    }

    /**
     * Show the Admin Dashboard.
     */
    public function admin(): View
    {
        return view('admin.dashboard');
    }

    /**
     * Show the User Dashboard.
     */
    public function user(): View
    {
        return view('dashboard');
    }
}
