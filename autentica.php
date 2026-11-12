<?php
require 'classes/rb-mysql.php';

if (!R::testConnection()) {
    R::setup('mysql:host=127.0.0.1;dbname=tarefas', 'root', 'aluno');
}

session_start();

function exigeLogin(): void
{
    if (empty($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit;
    }
}