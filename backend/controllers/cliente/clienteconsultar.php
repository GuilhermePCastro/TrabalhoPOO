<?php
include_once "./../../config/db.php";

//Validando sessão
(__DIR__);
include_once "./../../factorys/factorySessao.php";
$sessao = FactorySessao::criaSessao("Login");
$sessao->validaUser();

// Listar registros
$fantasia   = isset($_GET['ds_fantasia']) ? $_GET['ds_fantasia'] : '0';
$cpf        = isset($_GET['nr_cpf']) ? $_GET['nr_cpf'] : '0';


//Objeto de cliente
(__DIR__);
include_once "./../../factorys/factoryCliente.php";
$cliente = FactoryCliente::criaCliente("Cliente");

//Função que traz os registros e mostra na tela
$result = $cliente->consulta($fantasia, $cpf);
$count = $result;

include "../../../web/src/views/cliente/pg-clientes.php";

