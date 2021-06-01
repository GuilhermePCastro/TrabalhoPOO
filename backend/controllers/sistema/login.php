<?php
session_start();

//Objeto de produto
(__DIR__);
include_once "./../../factorys/factoryLogin.php";
$login = new FactoryLogin();
$login = $login::criaLogin("Normal");


//verificando se o usuário tentou entrar sem credênciais 
if($login->setDados($_POST)){
    header('Location: ../../../web/src/views/pg-login.html');
    exit();
}

//Verificando se voltou login e senha válidos
if($login->validaLogin()){

    //Classe Sessão
    (__DIR__);
    include_once "./../../factorys/factorySessao.php";
    $sessao = new FactorySessao();
    $sessao = $sessao::criaSessao("Login");

    //Setando os dados de Sessão com o retorno do login
    $sessao->setDados($login->getDados());

    //cria sessão
    $sessao->criaSession();

    header('Location: ../../../web/src/views/welcome.php');
    exit();

}else{

    $_SESSION['idusuario'] = 0;
    header('Location: ../../../web/src/views/pg-login.php');
    exit();
    
}
