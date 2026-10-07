<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ShortUrl;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        // Company comes from the logged-in user, never from the request
        $teamMembers = User::where('company_id', $user->company_id)
            ->orderBy('name')
            ->paginate(10, ['*'], 'team_page');

            // Admin sees every URL of their OWN company only
            $shortUrls = ShortUrl::with('user')
                ->where('company_id', $user->company_id)
                ->latest()
                ->paginate(10, ['*'], 'urls_page');

            return view('admin.dashboard', [
                'company'     => $user->company,
                'teamMembers' => $teamMembers,
                'shortUrls'   => $shortUrls,
            ]);
    }
}