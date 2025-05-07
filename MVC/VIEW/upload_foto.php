<?php
session_start();
require_once 'C:\Turma2\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['arquivo'])) {
    $usuario_id = $_SESSION['usuario_id'];
    $diretorio = 'users/';

    if (!is_dir($diretorio)) {
        mkdir($diretorio, 0777, true);
    }

    $arquivo = $_FILES['arquivo'];
    $nome_arquivo = $arquivo['name'];
    $tmp = $arquivo['tmp_name'];
    $erro = $arquivo['error'];
    $tamanho = $arquivo['size'];
    $extensao = strtolower(pathinfo($nome_arquivo, PATHINFO_EXTENSION));

    $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $tamanho_maximo = 2 * 1024 * 1024;

    if ($erro !== 0) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao enviar o arquivo.']);
        exit;
    }
    if (!in_array($extensao, $extensoes_permitidas)) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Tipo de arquivo inválido.']);
        exit;
    }
    if ($tamanho > $tamanho_maximo) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Arquivo muito grande.']);
        exit;
    }

    $foto_nome = 'perfil_' . $usuario_id . '_' . time() . '.' . $extensao;
    $destino = $diretorio . $foto_nome;

    if (move_uploaded_file($tmp, $destino)) {
        $sql = "UPDATE users SET foto_perfil = :foto WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':foto', $foto_nome);
        $stmt->bindParam(':id', $usuario_id);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'sucesso', 'arquivo' => $foto_nome]);
        } else {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao salvar no banco.']);
        }
    } else {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao mover o arquivo.']);
    }
}
?>