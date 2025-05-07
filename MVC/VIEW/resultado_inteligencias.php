<?php
session_start();
require 'C:\Turma2\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\config.php';

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
        #graficoInteligencias {
            width: 300px;
            height: 200px;
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

    <script>
        let ctx = document.getElementById('graficoInteligencias').getContext('2d');
        let myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Pontuação',
                    data: [],
                    backgroundColor: 'rgba(75, 192, 192, 0.6)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: { beginAtZero: true }
                },
                animation: {
                    duration: 500,
                    easing: 'easeInOutQuad'
                }
            }
        });

        document.getElementById('selecionar_teste').addEventListener('change', function() {
            let testeId = this.value;
            if (testeId) {
                fetch('encontrar_resultado.php?id=' + testeId)
                    .then(response => response.json())
                    .then(data => {
                        if (data.resultado) {
                            // Atualiza os dados do gráfico
                            myChart.data.labels = Object.keys(data.resultado);
                            myChart.data.datasets[0].data = Object.values(data.resultado);

                            // Força o gráfico a ser atualizado
                            myChart.update();

                            // Exibe o tipo de inteligência
                            document.getElementById("resultado_tipo").innerText = "Você é mais: " + data.tipo;
                        }
                    })
                    .catch(error => console.error('Erro ao buscar o teste:', error));
            }
        });
    </script>

    <h2 id="resultado_tipo">Tipo de inteligência:</h2>
    <a href="perfil.php">Voltar</a>
</body>
</html>
