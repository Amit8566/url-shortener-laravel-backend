<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\ShortUrl;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        // Member sees ONLY the URLs they created
        $shortUrls = ShortUrl::where('user_id', $user->id)
            ->latest()
            ->paginate(10, ['*'], 'urls_page');

        return view('member.dashboard', [
            'company'   => $user->company,
            'shortUrls' => $shortUrls,
        ]);
    }
}