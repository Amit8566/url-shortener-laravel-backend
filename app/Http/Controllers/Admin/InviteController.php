<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamInvitationRequest;
use App\Models\Invitation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class InviteController extends Controller
{
    public function create(): View
    {
        return view('admin.invite');
    }

    public function store(StoreTeamInvitationRequest $request): RedirectResponse
    {
        $admin = $request->user();

        // Company is ALWAYS the Admin's own company
        $companyId = $admin->company_id;

        // Replace any older pending invite for the same email in this company
        Invitation::where('company_id', $companyId)
            ->where('email', $request->email)
            ->whereNull('accepted_at')
            ->delete();

        $invitation = Invitation::create([
            'company_id' => $companyId,
            'invited_by' => $admin->id,
            'email'      => $request->email,
            'role'       => $request->role, // validated: admin or member only
            'token'      => Str::random(64),
            'expires_at' => now()->addDays(7),
        ]);

        return redirect()
            ->route('admin.dashboard')
            ->with('status', "Invitation created for {$invitation->email} as " . ucfirst($invitation->role) . '.')
            ->with('invite_link', route('invitations.show', $invitation->token));
    }
}