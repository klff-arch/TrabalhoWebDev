<?php
require 'autentica.php';
exigeLogin();

$userid = $_SESSION['usuario_id'];
$filtro = $_GET['filtro'] ?? 'todas';

if ($filtro === 'concluidas') {
    $tarefas = R::find('tarefa', ' usuario_id = ? AND concluida = 1 ', [$userid]);
} elseif ($filtro === 'nao_concluidas') {
    $tarefas = R::find('tarefa', ' usuario_id = ? AND concluida = 0 ', [$userid]);
} else {
    $tarefas = R::find('tarefa', ' usuario_id = ? ', [$userid]);
}

$total          = R::count('tarefa', ' usuario_id = ? ', [$userid]);
$concluidas     = R::count('tarefa', ' usuario_id = ? AND concluida = 1 ', [$userid]);
$nao_concluidas = R::count('tarefa', ' usuario_id = ? AND concluida = 0 ', [$userid]);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Gestão de Tarefas</title>
</head>

<body>

    <div class="container">
        <div class="banner">
            <p>Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?></p>
            <h1>Seu dia, com mais clareza.</h1>
            <p>Um lugar para organizar suas tarefas e celebrar cada conquista.<br>Adicione, acompanhe e conclua. Uma coisa de cada vez.</p>
        </div>

        <div class="filtros">
            <a href="index.php?filtro=todas" class="aba <?= $filtro === 'todas' ? 'active' : '' ?>">
                Todas <span><?= $total ?></span>
            </a>
            <a href="index.php?filtro=concluidas" class="aba <?= $filtro === 'concluidas' ? 'active' : '' ?>">
                Concluídas <span><?= $concluidas ?></span>
            </a>
            <a href="index.php?filtro=nao_concluidas" class="aba <?= $filtro === 'nao_concluidas' ? 'active' : '' ?>">
                Não concluídas <span><?= $nao_concluidas ?></span>
            </a>
        </div>

        <div class="add-tarefa">
            <form action="inclusao.php" method="POST">
                <input type="text" name="nome_tarefa" placeholder="Escreva o nome de uma nova tarefa" required>
                <button type="submit">+ Adicionar tarefa</button>
            </form>
        </div>

        <div class="lista-tarefas">
            <div class="lista-tarefas-header">
                <div><strong>Suas tarefas</strong> <?= $total ?> atividades</div>
                <div>Uma de cada vez, no seu ritmo.</div>
            </div>

            <?php foreach ($tarefas as $tarefa): ?>
                <div class="item-tarefa <?= $tarefa->concluida ? 'concluida' : '' ?>">
                    <div class="nome-tarefa">
                        <span><?= htmlspecialchars($tarefa->nome) ?></span>
                    </div>
                    <div class="opcoes-tarefa">
                        <form action="conclusao.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $tarefa->id ?>">
                            <button type="submit" class="btn">
                                <?= $tarefa->concluida ? '↩ Desfazer' : '✓ Concluir' ?>
                            </button>
                        </form>

                        <a href="exclusao.php?id=<?= $tarefa->id ?>" class="btn btn-deletar" onclick="return confirm('Deseja realmente excluir esta tarefa?');">🗑️</a>
                    </div>
                </div>
            <?php endforeach; ?>
            
        </div>
        <p><a href="logout.php" class="btn">Sair</a></p>
    </div>
</body>

</html>