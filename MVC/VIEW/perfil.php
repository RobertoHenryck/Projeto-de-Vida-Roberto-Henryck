<?php
session_start();

require_once 'C:\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\config.php';

if (!isset($_SESSION['usuario_id'])) {
    die("Erro: Usuário não autenticado.");
}

$usuario_id = $_SESSION['usuario_id'];

$sql = "SELECT nome, foto_perfil, sobre_mim FROM users WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $usuario_id);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

$foto_perfil = !empty($usuario['foto_perfil']) ? 'users/' . $usuario['foto_perfil'] : 'users/foto_padrao.png';
$sobre_mim_atual = $usuario['sobre_mim'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Perfil do Usuário</title>
</head>
<body>

    <header>
        <h1>Perfil</h1>
        <div>
            <form action="sair.php" method="POST">
                <button type="submit">Sair</button>
            </form>
        </div>
    </header>

    <main>
        <div>
            <h1><?= htmlspecialchars($usuario['nome']) ?></h1>
            <img src="<?= htmlspecialchars($foto_perfil) ?>" alt="Foto de Perfil" width="150" height="150"><br><br>

            <!-- FORMULÁRIO DE FOTO COM METHOD E ACTION -->
            <form id="formFoto" action="atualizar_foto.php" method="POST" enctype="multipart/form-data">
                <input type="file" id="arquivo" name="arquivo" accept="image/*" required>
                <label for="arquivo">Escolher arquivo</label><br><br>
                <button type="submit">Atualizar Foto</button>
            </form>
        </div>


        <div>
            <h2>Sobre você</h2>
            <?= nl2br(htmlspecialchars($sobre_mim_atual ?: 'Você ainda não escreveu nada sobre si mesmo.')) ?>
        </div>
    </main>

    <script>
        const formFoto = document.getElementById('formFoto');

        formFoto.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(formFoto);

            fetch('upload_foto.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                console.log(data); // Para depuração
                if (data.status === 'sucesso') {
                    const novaFoto = 'users/' + data.arquivo;
                    document.querySelector('img').src = novaFoto + '?t=' + new Date().getTime();
                } else {
                    alert(data.mensagem);
                }
            })
            .catch(() => {
                alert('Erro ao enviar a foto.');
            });
        });
    </script>
</body>
</html>
