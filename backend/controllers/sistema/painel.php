<?php
session_start();

/*
if($_SESSION['idusuario'] == 0){
    header('Location: ../../../web/src/views/pg-login.html');
    exit();
}

include "./../../functions/valida_user.php";
*/

//Validando sessão
(__DIR__);
include_once "./../../factorys/factorySessao.php";
$sessao = new FactorySessao();
$sessao = $sessao::criaSessao("Login");
$sessao->validaUser();

echo 'Olá '. $_SESSION['usersessao']['usuario'];

?>

<a href='./../../functions/logout.php'>Sair</a>