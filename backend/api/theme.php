<?php
    $json = file_get_contents("php://input"); // Acessa os dados enviados pela requisição
    $data = json_decode($json, true); // Transforma em array associativo

    if (isset($data['theme']) && in_array($data['theme'], ['dark', 'light'], true)) {
        $is_dark = ($data['theme'] === 'dark'); 
        $_SESSION['dark_mode'] = $is_dark;

        $sql = 'UPDATE users set dark_mode = :theme WHERE id = :id';
        $stmt = $pdo->prepare($sql);

        // 3o Argumento do bindValue se certifica que o tipo enviado será o desejado.
        $stmt->bindValue(":theme", $_SESSION['dark_mode'], PDO::PARAM_BOOL);
        $stmt->bindValue(":id", $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();
        http_response_code(200);
        echo json_encode(["status" => "success", "theme" => $data['theme']]);
        exit;
    } else {
        http_response_code(400);
        exit("Invalid Data.");
    }
?>