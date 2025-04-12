<div class="modern-sidebar">
    <!-- Profile Section -->
    <div class="profile-section">
        <div class="profile-cover"></div>
        <div class="profile-info">
            <div class="profile-image">
                <img src="{{ asset('images/avatar.png') }}" alt="User Avatar">
                <span class="status-dot"></span>
            </div>
            <h5 class="profile-name">{{ auth()->user()->name ?? 'esmeeilir1' }}</h5>
            <p class="profile-date">{{ now()->format('Y-m-d H:i:s') }}</p>
        </div>
    </div>

    <!-- Search Box -->
    <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="جستجو...">
    </div>

    <!-- Navigation Menu -->
    <nav class="nav-menu">
        <div class="menu-category">
            <div class="menu-header">
                <i class="fas fa-home"></i>
                <span>داشبورد</span>
            </div>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span>صفحه اصلی</span>
            </a>
        </div>

        <div class="menu-category">
            <div class="menu-header">
                <i class="fas fa-users"></i>
                <span>مدیریت اشخاص</span>
            </div>
            <a href="{{ route('persons.create') }}" class="nav-link {{ request()->routeIs('persons.create') ? 'active' : '' }}">
                <i class="fas fa-user-plus"></i>
                <span>شخص جدید</span>
                <span class="link-badge new">جدید</span>
            </a>
            <a href="{{ route('persons.index') }}" class="nav-link {{ request()->routeIs('persons.index') ? 'active' : '' }}">
                <i class="fas fa-user-friends"></i>
                <span>لیست اشخاص</span>
            </a>
            <a href="{{ route('receive') }}" class="nav-link {{ request()->routeIs('receive') ? 'active' : '' }}">
                <i class="fas fa-hand-holding-usd"></i>
                <span>دریافت</span>
            </a>
        </div>

        <div class="menu-category">
            <div class="menu-header">
                <i class="fas fa-shopping-cart"></i>
                <span>فروش و درآمد</span>
            </div>
            <a href="#" class="nav-link">
                <i class="fas fa-file-invoice"></i>
                <span>فاکتور جدید</span>
            </a>
            <a href="#" class="nav-link">
                <i class="fas fa-list-alt"></i>
                <span>لیست فاکتورها</span>
                <span class="link-badge count">12</span>
            </a>
        </div>

        <div class="menu-category">
            <div class="menu-header">
                <i class="fas fa-boxes"></i>
                <span>انبار و کالا</span>
            </div>
            <a href="#" class="nav-link">
                <i class="fas fa-box-open"></i>
                <span>موجودی انبار</span>
            </a>
            <a href="#" class="nav-link">
                <i class="fas fa-dolly"></i>
                <span>ورود و خروج کالا</span>
            </a>
        </div>

        <div class="menu-category">
            <div class="menu-header">
                <i class="fas fa-chart-pie"></i>
                <span>گزارشات</span>
            </div>
            <a href="#" class="nav-link">
                <i class="fas fa-chart-bar"></i>
                <span>گزارش فروش</span>
            </a>
            <a href="#" class="nav-link">
                <i class="fas fa-balance-scale"></i>
                <span>تراز مالی</span>
            </a>
        </div>
    </nav>

    <!-- Bottom Section -->
    <div class="sidebar-footer">
        <a href="#" class="footer-link">
            <i class="fas fa-cog"></i>
            <span>تنظیمات</span>
        </a>
        <a href="#" class="footer-link">
            <i class="fas fa-question-circle"></i>
            <span>راهنما</span>
        </a>
        <a href="#" class="footer-link">
            <i class="fas fa-sign-out-alt"></i>
            <span>خروج</span>
        </a>
    </div>
</div>

<style>
:root {
    --sidebar-width: 280px;
    --primary-color: #4f46e5;
    --secondary-color: #818cf8;
    --sidebar-bg: #fff;
    --menu-hover: #f3f4f6;
    --text-primary: #1f2937;
    --text-secondary: #6b7280;
    --active-item: #4f46e5;
    --transition: all 0.3s ease;
}

.modern-sidebar {
    width: var(--sidebar-width);
    height: 100vh;
    position: fixed;
    right: 0;
    top: 0;
    background: var(--sidebar-bg);
    border-left: 1px solid #e5e7eb;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transition: var(--transition);
    z-index: 1000;
}

/* Profile Section */
.profile-section {
    position: relative;
    padding-bottom: 1rem;
}

.profile-cover {
    height: 80px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
}

.profile-info {
    text-align: center;
    margin-top: -40px;
}

.profile-image {
    position: relative;
    display: inline-block;
}

.profile-image img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 4px solid white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.status-dot {
    position: absolute;
    bottom: 5px;
    right: 5px;
    width: 12px;
    height: 12px;
    background: #22c55e;
    border: 2px solid white;
    border-radius: 50%;
}

.profile-name {
    margin: 0.5rem 0 0;
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
}

.profile-date {
    font-size: 0.75rem;
    color: var(--text-secondary);
    margin: 0.25rem 0;
}

/* Search Box */
.search-box {
    margin: 1rem;
    padding: 0.5rem 1rem;
    background: #f3f4f6;
    border-radius: 8px;
    display: flex;
    align-items: center;
}

.search-box i {
    color: var(--text-secondary);
    margin-left: 0.5rem;
}

.search-box input {
    border: none;
    background: none;
    outline: none;
    width: 100%;
    font-size: 0.875rem;
}

/* Navigation Menu */
.nav-menu {
    flex: 1;
    overflow-y: auto;
    padding: 1rem 0;
}

.menu-category {
    margin-bottom: 1.5rem;
}

.menu-header {
    padding: 0 1.5rem;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    color: var(--text-secondary);
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.menu-header i {
    margin-left: 0.5rem;
    font-size: 0.875rem;
}

.nav-link {
    display: flex;
    align-items: center;
    padding: 0.75rem 1.5rem;
    color: var(--text-primary);
    text-decoration: none;
    transition: var(--transition);
    position: relative;
}

.nav-link:hover {
    background: var(--menu-hover);
    color: var(--active-item);
}

.nav-link.active {
    background: var(--menu-hover);
    color: var(--active-item);
    font-weight: 500;
}

.nav-link.active::before {
    content: '';
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    height: 60%;
    width: 3px;
    background: var(--active-item);
    border-radius: 0 3px 3px 0;
}

.nav-link i {
    width: 20px;
    margin-left: 0.75rem;
    font-size: 1.1rem;
}

.link-badge {
    margin-right: auto;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.75rem;
}

.link-badge.new {
    background: #e0f2fe;
    color: #0369a1;
}

.link-badge.count {
    background: #fee2e2;
    color: #991b1b;
}

/* Sidebar Footer */
.sidebar-footer {
    padding: 1rem;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
}

.footer-link {
    color: var(--text-secondary);
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    font-size: 0.75rem;
    transition: var(--transition);
}

.footer-link:hover {
    color: var(--active-item);
}

.footer-link i {
    font-size: 1.25rem;
    margin-bottom: 0.25rem;
}

/* Scrollbar */
.nav-menu::-webkit-scrollbar {
    width: 4px;
}

.nav-menu::-webkit-scrollbar-track {
    background: transparent;
}

.nav-menu::-webkit-scrollbar-thumb {
    background: #e5e7eb;
    border-radius: 2px;
}

.nav-menu::-webkit-scrollbar-thumb:hover {
    background: #d1d5db;
}

/* Responsive */
@media (max-width: 768px) {
    .modern-sidebar {
        transform: translateX(100%);
    }

    .modern-sidebar.active {
        transform: translateX(0);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.querySelector('.search-box input');
    const navLinks = document.querySelectorAll('.nav-link');

    searchInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        
        navLinks.forEach(link => {
            const text = link.textContent.toLowerCase();
            link.style.display = text.includes(searchTerm) ? 'flex' : 'none';
        });
    });

    // Active link highlighting
    const currentPath = window.location.pathname;
    const activeLink = document.querySelector(`a[href="${currentPath}"]`);
    if (activeLink) {
        activeLink.classList.add('active');
    }
});
</script>