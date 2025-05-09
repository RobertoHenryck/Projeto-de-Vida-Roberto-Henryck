<?php
session_start();
require_once 'C:\Turma2\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\config.php';

if (!isset($_SESSION['usuario_id'])) {
    die("Acesso negado. Faça login para continuar.");
}

// Obtém o tipo de personalidade passado pela URL
$resultado = $_GET['tipo'] ?? "Não definido";

// Descrições para cada tipo de personalidade
$descricao_personalidade = [
    "Líder Visionário" => "Você tem uma mente estratégica e inspiradora, sempre buscando motivar quem está ao seu redor e liderar com propósito.",
    "Analítico e Prático" => "Você se destaca por sua habilidade de tomar decisões racionais, resolver problemas com eficiência e manter tudo sob controle.",
    "Criativo e Comunicativo" => "Você é movido pela criatividade e pela troca de ideias, sendo uma pessoa expressiva e cheia de novas soluções.",
    "Equilibrado e Adaptável" => "Você possui um equilíbrio impressionante entre razão, emoção e ação, conseguindo lidar bem com mudanças e se adaptar facilmente."
];

// Escolhe a descrição com base no tipo
$descricao = $descricao_personalidade[$resultado] ?? "Perfil não identificado.";

// Pega as últimas respostas do usuário
$user_id = $_SESSION['usuario_id'];
$sql = "SELECT q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, q13, q14, q15, q16 
        FROM teste_personalidade 
        WHERE user_id = :user_id 
        ORDER BY data DESC 
        LIMIT 1";

$stmt = $pdo->prepare($sql);
$stmt->execute([':user_id' => $user_id]);

$respostas = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$respostas || !is_array($respostas)) {
    echo "<p>Você ainda não respondeu ao teste de personalidade.</p>";
    exit;
}

// Inicializa a contagem de respostas para cada categoria de personalidade
$pontuacao = ['Líder' => 0, 'Analítico' => 0, 'Criativo' => 0, 'Equilibrado' => 0];

// Mapeia as respostas para os tipos de personalidade
foreach ($respostas as $pergunta => $resposta) {
    switch ($resposta) {
        case 'A':
            $pontuacao['Líder']++;
            break;
        case 'B':
            $pontuacao['Analítico']++;
            break;
        case 'C':
            $pontuacao['Criativo']++;
            break;
        case 'D':
            $pontuacao['Equilibrado']++;
            break;
    }
}

// Prepara dados para o gráfico
$labels = json_encode(array_keys($pontuacao));
$valores = json_encode(array_values($pontuacao));

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultado do Teste</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6fa;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
            color: #4A7BFF;
        }

        p {
            text-align: center;
            font-size: 18px;
            margin: 10px auto;
            max-width: 600px;
        }

        canvas {
            display: block;
            margin: 40px auto;
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        a {
            display: block;
            text-align: center;
            margin: 30px auto;
            background-color: #4A7BFF;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 8px;
            width: fit-content;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #3a65e0;
        }
    </style>
</head>

<body>

    <h2>Seu Resultado</h2>
    <p><strong>Tipo de Personalidade:</strong> <?php echo $resultado; ?></p>
    <p><?php echo $descricao; ?></p>

    <canvas id="graficoPersonalidade" width="300" height="300"></canvas>

    <script>
        const ctx = document.getElementById('graficoPersonalidade').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo $labels; ?>,
                datasets: [{
                    label: 'Pontuação',
                    data: <?php echo $valores; ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 16
                    }
                }
            }
        });
    </script>

    <a href="perfil.php">Voltar</a>

</body>
</html>
