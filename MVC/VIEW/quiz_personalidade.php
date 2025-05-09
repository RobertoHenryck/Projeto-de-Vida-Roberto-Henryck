<?php
session_start();
require_once 'C:\Turma2\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\config.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    die("Acesso negado. Faça login para continuar.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['usuario_id'];

    // Respostas das questões
    $respostas = [
        $_POST['q1'],
        $_POST['q2'],
        $_POST['q3'],
        $_POST['q4'],
        $_POST['q5'],
        $_POST['q6'],
        $_POST['q7'],
        $_POST['q8'],
        $_POST['q9'],
        $_POST['q10'],
        $_POST['q11'],
        $_POST['q12'],
        $_POST['q13'],
        $_POST['q14'],
        $_POST['q15'],
        $_POST['q16']
    ];

    // Contagem de respostas para cada tipo
    $pontuacao = array_count_values($respostas);

    // Lógica para determinar o tipo de personalidade com base nas respostas
    if (($pontuacao['A'] ?? 0) >= 10) {
        $resultado = "Líder Visionário";
    } elseif (($pontuacao['B'] ?? 0) >= 10) {
        $resultado = "Analítico e Prático";
    } elseif (($pontuacao['C'] ?? 0) >= 10) {
        $resultado = "Criativo e Comunicativo";
    } elseif (($pontuacao['D'] ?? 0) >= 10) {
        $resultado = "Equilibrado e Adaptável";
    } else {
        $resultado = "Perfil não identificado";
    }

    // Inserir resultados no banco
    $sql = "INSERT INTO teste_personalidade (user_id, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, q13, q14, q15, q16, resultado, data) 
            VALUES (:user_id, :q1, :q2, :q3, :q4, :q5, :q6, :q7, :q8, :q9, :q10, :q11, :q12, :q13, :q14, :q15, :q16, :resultado, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':user_id' => $user_id,
        ':q1' => $respostas[0],
        ':q2' => $respostas[1],
        ':q3' => $respostas[2],
        ':q4' => $respostas[3],
        ':q5' => $respostas[4],
        ':q6' => $respostas[5],
        ':q7' => $respostas[6],
        ':q8' => $respostas[7],
        ':q9' => $respostas[8],
        ':q10' => $respostas[9],
        ':q11' => $respostas[10],
        ':q12' => $respostas[11],
        ':q13' => $respostas[12],
        ':q14' => $respostas[13],
        ':q15' => $respostas[14],
        ':q16' => $respostas[15],
        ':resultado' => $resultado
    ]);

    header("Location: resultado_personalidade.php?tipo=" . urlencode($resultado));
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../logo para web.png">
    <title>Teste de Personalidade</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
            color: #2c3e50;
        }

        form {
            max-width: 800px;
            margin: 30px auto;
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        p {
            font-weight: 600;
            margin: 20px 0 10px;
        }

        input[type="radio"] {
            margin-right: 8px;
            transform: scale(1.2);
        }

        label {
            display: block;
            margin: 5px 0;
            cursor: pointer;
        }

        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #4A7BFF;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 30px;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #3A65E0;
        }

        .links {
            display: flex;
            justify-content: center;
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

        @media (max-width: 600px) {
            form {
                padding: 20px;
            }
        }
    </style>


</head>

<body>

    <h2>Teste de Personalidade</h2>
    <form method="POST">
        <?php
        $perguntas = [
            "Você prefere trabalhar em equipe ou sozinho?",
            "Como você se sente diante de mudanças inesperadas?",
            "Você costuma tomar decisões rapidamente ou prefere pensar um pouco mais?",
            "Como você lida com conflitos entre amigos ou colegas?",
            "Você prefere um ambiente de trabalho mais organizado ou criativo?",
            "Quando você enfrenta um desafio, qual é sua abordagem principal?",
            "Você acha que é mais focado no presente ou no futuro?",
            "Você tende a seguir as regras ou prefere encontrar seu próprio caminho?",
            "Quando precisa tomar uma decisão importante, você se baseia em dados ou intuição?",
            "Como você lida com situações de alta pressão?",
            "Você prefere atividades individuais ou coletivas?",
            "Em uma situação de conflito, você prefere resolver de forma racional ou emocional?",
            "Você costuma ser mais introvertido ou extrovertido?",
            "Quando se depara com um problema, você é mais analítico ou criativo?",
            "Você costuma planejar as coisas com antecedência ou prefere improvisar?",
            "Você se considera uma pessoa mais prática ou idealista?"
        ];

        // Opções de respostas para cada pergunta
        $opcoes = [
            ["A - Sozinho", "B - Em equipe", "C - Ambas as opções", "D - Depende da situação"],
            ["A - Fico ansioso", "B - Vejo como oportunidade", "C - Tiro de letra", "D - Tento me adaptar o máximo possível"],
            ["A - Tomo uma decisão rápida", "B - Prefiro refletir mais", "C - Depende da situação", "D - Faço uma pesquisa"],
            ["A - Evito o conflito", "B - Tento resolver diretamente", "C - Depende da situação", "D - Peço ajuda de um mediador"],
            ["A - Organizado", "B - Criativo", "C - Um pouco de ambos", "D - Depende da tarefa"],
            ["A - Enfrento com lógica", "B - Enfrento com criatividade", "C - Enfrento com empatia", "D - Busco apoio de outros"],
            ["A - Presente", "B - Futuro", "C - Ambos, mas com foco no presente", "D - Planejo para o futuro, mas me preocupo com o presente"],
            ["A - Sigo regras", "B - Crio meu próprio caminho", "C - Tento seguir regras, mas faço exceções", "D - Avalio caso a caso"],
            ["A - Dados", "B - Intuição", "C - Consulto especialistas", "D - Avalio os prós e contras de cada opção"],
            ["A - Com calma e raciocínio", "B - Com ações rápidas", "C - Tento manter a calma e sou ponderado", "D - Fico nervoso, mas faço o que é necessário"],
            ["A - Individuais", "B - Coletivas", "C - Depende da atividade", "D - Não tenho preferência"],
            ["A - Racionalmente", "B - Com empatia", "C - Analiso e depois ajo", "D - Tiro conclusões baseadas nas pessoas envolvidas"],
            ["A - Introvertido", "B - Extrovertido", "C - Depende da situação", "D - Sou tanto introvertido quanto extrovertido"],
            ["A - Analítico", "B - Criativo", "C - Uso ambos os lados", "D - Depende do tipo de problema"],
            ["A - Planejo", "B - Improviso", "C - Planejo, mas também gosto de ser espontâneo", "D - Faço o que acho mais necessário"],
            ["A - Prático", "B - Idealista", "C - Realista", "D - Depende da situação"]
        ];

        // Exibe as perguntas e opções de resposta
        for ($i = 0; $i < 16; $i++) {
            echo "<p>" . ($i + 1) . ". " . $perguntas[$i] . "</p>";
            foreach ($opcoes[$i] as $opcao) {
                echo "<input type='radio' name='q" . ($i + 1) . "' value='" . substr($opcao, 0, 1) . "' required> $opcao <br>";
            }
        }
        ?>
        <button type="submit">Enviar Respostas</button>
        <div class="links">
            <a href="perfil.php">Voltar</a>
        </div>
    </form>

</body>

</html>