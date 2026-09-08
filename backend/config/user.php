<?php
try {
    $stmt = $pdo->prepare("SELECT username, pfp_url, robux, dark_mode, is_plus FROM users WHERE id = :id");
    $stmt->bindValue(":id", $_SESSION['user_id']);
    $stmt->execute();

    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user_data) {
        session_destroy();
        header("Location: ./index.php?page=login");
        exit;
    }

    $_SESSION['username']  = $user_data['username'];
    if (isset($user_data['pfp_url'])) $_SESSION['pfp_url'] = '/assets/img/avatars/' . $user_data['pfp_url'];
    $_SESSION['robux'] = $user_data['robux'];

    // Se não haver valor salvo na sessão, pega do banco
    if (!isset($_SESSION['dark_mode'])) $_SESSION['dark_mode'] = filter_var($user_data['dark_mode'], FILTER_VALIDATE_BOOLEAN);

} catch (PDOException $e) {
    error_log("Error loading user session: " . $e->getMessage());
}

$user_name  = $_SESSION['username'] ?? 'User';
$user_pfp   = $_SESSION['pfp_url'] ?? '/assets/img/system/default.png';
$user_robux = $_SESSION['robux'] ?? 0;
$dark_mode  = $_SESSION['dark_mode'] ?? true;
?>