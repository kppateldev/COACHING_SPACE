<!-- sidebar-->
<aside class="aside-container">
  <!-- START Sidebar (left)-->
  <div class="aside-inner">

    <nav class="sidebar" data-sidebar-anyclick-close="">
      <!-- START sidebar nav-->
      <ul class="sidebar-nav">

        <!-- Iterates over all sidebar items-->
        <li class="nav-heading ">
          <span>Main Navigation</span>
        </li>
        <?php 
        $adminId = 0;
        if( auth()->guard('admin')->check() ){
          $user_type = Auth::guard('admin')->user()->user_type;
        }
        ?>
        @if(isset($user_type) && $user_type == '1')
        <li class="{{ Request::is('admin','admin/coach/full-calender') ? 'active' : '' }}">
          <a href="{{route('admin.dashboard')}}" title="Dashboard">
            <em class="icon-speedometer"></em>
            <span>Dashboard</span>
          </a>
        </li>

        <li class="{{ Request::is('admin/organizations','admin/organizations/create','admin/organizations/edit/*','admin/organizations/users-list/*') ? 'active' : '' }}">
          <a href="{{route('admin.organizations')}}" title="Organisations">
            <em class="icon-organization"></em>
            <span>Organisations</span>
          </a>
        </li>

        <li class="{{ Request::is('admin/users','admin/users/create','admin/users/edit/*','admin/users/create-bulk-user') ? 'active' : '' }}">
          <a href="{{route('admin.users')}}" title="Users">
            <em class="icon-people"></em>
            <span>Users</span>
          </a>
        </li>

        <li class="{{ Request::is('admin/coach','admin/coach/create','admin/coach/edit/*','admin/coach/get_calender/*') ? 'active' : '' }}">
          <a href="{{route('admin.coach')}}" title="Coach">
            <em class="icon-people"></em>
            <span>Coaches</span>
          </a>
        </li>

        <li class="{{ Request::is('admin/sessions') ? 'active' : '' }}">
          <a href="{{route('admin.sessions')}}" title="Sessions">
            <em class="icon-book-open"></em>
            <span>Sessions</span>
          </a>
        </li>

        <li class=" ">
          <a href="#email_template" title="Email Template" data-toggle="collapse">
            <em class="icon-book-open"></em>
            <span>Email Template</span>
          </a>
          <ul class="sidebar-nav sidebar-subnav collapse" id="email_template">
            <li class="sidebar-subnav-header">Email Template</li>
            <li class="{{ Request::is('admin/email_header_template','admin/email_header_template/add','admin/email_header_template/edit/*') ? 'active' : '' }}">
              <a href="{{route('admin.email_header_template')}}" title="Email Header Template">
                <em class="fas fa-angle-double-right"></em>
                <span>Email Header Template</span>
              </a>
            </li>
            <li class="{{ Request::is('admin/email_footer_template','admin/email_footer_template/add','admin/email_footer_template/edit/*') ? 'active' : '' }}">
              <a href="{{route('admin.email_footer_template')}}" title="Email Footer Template">
                <em class="fas fa-angle-double-right"></em>
                <span>Email Footer Template</span>
              </a>
            </li>
            <li class="{{ Request::is('admin/email_templates','admin/email_templates/add','admin/email_templates/edit/*') ? 'active' : '' }}">
              <a href="{{route('admin.email_templates')}}" title="Email Template">
                <em class="fas fa-angle-double-right"></em>
                <span>Email Body Template</span>
              </a>
            </li>
          </ul>
        </li>

        {{--<li class="{{ Request::is('admin/reviews') ? 'active' : '' }}">
          <a href="{{route('admin.reviews')}}" title="Reviews">
            <em class="icon-pencil"></em>
            <span>Reviews</span>
          </a>
        </li>--}}

        <li class=" ">
          <a href="#coaching_levels" title="coaching_levels" data-toggle="collapse">
            <em class="icon-list"></em>
            <span>Coaching Levels</span>
          </a>
          <ul class="sidebar-nav sidebar-subnav collapse" id="coaching_levels">
            <li class="sidebar-subnav-header">Coaching Levels</li>
            <li class="{{ Request::is('admin/coaching_levels/create') ? 'active' : '' }}">
              <a href="{{route('admin.coaching_levels.create')}}" title="Add coaching_levels">
                <em class="fas fa-angle-double-right"></em>
                <span>Add New</span>
              </a>
            </li>
            <li class="{{ Request::is('admin/coaching_levels','admin/coaching_levels/edit/*') ? 'active' : '' }}">
              <a href="{{route('admin.coaching_levels')}}" title="All coaching_levels">
                <em class="fas fa-angle-double-right"></em>
                <span>All Coaching Levels</span>
              </a>
            </li>
          </ul>
        </li>

        <li class=" ">
          <a href="#strengths" title="strengths" data-toggle="collapse">
            <em class="icon-list"></em>
            <span>Strengths</span>
          </a>
          <ul class="sidebar-nav sidebar-subnav collapse" id="strengths">
            <li class="sidebar-subnav-header">Strengths</li>
            <li class="{{ Request::is('admin/strengths/create') ? 'active' : '' }}">
              <a href="{{route('admin.strengths.create')}}" title="Add strengths">
                <em class="fas fa-angle-double-right"></em>
                <span>Add New</span>
              </a>
            </li>
            <li class="{{ Request::is('admin/strengths','admin/strengths/edit/*') ? 'active' : '' }}">
              <a href="{{route('admin.strengths')}}" title="All strengths">
                <em class="fas fa-angle-double-right"></em>
                <span>All Strengths</span>
              </a>
            </li>
          </ul>
        </li>

        <li class=" ">
          <a href="#departments" title="departments" data-toggle="collapse">
            <em class="icon-list"></em>
            <span>Departments</span>
          </a>
          <ul class="sidebar-nav sidebar-subnav collapse" id="departments">
            <li class="sidebar-subnav-header">Departments</li>
            <li class="{{ Request::is('admin/departments','admin/departments/edit/*') ? 'active' : '' }}">
              <a href="{{route('admin.departments')}}" title="All Departments">
                <em class="fas fa-angle-double-right"></em>
                <span>All Departments</span>
              </a>
            </li>
            <li class="{{ Request::is('admin/departments/create') ? 'active' : '' }}">
              <a href="{{route('admin.departments.create')}}" title="Add departments">
                <em class="fas fa-angle-double-right"></em>
                <span>Add New</span>
              </a>
            </li>
          </ul>
        </li>

        <li class="{{ Request::is('admin/site-settings') ? 'active' : '' }}">
          <a href="{{route('admin.site-settings')}}" title="Site Settings">
            <em class="icon-grid"></em>
            <span>Site Settings</span>
          </a>
        </li>

        <li class="">
          <a href="{{route('admin.logout')}}" title="Log Out">
            <em class="icon-logout"></em>
            <span>Log Out</span>
          </a>
        </li>
        @elseif(isset($user_type) && $user_type == '2')
        <li class="{{ Request::is('admin') ? 'active' : '' }}">
          <a href="{{route('admin.dashboard')}}" title="Dashboard">
            <em class="icon-speedometer"></em>
            <span>Dashboard</span>
          </a>
        </li>
        
        <li class="{{ Request::is('admin/coach','admin/coach/edit/*','admin/coach/get_calender/*') ? 'active' : '' }}">
          <a href="{{route('admin.coach')}}" title="Coach">
            <em class="icon-user"></em>
            <span>Coach</span>
          </a>
        </li>

         <li class="{{ Request::is('admin/sessions') ? 'active' : '' }}">
          <a href="{{route('admin.sessions')}}" title="Sessions">
            <em class="icon-book-open"></em>
            <span>Sessions</span>
          </a>
        </li>


        <li class="">
          <a href="{{route('admin.logout')}}" title="Log Out">
            <em class="icon-logout"></em>
            <span>Log Out</span>
          </a>
        </li>
        @endif

        {{--<li class=" ">
          <a href="#facilities" title="Facilities" data-toggle="collapse">
            <em class="icon-list"></em>
            <span>Facilities</span>
          </a>
          <ul class="sidebar-nav sidebar-subnav collapse" id="facilities">
            <li class="sidebar-subnav-header">Facilities</li>
            <li class="{{ Request::is('admin/facilities/create') ? 'active' : '' }}">
              <a href="{{route('admin.facilities.create')}}" title="Add Facilities">
                <em class="fas fa-angle-double-right"></em>
                <span>Add Facilities</span>
              </a>
            </li>
            <li class="{{ Request::is('admin/facilities','admin/facilities/edit/*') ? 'active' : '' }}">
              <a href="{{route('admin.facilities')}}" title="All Facilities">
                <em class="fas fa-angle-double-right"></em>
                <span>All Facilities</span>
              </a>
            </li>
          </ul>
        </li>--}}

        {{-- <li class=" ">
          <a href="#categories" title="Categories" data-toggle="collapse">
            <em class="icon-list"></em>
            <span>Categories</span>
          </a>
          <ul class="sidebar-nav sidebar-subnav collapse" id="categories">
            <li class="sidebar-subnav-header">Categories</li>
            <li class="{{ Request::is('admin/categories/create') ? 'active' : '' }}">
              <a href="{{route('admin.categories.create')}}" title="Add Categories">
                <em class="fas fa-angle-double-right"></em>
                <span>Add Categories</span>
              </a>
            </li>
            <li class="{{ Request::is('admin/categories','admin/categories/edit/*') ? 'active' : '' }}">
              <a href="{{route('admin.categories')}}" title="All Categories">
                <em class="fas fa-angle-double-right"></em>
                <span>All Categories</span>
              </a>
            </li>
          </ul>
        </li> --}}

        {{--<li class=" ">
          <a href="#page" title="Pages" data-toggle="collapse">
            <em class="icon-docs"></em>
            <span>CMS Pages</span>
          </a>
          <ul class="sidebar-nav sidebar-subnav collapse" id="page">
            <li class="sidebar-subnav-header">Pages</li>
            <li class="{{ Request::is('admin/pages/create') ? 'active' : '' }}">
              <a href="{{route('admin.pages.create')}}" title="Add Page">
                <em class="fas fa-angle-double-right"></em>
                <span>Add Page</span>
              </a>
            </li>
            <li class="{{ Request::is('admin/pages','admin/pages/edit/*') ? 'active' : '' }}">
              <a href="{{route('admin.pages')}}" title="All Pages">
                <em class="fas fa-angle-double-right"></em>
                <span>All Pages</span>
              </a>
            </li>
          </ul>
        </li>--}}

      </ul>
      <!-- END sidebar nav-->
    </nav>
  </div>
  <!-- END Sidebar (left)-->
</aside>
