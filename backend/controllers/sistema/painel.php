<?php
session_start();


//Validando sessão
(__DIR__);
include_once "./../../factorys/factorySessao.php";
$sessao = FactorySessao::criaSessao("Login");
$sessao->validaUser();

echo 'Olá '. $_SESSION['usersessao']['usuario'];

?>

<a href='./../../functions/logout.php'>Sair</a>