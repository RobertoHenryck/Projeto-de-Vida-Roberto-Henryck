<?php
session_start();
require_once 'C:\Turma2\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $data_nascimento = $_POST['data_nascimento'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $erro = "Este email já está cadastrado!";
    } else {
        $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (nome, email, data_nascimento, senha) 
                VALUES (:nome, :email, :data_nascimento, :senha)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':data_nascimento', $data_nascimento);
        $stmt->bindParam(':senha', $senha_criptografada);

        if ($stmt->execute()) {
            $_SESSION['usuario_nome'] = $nome;
            $_SESSION['usuario_email'] = $email;
            $_SESSION['data_nascimento'] = $data_nascimento;
            $_SESSION['senha'] = $senha_criptografada;

            header('Location: index.php');
            exit;
        } else {
            $erro = "Erro ao cadastrar o usuário. Tente novamente!";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
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

        h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="password"] {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }

        input[type="submit"]
         {
            padding: 10px;
            background-color: #4A7BFF;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            margin-top: 10px;
        }

        input[type="submit"]:hover,
        .voltar-btn:hover {
            background-color: #3a65d8;
        }

        p {
            text-align: center;
            color: red;
            margin-top: 10px;
        }

        .voltar-btn {
            margin-top: 20px;
            width: 100%;
        }

        input[type="date"] {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            color: #333;
            background-color: white;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            position: relative;
            background-image: url('data:image/svg+xml;utf8,<svg fill="%234A7BFF" height="20" viewBox="0 0 24 24" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M7 10h2v2H7zm4 0h2v2h-2zm4 0h2v2h-2z" /><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-2 .89-2 2v14c0 1.1.89 2 2 2h14c1.11 0 2-.9 2-2V6c0-1.11-.89-2-2-2zm0 16H5V9h14v11zm0-13H5V6h14v1z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 20px 20px;
        }

        input[type="date"]:focus {
            border-color: #4A7BFF;
            outline: none;
            box-shadow: 0 0 3px #4A7BFF44;
        }
        a{
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            color: black;
            padding: 5px;
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
                <h2>Crie sua conta</h2>
                <input type="text" name="nome" placeholder="Nome" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="date" name="data_nascimento" required>
                <input type="password" name="senha" placeholder="Senha" required>
                <input type="submit" value="Cadastrar">
            </form>

            <?php if (isset($erro)): ?>
                <p><?php echo $erro; ?></p>
            <?php endif; ?>

           <a href="index.php">Voltar para o Login</a> 
        </div>
    </main>
</body>

</html>