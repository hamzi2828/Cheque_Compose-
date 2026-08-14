<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <div class="app-brand demo">
        <a href="{{ route ('cheques.index') }}" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bold" style="font-size: 1.1rem;">Cheque Compose</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        <!-- Cheques -->
        <li class="menu-item {{ request()->routeIs('cheques.*') ? 'active open' : '' }}">
            <a class="menu-link menu-toggle" href="javascript:void(0)">
                <i class="menu-icon tf-icons ti ti-checkbox"></i>
                <div data-i18n="Cheques">Cheques</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('cheques.index') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('cheques.index') }}">
                        <div data-i18n="All Cheques">All Cheques</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('cheques.create') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('cheques.create') }}">
                        <div data-i18n="New Cheque">New Cheque</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Clients -->
        <li class="menu-item {{ request()->routeIs('clients.*') ? 'active open' : '' }}">
            <a class="menu-link menu-toggle" href="javascript:void(0)">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="Clients">Clients</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('clients.index') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('clients.index') }}">
                        <div data-i18n="All Clients">All Clients</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('clients.create') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('clients.create') }}">
                        <div data-i18n="Add Client">Add Client</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Banks -->
        <li class="menu-item {{ request()->routeIs('banks.*') ? 'active open' : '' }}">
            <a class="menu-link menu-toggle" href="javascript:void(0)">
                <i class="menu-icon tf-icons ti ti-building-bank"></i>
                <div data-i18n="Banks">Banks</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('banks.index') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('banks.index') }}">
                        <div data-i18n="All Banks">All Banks</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('banks.create') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('banks.create') }}">
                        <div data-i18n="Add Bank">Add Bank</div>
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</aside>
<!-- / Menu -->
