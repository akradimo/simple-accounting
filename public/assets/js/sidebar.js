// اطمینان از لود شدن jQuery
if (typeof jQuery === 'undefined') {
    throw new Error('سایدبار نیاز به jQuery دارد');
}

// کد اصلی سایدبار
jQuery(function($) {
    'use strict';

    // نگهداری وضعیت منوها در localStorage
    function saveMenuState($menuItem) {
        const menuId = $menuItem.data('menu-id');
        if (menuId) {
            if ($menuItem.hasClass('open')) {
                localStorage.setItem('menu_' + menuId, 'open');
            } else {
                localStorage.removeItem('menu_' + menuId);
            }
        }
    }

    // بازیابی وضعیت منوها از localStorage
    function loadMenuState() {
        $('.menu-item').each(function() {
            const $menuItem = $(this);
            const menuId = $menuItem.data('menu-id');
            if (menuId && localStorage.getItem('menu_' + menuId) === 'open') {
                $menuItem.addClass('open');
                $menuItem.next('.submenu').show();
            }
        });
    }

    // باز و بسته کردن زیرمنوها
    $('.menu-item').on('click', function(e) {
        const $menuItem = $(this);
        if ($menuItem.next('.submenu').length) {
            e.preventDefault();
            $menuItem.toggleClass('open');
            $menuItem.next('.submenu').slideToggle(300);
            saveMenuState($menuItem);
        }
    });

    // فعال کردن منوی جاری
    const currentPath = window.location.pathname;
    $('.menu-item').each(function() {
        const $menuItem = $(this);
        const link = $menuItem.attr('href');
        if (link && currentPath.includes(link)) {
            $menuItem.addClass('active');
            $menuItem.parents('.submenu').show();
            $menuItem.parents('.submenu').prev('.menu-item').addClass('open');
            saveMenuState($menuItem.parents('.submenu').prev('.menu-item'));
        }
    });

    // لود کردن وضعیت منوها در شروع
    loadMenuState();

    // اضافه کردن دکمه تاگل برای حالت موبایل
    $('.content-wrapper').prepend(
        '<button type="button" class="sidebar-toggle">' +
        '<i class="fas fa-bars"></i>' +
        '</button>'
    );

    // تاگل سایدبار در موبایل
    $('.sidebar-toggle').on('click', function() {
        $('body').toggleClass('sidebar-open');
    });

    // بستن سایدبار با کلیک خارج از آن در موبایل
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.sidebar-wrapper, .sidebar-toggle').length) {
            $('body').removeClass('sidebar-open');
        }
    });
});