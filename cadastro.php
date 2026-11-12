<?php
require 'autentica.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome  = trim($_POST['nome'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $senha = $_POST['senha'] ?? '';

    if ($nome === '') {
        $erro = 'Preencha o seu nome.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'Informe um endereço de e-mail válido (ex: nome@dominio.com).';
    } elseif (mb_strlen($senha, 'UTF-8') < 6) {
        $erro = 'A senha deve ter ao menos 6 caracteres.';
    } elseif (R::findOne('usuario', ' email = ? ', [$email])) {
        $erro = 'Este e-mail já está cadastrado.';
    } else {
        $usuario = R::dispense('usuario');
        $usuario->nome  = $nome;
        $usuario->email = $email;
        $usuario->senha = password_hash($senha, PASSWORD_DEFAULT);
        R::store($usuario);

        session_regenerate_id(true);
        $_SESSION['usuario_id'] = $usuario->id;
        $_SESSION['usuario_nome'] = $usuario->nome;

        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Cadastro</title>
</head>

<body>
    <div class="container">
        <div class="banner">
            <h1>Crie sua conta</h1>
        </div>

        <?php if ($erro): ?>
            <p class="erro"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="campo">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" placeholder="Seu nome" autocomplete="name" autofocus required>
            </div>
            <div class="campo">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="voce@exemplo.com" autocomplete="email" required>
            </div>
            <div class="campo">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Mínimo de 6 caracteres" autocomplete="new-password" minlength="6" required>
            </div>
            <button type="submit">Criar conta</button>
        </form>

        <p>Já possui uma conta? <a href="login.php">Entrar</a></p>
    </div>
</body>

</html>