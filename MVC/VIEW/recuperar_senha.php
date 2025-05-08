<?php
require_once 'C:\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Redireciona para o formulário de nova senha, passando o e-mail por GET
        header("Location: nova_senha.php?email=" . urlencode($email));
        exit;
    } else {
        $erro = "E-mail não encontrado.";
    }
    header('Location: index.php');
    
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha</title>
</head>
<body>

<h2>Recuperar Senha</h2>
<form method="POST">
    <p>Digite seu e-mail cadastrado:</p>
    <input type="email" name="email" required>
    <button type="submit">Verificar</button>
</form>

<?php if (isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>

<p><a href="login.php">Voltar ao login</a></p>

</body>
</html>
