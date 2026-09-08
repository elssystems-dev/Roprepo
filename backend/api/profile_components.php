<?php
    $templatePath = __DIR__ . '/../templates/profile/';
    $type = $_GET['type'] ?? null;

    $allowed = [
        'bio'   => 'bio.php',
        'games' => 'games.php',
        'titles'=> 'titles.php',
        'users' => 'users.php',
        'avatar'=> 'avatar.php',
    ];

    if (!$type || !isset($allowed[$type])) {
        http_response_code(404);
        exit('Seção inválida');
    }

    include $templatePath . $allowed[$type];
?>