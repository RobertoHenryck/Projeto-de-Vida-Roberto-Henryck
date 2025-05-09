<?php
session_start();
require_once 'C:\Turma2\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_email'] = $usuario['email'];
            $_SESSION['data_nascimento'] = $usuario['data_nascimento'];

            header('Location: home.php');
            exit;
        } else {
            $erro = "Senha incorreta!";
        }
    } else {
        $erro = "Usuário não encontrado!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar</title>
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
            transition: opacity 0.5s ease;
        }

        .fade-out {
            opacity: 0;
        }

        main {
            display: flex;
            width: 800px;
            height: 500px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        .esquerda {
            flex: 1;
            background-color: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .esquerda img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .direita {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        h1 {
            margin-bottom: 20px;
            text-align: center;
        }

        input[type="email"],
        input[type="password"] {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }

        button[type="submit"] {
            padding: 10px;
            background-color: #4A7BFF;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            margin-top: 10px;
        }

        button[type="submit"]:hover {
            background-color: #3a65d8;
        }

        a {
            text-decoration: none;
            color: #4A7BFF;
            font-size: 14px;
            text-align: center;
            display: block;
            margin-top: 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        p {
            text-align: center;
            color: black;
        }

        a {
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
        <div class="esquerda">
            <img src="../banner projeto de vida.png" alt="Banner">
        </div>
        <div class="direita">
            <form method="POST">
                <h1>LOGIN</h1>
                <p>E-mail</p>
                <input type="email" name="email" placeholder="Email" required>
                <p>Senha</p>
                <input type="password" name="senha" placeholder="Senha" required>
                <button type="submit">Entrar</button>

                <?php if (isset($erro))
                    echo "<p>$erro</p>"; ?>

                <a href="#" onclick="transicaoCadastro(event)">Não tem uma conta? Cadastre-se aqui</a>
                <a href="nova_senha.php">Recuperar senha</a>
            </form>
        </div>
    </main>

    <script>
        function transicaoCadastro(event) {
            event.preventDefault(); // Evita o redirecionamento imediato
            document.body.classList.add('fade-out'); // Adiciona a animação

            setTimeout(() => {
                window.location.href = 'create_login.php'; // Redireciona após a transição
            }, 500); // Tempo da transição (em ms)
        }
    </script>
</body>

</html>