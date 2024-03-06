<section id="sidebar" class="sidebar-main">
  <div class="side-logo text-center mb-3"><a href="#"><img src="{{ url('front_assets/images/logo_final.png') }}"></a></div>
  <div class="sidebar-inner mt-5">
    <ul>
      <li class="nav-list {{ Request::is('dashboard','coach-profile/*') ? 'active' : '' }}">
        <a href="{{ url('dashboard') }}">
          <span class="li-icon"><i class="icon-dashboard"></i></span>
          <span class="li-text">Dashboard</span>
        </a>
      </li>
      <li class="nav-list {{ Request::is('my-sessions','my-sessions-details/*') ? 'active' : '' }}">
        <a href="{{ url('my-sessions') }}">
          <span class="li-icon"><i class="fa-regular fa-user fw-normal"></i></span>
          <span class="li-text">My Sessions</span>
        </a>
      </li>
      <li class="nav-list {{ Request::is('myprofile','user-change-password') ? 'active' : '' }}">
        <div class="dropdown">
          <a class="btn border-0" href="#" role="button" id="dropdownsubmenu" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="li-icon"><i class="fa-regular fa-user fw-normal"></i></span>
            <span class="li-text">My Account</span>
          </a>

          <ul class="dropdown-menu {{ Request::is('myprofile','user-change-password') ? 'show' : '' }}" aria-labelledby="dropdownsubmenu">
            <li class="{{ Request::is('myprofile') ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('myprofile') }}"><span class="submenu-icon d-lg-none"><i class="fa-solid fa-id-badge"></i></span> <span class="d-lg-inline-block d-none">My Profile</span></a></li>
            <li class="{{ Request::is('user-change-password') ? 'active' : '' }}"><a class="dropdown-item" href="{{ url('user-change-password') }}"><span class="submenu-icon d-lg-none"><i class="fa-solid fa-key"></i></span> <span class="d-lg-inline-block d-none">Change Password</span></a></li>
          </ul>
        </div>
      </li>
       <li class="nav-list">
        <a href="https://coachingspace.co.uk/faq.html" target="_blank">
          <span class="li-icon"><i class="icon-question-regular-icon"></i></span>
          <span class="li-text">FAQs</span>
        </a>
      </li>
      <li class="nav-list">
        <a href="https://coachingspace.co.uk/support.html" target="_blank">
          <span class="li-icon"><i class="icon-headset"></i></span>
          <span class="li-text">Support</span>
        </a>
      </li>
      <li class="nav-list">
        <a href="{{ url('logout') }}">
          <span class="li-icon"><i class="icon-logout-icon"></i></span>
          <span class="li-text">Logout</span>
        </a>
      </li>
    </ul>
  </div>
</section>