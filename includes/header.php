<?php 
    $isDark = isset($_SESSION['dark_mode']) && $_SESSION['dark_mode'] === true;
    $themeClass = $isDark ? 'dark-mode' : '';
?>

<body class="<?= $themeClass ?>">
    <header>
        <div class="roprepo-logo">
            <a href="/" class="roprepo-link">
                <img class="roprepo-logo-img logo-text logo-white" src="/assets/icons/common/roprepo-title-dark.svg" alt="Roprepo Logo">
                <img class="roprepo-logo-img logo-text logo-black" src="/assets/icons/common/roprepo-title-light.svg" alt="Roprepo Logo">
                <img class="roprepo-logo-img logo-icon" src="/assets/icons/common/roprepo-icon.svg" alt="Roprepo Logo">
            </a>
        </div>
        <nav class="page-switch">
            <a href="/charts" class="nav-link">Charts</a>
            <a href="/catalog" class="nav-link">Marketplace</a>
            <a href="/robux" class="nav-link">Robux</a>
        </nav>
        <input type="search" name="search" class="search-bar" placeholder="Find our games..." autocomplete="off">
        <div class="user-section">
            <a href="/profile" class="profile-src"><img src= <?=$user_pfp?> alt="profile picture" class="user-pfp"></a>
            <a class="robux-card" href="/robux">
                <img src="/assets/icons/external/robux.svg" alt="Robux Icon" class="robux mono-icon">
                <p><?=$user_robux?></p>
            </a>
            <button class="theme-mode js-theme-toggle">
                <img src="/assets/icons/external/theme.svg" alt="Change Theme" class="theme-mode-img mono-icon">
            </button>
        </div>
    </header>