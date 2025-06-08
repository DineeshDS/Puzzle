<div class="menu">
    <div class="menu-header">
        <a href="{{ url('dashboard') }}" class="menu-header-logo">
            {{-- <img src="{{asset('/assets/images/epicneedle.png')}}" alt="logo" style="width:175px"> --}}
        </a>
        <a href="index.html" class="btn btn-sm menu-close-btn">
            <i class="bi bi-x"></i>
        </a>

    </div>
    <div class="menu-body">
        <ul>
            <li>
                <a class="{{ isset($tab) && $tab == 'Dashboard' ? 'active' : '' }}" href="{{ url('dashboard') }}">
                    <span class="nav-link-icon">
                        <i class="bi bi-bar-chart"></i>
                    </span>
                    <span>Dashboard</span>
                </a>
            </li>

            
            {{-- <li>
                <a class="{{ isset($tab) && $tab == 'users' ? 'active' : '' }}" href="{#">
                    <span class="nav-link-icon">
                        <i class="bi bi-people"></i>
                    </span>
                    <span>User List</span>
                </a>
            </li> --}}
            @if( Gate::check('role-management') || Gate::check('user-management') || Gate::check('permission-management'))
            <li>
                <a href="#">
                <span class="nav-link-icon">
                    <i class="bi bi-people"></i>
                </span>
                    <span>Access Controls</span>
                </a>
                <ul>
                    @can('role-management')
                    <li>
                        <a class="{{isset($tab) && $tab=='roles' ? 'active' : ''}}" href="{{route('roles.index')}}">Role
                            Management</a>
                    </li>
                    @endcan
                    @can('user-management')
                    <li>
                        <a href="#">
                        <span>User Management</span>
                        </a>
                        <ul>
                            <li>
                               <a class="{{isset($tab) && $tab=='users' ? 'active' : ''}}" href="{{route('users.index')}}">User List</a> 
                            </li>
                            <!-- <li>
                               <a class="{{isset($tab) && $tab=='users-pending' ? 'active' : ''}}" href="{{route('user.status')}}">Pending Approval</a> 
                            </li> -->
                            
                        </ul>
                    </li>
                    @endcan
                    @can('permission-management')
                    <li>
                        <a class="{{isset($tab) && $tab=='permissions' ? 'active' : ''}}"
                           href="{{route('permissions.index')}}">Permission Mangement</a>
                    </li>
                    @endcan
                </ul>
            </li>
        @endif
        </ul>
    </div>
</div>
