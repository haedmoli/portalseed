(function (Drupal, once) {
    'use strict';

    Drupal.behaviors.insightHeroTypewriter = {
        attach: function (context, settings) {
            once('insightHeroTypewriter', '.insight-hero-typewriter', context).forEach(function (element) {
                const textToType = element.getAttribute('data-text') || '';
                const target = element.querySelector('.typewriter-content');
                if (!target) return;

                let index = 0;
                const speed = 30; // ms per character

                function type() {
                    if (index <= textToType.length) {
                        target.textContent = textToType.slice(0, index);
                        index++;
                        setTimeout(type, speed);
                    }
                }

                // Start typing
                type();
            });
        }
    };
})(Drupal, once);
