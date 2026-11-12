<?php
require 'autentica.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $senha = $_POST['senha'] ?? '';

    $usuario = R::findOne('usuario', ' email = ? ', [$email]);

    if ($usuario && password_verify($senha, $usuario->senha)) {
        session_regenerate_id(true);
        $_SESSION['usuario_id'] = $usuario->id;
        $_SESSION['usuario_nome'] = $usuario->nome;
        header('Location: index.php');
        exit;
    }

    $erro = 'E-mail ou senha inválidos.';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="banner">
            <h1>Bem-vindo de volta</h1>
        </div>

        <?php if ($erro): ?>
            <p class="erro"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="campo">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="voce@exemplo.com" autocomplete="email" autofocus required>
            </div>
            <div class="campo">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Sua senha" autocomplete="current-password" required>
            </div>
            <button type="submit">Entrar</button>
        </form>

        <p>Não tem conta? <a href="cadastro.php">Cadastre-se</a></p>
    </div>
</body>

</html>