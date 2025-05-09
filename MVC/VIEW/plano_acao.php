<?php
session_start();
require_once 'C:\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\config.php';

if (!isset($_SESSION['usuario_id'])) {
    die("Erro: Usuário não autenticado.");
}

$user_id = $_SESSION['usuario_id'];
$areas = ['Relacionamento Familiar', 'Estudos'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($areas as $area) {
        $key = str_replace(' ', '_', strtolower($area));
        $descricao = $_POST["descricao_$key"] ?? '';
        $prazo = $_POST["prazo_$key"] ?? '';
        $passo1 = $_POST["passo1_$key"] ?? '';
        $passo2 = $_POST["passo2_$key"] ?? '';
        $passo3 = $_POST["passo3_$key"] ?? '';

        $sql = "SELECT id FROM plano_acao WHERE user_id = :user_id AND area = :area";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'area' => $area]);

        if ($stmt->rowCount() > 0) {
            $sql = "UPDATE plano_acao SET descricao = :descricao, prazo = :prazo, 
                    passo1 = :passo1, passo2 = :passo2, passo3 = :passo3, updated_at = NOW()
                    WHERE user_id = :user_id AND area = :area";
        } else {
            $sql = "INSERT INTO plano_acao (user_id, area, descricao, prazo, passo1, passo2, passo3, created_at, updated_at)
                    VALUES (:user_id, :area, :descricao, :prazo, :passo1, :passo2, :passo3, NOW(), NOW())";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'user_id' => $user_id,
            'area' => $area,
            'descricao' => $descricao,
            'prazo' => $prazo,
            'passo1' => $passo1,
            'passo2' => $passo2,
            'passo3' => $passo3
        ]);
    }

    header('Location: resultado_plano_acao.php');
    exit;
}

$planos_acao = [];
foreach ($areas as $area) {
    $key = str_replace(' ', '_', strtolower($area));
    $sql = "SELECT descricao, prazo, passo1, passo2, passo3 FROM plano_acao WHERE user_id = :user_id AND area = :area";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id, 'area' => $area]);
    $planos_acao[$key] = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Plano de Ação</title>
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 40px;
        }

        .area-section {
            margin-bottom: 40px;
        }

        .area-title {
            font-size: 20px;
            color: #2980b9;
            border-bottom: 2px solid #e0e0e0;
            margin-bottom: 15px;
            padding-bottom: 5px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="date"] {
            width: 100%;
            padding: 10px 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            background: #fdfdfd;
        }

        input[type="text"]:focus,
        input[type="date"]:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }

        .btn-submit {
            display: block;
            width: 100%;
            background-color: #4A7BFF;
            color: white;
            border: none;
            padding: 15px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Plano de Ação</h1>

    <form method="POST">
        <?php foreach ($areas as $area): ?>
            <?php $key = str_replace(' ', '_', strtolower($area)); ?>
            <div class="area-section">
                <div class="area-title"><?= htmlspecialchars($area) ?></div>

                <div class="form-group">
                    <label for="descricao_<?= $key ?>">O que você quer melhorar?</label>
                    <input type="text" name="descricao_<?= $key ?>" id="descricao_<?= $key ?>"
                           value="<?= htmlspecialchars($planos_acao[$key]['descricao'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="prazo_<?= $key ?>">Prazo para alcançar:</label>
                    <input type="date" name="prazo_<?= $key ?>" id="prazo_<?= $key ?>"
                           value="<?= htmlspecialchars($planos_acao[$key]['prazo'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="passo1_<?= $key ?>">Passo 1:</label>
                    <input type="text" name="passo1_<?= $key ?>" id="passo1_<?= $key ?>"
                           value="<?= htmlspecialchars($planos_acao[$key]['passo1'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="passo2_<?= $key ?>">Passo 2:</label>
                    <input type="text" name="passo2_<?= $key ?>" id="passo2_<?= $key ?>"
                           value="<?= htmlspecialchars($planos_acao[$key]['passo2'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="passo3_<?= $key ?>">Passo 3:</label>
                    <input type="text" name="passo3_<?= $key ?>" id="passo3_<?= $key ?>"
                           value="<?= htmlspecialchars($planos_acao[$key]['passo3'] ?? '') ?>">
                </div>
            </div>
        <?php endforeach; ?>

        <button type="submit" class="btn-submit">Salvar Plano de Ação</button>
    </form>
</div>

</body>
</html>
