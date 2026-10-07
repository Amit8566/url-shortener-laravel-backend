<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class AcceptInvitationController extends Controller
{
    // Show the "set name + password" form
    public function show(string $token): View
    {
        $invitation = $this->findValidInvitation($token);

        return view('invitations.accept', compact('invitation'));
    }

    // Create the user from the invitation
    public function store(Request $request, string $token): RedirectResponse
    {
        $invitation = $this->findValidInvitation($token);

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // The email may have been registered after the invite was created
        if (User::where('email', $invitation->email)->exists()) {
            return back()->withErrors(['name' => 'This email is already registered.']);
        }

        $user = DB::transaction(function () use ($invitation, $data) {
            $user = User::create([
                'company_id' => $invitation->company_id, // from invitation
                'name'       => $data['name'],
                'email'      => $invitation->email,      // from invitation
                'password'   => $data['password'],       // hashed by the model cast
                'role'       => $invitation->role,       // from invitation
            ]);

            // No email flow, so mark the user as verified (needed by the 'verified' middleware)
            $user->forceFill(['email_verified_at' => now()])->save();

            // One-time use
            $invitation->update(['accepted_at' => now()]);

            return $user;
        });

        Auth::login($user);

        return redirect()->route('dashboard'); // role-based redirect
    }

    // Token must exist, be unused and not expired, otherwise 404
    private function findValidInvitation(string $token): Invitation
    {
        return Invitation::with('company')
            ->where('token', $token)
            ->whereNull('accepted_at')
            ->where('expires_at', '>', now())
            ->firstOrFail();
    }
}