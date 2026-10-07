<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Member Dashboard</title>
</head>
<body>

    {{-- Header --}}
    <table width="100%" border="1" cellpadding="8">
        <tr>
            <td><strong>&gt;URL&lt;</strong> &nbsp; Dashboard (Member) - {{ auth()->user()->company?->name }}</td>
            <td align="right">
                {{ auth()->user()->name }} &nbsp;
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit">Logout &rarr;</button>
                </form>
            </td>
        </tr>
    </table>

    <hr>

    {{-- Step 4: Generate Short URL form --}}
    <h2>Generate Short URL</h2>
    <p><small>Coming in Step 4.</small></p>

    <hr>

    {{-- Step 5: Member's own URLs --}}
    <h2>Generated Short URLs</h2>
    <p><small>Coming in Step 5. It will list only the URLs you created.</small></p>

</body>
</html>