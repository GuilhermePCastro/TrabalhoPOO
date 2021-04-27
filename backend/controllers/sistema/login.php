<?php
session_start();

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

    //Cria sessão
    $login->criaSession();
    header('Location: ../../../web/src/views/welcome.php');
    exit();

}else{

    $_SESSION['idusuario'] = 0;
    header('Location: ../../../web/src/views/pg-login.php');
    exit();
    
}
