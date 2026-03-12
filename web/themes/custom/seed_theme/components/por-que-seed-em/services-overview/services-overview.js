((Drupal, once) => {
    Drupal.behaviors.servicesOverviewInteractive = {
        attach: function (context) {
            once('servicesOverviewInteractive', '[data-services-overview]', context).forEach(el => {
                // Mobile Accordion Logic
                const accordionTriggers = el.querySelectorAll('.accordion-trigger');
                accordionTriggers.forEach(trigger => {
                    trigger.addEventListener('click', (e) => {
                        const currentItem = e.currentTarget.closest('.accordion-item');
                        const content = currentItem.querySelector('.accordion-content');
                        const isActive = e.currentTarget.classList.contains('is-active');

                        // Close all others
                        el.querySelectorAll('.accordion-item').forEach(item => {
                            const btn = item.querySelector('.accordion-trigger');
                            const cnt = item.querySelector('.accordion-content');
                            const title = item.querySelector('.accordion-title');

                            btn.classList.remove('is-active', 'border-cyan-400', 'bg-white');
                            btn.classList.add('border-cyan-400/50', 'bg-seed-gray-900', 'hover:bg-seed-gray-800');
                            btn.setAttribute('aria-expanded', 'false');

                            title.classList.remove('text-seed-gray-900');
                            title.classList.add('text-white', 'group-hover:text-cyan-400');

                            cnt.classList.add('hidden');
                            cnt.classList.remove('block');
                        });

                        // Toggle current
                        if (!isActive) {
                            e.currentTarget.classList.add('is-active', 'border-cyan-400', 'bg-white');
                            e.currentTarget.classList.remove('border-cyan-400/50', 'bg-seed-gray-900', 'hover:bg-seed-gray-800');
                            e.currentTarget.setAttribute('aria-expanded', 'true');

                            const title = currentItem.querySelector('.accordion-title');
                            title.classList.add('text-seed-gray-900');
                            title.classList.remove('text-white', 'group-hover:text-cyan-400');

                            content.classList.remove('hidden');
                            content.classList.add('block');

                            setTimeout(() => {
                                const rect = currentItem.getBoundingClientRect();
                                const absoluteTop = rect.top + window.pageYOffset;
                                const middle = absoluteTop - (window.innerHeight / 2) + (rect.height / 2);
                                window.scrollTo({ top: middle, behavior: 'smooth' });
                            }, 100);
                        }
                    });
                });

                // Desktop Tabs Logic
                const desktopTriggers = el.querySelectorAll('.desktop-service-trigger');
                const desktopContents = el.querySelectorAll('[data-desktop-content]');

                desktopTriggers.forEach(trigger => {
                    trigger.addEventListener('click', (e) => {
                        const targetId = e.currentTarget.getAttribute('data-desktop-trigger');

                        // Inactivate all triggers
                        desktopTriggers.forEach(t => {
                            t.classList.remove('is-active', 'border-cyan-400', 'bg-white');
                            t.classList.add('border-cyan-400/50', 'bg-seed-gray-900/80', 'hover:bg-seed-gray-900', 'hover:border-cyan-400');
                            const title = t.querySelector('.desktop-service-title');
                            title.classList.remove('text-seed-gray-900');
                            title.classList.add('text-white');
                        });

                        // Activate current trigger
                        e.currentTarget.classList.add('is-active', 'border-cyan-400', 'bg-white');
                        e.currentTarget.classList.remove('border-cyan-400/50', 'bg-seed-gray-900/80', 'hover:bg-seed-gray-900', 'hover:border-cyan-400');
                        const currentTitle = e.currentTarget.querySelector('.desktop-service-title');
                        currentTitle.classList.add('text-seed-gray-900');
                        currentTitle.classList.remove('text-white');

                        // Hide all contents
                        desktopContents.forEach(c => {
                            c.classList.remove('opacity-100', 'relative');
                            c.classList.add('opacity-0', 'absolute', 'pointer-events-none');
                            c.style.top = '0';
                            c.style.left = '0';
                            c.style.width = '100%';
                        });

                        // Show target content
                        const targetContent = el.querySelector(`[data-desktop-content="${targetId}"]`);
                        if (targetContent) {
                            targetContent.classList.remove('opacity-0', 'absolute', 'pointer-events-none');
                            targetContent.classList.add('opacity-100', 'relative');
                            targetContent.style.top = '';
                            targetContent.style.left = '';
                            targetContent.style.width = '';
                        }
                    });
                });
            });
        }
    };
})(Drupal, once);
