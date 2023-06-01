@if ( Auth::user()->role == 'admin' )
<nav class="side-nav">
    <a href="" class="-intro-x flex items-center pt-5">
    <h2 class="text-white">The CheckIn</h2>
    </a>
    <div class="side-nav__devider my-6"></div>
    <ul>
        <li>
            <a href="{{ url('/') }}" class="side-menu side-menu{{ request()->is('admin') ? '--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="home"></i> </div>
                <div class="side-menu__title">
                    Groups
                </div>
            </a>

        </li>

        <li>
            <a href="{{ route('developers') }}" class="side-menu side-menu{{ request()->is('admin/developers*') ? '--active' : '' }}">
                <div class="side-menu__icon"> <i data-feather="users"></i> </div>
                <div class="side-menu__title"> Friends </div>
            </a>
        </li>

       <li class="side-nav__devider my-6"></li>

    </ul>
</nav>
@endif