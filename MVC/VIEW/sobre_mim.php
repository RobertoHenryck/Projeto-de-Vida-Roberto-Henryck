<?php
session_start();
require_once 'C:\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\MVC\VIEW\upload_foto.php';

if (!isset($_SESSION['usuario_id'])) {
    die("Erro: Usuário não autenticado.");
}

$user_id = $_SESSION['usuario_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sobre_mim = $_POST['sobre_mim'] ?? '';

    $sql = "UPDATE users SET sobre_mim = :sobre_mim WHERE id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':sobre_mim', $sobre_mim);
    $stmt->bindParam(':user_id', $user_id);

    if ($stmt->execute()) {
        header("Location: perfil.php");
        exit;
    } else {
        $erro = "Erro ao atualizar o campo 'Sobre Mim'.";
    }
}

$sql = "SELECT sobre_mim FROM users WHERE id = :user_id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
$sobre_mim_atual = $usuario ? $usuario['sobre_mim'] : '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Sobre Mim</title>
</head>
<body>

<h2>Sobre Mim</h2>

<?php if (isset($erro)) echo "<p>$erro</p>"; ?>

<form method="POST">
    <label for="sobre_mim">Escreva algo sobre você:</label><br>
    <textarea name="sobre_mim" id="sobre_mim" rows="5" cols="50" maxlength="500" required><?= htmlspecialchars($sobre_mim_atual) ?></textarea><br><br>
    <button type="submit">Salvar</button>
</form>

</body>
</html>
