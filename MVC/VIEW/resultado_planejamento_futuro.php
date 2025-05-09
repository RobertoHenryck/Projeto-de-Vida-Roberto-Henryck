<?php
session_start();
require_once 'C:\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\config.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    die("Acesso negado. Faça login para continuar.");
}

$user_id = $_SESSION['usuario_id'];

// Busca os dados do formulário preenchido pelo usuário
$sql = "SELECT * FROM planejamento_futuro WHERE user_id = :user_id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();

$dados = $stmt->rowCount() > 0 ? $stmt->fetch(PDO::FETCH_ASSOC) : null;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Projeto de Vida - Resumo</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #4A7BFF;
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 90%;
            max-width: 1000px;
            margin: 0 auto 30px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 14px 20px;
            text-align: left;
            border-bottom: 1px solid #eaeaea;
        }

        th {
            background-color: #4A7BFF;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #eef3ff;
        }

        .links {
            text-align: center;
        }

        .links a {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background-color: #4A7BFF;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .links a:hover {
            background-color: #365edc;
        }

        p {
            text-align: center;
            font-size: 16px;
            color: #666;
        }
    </style>
</head>
<body>

    <h1>Projeto de Vida - Resumo</h1>

    <?php if ($dados): ?>
        <table>
            <tr><th>Tópicos</th><th>Descrição</th></tr>
            <tr><td>Minhas Aspirações</td><td><?= nl2br(htmlspecialchars($dados['minhas_aspiracoes'])) ?></td></tr>
            <tr><td>Meu Sonho de Infância</td><td><?= nl2br(htmlspecialchars($dados['meu_sonho_infancia'])) ?></td></tr>
            <tr><td>Escolha Profissional</td><td><?= nl2br(htmlspecialchars($dados['escolha_profissional'])) ?></td></tr>
            <tr><td>Detalhes da Profissão</td><td><?= nl2br(htmlspecialchars($dados['detalhes_profissao'])) ?></td></tr>
            <tr><td>Meus Sonhos</td><td><?= nl2br(htmlspecialchars($dados['meus_sonhos'])) ?></td></tr>
            <tr><td>O que já faço</td><td><?= nl2br(htmlspecialchars($dados['o_que_ja_faco'])) ?></td></tr>
            <tr><td>O que preciso fazer</td><td><?= nl2br(htmlspecialchars($dados['o_que_preciso_fazer'])) ?></td></tr>
            <tr><td>Objetivo a Curto Prazo</td><td><?= nl2br(htmlspecialchars($dados['objetivo_curto_prazo'])) ?></td></tr>
            <tr><td>Objetivo a Médio Prazo</td><td><?= nl2br(htmlspecialchars($dados['objetivo_medio_prazo'])) ?></td></tr>
            <tr><td>Objetivo a Longo Prazo</td><td><?= nl2br(htmlspecialchars($dados['objetivo_longo_prazo'])) ?></td></tr>
            <tr><td>Visão para os Próximos 10 Anos</td><td><?= nl2br(htmlspecialchars($dados['visao_10_anos'])) ?></td></tr>
        </table>
    <?php else: ?>
        <p>Você ainda não preencheu o formulário do projeto de vida.</p>
    <?php endif; ?>

    <div class="links">
        <a href="home.php">Página Inicial</a>
        <a href="perfil.php">Voltar</a>
    </div>

</body>
</html>
