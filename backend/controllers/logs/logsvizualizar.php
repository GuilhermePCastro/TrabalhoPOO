<?php 
include_once "./../../config/db.php";

//Validando sessão
(__DIR__);
include_once "./../../factorys/factorySessao.php";
$sessao = new FactorySessao();
$sessao = $sessao::criaSessao("Login");
$sessao->validaUser();

(__DIR__);
include_once "./../../classes/logClass.php";
$log = new Log();
 
$id = preg_replace('/\D/','', $_GET['id']);
$array = $log->vizualizar($id);

include "../../../web/src/views/logs/visualize-logs.php";
