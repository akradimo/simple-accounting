{{-- resources/views/partials/sidebar.blade.php --}}
<aside class="main-sidebar">
    <div class="sidebar-header">
        <div class="app-brand">
            <a href="{{ route('dashboard') }}" class="brand-link">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="brand-image">
                <span class="brand-text">حسابداری ساده</span>
            </a>
        </div>
    </div>

    <div class="sidebar-user">
        <div class="user-profile">
            <img src="{{ asset('assets/images/default-avatar.png') }}" alt="User Image" class="user-image">
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name ?? 'esmeeilir1' }}</div>
                <div class="user-status">
                    <i class="fas fa-circle text-success"></i>
                    <span>آنلاین</span>
                </div>
            </div>
        </div>
        <div class="user-date">{{ now()->format('Y-m-d H:i:s') }}</div>
    </div>

    <div class="sidebar-menu">
        <ul class="nav nav-pills nav-sidebar flex-column">
            {{-- داشبورد --}}
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>داشبورد</p>
                </a>
            </li>

            {{-- اشخاص --}}
            <li class="nav-item {{ request()->is('persons*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        مدیریت اشخاص
                        <i class="fas fa-angle-left left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('persons.index') }}" class="nav-link {{ request()->is('persons') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>لیست اشخاص</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('persons.create') }}" class="nav-link {{ request()->is('persons/create') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>افزودن شخص جدید</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('person-categories.index') }}" class="nav-link {{ request()->is('person-categories*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>دسته‌بندی اشخاص</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- مالی --}}
            <li class="nav-item {{ request()->is('financial*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-money-bill"></i>
                    <p>
                        امور مالی
                        <i class="fas fa-angle-left left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('transactions.index') }}" class="nav-link {{ request()->is('transactions*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>تراکنش‌ها</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('invoices.index') }}" class="nav-link {{ request()->is('invoices*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>فاکتورها</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- گزارشات --}}
            <li class="nav-item">
                <a href="{{ route('reports.index') }}" class="nav-link {{ request()->is('reports*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-chart-bar"></i>
                    <p>گزارشات</p>
                </a>
            </li>

            {{-- تنظیمات --}}
            <li class="nav-item">
                <a href="{{ route('settings.index') }}" class="nav-link {{ request()->is('settings*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cog"></i>
                    <p>تنظیمات</p>
                </a>
            </li>
        </ul>
    </div>
</aside>

<style>
.main-sidebar {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    width: 250px;
    background: #283046;
    border-left: 1px solid rgba(255, 255, 255, 0.1);
    z-index: 100;
    transition: all 0.3s ease;
}

.sidebar-header {
    padding: 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.app-brand {
    display: flex;
    align-items: center;
}

.brand-link {
    display: flex;
    align-items: center;
    color: #fff;
    text-decoration: none;
}

.brand-image {
    width: 35px;
    height: 35px;
    margin-left: 0.8rem;
}

.brand-text {
    font-size: 1.2rem;
    font-weight: 600;
}

.sidebar-user {
    padding: 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.user-profile {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
}

.user-image {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-left: 1rem;
    border: 2px solid rgba(255, 255, 255, 0.2);
}

.user-info {
    color: #fff;
}

.user-name {
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.user-status {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.7);
}

.user-date {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.5);
}

.sidebar-menu {
    padding: 1rem 0;
}

.nav-sidebar {
    padding: 0;
    margin: 0;
    list-style: none;
}

.nav-item {
    margin: 0.25rem 0;
}

.nav-link {
    display: flex;
    align-items: center;
    padding: 0.8rem 1.5rem;
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    transition: all 0.3s ease;
}

.nav-link:hover {
    color: #fff;
    background: rgba(255, 255, 255, 0.1);
}

.nav-link.active {
    color: #7367f0;
    background: rgba(115, 103, 240, 0.15);
}

.nav-icon {
    width: 1.25rem;
    margin-left: 0.8rem;
    font-size: 1.1rem;
    text-align: center;
}

.nav-treeview {
    display: none;
    list-style: none;
    padding: 0;
    margin: 0;
    padding-right: 1rem;
}

.menu-open > .nav-treeview {
    display: block;
}

.nav-treeview .nav-link {
    padding: 0.5rem 2.5rem 0.5rem 1rem;
    font-size: 0.9rem;
}

.left {
    position: absolute;
    left: 1rem;
    transition: transform 0.3s ease;
}

.menu-open > .nav-link .left {
    transform: rotate(-90deg);
}

/* Animations */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(10px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.nav-link.active {
    animation: slideIn 0.3s ease;
}

/* Responsive */
@media (max-width: 992px) {
    .main-sidebar {
        transform: translateX(100%);
    }

    .sidebar-open .main-sidebar {
        transform: translateX(0);
    }
}

/* Scrollbar */
.main-sidebar {
    overflow-y: auto;
}

.main-sidebar::-webkit-scrollbar {
    width: 5px;
}

.main-sidebar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
}

.main-sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 5px;
}

.main-sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.3);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle submenu
    const menuItems = document.querySelectorAll('.nav-item');
    menuItems.forEach(item => {
        const link = item.querySelector('.nav-link');
        if (link && item.querySelector('.nav-treeview')) {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                item.classList.toggle('menu-open');
            });
        }
    });

    // Mobile menu toggle
    const mobileToggle = document.querySelector('.mobile-toggle');
    if (mobileToggle) {
        mobileToggle.addEventListener('click', () => {
            document.body.classList.toggle('sidebar-open');
        });
    }
});
</script>