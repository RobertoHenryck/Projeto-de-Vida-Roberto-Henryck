<?php
session_start();
require_once 'C:\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\config.php';

if (!isset($_SESSION['usuario_nome'])) {
    header('Location: index.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT nome, foto_perfil, data_nascimento FROM users WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $usuario_id);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

$foto_perfil = !empty($usuario['foto_perfil']) ? 'users/' . $usuario['foto_perfil'] : 'users/foto_padrao.png';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Principal</title>
    <link rel="icon" type="image/png" href="logo para web.png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #ffffff;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background-color: #f8f9fa;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e0e0e0;
        }

        header h1 {
            font-size: 24px;
            color: #333;
        }

        .area-usuario {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .avatar-link {
            display: flex;
            align-items: center;
        }

        .foto-usuario {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #4A7BFF;
        }

        .botao-sair {
            background-color: #4A7BFF;
            color: white;
            border: none;
            padding: 10px 18px;
            font-size: 14px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .botao-sair:hover {
            background-color: #365edc;
        }

        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            text-align: center;
        }

        .botoes-escolha {
            margin-top: 30px;
            display: flex;
            gap: 20px;
        }

        .botoes-escolha a {
            background-color: #4A7BFF;
            color: white;
            text-decoration: none;
            padding: 14px 28px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 10px;
            transition: background-color 0.3s ease;
        }

        .botoes-escolha a:hover {
            background-color: #365edc;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #f1f1f1;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <header>
        <h1>Bem-vindo, <?php echo htmlspecialchars($usuario['nome']); ?>!</h1>
        <div class="area-usuario">
            <a href="perfil.php" class="avatar-link" title="Perfil">
                <img src="<?php echo htmlspecialchars($foto_perfil); ?>" alt="Foto de Perfil" class="foto-usuario">
            </a>
            <form action="sair.php" method="POST" style="margin: 0;">
                <button type="submit" class="botao-sair">Sair</button>
            </form>
        </div>
    </header>

    <main>
        <h2>Escolha uma opção abaixo:</h2>
        <div class="botoes-escolha">
            <a href="quiz_personalidade.php">DESCUBRA SUA PERSONALIDADE</a>
            <a href="quiz_inteligencia.php">DESCUBRA SUA INTELIGÊNCIA</a>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 Todos os direitos reservados.</p>
    </footer>
</body>

</html>
