<?php

// Extrai apenas o caminho da URL (ignorando parâmetros como ?id=1)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Tenta capturar a extensão do arquivo (ex: "css" de "/assets/css/base.css")
$extension = pathinfo($uri, PATHINFO_EXTENSION);

// Se houver uma extensão na URL, validamos se é um arquivo estático permitido
if ($extension) {
    $allowedExtensions = require_once __DIR__ . '/../backend/config/allowed_extensions.php';
        if (in_array(strtolower($extension), $allowedExtensions)) {
        return false; // Permite que o arquivo estático seja renderizado sem a intervenção do script
    }
}

session_start();

// Chave de Segurança: Impede do usuário digitar caminhos reais do servidor na URL
define('ROPREPO_ACCESS', true);

// Extrai os caminhos reais do servidor (Atalhos)
define('ROOT', realpath(__DIR__ . '/../'));
define('INCLUDES', ROOT . '/includes');
define('BACKEND', ROOT . '/backend');

require_once BACKEND . '/config/database.php';

// Peça chave: Identifica a URL acionada pelo cliente
$page = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// APIs Públicas (Não precisam de autenticação para chamar)
$publicAPIs = require_once BACKEND . '/routes/public_api.php';

// Middleware protetor -> Dispara HTTP 429 caso haja spam
require_once BACKEND . '/middleware/rate_limit.php';

if (array_key_exists($page, $publicAPIs)) {
    applyRateLimit($page, 5, 10, 60); // Repetindo os parâmetros default para melhor legibilidade
    require_once BACKEND . $publicAPIs[$page];
    exit; 
}

// Barreira de autenticação
if (!isset($_SESSION["user_id"])) {
    require_once 'login.html';
    exit; 
}

$privateAPIs = require_once BACKEND . '/routes/private_api.php';

if (array_key_exists($page, $privateAPIs)) {
    applyRateLimit($page, 8, 10, 45); // Limite menos rígido para usuários logados
    require_once BACKEND . $privateAPIs[$page];
    exit; 
}

// Carrega os dados do usuário
require_once BACKEND . '/config/user.php';

// Busca o array com a rota de páginas
$routes = require_once BACKEND . "/routes/render.php";

// Se a página digitada na URL não existir no mapa, renderiza o not_index.php (irmão do front-controller)
if (!array_key_exists($page, $routes)) {
    http_response_code(404);
    require_once __DIR__ . '/not_index.php';
    exit;
}

// Extrai o conteúdo da página desejada
$component = $routes[$page]['component']; // Renderizado dentro de body header.php -> <- footer.php
$pageName = $routes[$page]['title']; // Título para a página <title>

$cssPath = $routes[$page]['css']; 
$jsPath = $routes[$page]['js'];

// Ternário: Se importação não foi definida, envia uma string vazia para os próximos arquivos
$cssImport = !empty($cssPath) ? "<link rel='stylesheet' href='/{$cssPath}'>" : ""; // Utilizado em head.php
$jsImport = !empty($jsPath) ? "<script src='/{$jsPath}' type='module'></script>" : ""; // Utilizado em footer.php

// Montagem sequencial do site
require_once INCLUDES . '/head.php'; 
require_once INCLUDES . '/header.php';
require_once $component;
require_once INCLUDES . '/footer.php';
?>