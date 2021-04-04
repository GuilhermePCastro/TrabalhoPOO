<?php
include_once "./config/db.php";


// validando usuário
include "./functions/valida_user.php";


(__DIR__);
include_once "./classes/usuarioClass.php";
$usuario = new Usuario();


if($_POST['ds_senha'] != $_POST['ds_senhacon']){
    header('Location: ../web/src/views/usuario.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'As senhas não são iguais!';
    exit();
}

//verificando login
$result = $usuario->validaLogin($_POST['ds_login'], 0);
if($result){
    header('Location: ../web/src/views/usuario.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Login já cadastrado!';
    exit();
}

//verificando email
$result = $usuario->validaEmail($_POST['ds_email']);
if($result){
    header('Location: ../web/src/views/usuario.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'E-mail já cadastrado!';
    exit();
}

$return = $usuario->incluir();

if($return){
    (__DIR__);
    include './functions/gravalog.php';

    // grava log
    $objSmtm = $objBanco -> prepare("SELECT MAX(PK_ID) AS 'PK_ID' FROM TS_USUARIO");
    $objSmtm -> execute();
    $result = $objSmtm -> fetch(PDO::FETCH_ASSOC);

    $ret = Gravalog(intval($result['PK_ID']), 'TS_USUARIO', 'Incluiu', 'Usuário incluir');

    
    header('Location: ../web/src/views/usuario.php');
    $_SESSION['erro'] = false;
    $_SESSION['msgusu'] = 'Registro salvo com sucesso!';
    exit(); 
}else{
    header('Location: ../web/src/views/usuario.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Erro ao salvar cadastro, tente novamente mais tarde!';
    exit();
}

