<?php
session_start();
require_once 'C:\Turma2\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\config.php';
require_once 'C:\Turma2\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\MVC\CONTROLLER\controller.php';

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
    <link rel="icon" type="image/png" href="../logo para web.png">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        thead {
            background-color: #4A7BFF;
            color: white;
        }

        th, td {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: center;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #ecf3fa;
        }

        p {
            text-align: center;
            font-size: 16px;
            color: #555;
        }

        .actions {
            text-align: center;
            margin-top: 20px;
        }

        .actions a {
            display: inline-block;
            background-color: #4A7BFF;
            color: white;
            padding: 10px 18px;
            margin: 5px;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .actions a:hover {
            background-color: #375bd8;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Seus Planos de Ação</h1>

    <table>
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
                    <td><?= htmlspecialchars($area) ?></td>
                    <td><?= htmlspecialchars($planos_acao[$area_underscore]['descricao'] ?? 'Não informado') ?></td>
                    <td><?= htmlspecialchars($planos_acao[$area_underscore]['prazo'] ?? 'Não informado') ?></td>
                    <td><?= htmlspecialchars($planos_acao[$area_underscore]['passo1'] ?? 'Não informado') ?></td>
                    <td><?= htmlspecialchars($planos_acao[$area_underscore]['passo2'] ?? 'Não informado') ?></td>
                    <td><?= htmlspecialchars($planos_acao[$area_underscore]['passo3'] ?? 'Não informado') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p>Visualize e gerencie seus planos de ação de forma clara e organizada.</p>

    <div class="actions">
  
        <a href="perfil.php">Voltar ao Perfil</a>
    </div>
</div>

</body>
</html>

