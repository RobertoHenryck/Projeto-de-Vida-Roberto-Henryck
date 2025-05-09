<?php
session_start();
require 'C:\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\config.php';

if (!isset($_SESSION['usuario_id'])) {
    die("Erro: Usuário não autenticado.");
}

$user_id = $_SESSION['usuario_id'];

$sql = "SELECT id, data FROM teste_inteligencia WHERE user_id = :user_id ORDER BY data DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$testes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$testes) {
    echo "<p>Nenhum teste encontrado.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado do Teste de Inteligências</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4ff;
            color: #333;
            padding: 2rem;
            text-align: center;
        }

        select,
        a,
        h2 {
            margin-top: 1rem;
        }

        canvas#graficoInteligencias {
            width: 100% !important;
            max-width: 600px;
            aspect-ratio: 2 / 1;
            height: auto !important;
            margin: 2rem auto;
            display: block;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 1rem;
        }

        select {
            padding: 0.5rem;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        a {
            display: inline-block;
            margin-top: 2rem;
            text-decoration: none;
            background-color: #4A7BFF;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 6px;
        }
    </style>
</head>

<body>
    <h2>Selecione um teste anterior:</h2>
    <select id="selecionar_teste">
        <option value="">Escolha um teste</option>
        <?php foreach ($testes as $teste): ?>
            <option value="<?= $teste['id'] ?>">Teste de <?= date("d/m/Y H:i", strtotime($teste['data'])) ?></option>
        <?php endforeach; ?>
    </select>

    <canvas id="graficoInteligencias"></canvas>

    <h2 id="resultado_tipo">Tipo de inteligência:</h2>

    <a href="perfil.php">Voltar</a>

    <script>
        const ctx = document.getElementById('graficoInteligencias').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Pontuação',
                    data: [],
                    backgroundColor: '#4A7BFF'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        document.getElementById('selecionar_teste').addEventListener('change', function () {
            const testeId = this.value;
            if (testeId) {
                fetch('encontrar_resultado.php?id=' + testeId)
                    .then(response => response.json())
                    .then(data => {
                        if (data.resultado) {
                            myChart.data.labels = Object.keys(data.resultado);
                            myChart.data.datasets[0].data = Object.values(data.resultado);
                            myChart.update();
                            document.getElementById("resultado_tipo").innerText = "Você é mais: " + data.tipo;
                        }
                    })
                    .catch(error => console.error('Erro ao buscar o teste:', error));
            }
        });
    </script>
</body>

</html>