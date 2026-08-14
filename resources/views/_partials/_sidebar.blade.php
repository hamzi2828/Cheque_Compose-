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

        <!-- Companies -->
        <li class="menu-item {{ request()->routeIs('clients.*') ? 'active open' : '' }}">
            <a class="menu-link menu-toggle" href="javascript:void(0)">
                <i class="menu-icon tf-icons ti ti-building"></i>
                <div data-i18n="Companies">Companies</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('clients.index') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('clients.index') }}">
                        <div data-i18n="All Companies">All Companies</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('clients.create') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('clients.create') }}">
                        <div data-i18n="Add Company">Add Company</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Payees -->
        <li class="menu-item {{ request()->routeIs('payees.*') ? 'active open' : '' }}">
            <a class="menu-link menu-toggle" href="javascript:void(0)">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="Payees">Payees</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('payees.index') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('payees.index') }}">
                        <div data-i18n="All Payees">All Payees</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('payees.create') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('payees.create') }}">
                        <div data-i18n="Add Payee">Add Payee</div>
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

        <!-- Settings -->
        <li class="menu-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
            <a class="menu-link" href="{{ route('settings.create') }}">
                <i class="menu-icon tf-icons ti ti-settings"></i>
                <div data-i18n="Settings">Settings</div>
            </a>
        </li>

    </ul>
</aside>
<!-- / Menu -->
