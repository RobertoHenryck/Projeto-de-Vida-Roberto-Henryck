<?php
session_start();
require_once 'C:\Turma2\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\config.php';
require_once 'C:\Turma2\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\MVC\CONTROLLER\controller.php';

if (!isset($_SESSION['usuario_id'])) {
    die("Erro: Usuário não autenticado.");
}

$usuario_id = $_SESSION['usuario_id'];

// Consulta os dados do usuário
$sql = "SELECT nome, foto_perfil FROM users WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $usuario_id, PDO::PARAM_INT);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die("Erro: Usuário não encontrado no banco de dados.");
}

$foto_perfil = !empty($usuario['foto_perfil']) ? 'users/' . $usuario['foto_perfil'] : 'users/foto_padrao.png';

$controller = new Controller($pdo);
$dados = $controller->listarQuemSou($usuario_id);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Perfil do Usuário</title>
    <link rel="icon" type="image/png" href="../logo para web.png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
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

        .foto-usuario {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #4A7BFF;
        }

        .botao-sair,
        a,
        button {
            text-decoration: none;
            background-color: #4A7BFF;
            color: white;
            border: none;
            padding: 10px 18px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .botao-sair:hover {
            background-color: #365edc;
        }

        main {
            display: flex;
            padding: 30px;
        }

        .sidebar {
            width: 250px;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .sidebar img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 15px;
            border: 2px solid #4A7BFF;
        }

        .sidebar button,
        .sidebar a {
            display: block;
            width: 100%;
            margin: 5px 0;
            padding: 10px;
            background-color: #4A7BFF;
            color: white;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            text-align: center;
            font-weight: bold;
        }

        .sidebar a:hover {
            background-color: #365edc;
        }

        .content {
            flex-grow: 1;
            margin-left: 30px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .content h2 {
            color: #4A7BFF;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4A7BFF;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        strong {
            color: #333;
        }
    </style>
</head>

<body>

<header>
    <h1>Bem-vindo(a), <?= htmlspecialchars($usuario['nome']) ?>!</h1>
    <div class="area-usuario">
        <form action="sair.php" method="POST">
            <button><a href="Home.php">Home</a></button>
            <button type="submit" class="botao-sair">Sair</button>
        </form>
    </div>
</header>

<main>
    <div class="sidebar">
        <img src="<?= htmlspecialchars($foto_perfil) ?>" alt="Foto de Perfil"><br>
        <form id="formFoto" action="upload_foto.php" method="POST" enctype="multipart/form-data">
            <input type="file" id="arquivo" name="arquivo" accept="image/*" required><br><br>
            <button type="submit">Atualizar Foto</button>
        </form>
        <hr><br>
        <a href="planejamento_futuro.php">Planejamento do Futuro</a>
        <a href="resultado_planejamento_futuro.php">Ver Meu Planejamento</a>
        <a href="plano_acao.php">Plano de Ação</a>
        <a href="resultado_plano_acao.php">Ver Meu Plano de Ação</a>
        <a href="quiz_inteligencia.php">Quiz Inteligência</a>
        <a href="resultado_inteligencias.php">Resultado Quiz Inteligência</a>
        <a href="quiz_personalidade.php">Quiz Personalidade</a>
        <a href="resultado_personalidade.php">Resultado Quiz Personalidade</a>
        <a href="quem_sou.php">Quem Sou</a>
    </div>

    <div class="content">
        <h2>Meus Dados - Quem Sou Eu</h2>

        <?php if ($dados): ?>
            <table>
                <thead>
                    <tr>
                        <th>Categorias</th>
                        <th>Descrição</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($dados as $campo => $valor): ?>
                    <?php if (!in_array($campo, ['id', 'user_id', 'created_at', 'updated_at'])): ?>
                        <tr>
                            <td><strong><?= ucwords(str_replace('_', ' ', $campo)) ?>:</strong></td>
                            <td><?= htmlspecialchars($valor) ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum dado encontrado.</p>
        <?php endif; ?>
    </div>
</main>

</body>
</html>
