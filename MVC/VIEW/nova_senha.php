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
            header('Location: index.php');
            exit;
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
    <link rel="icon" type="image/png" href="../logo para web.png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            opacity: 0;
            animation: fadeIn 1s ease forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        main {
            width: 400px;
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        p {
            font-size: 14px;
            margin: 10px 0 5px;
        }

        input[type="password"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 15px;
        }

        button {
            padding: 10px;
            background-color: #4A7BFF;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
        }

        button:hover {
            background-color: #3a65d8;
        }

        .erro {
            text-align: center;
            color: red;
            margin-top: 10px;
        }

        .sucesso {
            text-align: center;
            color: green;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <main>
        <h2>Criar Nova Senha</h2>
        <form method="POST">
            <p>Nova Senha:</p>
            <input type="password" name="nova_senha" required>
            <p>Confirmar Senha:</p>
            <input type="password" name="confirmar_senha" required>
            <button type="submit">Atualizar Senha</button>
        </form>

        <?php
        if (isset($erro)) echo "<p class='erro'>$erro</p>";
        if (isset($sucesso)) echo "<p class='sucesso'>$sucesso</p>";
        ?>
    </main>
</body>
</html>
