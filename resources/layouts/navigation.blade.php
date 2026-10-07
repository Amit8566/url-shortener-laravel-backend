<nav class="bg-white border-b border-gray-200">

    <div class="px-6 h-16 flex items-center justify-between">

        <div>
            <span class="text-xl font-bold text-gray-800">
                URL Shortener
            </span>
        </div>

        <div class="flex items-center gap-5">

            <div class="text-sm">
                <span class="font-medium">
                    {{ auth()->user()->name }}
                </span>

                <span class="text-gray-500">
                    ({{ auth()->user()->role }})
                </span>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button
                    type="submit"
                    class="text-sm text-red-600 hover:text-red-800">
                    Logout
                </button>
            </form>

        </div>

    </div>

</nav>