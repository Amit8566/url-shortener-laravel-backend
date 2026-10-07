<h2>Generated Short URLs</h2>

<table width="100%" border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th align="left">Short URL</th>
            <th align="left">Long URL</th>
            @if ($showCreator ?? false)
                <th align="left">Created By</th>
            @endif
            <th>Created On</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($shortUrls as $url)
            <tr>
                <td>
                    <a href="{{ url($url->short_code) }}" target="_blank">{{ url($url->short_code) }}</a>
                </td>
                <td>{{ \Illuminate\Support\Str::limit($url->original_url, 50) }}</td>
                @if ($showCreator ?? false)
                    <td>{{ $url->user->name }}</td>
                @endif
                <td align="center">{{ $url->created_at->format("d M 'y") }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="{{ ($showCreator ?? false) ? 4 : 3 }}" align="center">No short URLs yet.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<p>
    Showing {{ $shortUrls->count() }} of total {{ $shortUrls->total() }}
    &nbsp; {{ $shortUrls->links() }}
</p>