<?php
session_start();
require_once 'C:\Turma2\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\config.php';
require_once 'C:\Turma2\xampp\htdocs\Projeto-de-Vida---Roberto\MVC\Controller\Controller.php';

$controller = new Controller($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['usuario_id'];

    $fale_sobre_voce = $_POST['fale_sobre_voce'] ?? '';
    $minhas_lembrancas = $_POST['minhas_lembrancas'] ?? '';
    $pontos_fortes = $_POST['pontos_fortes'] ?? '';
    $pontos_fracos = $_POST['pontos_fracos'] ?? '';
    $meus_valores = $_POST['meus_valores'] ?? '';
    $minhas_aptidoes = $_POST['minhas_aptidoes'] ?? '';
    $meus_relacionamentos = $_POST['meus_relacionamentos'] ?? '';
    $o_que_gosto = $_POST['o_que_gosto'] ?? '';
    $o_que_nao_gosto = $_POST['o_que_nao_gosto'] ?? '';
    $rotina_lazer_estudos = $_POST['rotina_lazer_estudos'] ?? '';
    $minha_vida_escolar = $_POST['minha_vida_escolar'] ?? '';
    $visao_fisica = $_POST['visao_fisica'] ?? '';
    $visao_intelectual = $_POST['visao_intelectual'] ?? '';
    $visao_emocional = $_POST['visao_emocional'] ?? '';
    $visao_pessoas_sobre_mim = $_POST['visao_pessoas_sobre_mim'] ?? '';
    $autovalorizacao = $_POST['autovalorizacao'] ?? '';

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

    header('Location: lista_quem_sou.php');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Quem Sou Eu</title>
</head>
<body>
    <h2>Quem Sou Eu?</h2>
    <form action="quem_sou.php" method="POST">
        <label>Fale sobre você:</label>
        <textarea name="fale_sobre_voce"></textarea>

        <label>Minhas Lembranças:</label>
        <textarea name="minhas_lembrancas"></textarea>

        <label>Pontos Fortes:</label>
        <textarea name="pontos_fortes"></textarea>

        <label>Pontos Fracos:</label>
        <textarea name="pontos_fracos"></textarea>

        <label>Meus Valores:</label>
        <input type="text" name="meus_valores">

        <label>Minhas Aptidões:</label>
        <input type="text" name="minhas_aptidoes">

        <label>Meus Relacionamentos:</label>
        <input type="text" name="meus_relacionamentos">

        <label>O que gosto de fazer:</label>
        <input type="text" name="o_que_gosto">

        <label>O que não gosto:</label>
        <input type="text" name="o_que_nao_gosto">

        <label>Rotina, lazer e estudos:</label>
        <input type="text" name="rotina_lazer_estudos">

        <label>Minha Vida Escolar:</label>
        <textarea name="minha_vida_escolar"></textarea>

        <label>Minha Visão Sobre Mim:</label>
        <input type="text" name="visao_fisica" placeholder="Física">
        <input type="text" name="visao_intelectual" placeholder="Intelectual">
        <input type="text" name="visao_emocional" placeholder="Emocional">

        <label>A Visão das Pessoas Sobre Mim:</label>
        <textarea name="visao_pessoas_sobre_mim"></textarea>

        <label>Autovalorização:</label>
        <input type="text" name="autovalorizacao">

        <button type="submit">Salvar</button>
    </form>
</body>
</html>
