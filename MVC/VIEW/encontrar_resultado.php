<?php
session_start();
require 'C:\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\config.php';

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(403);
    echo json_encode(['erro' => 'Não autenticado']);
    exit;
}

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'ID do teste não fornecido']);
    exit;
}

$teste_id = $_GET['id'];
$user_id = $_SESSION['usuario_id'];

$sql = "SELECT resultado FROM teste_inteligencia WHERE id = :id AND user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $teste_id, 'user_id' => $user_id]);
$teste = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$teste) {
    http_response_code(404);
    echo json_encode(['erro' => 'Teste não encontrado']);
    exit;
}

$resultado_array = json_decode($teste['resultado'], true);
arsort($resultado_array);
$tipo_principal = key($resultado_array);

echo json_encode([
    'resultado' => $resultado_array,
    'tipo' => ucfirst($tipo_principal)
]);
