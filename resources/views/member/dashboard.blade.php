<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Member Dashboard</title>
</head>
<body>

    <table width="100%" border="1" cellpadding="8">
        <tr>
            <td><strong>&gt;URL&lt;</strong> &nbsp; Dashboard (Member) - {{ $company?->name }}</td>
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

    @include('partials.short-url-form')

    <hr>

    @include('partials.short-url-table')

</body>
</html>