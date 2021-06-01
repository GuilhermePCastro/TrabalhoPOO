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

$usuario->setDados($_POST);

//comparando senha
if(!$usuario->comparaSenha()){
    header('Location: ../../../web/src/views/usuario/usuario.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'As senhas não são iguais!';
    exit();
}

//verificando login
if($usuario->validaLogin()){
    header('Location: ../../../web/src/views/usuario/usuario.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Login já cadastrado!';
    exit();
}

//verificando email
if($usuario->validaEmail()){
    header('Location: ../../../web/src/views/usuario/usuario.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'E-mail já cadastrado!';
    exit();
}

if($usuario->incluir()){

    //Grava o Log
    (__DIR__);
    include_once "./../../factorys/factoryLog.php";
    $log = new FactoryLog();
    $log = $log::criaLog("LogBanco");

    // grava log
    $objSmtm = $objBanco -> prepare("SELECT MAX(PK_ID) AS 'PK_ID' FROM TS_USUARIO");
    $objSmtm -> execute();
    $result = $objSmtm -> fetch(PDO::FETCH_ASSOC);
    $log->Gravalog(intval($result['PK_ID']), 'TS_USUARIO', 'Incluiu', 'Usuário incluir');

    
    header('Location: ../../../web/src/views/usuario/usuario.php');
    $_SESSION['erro'] = false;
    $_SESSION['msgusu'] = 'Registro salvo com sucesso!';
    exit(); 

}else{

    header('Location: ../../../web/src/views/usuario/usuario.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Erro ao salvar cadastro, tente novamente mais tarde!';
    exit();

}

