<?php 
include_once "./../../config/db.php";

//Validando sessão
(__DIR__);
include_once "./../../factorys/factorySessao.php";
$sessao = FactorySessao::criaSessao("Login");
$sessao->validaUser();

//Grava o Log
(__DIR__);
include_once "./../../factorys/factoryLog.php";
$log = FactoryLog::criaLog("LogBanco");
 
$id = preg_replace('/\D/','', $_GET['id']);
$array = $log->vizualizar($id);

include "../../../web/src/views/logs/visualize-logs.php";
