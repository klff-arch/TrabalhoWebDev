<?php
require 'autentica.php';
exigeLogin();

if (isset($_POST['nome_tarefa']) && !empty(trim($_POST['nome_tarefa']))) {
    $tarefa = R::dispense('tarefa');
    $tarefa->nome = trim($_POST['nome_tarefa']);
    $tarefa->concluida = 0;
    $tarefa->usuario_id = $_SESSION['usuario_id'];
    R::store($tarefa);
}

header('Location: index.php');
exit;