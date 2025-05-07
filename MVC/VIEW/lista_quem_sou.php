<?php
session_start();
require_once 'C:\Turma2\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\config.php';
require_once 'C:\Turma2\xampp\htdocs\Projeto-de-Vida---Roberto\MVC\Controller\Controller.php';

$controller = new Controller($pdo);
$user_id = $_SESSION['usuario_id'];

$dados = $controller->listarQuemSou($user_id);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Quem Sou Eu - Visualizar</title>
</head>
<body>
    <h2>Meus Dados - Quem Sou Eu</h2>

    <?php if ($dados): ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Categorias</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody>
                <tr><td><strong>Fale sobre você:</strong></td><td><?= htmlspecialchars($dados['fale_sobre_voce']) ?></td></tr>
                <tr><td><strong>Minhas Lembranças:</strong></td><td><?= htmlspecialchars($dados['minhas_lembrancas']) ?></td></tr>
                <tr><td><strong>Pontos Fortes:</strong></td><td><?= htmlspecialchars($dados['pontos_fortes']) ?></td></tr>
                <tr><td><strong>Pontos Fracos:</strong></td><td><?= htmlspecialchars($dados['pontos_fracos']) ?></td></tr>
                <tr><td><strong>Meus Valores:</strong></td><td><?= htmlspecialchars($dados['meus_valores']) ?></td></tr>
                <tr><td><strong>Minhas Aptidões:</strong></td><td><?= htmlspecialchars($dados['minhas_aptidoes']) ?></td></tr>
                <tr><td><strong>Meus Relacionamentos:</strong></td><td><?= htmlspecialchars($dados['meus_relacionamentos']) ?></td></tr>
                <tr><td><strong>O que gosto de fazer:</strong></td><td><?= htmlspecialchars($dados['o_que_gosto']) ?></td></tr>
                <tr><td><strong>O que não gosto:</strong></td><td><?= htmlspecialchars($dados['o_que_nao_gosto']) ?></td></tr>
                <tr><td><strong>Rotina, lazer e estudos:</strong></td><td><?= htmlspecialchars($dados['rotina_lazer_estudos']) ?></td></tr>
                <tr><td><strong>Minha Vida Escolar:</strong></td><td><?= htmlspecialchars($dados['minha_vida_escolar']) ?></td></tr>
                <tr><td><strong>Visão Física:</strong></td><td><?= htmlspecialchars($dados['visao_fisica']) ?></td></tr>
                <tr><td><strong>Visão Intelectual:</strong></td><td><?= htmlspecialchars($dados['visao_intelectual']) ?></td></tr>
                <tr><td><strong>Visão Emocional:</strong></td><td><?= htmlspecialchars($dados['visao_emocional']) ?></td></tr>
                <tr><td><strong>O que as pessoas pensam sobre mim:</strong></td><td><?= htmlspecialchars($dados['visao_pessoas_sobre_mim']) ?></td></tr>
                <tr><td><strong>Autovalorização:</strong></td><td><?= htmlspecialchars($dados['autovalorizacao']) ?></td></tr>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum dado encontrado.</p>
    <?php endif; ?>

    <p><a href="perfil.php">Voltar</a></p>
</body>
</html>
