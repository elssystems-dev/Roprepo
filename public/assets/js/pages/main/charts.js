const navigations = document.querySelectorAll(".game-navigation");

navigations.forEach(nav => {
    const gameContainer = nav.querySelector(".game-card-container");
    const btnForward = nav.querySelector(".go-forward");
    const btnBackward = nav.querySelector(".go-backward");

    const getScrollValue = () => {
        const firstCard = gameContainer.querySelector(".game-card-link");
        if (!firstCard) return gameContainer.clientWidth * 0.8;

        const cardWidth = firstCard.getBoundingClientRect().width;
        const computedStyle = window.getComputedStyle(gameContainer);
        const gap = parseFloat(computedStyle.gap) || 0;

        const totalSpace = gameContainer.clientWidth;
        const oneCardSpace = cardWidth + gap;
        
        // Vê quantos cards cabem inteiros
        const visibleCards = Math.floor(totalSpace / oneCardSpace);
        
        // Avança o bloco completo (menos 1 para manter o contexto visual)
        const cardsToScroll = visibleCards <= 1 ? 1 : visibleCards - 1;

        return oneCardSpace * cardsToScroll;
    };

    btnForward.addEventListener("click", () => {
        gameContainer.scrollLeft += getScrollValue();
    });

    btnBackward.addEventListener("click", () => {
        gameContainer.scrollLeft -= getScrollValue();
    });

    // Monitora as extremidades para ativar/desativar botões com segurança
    gameContainer.addEventListener("scroll", () => {
        const scrollLeft = gameContainer.scrollLeft;
        const maxScroll = gameContainer.scrollWidth - gameContainer.clientWidth;

        if (scrollLeft <= 4) {
            btnBackward.classList.add('killed');
        } else {
            btnBackward.classList.remove('killed');
        }

        if (Math.ceil(scrollLeft) >= maxScroll - 4) {
            btnForward.classList.add('killed');
        } else {
            btnForward.classList.remove('killed');
        }
    });
});