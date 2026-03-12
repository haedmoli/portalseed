/**
 * @file
 * insight-detail.js
 * JavaScript for the social share popover.
 */

(function (Drupal, once) {
    'use strict';

    Drupal.behaviors.insightSharePopover = {
        attach: function (context, settings) {
            once('insightSharePopover', '.insight-share-container', context).forEach(function (container) {
                const trigger = container.querySelector('.insight-share-trigger');
                const popover = container.querySelector('.insight-share-popover');

                if (!trigger || !popover) return;

                trigger.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const isVisible = popover.classList.toggle('is-visible');
                    trigger.classList.toggle('is-active', isVisible);
                });

                // Close when clicking outside
                document.addEventListener('click', function (e) {
                    if (!container.contains(e.target)) {
                        popover.classList.remove('is-visible');
                        trigger.classList.remove('is-active');
                    }
                });

                // Close on Escape key
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') {
                        popover.classList.remove('is-visible');
                        trigger.classList.remove('is-active');
                    }
                });
            });
        }
    };

})(Drupal, once);
