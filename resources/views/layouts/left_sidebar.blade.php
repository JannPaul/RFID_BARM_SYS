<div class="nk-sidebar">
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label">{{Session::get('session_user_type')}} - {{Session::get('session_name')}}</li>
            <li>
                <a href="{{ route('index') }}" aria-expanded="false">
                    <i class="fa fa-tachometer menu-icon"></i><span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-label">Apps</li>
            <li class="mega-menu mega-menu-sm">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="fas fa-boxes menu-icon"></i><span class="nav-text">Time In/Check Out</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('students.monitoring') }}">Student</a></li>
                    <li><a href="{{ route('personnel.monitoring') }}">Personnel</a></li>
                </ul>
            </li>
            <li class="mega-menu mega-menu-sm">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-tags menu-icon"></i><span class="nav-text">Books Borrowed/Reserved</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('book') }}">Books</a></li>
                    <li><a href="{{ route('bookborrow') }}">Books Borrowed/Books Returned</a></li>
                    <li><a href="{{ route('reserve.monitoring') }}">Books Reserved</a></li>
                </ul>
            </li>
            <li class="mega-menu mega-menu-sm">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-group menu-icon"></i><span class="nav-text">User Management</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('user.management') }}">Staff</a></li>
                    <li><a href="{{ route('studentpersonnel.management') }}">Student/Personnel</a></li>
                </ul>
            </li>
            @if(strtolower(session('session_user_type')) == 'admin')
            <li class="mega-menu mega-menu-sm">
                <a class="has-arrow"  aria-expanded="false">
                    <i class="fa fa-user menu-icon"></i><span class="nav-text">Staff</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="">Create Staff</a></li>
                    <li><a href="">Staff List</a></li>
                </ul>
            </li>
            @endif
           
                <li>
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="icon-key"></i>
        <span class="nav-text">Logout</span>
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</li>
        </ul>
    </div>
</div>