<?php
// Se o arquivo for chamado direto pela URL real, essa constante NÃO vai existir
if (!defined('ROPREPO_ACCESS')) {
    http_response_code(404);
    include __DIR__ . '/../../not_index.php';
    exit;
}
?>
<main>
    <section class="user-greetings">
        <img src=<?=$user_pfp?> alt="Your Profile Picture" class="user-pfp">
        <h1>Greetings, <?=$user_name?>!</h1>
    </section>
    <h1>What's your next step?</h1>
    <section class="user-steps">
        <a href="/charts" class="step-option mono-icon">
            <img src="/assets/icons/external/charts.svg" alt="Charts">
            <h2>Charts</h2>
        </a>
        <a href="/catalog" class="step-option mono-icon">
            <img src="/assets/icons/external/catalog.svg" alt="Catalog">
            <h2>Catalog</h2>
        </a>
        <a href="/profile" class="step-option mono-icon">
            <img src="/assets/icons/external/profile.svg" alt="Profile">
            <h2>Profile</h2>
        </a>
    </section>
</main>
