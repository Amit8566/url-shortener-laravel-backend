<aside class="w-64 min-h-[calc(100vh-64px)] bg-white border-r border-gray-200">

    <div class="p-4">

        <div class="text-xs font-semibold text-gray-400 uppercase mb-3">
            Menu
        </div>

        {{-- Dashboard --}}
        <a
            href="{{ route('dashboard') }}"
            class="block px-4 py-2 rounded hover:bg-gray-100 mb-1">
            Dashboard
        </a>


        {{-- SuperAdmin --}}
        @if(auth()->user()->role === 'SuperAdmin')

            <a
                href="{{ route('superadmin.dashboard') }}"
                class="block px-4 py-2 rounded hover:bg-gray-100 mb-1">
                Dashboard
            </a>

            <a
                href="#"
                class="block px-4 py-2 rounded hover:bg-gray-100 mb-1">
                Companies
            </a>

            <a
                href="#"
                class="block px-4 py-2 rounded hover:bg-gray-100 mb-1">
                Users
            </a>

            <a
                href="#"
                class="block px-4 py-2 rounded hover:bg-gray-100 mb-1">
                Short URLs
            </a>

        @endif


        {{-- Admin --}}
        @if(auth()->user()->role === 'Admin')

            <a
                href="{{ route('admin.dashboard') }}"
                class="block px-4 py-2 rounded hover:bg-gray-100 mb-1">
                Dashboard
            </a>

            <a
                href="#"
                class="block px-4 py-2 rounded hover:bg-gray-100 mb-1">
                Team
            </a>

            <a
                href="#"
                class="block px-4 py-2 rounded hover:bg-gray-100 mb-1">
                Short URLs
            </a>

        @endif


        {{-- Member --}}
        @if(auth()->user()->role === 'Member')

            <a
                href="{{ route('member.dashboard') }}"
                class="block px-4 py-2 rounded hover:bg-gray-100 mb-1">
                Dashboard
            </a>

            <a
                href="#"
                class="block px-4 py-2 rounded hover:bg-gray-100 mb-1">
                My Short URLs
            </a>

        @endif

    </div>

</aside>