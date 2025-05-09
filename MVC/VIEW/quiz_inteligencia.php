<?php
session_start();

require_once 'C:\Turma2\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\config.php';

if (!isset($_SESSION['usuario_id'])) {
    die("Acesso negado. Faça login para continuar.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['usuario_id'];
    $respostas = [];
    for ($i = 1; $i <= 16; $i++) {
        $respostas[$i] = $_POST["q$i"] ?? "N";
    }

    $mapa_inteligencias = [
        1 => "musical", 2 => "musical", 3 => "logico", 4 => "logico",
        5 => "corporal", 6 => "corporal", 7 => "linguistica", 8 => "linguistica",
        9 => "interpessoal", 10 => "interpessoal", 11 => "intrapessoal", 12 => "intrapessoal",
        13 => "naturalista", 14 => "naturalista", 15 => "emocional", 16 => "emocional"
    ];

    $pontuacoes = array_fill_keys(array_unique(array_values($mapa_inteligencias)), 0);

    foreach ($respostas as $num => $resposta) {
        if ($resposta === 'A') {
            $tipo = $mapa_inteligencias[$num];
            $pontuacoes[$tipo]++;
        }
    }

    $resultado_json = json_encode($pontuacoes);

    $sql = "INSERT INTO teste_inteligencia (user_id, " . 
        implode(",", array_map(fn($i) => "q$i", range(1, 16))) . 
        ", resultado) VALUES (:user_id, " . 
        implode(",", array_map(fn($i) => ":q$i", range(1, 16))) . 
        ", :resultado)";

    $stmt = $pdo->prepare($sql);
    $params = [':user_id' => $user_id, ':resultado' => $resultado_json];
    for ($i = 1; $i <= 16; $i++) {
        $params[":q$i"] = $respostas[$i];
    }

    $stmt->execute($params);
    $last_id = $pdo->lastInsertId();
    header("Location: resultado_inteligencias.php?id=$last_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<link rel="icon" type="image/png" href="../logo para web.png">
<head>
    <meta charset="UTF-8">
    <title>Teste de Múltiplas Inteligências</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }

        .pergunta {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .pergunta p {
            font-weight: 500;
            color: #333;
        }

        label {
            margin-right: 20px;
            cursor: pointer;
        }

        input[type="radio"] {
            margin-right: 6px;
        }

        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 14px;
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
            background-color: #365ee6;
        }

        @media (max-width: 600px) {
            .container {
                margin: 20px;
                padding: 20px;
            }

            label {
                display: block;
                margin: 8px 0;
            }
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
    </style>
</head>
<body>

<div class="container">
    <h2>Teste de Múltiplas Inteligências</h2>
    <form method="POST">
        <?php
        $perguntas = [
            "Eu consigo identificar melodias e ritmos facilmente.",
            "Eu sou capaz de aprender novas músicas ou canções rapidamente.",
            "Eu gosto de resolver quebra-cabeças e problemas de lógica.",
            "Eu consigo perceber padrões em dados ou números rapidamente.",
            "Eu me sinto mais confortável quando estou em movimento.",
            "Eu tenho facilidade para aprender novas habilidades físicas ou esportivas.",
            "Eu sou bom em me expressar de forma clara, seja falando ou escrevendo.",
            "Eu gosto de escrever ou criar histórias, poesias ou textos criativos.",
            "Eu me dou bem trabalhando em equipe e gosto de ajudar os outros.",
            "Eu sou bom em perceber as necessidades e sentimentos dos outros.",
            "Eu frequentemente reflito sobre minhas próprias emoções e ações.",
            "Eu sei reconhecer meus pontos fortes e áreas em que preciso melhorar.",
            "Eu me interesso por estudar plantas, animais ou o meio ambiente.",
            "Eu gosto de observar a natureza e aprender como ela funciona.",
            "Eu sou bom em reconhecer as emoções que estou sentindo em momentos de estresse.",
            "Eu consigo lidar com situações emocionais intensas sem perder o controle."
        ];

        $opcoes = [
            "A" => "Concordo",
            "B" => "Discordo"
        ];

        foreach ($perguntas as $index => $pergunta) {
            echo "<div class='pergunta'>";
            echo "<p>" . ($index + 1) . ". $pergunta</p>";
            foreach ($opcoes as $key => $label) {
                echo "<label><input type='radio' name='q" . ($index + 1) . "' value='$key' required> $label</label>";
            }
            echo "</div>";
        }
        ?>
        <button type="submit">Enviar</button>
        <div class="links">
            <a href="perfil.php">Voltar</a>
        </div>
    </form>
</div>

</body>
</html>
