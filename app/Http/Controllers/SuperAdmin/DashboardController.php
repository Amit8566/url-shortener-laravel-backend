<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Contracts\View\View;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules\Password;

use Illuminate\Http\Request;
class DashboardController extends Controller
{
    public function index(): View
    {
        // Clients table: company name + number of users
        $companies = Company::withCount('users')
            ->latest()
            ->paginate(10, ['*'], 'companies_page');

        // Step 5: SuperAdmin sees ALL short URLs from every company.
        // Uncomment once the ShortUrl model exists:
        //
        // $shortUrls = \App\Models\ShortUrl::with(['company', 'user'])
        //     ->latest()
        //     ->paginate(10, ['*'], 'urls_page');

        $shortUrls = collect(); // temporary until Step 5

        return view('superadmin.dashboard', compact('companies', 'shortUrls'));
    }

    public function show(string $token): View
    {
        $invitation = $this->findValidInvitation($token);

        return view('invitations.accept', compact('invitation'));
    }

    public function store(Request $request, string $token)
    {
        $invitation = $this->findValidInvitation($token);

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // Email could have been registered after the invite was sent
        abort_if(User::where('email', $invitation->email)->exists(), 422, 'This email is already registered.');

        $user = DB::transaction(function () use ($invitation, $data) {
            $user = User::create([
                'company_id' => $invitation->company_id, // from invitation
                'name'       => $data['name'],
                'email'      => $invitation->email,      // from invitation
                'password'   => $data['password'],       // hashed by model cast
                'role'       => $invitation->role,       // from invitation
            ]);

            $user->forceFill(['email_verified_at' => now()])->save();

            $invitation->update(['accepted_at' => now()]);

            return $user;
        });

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    private function findValidInvitation(string $token): Invitation
    {
        return Invitation::with('company')
            ->where('token', $token)
            ->whereNull('accepted_at')
            ->where('expires_at', '>', now())
            ->firstOrFail();
    }
}