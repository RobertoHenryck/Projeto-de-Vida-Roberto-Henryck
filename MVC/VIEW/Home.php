<?php
session_start();
require_once 'C:\Turma2\xampp\htdocs\Projeto-de-Vida-Roberto-Henryck\config.php';

if (!isset($_SESSION['usuario_nome'])) {
    header('Location: index.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT nome, foto_perfil, data_nascimento FROM users WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $usuario_id);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

$foto_perfil = !empty($usuario['foto_perfil']) ? 'users/' . $usuario['foto_perfil'] : 'users/foto_padrao.png';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Principal</title>
</head>

<body>

    <header>
        <h1>Bem-vindo, <?php echo htmlspecialchars($usuario['nome']); ?>!</h1>
        <div>
            <a href="perfil.php">
                <img src="<?php echo htmlspecialchars($foto_perfil); ?>" alt="Foto de Perfil">
            </a>

            <form action="sair.php" method="POST">
                <button type="submit">Sair</button>
            </form>
        </div>
    </header>

 

    <footer>
        <p>&copy; 2025 Todos os direitos reservados.</p>
    </footer>

</body>

</html>
