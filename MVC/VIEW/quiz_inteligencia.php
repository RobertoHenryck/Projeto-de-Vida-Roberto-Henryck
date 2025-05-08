<?php
session_start();

require_once 'C:\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\config.php';

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
<head>
    <meta charset="UTF-8">
    <title>Teste de Múltiplas Inteligências</title>
</head>
<body>

<h2>Teste de Múltiplas Inteligências</h2>
<form method="POST">

<?php
$perguntas = [
    // Musical
    "Eu consigo identificar melodias e ritmos facilmente.",
    "Eu sou capaz de aprender novas músicas ou canções rapidamente.",

    // Lógico-Matemática
    "Eu gosto de resolver quebra-cabeças e problemas de lógica.",
    "Eu consigo perceber padrões em dados ou números rapidamente.",

    // Corporal-Cinestésica
    "Eu me sinto mais confortável quando estou em movimento.",
    "Eu tenho facilidade para aprender novas habilidades físicas ou esportivas.",

    // Linguística
    "Eu sou bom em me expressar de forma clara, seja falando ou escrevendo.",
    "Eu gosto de escrever ou criar histórias, poesias ou textos criativos.",

    // Interpessoal
    "Eu me dou bem trabalhando em equipe e gosto de ajudar os outros.",
    "Eu sou bom em perceber as necessidades e sentimentos dos outros.",

    // Intrapessoal
    "Eu frequentemente reflito sobre minhas próprias emoções e ações.",
    "Eu sei reconhecer meus pontos fortes e áreas em que preciso melhorar.",

    // Naturalista
    "Eu me interesso por estudar plantas, animais ou o meio ambiente.",
    "Eu gosto de observar a natureza e aprender como ela funciona.",

    // Emocional
    "Eu sou bom em reconhecer as emoções que estou sentindo em momentos de estresse.",
    "Eu consigo lidar com situações emocionais intensas sem perder o controle."
];

$opcoes = [
    "A" => "Concordo",
    "B" => "Discordo"
];

foreach ($perguntas as $index => $pergunta) {
    echo "<p>" . ($index + 1) . ". " . $pergunta . "</p>";  
    foreach ($opcoes as $key => $value) {
        echo "<input type='radio' name='q" . ($index + 1) . "' value='$key' required> $value ";
    }
    echo "<br><br>";
}
?>

<br>
<button type="submit">Enviar</button>
</form>

</body>
</html>
