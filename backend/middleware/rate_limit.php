<?php
function applyRateLimit($page, $clickLimit = 5, $timeWindow = 10, $blockTime = 60) {

    // Garante que a sessão está ativa (Para utilizá-la depois)
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $timeNow = time(); // Tempo atual em segundos

    // Inicializa o sub-array para a rota atual se ele não existir na sessão
    if (!isset($_SESSION['rate_limit'][$page])) {
        $_SESSION['rate_limit'][$page] = [
            'click_history' => 0,
            'window_start' => $timeNow,
            'blocked_until' => 0
        ];
    }

    // Importante: Cada rota tem seu próprio rate limit
    $currentRoute = &$_SESSION['rate_limit'][$page];
    // Essencial, pois o usuário pode spammar a mudança de tema e ser impedido de deslogar, por exemplo.

    // Se o usuário já estiver bloqueado, barra logo no início
    if (isset($currentRoute['blocked_until']) && $timeNow < $currentRoute['blocked_until']) {
        http_response_code(429);
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false, 
            'message' => 'You are temporarily blocked due to spam.'
        ]);
        exit;
    }

    if (!isset($currentRoute['click_history']) || ($timeNow - ($currentRoute['window_start'] ?? 0)) > $timeWindow) {
        $currentRoute['click_history'] = 0;
        $currentRoute['window_start'] = $timeNow;
    }

    $currentRoute['click_history']++;

    // Se estourou o limite, bloqueia por x tempo.
    if ($currentRoute['click_history'] > $clickLimit) {
        $currentRoute['blocked_until'] = $timeNow + $blockTime;
        
        http_response_code(429);
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false, 
            'message' => 'Blocked due to excessive requests.'
        ]);
        exit;
    }
}