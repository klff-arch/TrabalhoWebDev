<?php

require 'classes/rb-mysql.php';
R::setup('mysql:host=127.0.0.1;dbname=tarefas', 'root', 'aluno');

if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];
    $tarefa = R::load('tarefa', $id);

    if ($tarefa->id) {
        $tarefa->concluida = $tarefa->concluida ? 0 : 1;
        R::store($tarefa);
    }
}

header('Location: index.php');
exit;
