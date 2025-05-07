<?php
session_start();
require_once 'C:\Turma2\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\config.php';
require_once 'C:\Turma2\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\MVC\Controller\Controller.php';

if (!isset($_SESSION['usuario_id'])) {
    die("Erro: Usuário não autenticado.");
}

$user_id = $_SESSION['usuario_id'];
$areas = ['Relacionamento Familiar', 'Estudos'];

$planos_acao = [];

foreach ($areas as $area) {
    $area_underscore = str_replace(' ', '_', $area);
    $sql = "SELECT descricao, prazo, passo1, passo2, passo3 FROM plano_acao WHERE user_id = :user_id AND area = :area";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':area', $area);
    $stmt->execute();
    $planos_acao[$area_underscore] = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Plano de Ação - Listagem</title>
</head>
<body>

    <h1>Planos de Ação</h1>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Área</th>
                <th>Descrição</th>
                <th>Prazo</th>
                <th>Passo 1</th>
                <th>Passo 2</th>
                <th>Passo 3</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($areas as $area): ?>
                <?php $area_underscore = str_replace(' ', '_', $area); ?>
                <tr>
                    <td><?php echo htmlspecialchars($area); ?></td>
                    <td><?php echo htmlspecialchars($planos_acao[$area_underscore]['descricao'] ?? 'Não informado'); ?></td>
                    <td><?php echo htmlspecialchars($planos_acao[$area_underscore]['prazo'] ?? 'Não informado'); ?></td>
                    <td><?php echo htmlspecialchars($planos_acao[$area_underscore]['passo1'] ?? 'Não informado'); ?></td>
                    <td><?php echo htmlspecialchars($planos_acao[$area_underscore]['passo2'] ?? 'Não informado'); ?></td>
                    <td><?php echo htmlspecialchars($planos_acao[$area_underscore]['passo3'] ?? 'Não informado'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p>Essa é a lista dos seus planos de ação. Se necessário, você pode editá-los a qualquer momento.</p>

    <p><a href="editar_plano_acao.php">Editar Plano de Ação</a></p>
    <p><a href="perfil.php">Voltar</a></p>

</body>
</html>
