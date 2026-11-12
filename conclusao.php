<?php
require 'autentica.php';
exigeLogin();

if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $tarefa = R::load('tarefa', $_POST['id']);

    if ($tarefa->id && $tarefa->usuario_id == $_SESSION['usuario_id']) {
        $tarefa->concluida = $tarefa->concluida ? 0 : 1;
        R::store($tarefa);
    }
}

header('Location: index.php');
exit;