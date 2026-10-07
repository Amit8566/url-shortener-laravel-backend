<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShortUrlRequest;
use App\Models\ShortUrl;
use Illuminate\Http\RedirectResponse;

class ShortUrlController extends Controller
{
    // Admin + Member only (enforced by route middleware)
    public function store(StoreShortUrlRequest $request): RedirectResponse
    {
        $user = $request->user();

        $shortUrl = ShortUrl::create([
            'company_id'   => $user->company_id,   // from the logged-in user
            'user_id'      => $user->id,
            'original_url' => $request->original_url,
            'short_code'   => ShortUrl::generateUniqueCode(),
        ]);

        return redirect()
            ->route('dashboard')   // role-based redirect back to own dashboard
            ->with('status', 'Short URL created.')
            ->with('short_link', url($shortUrl->short_code));
    }

    // Public, no authentication
    public function redirect(string $shortCode): RedirectResponse
    {
        $shortUrl = ShortUrl::where('short_code', $shortCode)->firstOrFail();

        return redirect()->away($shortUrl->original_url);
    }
}