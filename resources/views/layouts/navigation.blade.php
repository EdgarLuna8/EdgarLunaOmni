<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
    
        <div class="collapse navbar-collapse justify-content-between m-2" id="navbarNav">
            <!-- Navigation Links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 text-gray-200" style="height: 110%" />
                    </a>
                </li>
            </ul>

            <!-- Settings Dropdown -->
            <ul class="navbar-nav mr-4">
                <li class="nav-item dropdown mr-4">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu mr-4" aria-labelledby="navbarDropdown">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

</nav>
