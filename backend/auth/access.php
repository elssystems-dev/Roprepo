<?php
header('Content-Type: application/json');
ini_set('display_errors', 0); // Impede o PHP de cuspir HTML de erros no meio da API

$current_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$action = (strpos($current_path, 'register') !== false) ? 'register' : 'login';

$user_name = isset($_POST['username']) ? trim($_POST['username']) : '';
$password  = $_POST['passwd'] ?? '';

// Função auxiliar para responder o cliente
function returnResponse($success, $message, $redirect = null) {
    if (!$success) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => $message]);
    } else {
        http_response_code(200);
        $response = ['success' => true];
        if ($redirect) {
            $response['redirect'] = $redirect;
        } else {
            $response['message'] = $message;
        }
        echo json_encode($response);
    }
    exit;
}

// Aplica RegEx para o nome de usuário
$user_name_cleaned = preg_replace('/[^a-zA-Z0-9_]/', '', $user_name);
if ($user_name !== $user_name_cleaned) returnResponse(false, 'Username contains illegal characters.');

// Validação de campos vazios
if ($user_name === '' || $password === '') returnResponse(false, 'Please, fill all fields to proceed.');

// Validação de tamanho do Username
if (mb_strlen($user_name) < 3) returnResponse(false, 'User must have more than 3 characters.');
elseif (mb_strlen($user_name) > 20) returnResponse(false, 'User must have less or equal to 20 characters.');

// Validação de tamanho da Senha
if (mb_strlen($password) < 8) returnResponse(false, 'Password must have atleast 8 characters.');

if ($action === 'login') {
    try {
        $stmt = $pdo->prepare("SELECT id, username, password_hash, dark_mode FROM users WHERE LOWER(username) = LOWER(?)");
        $stmt->execute([$user_name]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            returnResponse(true, 'Login successful', '/');

        } else returnResponse(false, 'Invalid username or password.');

    } catch (PDOException $e) {
        http_response_code(500); 
        echo json_encode(['success' => false, 'message' => 'Database connection error.']);
        exit;
    }
}

elseif ($action === 'register') {
    $email = isset($_POST['email']) ? strtolower(trim($_POST['email'])) : '';
    $verify_value = $_POST['passwdVerify'] ?? '';

    if ($email === '' || $verify_value === '') returnResponse(false, 'Please, fill all fields to proceed.');

    $email_regex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

    if (!preg_match($email_regex, $email)) returnResponse(false, 'Please enter a valid email address.');

    if ($password !== $verify_value) returnResponse(false, 'Passwords do not match!');

    try {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE LOWER(username) = LOWER(?) OR email = ?");
        $stmt->execute([$user_name, $email]);
        
        if ($stmt->fetch()) returnResponse(false, 'Username or email is already taken.');

        $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
        $insert_stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
        $insert_stmt->execute([$user_name, $email, $password_hash]);

        $_SESSION['user_id'] = $pdo->lastInsertId();

        returnResponse(true, 'Account created successfully!', '/');

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error creating account. Try again later.']);
        exit;
    }
}

// Rota inválida
else returnResponse(false, 'Invalid routing action.');
?>