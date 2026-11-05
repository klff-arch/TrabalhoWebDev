<?php

require 'classes/rb-mysql.php';
R::setup('mysql:host=127.0.0.1;dbname=tarefas', 'root', 'aluno');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $tarefa = R::load('tarefa', $id);

    if ($tarefa->id) {
        R::trash($tarefa);
    }
}

header('Location: index.php');
exit;
