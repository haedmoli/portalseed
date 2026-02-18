/**
 * Seed Theme — Global Scripts
 */
(function () {
    'use strict';

    // Mobile menu toggle
    document.addEventListener('DOMContentLoaded', function () {
        var toggle = document.getElementById('mobile-menu-toggle');
        var mobileNav = document.getElementById('mobile-nav');
        var iconMenu = document.getElementById('icon-menu');
        var iconClose = document.getElementById('icon-close');

        if (!toggle || !mobileNav) return;

        toggle.addEventListener('click', function () {
            var isOpen = mobileNav.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            mobileNav.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
            if (iconMenu) iconMenu.style.display = isOpen ? 'none' : 'block';
            if (iconClose) iconClose.style.display = isOpen ? 'block' : 'none';
        });

        // Close mobile menu when a link is clicked
        mobileNav.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                mobileNav.classList.remove('is-open');
                toggle.setAttribute('aria-expanded', 'false');
                mobileNav.setAttribute('aria-hidden', 'true');
                if (iconMenu) iconMenu.style.display = 'block';
                if (iconClose) iconClose.style.display = 'none';
            });
        });
    });

})();
