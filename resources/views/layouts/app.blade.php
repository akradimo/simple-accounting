<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'سیستم حسابداری') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CDN Links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Google Fonts - Vazirmatn -->
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-Variable-font-face.css" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css">

    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 70px;
            --topbar-height: 60px;
            --primary-color: #4F46E5;
            --primary-hover: #4338CA;
            --secondary-color: #1F2937;
            --menu-hover: #374151;
            --submenu-bg: #111827;
            --text-light: #F3F4F6;
            --text-muted: #9CA3AF;
            --border-color: #374151;
        }

        body {
            font-family: 'Vazirmatn', system-ui, -apple-system, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #F9FAFB;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            right: 0;
            top: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: var(--secondary-color);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            overflow-y: auto;
            box-shadow: -2px 0 8px rgba(0, 0, 0, 0.1);
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background-color: var(--border-color);
            border-radius: 3px;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-header {
            height: var(--topbar-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            background: var(--primary-color);
            border-bottom: 1px solid var(--border-color);
        }

        .brand-title {
            color: white;
            font-size: 1.25rem;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .toggle-sidebar {
            cursor: pointer;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            color: white;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.2s;
        }

        .toggle-sidebar:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Menu Styles */
        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-section {
            margin-bottom: 0.5rem;
            padding: 0 1rem;
        }

        .menu-section-title {
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.5rem 0;
        }

        .menu-item {
            padding: 0.75rem 1rem;
            color: var(--text-light);
            text-decoration: none;
            display: flex;
            align-items: center;
            position: relative;
            cursor: pointer;
            transition: all 0.2s;
            border-radius: 8px;
            margin: 0.25rem 1rem;
        }

        .menu-item:hover {
            background: var(--menu-hover);
            color: white;
        }

        .menu-item i:first-child {
            margin-left: 0.75rem;
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        .menu-item .title {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-weight: 500;
        }

        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
            background: var(--submenu-bg);
            margin: 0 1rem;
            border-radius: 8px;
        }

        .submenu.show {
            max-height: 1000px;
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .submenu .menu-item {
            padding: 0.6rem 1rem 0.6rem 2rem;
            margin: 0.125rem 0.5rem;
            font-size: 0.95rem;
            opacity: 0.9;
        }

        .menu-item .arrow {
            margin-right: auto;
            transition: transform 0.3s;
            opacity: 0.7;
            font-size: 0.8rem;
        }

        .menu-item.open .arrow {
            transform: rotate(-90deg);
        }

        .menu-item.active {
            background: var(--primary-color);
            color: white;
        }

        .menu-item.active:hover {
            background: var(--primary-hover);
        }

        .submenu .menu-item.active {
            background: var(--menu-hover);
        }

        /* Badge Styles */
        .menu-badge {
            background: var(--primary-color);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 999px;
            font-size: 0.75rem;
            margin-right: auto;
        }

        /* Content Area */
        .main-content {
            margin-right: var(--sidebar-width);
            padding: 1rem;
            transition: all 0.3s;
        }

        .main-content.expanded {
            margin-right: var(--sidebar-collapsed-width);
        }

        /* Topbar */
        .topbar {
            height: var(--topbar-height);
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            margin-bottom: 1.5rem;
            border-radius: 12px;
        }

        /* Mobile Styles */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-right: 0;
            }

            .main-content.expanded {
                margin-right: 0;
            }

            .mobile-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 40px;
                height: 40px;
                border-radius: 8px;
                background: var(--primary-color);
                color: white;
                cursor: pointer;
            }
        }

        /* Dropdown Menu */
        .user-menu .dropdown-toggle {
            background: var(--primary-color);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
        }

        .user-menu .dropdown-toggle:hover {
            background: var(--primary-hover);
        }

        .user-menu .dropdown-menu {
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border-color);
        }

        .dropdown-item {
            padding: 0.75rem 1rem;
            color: var(--secondary-color);
        }

        .dropdown-item:hover {
            background: var(--primary-color);
            color: white;
        }

        /* SweetAlert2 Custom Styles */
        .swal2-popup {
            font-family: 'Vazirmatn', system-ui, -apple-system, sans-serif !important;
        }
    </style>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Google Fonts - Vazirmatn -->
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-Variable-font-face.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css">
    @stack('styles')
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="brand-title">سیستم حسابداری</div>
            <div class="toggle-sidebar">
                <i class="fas fa-bars"></i>
            </div>
        </div>
        
        <div class="sidebar-menu">
            @include('layouts.sidebar')
        </div>
    </div>

    <div class="main-content" id="main-content">
        <div class="topbar">
            <div class="mobile-toggle">
                <i class="fas fa-bars"></i>
            </div>
            <div class="user-menu">
                @auth
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-2"></i>
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt ml-2"></i>
                                    خروج
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth
            </div>
        </div>

        @include('sweetalert::alert')
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const toggleButtons = document.querySelectorAll('.toggle-sidebar, .mobile-toggle');
            const menuItems = document.querySelectorAll('.menu-item');

            // تابع برای بستن تمام زیرمنوها
            function closeAllSubmenus() {
                document.querySelectorAll('.submenu.show').forEach(submenu => {
                    submenu.classList.remove('show');
                    const parentMenuItem = submenu.previousElementSibling;
                    if (parentMenuItem) {
                        parentMenuItem.classList.remove('open');
                    }
                });
            }

            // مدیریت تغییر وضعیت سایدبار
            toggleButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.stopPropagation();
                    sidebar.classList.toggle('collapsed');
                    sidebar.classList.toggle('show');
                    mainContent.classList.toggle('expanded');
                });
            });

            // مدیریت منوهای اصلی و زیرمنوها
            menuItems.forEach(item => {
                if (item.querySelector('.arrow')) {
                    item.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        const submenu = item.nextElementSibling;
                        
                        if (submenu && submenu.classList.contains('submenu')) {
                            if (!submenu.classList.contains('show')) {
                                closeAllSubmenus();
                            }
                            item.classList.toggle('open');
                            submenu.classList.toggle('show');
                        }
                    });
                }
            });

            // فعال کردن منوی جاری
            const currentPath = window.location.pathname;
            const menuLinks = document.querySelectorAll('.menu-item[href]');
            
            menuLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                    const parentSubmenu = link.closest('.submenu');
                    if (parentSubmenu) {
                        parentSubmenu.classList.add('show');
                        const parentMenuItem = parentSubmenu.previousElementSibling;
                        if (parentMenuItem) {
                            parentMenuItem.classList.add('open');
                        }
                    }
                }
            });

            // بستن سایدبار در حالت موبایل با کلیک بیرون
            document.addEventListener('click', (e) => {
                if (window.innerWidth <= 768) {
                    if (!sidebar.contains(e.target) && !e.target.closest('.mobile-toggle')) {
                        sidebar.classList.remove('show');
                    }
                }
            });

            // اضافه کردن افکت ریپل به دکمه‌ها
            const buttons = document.querySelectorAll('.menu-item');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const ripple = document.createElement('div');
                    ripple.classList.add('ripple');
                    this.appendChild(ripple);
                    
                    const rect = this.getBoundingClientRect();
                    ripple.style.left = `${e.clientX - rect.left}px`;
                    ripple.style.top = `${e.clientY - rect.top}px`;
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>