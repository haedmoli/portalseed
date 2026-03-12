(function (Drupal) {
    Drupal.behaviors.contactHeroTypewriter = {
        attach: function (context, settings) {
            const elements = context.querySelectorAll('.contact-hero-typewriter');
            elements.forEach(el => {
                if (el.dataset.processed) return;
                el.dataset.processed = "true";

                const text = el.getAttribute('data-full-text') || "";
                const highlightWords = (el.getAttribute('data-highlight-words') || "").split(',');
                let currentIndex = 0;

                function type() {
                    if (currentIndex <= text.length) {
                        const currentSlice = text.slice(0, currentIndex);
                        const words = currentSlice.split(' ');

                        el.innerHTML = words.map((word, idx) => {
                            const cleanWord = word.replace(/[,.]/, '');
                            const isHighlight = highlightWords.includes(cleanWord);
                            const isLast = idx === words.length - 1;
                            return isHighlight ? `<strong class="font-bold">${word}</strong>` : word;
                        }).join(' ') + '<span class="inline-block w-[2px] h-[16px] bg-seed-blue-500 ml-1 animate-pulse"></span>';

                        currentIndex++;
                        setTimeout(type, 30);
                    }
                }
                type();
            });
        }
    };
})(Drupal);
