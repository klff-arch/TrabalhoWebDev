<?php
require 'classes/rb-mysql.php';

if (!R::testConnection()) {
    R::setup('mysql:host=sql303.infinityfree.com;dbname=if0_43060985_Tarefas', 'if0_43060985', '8DazyVnQVDLVhM');
}

session_start();

function exigeLogin(): void
{
    if (empty($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit;
    }
}