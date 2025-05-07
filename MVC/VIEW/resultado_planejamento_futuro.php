<?php
session_start();
require_once 'C:\Turma2\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\config.php';

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
</head>
<body>

    <h1>Projeto de Vida - Resumo</h1>

    <?php if ($dados): ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <tr><th>Campo</th><th>Valor</th></tr>
            <tr><td>Minhas Aspirações</td><td><?php echo nl2br(htmlspecialchars($dados['minhas_aspiracoes'])); ?></td></tr>
            <tr><td>Meu Sonho de Infância</td><td><?php echo nl2br(htmlspecialchars($dados['meu_sonho_infancia'])); ?></td></tr>
            <tr><td>Escolha Profissional</td><td><?php echo nl2br(htmlspecialchars($dados['escolha_profissional'])); ?></td></tr>
            <tr><td>Detalhes da Profissão</td><td><?php echo nl2br(htmlspecialchars($dados['detalhes_profissao'])); ?></td></tr>
            <tr><td>Meus Sonhos</td><td><?php echo nl2br(htmlspecialchars($dados['meus_sonhos'])); ?></td></tr>
            <tr><td>O que já faço</td><td><?php echo nl2br(htmlspecialchars($dados['o_que_ja_faco'])); ?></td></tr>
            <tr><td>O que preciso fazer</td><td><?php echo nl2br(htmlspecialchars($dados['o_que_preciso_fazer'])); ?></td></tr>
            <tr><td>Objetivo a Curto Prazo</td><td><?php echo nl2br(htmlspecialchars($dados['objetivo_curto_prazo'])); ?></td></tr>
            <tr><td>Objetivo a Médio Prazo</td><td><?php echo nl2br(htmlspecialchars($dados['objetivo_medio_prazo'])); ?></td></tr>
            <tr><td>Objetivo a Longo Prazo</td><td><?php echo nl2br(htmlspecialchars($dados['objetivo_longo_prazo'])); ?></td></tr>
            <tr><td>Visão para os Próximos 10 Anos</td><td><?php echo nl2br(htmlspecialchars($dados['visao_10_anos'])); ?></td></tr>
        </table>
    <?php else: ?>
        <p>Você ainda não preencheu o formulário do projeto de vida.</p>
    <?php endif; ?>

    <p><a href="home.php">Voltar para a Página Inicial</a></p>
    <p><a href="perfil.php">Voltar</a></p>

</body>
</html>
