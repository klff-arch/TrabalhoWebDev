<?php
require 'autentica.php';
exigeLogin();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $tarefa = R::load('tarefa', $_GET['id']);

    if ($tarefa->id && $tarefa->usuario_id == $_SESSION['usuario_id']) {
        R::trash($tarefa);
    }
}

header('Location: index.php');
exit;