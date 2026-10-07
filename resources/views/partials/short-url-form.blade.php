<h2>Generate Short URL</h2>

@if (session('status'))
    <p style="color: green;">{{ session('status') }}</p>
@endif

@if (session('short_link'))
    <p>
        Your short link:
        <a href="{{ session('short_link') }}" target="_blank">{{ session('short_link') }}</a>
    </p>
@endif

@if ($errors->has('original_url'))
    <p style="color: red;">{{ $errors->first('original_url') }}</p>
@endif

<form method="POST" action="{{ route('short-urls.store') }}">
    @csrf
    <label for="original_url">Long URL</label><br>
    <input type="text" id="original_url" name="original_url" size="80"
           value="{{ old('original_url') }}"
           placeholder="e.g. https://example.com/some-long-url" required>
    <br><br>
    <button type="submit">Generate</button>
</form>