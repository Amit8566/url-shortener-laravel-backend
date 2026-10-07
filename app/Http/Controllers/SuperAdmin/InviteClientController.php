<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientInvitationRequest;
use App\Mail\InvitationMail;
use App\Models\Company;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InviteClientController extends Controller
{
    public function create(): View
    {
        return view('superadmin.invite-client', [
            'companies' => Company::orderBy('name')->get(),
        ]);
    }

    public function store(StoreClientInvitationRequest $request): RedirectResponse
    {

        $invitation = DB::transaction(function () use ($request) {
            // Use the selected company, or create a new one
            $company = $request->filled('company_id')
                ? Company::findOrFail($request->company_id)
                : Company::create(['name' => $request->company_name]);

            // Replace any older pending invite for the same email + company
            Invitation::where('company_id', $company->id)
                ->where('email', $request->email)
                ->whereNull('accepted_at')
                ->delete();

            return Invitation::create([
                'company_id' => $company->id,
                'invited_by' => $request->user()->id,
                'email'      => $request->email,
                'role'       => "admin",
                'token'      => Str::random(64),
                'expires_at' => now()->addDays(7),
            ]);
        });

       return redirect()
            ->route('superadmin.dashboard')
            ->with('status', "Invitation created for {$invitation->email} ({$invitation->company->name}).")
            ->with('invite_link', route('invitations.show', $invitation->token));
    }
}