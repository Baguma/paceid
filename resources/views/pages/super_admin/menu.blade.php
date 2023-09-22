{{--Manage Settings--}}
<li class="nav-item">
    <a href="{{ route('settings') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['settings',]) ? 'active' : '' }}"><i class="icon-gear"></i> <span>Settings</span></a>
</li>

{{--Pins--}}
<li class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['reports.view', 'reports.index']) ? 'nav-item-expanded nav-item-open' : '' }} ">
    <a href="#" class="nav-link"><i class="icon-lock2"></i> <span> Reports</span></a>

    <ul class="nav nav-group-sub" data-submenu-title="Manage Pins">
        {{--Generate Pins--}}
        <li class="nav-item">
            <a href="{{ route('reports.view') }}"
               class="nav-link {{ (Route::is('reports.view')) ? 'active' : '' }}">General Report</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('reports.view') }}"
               class="nav-link {{ (Route::is('reports.view')) ? 'active' : '' }}">Graphical Report</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('reports.view') }}"
               class="nav-link {{ (Route::is('reports.view')) ? 'active' : '' }}">Pivot Report</a>
        </li>

    </ul>
</li>
