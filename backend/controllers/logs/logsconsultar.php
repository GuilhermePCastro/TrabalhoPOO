<?php
include_once "../../../backend/config/db.php";

//Validando sessão
(__DIR__);
include_once "./../../factorys/factorySessao.php";
$sessao = new FactorySessao();
$sessao = $sessao::criaSessao("Login");
$sessao->validaUser();

//classe de Log
(__DIR__);
include_once "./../../classes/logClass.php";
$log = new Log();

if($_SESSION['usersessao']['adm'] == 0){
    $result = $log->consultaVazia();
    $count = $result;
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Seu usuário não tem permissão para ver logs!';
    include "../../../web/src/views/logs/pg-logs.php";
    exit();
}

// Listar registros
$codigo     = isset($_GET['cod']) ? $_GET['cod'] : '0';
$tabela     = isset($_GET['tabela']) ? $_GET['tabela'] : '0';

//Função que traz os registros e mostra na tela
$result = $log->consulta($codigo, $tabela);
$count = $result;

include "../../../web/src/views/logs/pg-logs.php";


