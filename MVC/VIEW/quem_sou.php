<?php
session_start();
require_once 'C:\Turma2\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\config.php';
require_once 'C:\Turma2\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\MVC\CONTROLLER\controller.php';

$controller = new Controller($pdo);

$user_id = $_SESSION['usuario_id'];

// Carregar dados do usuário para exibição no formulário (se já existirem)
$dados = $controller->listarQuemSou($user_id);

// Se houver dados, preenche os campos com o que foi salvo anteriormente
$fale_sobre_voce = $dados['fale_sobre_voce'] ?? '';
$minhas_lembrancas = $dados['minhas_lembrancas'] ?? '';
$pontos_fortes = $dados['pontos_fortes'] ?? '';
$pontos_fracos = $dados['pontos_fracos'] ?? '';
$meus_valores = $dados['meus_valores'] ?? '';
$minhas_aptidoes = $dados['minhas_aptidoes'] ?? '';
$meus_relacionamentos = $dados['meus_relacionamentos'] ?? '';
$o_que_gosto = $dados['o_que_gosto'] ?? '';
$o_que_nao_gosto = $dados['o_que_nao_gosto'] ?? '';
$rotina_lazer_estudos = $dados['rotina_lazer_estudos'] ?? '';
$minha_vida_escolar = $dados['minha_vida_escolar'] ?? '';
$visao_fisica = $dados['visao_fisica'] ?? '';
$visao_intelectual = $dados['visao_intelectual'] ?? '';
$visao_emocional = $dados['visao_emocional'] ?? '';
$visao_pessoas_sobre_mim = $dados['visao_pessoas_sobre_mim'] ?? '';
$autovalorizacao = $dados['autovalorizacao'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Processar os dados submetidos pelo formulário
    $fale_sobre_voce = $_POST['fale_sobre_voce'];
    $minhas_lembrancas = $_POST['minhas_lembrancas'];
    $pontos_fortes = $_POST['pontos_fortes'];
    $pontos_fracos = $_POST['pontos_fracos'];
    $meus_valores = $_POST['meus_valores'];
    $minhas_aptidoes = $_POST['minhas_aptidoes'];
    $meus_relacionamentos = $_POST['meus_relacionamentos'];
    $o_que_gosto = $_POST['o_que_gosto'];
    $o_que_nao_gosto = $_POST['o_que_nao_gosto'];
    $rotina_lazer_estudos = $_POST['rotina_lazer_estudos'];
    $minha_vida_escolar = $_POST['minha_vida_escolar'];
    $visao_fisica = $_POST['visao_fisica'];
    $visao_intelectual = $_POST['visao_intelectual'];
    $visao_emocional = $_POST['visao_emocional'];
    $visao_pessoas_sobre_mim = $_POST['visao_pessoas_sobre_mim'];
    $autovalorizacao = $_POST['autovalorizacao'];

    $sucesso = $controller->salvarQuemSou(
        $user_id, $fale_sobre_voce, $minhas_lembrancas, $pontos_fortes, $pontos_fracos, $meus_valores, 
        $minhas_aptidoes, $meus_relacionamentos, $o_que_gosto, $o_que_nao_gosto, $rotina_lazer_estudos, 
        $minha_vida_escolar, $visao_fisica, $visao_intelectual, $visao_emocional, $visao_pessoas_sobre_mim, 
        $autovalorizacao
    );

    if ($sucesso) {
        echo "<script>alert('Dados salvos com sucesso!'); window.location.href = 'quem_sou.php';</script>";
    } else {
        echo "<script>alert('Erro ao salvar os dados!');</script>";
    }

    header('Location: perfil.php');
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Quem Sou Eu</title>
    <link rel="icon" type="image/png" href="../logo para web.png">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #4A7BFF;
            margin-top: 30px;
        }

        form {
            max-width: 800px;
            margin: 30px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        label {
            display: block;
            margin-top: 20px;
            font-weight: bold;
            color: #333;
        }

        textarea,
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            resize: vertical;
            background-color: #fdfdfd;
        }

        input[type="text"]::placeholder {
            color: #999;
        }

        button {
            display: block;
            margin: 30px auto 0;
            padding: 12px 30px;
            background-color: #4A7BFF;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #3a65e0;
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
    <h2>Quem Sou Eu?</h2>
    <form action="quem_sou.php" method="POST">
        <label>Fale sobre você:</label>
        <textarea name="fale_sobre_voce"><?= htmlspecialchars($fale_sobre_voce) ?></textarea>

        <label>Minhas Lembranças:</label>
        <textarea name="minhas_lembrancas"><?= htmlspecialchars($minhas_lembrancas) ?></textarea>

        <label>Pontos Fortes:</label>
        <textarea name="pontos_fortes"><?= htmlspecialchars($pontos_fortes) ?></textarea>

        <label>Pontos Fracos:</label>
        <textarea name="pontos_fracos"><?= htmlspecialchars($pontos_fracos) ?></textarea>

        <label>Meus Valores:</label>
        <input type="text" name="meus_valores" value="<?= htmlspecialchars($meus_valores) ?>">

        <label>Minhas Aptidões:</label>
        <input type="text" name="minhas_aptidoes" value="<?= htmlspecialchars($minhas_aptidoes) ?>">

        <label>Meus Relacionamentos:</label>
        <input type="text" name="meus_relacionamentos" value="<?= htmlspecialchars($meus_relacionamentos) ?>">

        <label>O que gosto de fazer:</label>
        <input type="text" name="o_que_gosto" value="<?= htmlspecialchars($o_que_gosto) ?>">

        <label>O que não gosto:</label>
        <input type="text" name="o_que_nao_gosto" value="<?= htmlspecialchars($o_que_nao_gosto) ?>">

        <label>Rotina, lazer e estudos:</label>
        <input type="text" name="rotina_lazer_estudos" value="<?= htmlspecialchars($rotina_lazer_estudos) ?>">

        <label>Minha Vida Escolar:</label>
        <textarea name="minha_vida_escolar"><?= htmlspecialchars($minha_vida_escolar) ?></textarea>

        <label>Minha Visão Sobre Mim:</label>
        <input type="text" name="visao_fisica" placeholder="Física" value="<?= htmlspecialchars($visao_fisica) ?>">
        <input type="text" name="visao_intelectual" placeholder="Intelectual" value="<?= htmlspecialchars($visao_intelectual) ?>">
        <input type="text" name="visao_emocional" placeholder="Emocional" value="<?= htmlspecialchars($visao_emocional) ?>">

        <label>A Visão das Pessoas Sobre Mim:</label>
        <textarea name="visao_pessoas_sobre_mim"><?= htmlspecialchars($visao_pessoas_sobre_mim) ?></textarea>

        <label>Autovalorização:</label>
        <input type="text" name="autovalorizacao" value="<?= htmlspecialchars($autovalorizacao) ?>">

        <button type="submit">Atualizar</button>
        <div class="links">
            <a href="perfil.php">Voltar</a>
        </div>
    </form>
</body>
</html>
