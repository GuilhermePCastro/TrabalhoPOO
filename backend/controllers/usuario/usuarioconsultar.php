<?php
include_once "./../../config/db.php";

//Validando sessão
(__DIR__);
include_once "./../../factorys/factorySessao.php";
$sessao = new FactorySessao();
$sessao = $sessao::criaSessao("Login");
$sessao->validaUser();

//Objeto de usuário
(__DIR__);
include_once "./../../factorys/factoryUsuario.php";
$usuario = new FactoryUsuario();
$usuario = $usuario::criaUsuario("Usuario");

// Listar registros
$login   = isset($_GET['ds_login']) ? $_GET['ds_login'] : '0';
$email   = isset($_GET['ds_email']) ? $_GET['ds_email'] : '0';


//Função que traz os registros e mostra na tela
$result = $usuario->consulta($login, $email);
$count = $result;
include "../../../web/src/views/usuario/pg-user.php";


