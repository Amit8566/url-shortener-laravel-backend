<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Super Admin Dashboard</title>
</head>
<body>


    {{-- Header --}}
    <table width="100%" border="1" cellpadding="8">
        <tr>
            <td><strong>&gt;URL&lt;</strong> &nbsp; Dashboard (Super Admin)</td>
            <td align="right">
                {{ auth()->user()->name }} &nbsp;
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit">Logout &rarr;</button>
                </form>
            </td>
        </tr>
    </table>

   @if (session('status'))
    <p style="color: green;">{{ session('status') }}</p>
@endif

@if (session('invite_link'))
    <p>Share this link with the new Admin (valid for 7 days):</p>
    <input type="text" value="{{ session('invite_link') }}" size="90" readonly onclick="this.select()">
@endif

    <hr>

    {{-- ============ SECTION 1: CLIENTS ============ --}}
    <table width="100%">
        <tr>
            <td><h2>Clients</h2></td>
            <td align="right">
                <a href="{{ route('superadmin.invite-client') }}">
                    <button type="button">Invite</button>
                </a>
            </td>
        </tr>
    </table>

    <table width="100%" border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th align="left">Client Name</th>
                <th>Users</th>
                <th>Total Generated URLs</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($companies as $company)
                <tr>
                    <td>{{ $company->name }}</td>
                    <td align="center">{{ $company->users_count }}</td>
                    {{-- Step 3: replace with withCount('shortUrls') -> $company->short_urls_count --}}
                    <td align="center">-</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" align="center">No clients yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p>
        Showing {{ $companies->count() }} of total {{ $companies->total() }}
        &nbsp; {{ $companies->links() }}
    </p>

    <hr>

    {{-- ============ SECTION 2: ALL SHORT URLS ============ --}}
    <h2>Generated Short URLs</h2>
    <p><small>Read only. Super Admin cannot create short URLs.</small></p>

    <table width="100%" border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th align="left">Short URL</th>
                <th align="left">Long URL</th>
                <th align="left">Company</th>
                <th align="left">Created By</th>
                <th>Created On</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($shortUrls as $url)
                <tr>
                    <td>
                        <a href="{{ url($url->short_code) }}" target="_blank">
                            {{ url($url->short_code) }}
                        </a>
                    </td>
                    <td>{{ \Illuminate\Support\Str::limit($url->original_url, 40) }}</td>
                    <td>{{ $url->company->name }}</td>
                    <td>{{ $url->user->name }}</td>
                    <td align="center">{{ $url->created_at->format('d M \'y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" align="center">No short URLs yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if ($shortUrls instanceof \Illuminate\Contracts\Pagination\Paginator)
        <p>
            Showing {{ $shortUrls->count() }} of total {{ $shortUrls->total() }}
            &nbsp; {{ $shortUrls->links() }}
        </p>
    @endif

</body>
</html>