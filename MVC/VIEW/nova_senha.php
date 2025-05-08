<?php
require_once 'C:\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\config.php';

if (!isset($_GET['email'])) {
    header("Location: recuperar_senha.php");
    exit;
}

$email = $_GET['email'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $novaSenha = $_POST['nova_senha'];
    $confirmarSenha = $_POST['confirmar_senha'];

    if ($novaSenha === $confirmarSenha) {
        $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET senha = :senha WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':senha', $senhaHash);
        $stmt->bindParam(':email', $email);

        if ($stmt->execute()) {
            $sucesso =     header('Location: index.php');;
        } else {
            $erro = "Erro ao atualizar a senha.";
        }
    } else {
        $erro = "As senhas não coincidem.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Nova Senha</title>
</head>
<body>

<h2>Criar Nova Senha</h2>
<form method="POST">
    <p>Nova Senha:</p>
    <input type="password" name="nova_senha" required>
    <p>Confirmar Senha:</p>
    <input type="password" name="confirmar_senha" required>
    <button type="submit">Atualizar Senha</button>
</form>

<?php
if (isset($erro)) echo "<p style='color:red;'>$erro</p>";
if (isset($sucesso)) echo "<p style='color:green;'>$sucesso</p>";
?>

</body>
</html>
