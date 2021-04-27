<?php
include_once "./../../config/db.php";

//Valdiando sessão
(__DIR__);
include_once "./../../classes/loginClass.php";
$login = new Login();
$login->validaUser();

// Listar registros
$fantasia   = isset($_GET['ds_fantasia']) ? $_GET['ds_fantasia'] : '0';
$cpf        = isset($_GET['nr_cpf']) ? $_GET['nr_cpf'] : '0';


//Objeto de cliente
(__DIR__);
include_once "./../../classes/clienteClass.php";
$cliente = new Cliente();

//Função que traz os registros e mostra na tela
$result = $cliente->consulta($fantasia, $cpf);
$count = $result;

include "../../../web/src/views/cliente/pg-clientes.php";

