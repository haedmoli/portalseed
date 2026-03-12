((Drupal, once) => {
    Drupal.behaviors.aboutHeroTypewriter = {
        attach: function (context) {
            once('aboutHeroTypewriter', '[data-about-hero-typewriter]', context).forEach(el => {
                const fullText = el.getAttribute('data-full-text') || '';
                const highlightWordsStr = el.getAttribute('data-highlight-words') || '';
                const highlightWords = highlightWordsStr.split(',').map(w => w.trim().toLowerCase()).filter(w => w);

                let currentIndex = 0;
                let displayedText = '';

                const renderText = (text) => {
                    const words = text.split(' ');
                    const formattedWords = words.map((word, index) => {
                        const cleanWord = word.replace(/[,.]/g, '').toLowerCase();
                        const isBold = highlightWords.some(hw => cleanWord.includes(hw));

                        let result = isBold ? `<strong class="font-bold">${word}</strong>` : word;
                        return result;
                    });

                    return formattedWords.join(' ');
                };

                const typingInterval = setInterval(() => {
                    if (currentIndex <= fullText.length) {
                        displayedText = fullText.slice(0, currentIndex);
                        el.innerHTML = renderText(displayedText) + '<span class="inline-block w-[2px] h-[16px] bg-seed-blue-500 ml-1 animate-pulse"></span>';
                        currentIndex++;
                    } else {
                        clearInterval(typingInterval);
                        el.innerHTML = renderText(fullText) + '<span class="inline-block w-[2px] h-[16px] bg-seed-blue-500 ml-1 animate-pulse"></span>';
                    }
                }, 30);
            });
        }
    };
})(Drupal, once);
