<?php
session_start();

/*
if($_SESSION['idusuario'] == 0){
    header('Location: ../../../web/src/views/pg-login.html');
    exit();
}

include "./../../functions/valida_user.php";
*/

include_once "./../../classes/sessaoClass.php";
$sessao = new Sessao();
$sessao->validaUser();

echo 'Olá '. $_SESSION['usersessao']['usuario'];

?>

<a href='./../../functions/logout.php'>Sair</a>