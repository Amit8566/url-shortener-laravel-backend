<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invite Team Member</title>
</head>
<body>

    <table width="100%" border="1" cellpadding="8">
        <tr>
            <td><strong>&gt;URL&lt;</strong> &nbsp; Dashboard</td>
            <td align="right">
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit">Logout &rarr;</button>
                </form>
            </td>
        </tr>
    </table>

    <hr>

    <h2>Invite New Team Member</h2>
    <p><a href="{{ route('admin.dashboard') }}">&larr; Back to Dashboard</a></p>

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('admin.invite.store') }}">
        @csrf

        <table border="1" cellpadding="12">
            <tr>
                <td>
                    <label for="email">Email</label><br>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}" placeholder="ex. sample@example.com" required>
                </td>
                <td>
                    <label for="role">Role</label><br>
                    <select id="role" name="role" required>
                        <option value="member" @selected(old('role') === 'member')>Member</option>
                        <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit">Create Invitation</button>
                </td>
            </tr>
        </table>
    </form>

</body>
</html>