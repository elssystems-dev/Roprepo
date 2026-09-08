<?php
if (!defined('ROPREPO_ACCESS')) {
    http_response_code(404);
    include __DIR__ . '/../../not_index.php';
    exit;
}
?>
<main>
    <section class="robux-intro">
        <h1>Robux</h1>
        <p>
            In Roprepo, robux are free rewards earned by playing <a href="/app/main/charts.html">available games</a> 
            and scoring points, serving as the primary currency to unlock exclusive title cosmetics in the 
            <a href="/app/main/catalog.html">catalog</a>. This rewarding mechanic is heavily inspired by the classic 
            Roblox Tickets (A.K.A Tix), a former method of acquiring website prizes and customizing your 
            account purely through gameplay and platform engagement.
        </p>
    </section>
    <section class="robux-advice game-display">
        <h2>Most Rewarding Games</h2>
        <p>Here are the three games which provides the most points</p>
        <!-- Meta: Fazer um SELECT no Postgres que renderiza os 3 jogos com maior multiplicador de pontos -->
        <nav class="rewarding-games game-navigation">
            <div class="game-card-container">
                <a href="#" class="game-card-link">
                    <div class="game-card-thumb-container">
                        <img src="" alt="Game" class="game-card-img">
                    </div>
                    <div class="game-card-name">
                        <span>1</span>
                    </div>
                </a>
                <a href="#" class="game-card-link">
                    <div class="game-card-thumb-container">
                        <img src="" alt="Game" class="game-card-img">
                    </div>
                    <div class="game-card-name">
                        <span>2</span>
                    </div>
                </a>
                <a href="#" class="game-card-link">
                    <div class="game-card-thumb-container">
                        <img src="" alt="Game" class="game-card-img">
                    </div>
                    <div class="game-card-name">
                        <span>3</span>
                    </div>
                </a>
            </div>
        </nav>
    </section>
    <section class="plus-advise">
        <h2>Get Roprepo Plus</h2>
        <a href="/plus" class="btn">Here</a>
    </section>
</main>