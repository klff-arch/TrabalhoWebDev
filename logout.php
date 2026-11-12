<?php
require 'autentica.php';

$_SESSION = [];
session_destroy();

header('Location: login.php');
exit;