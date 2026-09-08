<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_id'])) {
        http_response_code(401); // Unauthorized
        include __DIR__ . '/login.html';
        exit;
    }

    if (!defined('INCLUDES')) define('INCLUDES', __DIR__ . '/../includes');
    
    $pageName = "Page Not Found";
    $cssImport = "<link rel='stylesheet' href='/assets/css/pages/main/404.css'>";
    $jsImport = "";
    require_once INCLUDES . '/head.php'; 
    require_once INCLUDES . '/header.php'
?>
<main>
    <h1>Error 404 - Not Found</h1>
    <img src="/assets/icons/external/builderman.svg" alt="ERROR PHOTO">
</main>
<?php 
    require_once INCLUDES . '/footer.php'; 
?>