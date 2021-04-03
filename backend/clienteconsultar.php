<?php
session_start();
include_once "../backend/config/db.php";

// Se não tem sessão, volta para o login
if(!$_SESSION['usersessao']){
    header('Location: ../web/src/views/pg-login.html');
    exit();
}

// Listar registros
$fantasia   = isset($_GET['ds_fantasia']) ? $_GET['ds_fantasia'] : '0';
$cpf        = isset($_GET['nr_cpf']) ? $_GET['nr_cpf'] : '0';


//Objeto de cliente
(__DIR__);
include_once "./classes/clienteClass.php";
$cliente = new Cliente();

//Função que traz os registros e mostra na tela
$cliente->consulta($fantasia, $cpf);


