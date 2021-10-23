<header id="mainNav">
    <span id="pageTitle">
        {{-- {{ isset($page_title) ? $page_title : $page }} --}}
    </span>

    <div id="navBarStuff" style="margin-left: 20px;">
        {{-- {{ isset($navBarContent) ? $navBarContent : "" }} --}}
    </div>

    @if (Auth::user())    
        <div id="userMenu">
            <div class="flex-layout center-center">
                <span id="username" class="z-10" style="margin-right:20px">
                    {{ Auth::user()->name }}
                </span>
                <span id="dp" class="z-10">
                    <img src="{{asset('assets/img/default_dp.png')}}" alt="">
                </span>
            </div>

            <div id="details" class="rounded">
                <span class="block mt-2 opacity-0">
                    {{ Auth::user()->name }}
                </span>

                <a class="rounded-btn" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
        
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    @endif
</header>