<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Accept Invitation</title>
</head>
<body>
    <h2>Join {{ $invitation->company->name }}</h2>
    <p>You are invited as <strong>{{ ucfirst($invitation->role) }}</strong> ({{ $invitation->email }}).</p>

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('invitations.store', $invitation->token) }}">
        @csrf

        <p>
            <label>Name</label><br>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </p>
        <p>
            <label>Password</label><br>
            <input type="password" name="password" required>
        </p>
        <p>
            <label>Confirm Password</label><br>
            <input type="password" name="password_confirmation" required>
        </p>

        <button type="submit">Create Account</button>
    </form>
</body>
</html>