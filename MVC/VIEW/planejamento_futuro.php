<?php
session_start();
require_once 'C:\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\config.php';


if (!isset($_SESSION['usuario_id'])) {
    die("Acesso negado. Faça login para continuar.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['usuario_id'];
    $minhas_aspiracoes = $_POST['minhas_aspiracoes'];
    $meu_sonho_infancia = $_POST['meu_sonho_infancia'];
    $escolha_profissional = $_POST['escolha_profissional'];
    $detalhes_profissao = $_POST['detalhes_profissao'];
    $meus_sonhos = $_POST['meus_sonhos'];
    $o_que_ja_faco = $_POST['o_que_ja_faco'];
    $o_que_preciso_fazer = $_POST['o_que_preciso_fazer'];
    $objetivo_curto_prazo = $_POST['objetivo_curto_prazo'];
    $objetivo_medio_prazo = $_POST['objetivo_medio_prazo'];
    $objetivo_longo_prazo = $_POST['objetivo_longo_prazo'];
    $visao_10_anos = $_POST['visao_10_anos'];

    $sql = "INSERT INTO planejamento_futuro (
                user_id, minhas_aspiracoes, meu_sonho_infancia, escolha_profissional, 
                detalhes_profissao, meus_sonhos, o_que_ja_faco, o_que_preciso_fazer, 
                objetivo_curto_prazo, objetivo_medio_prazo, objetivo_longo_prazo, visao_10_anos
            ) VALUES (
                :user_id, :minhas_aspiracoes, :meu_sonho_infancia, :escolha_profissional, 
                :detalhes_profissao, :meus_sonhos, :o_que_ja_faco, :o_que_preciso_fazer, 
                :objetivo_curto_prazo, :objetivo_medio_prazo, :objetivo_longo_prazo, :visao_10_anos
            )";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':user_id' => $user_id,
        ':minhas_aspiracoes' => $minhas_aspiracoes,
        ':meu_sonho_infancia' => $meu_sonho_infancia,
        ':escolha_profissional' => $escolha_profissional,
        ':detalhes_profissao' => $detalhes_profissao,
        ':meus_sonhos' => $meus_sonhos,
        ':o_que_ja_faco' => $o_que_ja_faco,
        ':o_que_preciso_fazer' => $o_que_preciso_fazer,
        ':objetivo_curto_prazo' => $objetivo_curto_prazo,
        ':objetivo_medio_prazo' => $objetivo_medio_prazo,
        ':objetivo_longo_prazo' => $objetivo_longo_prazo,
        ':visao_10_anos' => $visao_10_anos
    ]);

    header('Location: resultado_planejamento_futuro.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Projeto de Vida</title>
</head>
<body>

    <form method="POST">
        <h1>Projeto de Vida</h1>

        <label>Minhas Aspirações</label>
        <textarea name="minhas_aspiracoes" required></textarea>

        <label>Meu Sonho de Infância</label>
        <textarea name="meu_sonho_infancia" required></textarea>

        <label>Escolha Profissional</label>
        <textarea name="escolha_profissional" required></textarea>

        <label>Detalhes da Profissão</label>
        <textarea name="detalhes_profissao"></textarea>

        <label>Meus Sonhos</label>
        <textarea name="meus_sonhos" required></textarea>

        <label>O que já faço</label>
        <textarea name="o_que_ja_faco" required></textarea>

        <label>O que preciso fazer</label>
        <textarea name="o_que_preciso_fazer" required></textarea>

        <label>Objetivo a Curto Prazo</label>
        <textarea name="objetivo_curto_prazo" required></textarea>

        <label>Objetivo a Médio Prazo</label>
        <textarea name="objetivo_medio_prazo" required></textarea>

        <label>Objetivo a Longo Prazo</label>
        <textarea name="objetivo_longo_prazo" required></textarea>

        <label>Visão para os Próximos 10 Anos</label>
        <textarea name="visao_10_anos" required></textarea>

        <button type="submit">Enviar</button>
    </form>

</body>
</html>
