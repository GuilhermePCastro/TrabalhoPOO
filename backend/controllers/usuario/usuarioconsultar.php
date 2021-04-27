<?php
include_once "./../../config/db.php";

//Valdiando sessão
(__DIR__);
include_once "./../../classes/loginClass.php";
$login = new Login();
$login->validaUser();

(__DIR__);
include_once "./../../classes/usuarioClass.php";
$usuario = new Usuario();

// Listar registros
$login   = isset($_GET['ds_login']) ? $_GET['ds_login'] : '0';
$email   = isset($_GET['ds_email']) ? $_GET['ds_email'] : '0';


//Função que traz os registros e mostra na tela
$result = $usuario->consulta($login, $email);
$count = $result;
include "../../../web/src/views/usuario/pg-user.php";


