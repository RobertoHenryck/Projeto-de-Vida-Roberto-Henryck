<?php
require_once 'C:\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        header("Location: nova_senha.php?email=" . urlencode($email));
        exit;
    } else {
        $erro = "E-mail não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha</title>
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
            margin-bottom: 10px;
        }

        input[type="email"] {
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
            margin-bottom: 10px;
        }

        button:hover {
            background-color: #3a65d8;
        }

        .erro {
            text-align: center;
            color: red;
            margin-top: 10px;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
           
            text-decoration: none;
            color: black;
        }
        a:hover{
            text-decoration: none;
            color: black;
        }
    </style>
       
</head>
<body>
    <main>
        <h2>Recuperar Senha</h2>
        <form method="POST">
            <p>Digite seu e-mail cadastrado:</p>
            <input type="email" name="email" required>
            <button type="submit">Verificar</button>
        </form>

        <?php if (isset($erro)) echo "<p class='erro'>$erro</p>"; ?>

        <a href="login.php">Voltar ao login</a>
    </main>
</body>
</html>
