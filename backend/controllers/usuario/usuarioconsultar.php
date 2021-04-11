<?php
session_start();
include_once "../../../backend/config/db.php";

// Se não tem sessão, volta para o login
if(!$_SESSION['usersessao']){
    header('Location: ../../../web/src/views/pg-login.html');
    exit();
}

(__DIR__);
include_once "./../../classes/usuarioClass.php";
$usuario = new Usuario();

// Listar registros
$login   = isset($_GET['ds_login']) ? $_GET['ds_login'] : '0';
$email   = isset($_GET['ds_email']) ? $_GET['ds_email'] : '0';


//Função que traz os registros e mostra na tela
$usuario->consulta($login, $email);


