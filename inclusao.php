<?php

require 'classes/rb-mysql.php';
R::setup('mysql:host=127.0.0.1;dbname=tarefas', 'root', 'aluno');

if (isset($_POST['nome_tarefa']) && !empty(trim($_POST['nome_tarefa']))) {
    $nomeTarefa = trim($_POST['nome_tarefa']);

    $tarefa = R::dispense('tarefa');
    $tarefa->nome = $nomeTarefa;
    $tarefa->concluida = 0;

    R::store($tarefa);
}

header('Location: index.php');
exit;
