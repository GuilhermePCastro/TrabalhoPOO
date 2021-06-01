<?php

//Objeto de produto
(__DIR__);
include_once "./../../factorys/factoryLogin.php";
$login = new FactoryLogin();
$login = $login::criaLogin("Normal");

$login->logout();