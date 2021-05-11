<?php
session_start();

//classe Login
(__DIR__);
include_once "./../../classes/loginClass.php";
$login = new Login();


//verificando se o usuário tentou entrar sem credênciais 
if($login->setDados($_POST)){
    header('Location: ../../../web/src/views/pg-login.html');
    exit();
}

//Verificando se voltou login e senha válidos
if($login->validaLogin()){

    //Classe Sessão
    include_once "./../../classes/sessaoClass.php";
    $sessao = new Sessao();

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
