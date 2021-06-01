<?php

//Objeto de produto
(__DIR__);
include_once "./../../factorys/factoryLogin.php";
$login = FactoryLogin::criaLogin("Normal");

$login->logout();