<nav class="flex items-center justify-between flex-wrap bg-yellow-300 px-6 py-6">
    <div class="flex-1">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
    </div>
    <div>
        <!-- Right Side Of Navbar -->
        <ul class="flex">
            <!-- Authentication Links -->
            @guest
                <button class="button-main">
                    <a href="{{ route('login') }}">{{ __('Login') }}</a>
                </button>
                @if (Route::has('register'))
                    <button class="button-less">
                        <a href="{{ route('register') }}">{{ __('Register') }}</a>
                    </button>
                @endif
            @else
                <button class="button-main">
                    <a href="{{ route('appointments.index') }}">My Appointments</a>
                </button>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="button-less">Logout</button>
                </form>
            @endguest
        </ul>
    </div>
</nav>