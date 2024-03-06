<!-- top navbar-->
<header class="topnavbar-wrapper">
  <!-- START Top Navbar-->
  <nav class="navbar topnavbar">
    <!-- START navbar header-->
    <div class="navbar-header">
      <a class="navbar-brand" href="{{route('admin.dashboard')}}">
        <div class="brand-logo" style="background-color: white;">
          @if(get_settings('logo'))
          <img class="img-fluid" src="{{asset('uploads/'.get_settings('favicon'))}}" alt="App Logo" style="height: 50px;"><br>
          <span style="color:#000;font-size: 12px;">Coaching Space</span>
          @else
          <img class="img-fluid" src="{{asset('assets/admin/img/logo.png')}}" alt="App Logo" style="height: 50px;">
          @endif
        </div>
        <div class="brand-logo-collapsed">
          @if(get_settings('favicon'))
          <img class="img-fluid" src="{{ get_settings('favicon') ? asset('uploads/'.get_settings('favicon')) : asset('favicon.ico') }}" style="height: 40px;" alt="App Logo">
          @else
          <img class="img-fluid" src="{{asset('assets/admin/img/logo-single.png')}}" alt="App Logo" style="height: 40px;">
          @endif
        </div>
      </a>
    </div>
    <!-- END navbar header-->
    <!-- START Left navbar-->
    <ul class="navbar-nav mr-auto flex-row">
      <li class="nav-item">
        <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
        <a class="nav-link d-none d-md-block d-lg-block d-xl-block" href="#" data-trigger-resize="" data-toggle-state="aside-collapsed">
          <em class="fas fa-bars"></em>
        </a>
        <!-- Button to show/hide the sidebar on mobile. Visible on mobile only.-->
        <a class="nav-link sidebar-toggle d-md-none" href="#" data-toggle-state="aside-toggled" data-no-persist="true">
          <em class="fas fa-bars"></em>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('admin.cache-clear')}}" title="Clear Cache">
          <em class="fas fa-sync"></em>
        </a>
      </li>

    </ul>
    <!-- END Left navbar-->
    <!-- START Right Navbar-->
    <ul class="navbar-nav flex-row">

      <li class="nav-item dropdown dropdown-list">
        <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
        <a class="nav-link dropdown-toggle dropdown-toggle-caret" href="#" data-toggle="dropdown">
          <em class="icon-user pr-2"></em>
          <span>
            <?php
            $adminId = 0;
            if( auth()->guard('admin')->check() ){
              $adminId = Auth::guard('admin')->user()->id;
            }
            $user = App\Models\Admin::where('id',$adminId)->first();
            ?>
            @if(isset($user->name))
                {{$user->name}}
            @else
              Admin
            @endif
          </span>
        </a>

        <div class="dropdown-menu dropdown-menu-right animated flipInX" id="user-block">
          <div class="dropdown-item">
            <!-- START list group-->

            <div class="list-group">

              <!-- list item-->

              <a class="nav-link" href="{{route('admin.userSettings')}}" title="Admin Settings">
              <div class="list-group-item list-group-item-action">
                <div class="media">
                  <div class="align-self-start mr-2">
                    <em class="icon-settings"></em>
                  </div>
                  <div class="media-body">
                    <p>Admin Settings</p>
                  </div>
                </div>
              </div>
              </a>

              <a class="nav-link" href="{{route('admin.logout')}}" title="Log Out">
              <div class="list-group-item list-group-item-action">
                <div class="media">
                  <div class="align-self-start mr-2">
                    <em class="icon-logout"></em>
                  </div>
                  <div class="media-body">
                    <p>Log Out</p>
                  </div>
                </div>
              </div>
              </a>

            </div>

          </div>
        </div>

      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{route('admin.logout')}}" title="Log Out">
          <em class="icon-logout"></em>
        </a>
      </li>


    </ul>
    <!-- END Right Navbar-->

  </nav>
  <!-- END Top Navbar-->
</header>
