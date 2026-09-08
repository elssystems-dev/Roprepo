<?php 
    // Mapa de páginas do sistema com seus respectivos títulos e importações
    // Vantagem dessa abordagem: Controle total na construção da página
    // Principal desvantagem: Configuração manual
    // IMPORTANTE: Para que os caminhos funcionem, é necessário que o script que o inclua esteja no mesmo nível que index.php. (filho direto de public/)
    return [
        '/' => ['component' => 'app/main/home.php', 'title' => 'Home', 'css' => 'assets/css/pages/main/home.css', 'js' => ''],
        '/profile' => ['component' => 'app/main/profile.php', 'title' => $user_name ?? 'Profile', 'css' => 'assets/css/pages/main/profile.css', 'js' => 'assets/js/pages/main/profile.js'],
        '/catalog' => ['component' => 'app/main/catalog.php', 'title' => 'Marketplace', 'css' => 'assets/css/pages/main/catalog.css', 'js' => ''],
        '/plus' => ['component' => 'app/main/plus.php', 'title' => 'Plus', 'css' => 'assets/css/pages/main/plus.css', 'js' => ''],
        '/robux' => ['component' => 'app/main/robux.php', 'title' => 'Robux', 'css' => 'assets/css/pages/main/robux.css', 'js' => ''],
        '/charts'  => ['component' => 'app/main/charts.php', 'title' => 'Charts', 'css' => 'assets/css/pages/main/charts.css', 'js' => 'assets/js/pages/main/charts.js'],
    ];
?>