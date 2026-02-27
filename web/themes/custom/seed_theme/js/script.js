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

        // Custom Tabs Logic for Services (Vanilla JS replacing Bootstrap)
        var tabButtons = document.querySelectorAll('.pg-services-tab-btn');
        if (tabButtons.length > 0) {
            tabButtons.forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    var targetId = this.getAttribute('data-bs-target');
                    if (!targetId) return;

                    var targetPane = document.querySelector(targetId);
                    if (!targetPane) return;

                    // Remove active from all buttons and panes in same group
                    var parentWrapper = this.closest('.pg-services-tabs-section');
                    if (parentWrapper) {
                        parentWrapper.querySelectorAll('.pg-services-tab-btn').forEach(b => b.classList.remove('active'));
                        parentWrapper.querySelectorAll('.pg-services-tab-pane').forEach(p => p.classList.remove('active'));
                    }

                    // Add active to current
                    this.classList.add('active');
                    targetPane.classList.add('active');
                });
            });
        }
    });

})();
