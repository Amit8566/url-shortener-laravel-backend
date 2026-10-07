<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>

    {{-- Header --}}
    <table width="100%" border="1" cellpadding="8">
        <tr>
            <td><strong>&gt;URL&lt;</strong> &nbsp; Dashboard (Admin) - {{ $company?->name }}</td>
            <td align="right">
                {{ auth()->user()->name }} &nbsp;
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit">Logout &rarr;</button>
                </form>
            </td>
        </tr>
    </table>


    @if (session('invite_link'))
        <p>Share this link with the invited user (valid for 7 days):</p>
        <input type="text" value="{{ session('invite_link') }}" size="90" readonly onclick="this.select()">
    @endif

    <hr>

    @include('partials.short-url-form')

    <hr>

    @include('partials.short-url-table', ['showCreator' => true])

    <hr>

    {{-- ============ SECTION 3: TEAM MEMBERS ============ --}}
    <table width="100%">
        <tr>
            <td><h2>Team Members</h2></td>
            <td align="right">
                <a href="{{ route('admin.invite') }}"><button type="button">Invite</button></a>
            </td>
        </tr>
    </table>

    <table width="100%" border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th align="left">Name</th>
                <th align="left">Email</th>
                <th align="left">Role</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($teamMembers as $member)
                <tr>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ ucfirst($member->role) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" align="center">No team members.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p>
        Showing {{ $teamMembers->count() }} of total {{ $teamMembers->total() }}
        &nbsp; {{ $teamMembers->links() }}
    </p>

</body>
</html>