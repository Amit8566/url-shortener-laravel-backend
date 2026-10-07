<p>Hello,</p>

<p>
    You have been invited to join <strong>{{ $invitation->company->name }}</strong>
    as <strong>{{ ucfirst($invitation->role) }}</strong>.
</p>

<p>
    <a href="{{ route('invitations.show', $invitation->token) }}">Accept invitation</a>
</p>

<p>
    Or copy this link into your browser:<br>
    {{ route('invitations.show', $invitation->token) }}
</p>

<p>This link expires on {{ $invitation->expires_at->format('d M Y') }}.</p>