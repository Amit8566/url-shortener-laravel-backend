<form method="POST" action="{{ route('superadmin.invite-client.store') }}">
    @csrf

    <table border="1" cellpadding="12">
        <tr>
            <td colspan="2">
                <label for="company_id">Existing Company</label><br>
                <select id="company_id" name="company_id">
                    <option value="">-- Select existing company --</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" @selected(old('company_id') == $company->id)>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
                <br><small>OR create a new one below</small>
            </td>
        </tr>
        <tr>
            <td>
                <label for="company_name">New Company Name</label><br>
                <input type="text" id="company_name" name="company_name"
                       value="{{ old('company_name') }}" placeholder="Client Name....">
            </td>
            <td>
                <label for="email">Admin Email</label><br>
                <input type="email" id="email" name="email"
                       value="{{ old('email') }}" placeholder="ex. sample@example.com" required>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="submit">Send Invitation</button>
            </td>
        </tr>
    </table>
</form>