<?php
    // .env -> Mantém informações sensíveis seguras (sem push no GitHub)

    // Sobe 2 níveis a partir de database.php (config -> backend -> raiz)
    $path_to_env = dirname(__DIR__, 2) . '/.env';
    
    // Lê o arquivo em um array, ignorando quebras de linha e linhas vazias
    $lines = file($path_to_env, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        // Divide a linha em nome e valor no primeiro '=' que encontrar
        list($name, $value) = explode('=', $line, 2);
        // Salva a chave e o valor limpos dentro da superglobal $_ENV
        $_ENV[trim($name)] = trim($value);
    }

    // Puxa as variáveis do $_ENV. 
    $host = $_ENV['DB_HOST'] ?? 'localhost';
    $db   = $_ENV['DB_NAME'] ?? 'roprepo_db';
    $user = $_ENV['DB_USER'] ?? 'root';
    $pass = $_ENV['DB_PASS'] ?? '';

    // Conexão
    try {
        $pdo = new PDO (
            "pgsql:host=$host;dbname=$db",
            $user,
            $pass
        );
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    return $pdo;
?>