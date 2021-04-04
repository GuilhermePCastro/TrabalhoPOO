<?php 
session_start();
include_once "./config/db.php";

// validando usuário
if($_SESSION['usersessao']['idusuario'] == 0){
    header('Location: ./pg-login.html');
    exit();
}

if($_SESSION['usersessao']['adm'] == 0){
    header('Location: ./usuarioconsultar.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Você não tem permissão para alterar usuários!';
    exit();
}

(__DIR__);
include_once "./classes/usuarioClass.php";
$usuario = new Usuario();


// verificando se é uma alteração   
if(isset($_POST['pk_id'])){

    $id = preg_replace('/\D/','', $_POST['pk_id']);

    
    if($_POST['ds_senha'] != $_POST['ds_senhacon']){

        //montando o registro para alterar
        $array = $usuario->montaRegistro($id);

        //substituindo os valores para continuar com o que foi digitado
        $array['DS_LOGIN']  = $login;
        $array['TG_ADM']    = $adm ;

        //passando para a tela
        $_SESSION['erro'] = true;
        $_SESSION['msgusu'] = 'As senhas não são iguais!';
        include "../web/src/views/usuarioalterar.php";
        exit();
    }

    //verificando login
    $result = $usuario->validaLogin($_POST['ds_login'], $id);
    if($result){
        
        //montando o registro para alterar
        $array = $usuario->montaRegistro($id);

        //substituindo os valores para continuar com o que foi digitado
         $array['DS_LOGIN']  = $login;
         $array['TG_ADM']    = $adm ;
 
        //passando para a tela
        $_SESSION['erro'] = true;
        $_SESSION['msgusu'] = 'Login já cadastrado!';
        include "../web/src/views/usuarioalterar.php";
        
        exit();
    }

    $return = $usuario->alterar($id);
    
    if($return){

        (__DIR__);
        include './functions/gravalog.php';

        $ret = Gravalog(intval($id), 'TS_USUARIO', 'Alterou', 'Usuário alterar');

        header('Location: ./usuarioconsultar.php');
        $_SESSION['erro'] = false;
        $_SESSION['msgusu'] = 'Registro alterado com sucesso!';
        exit(); 
    }else{
        header('Location: ./usuarioconsultar.php'); 
        $_SESSION['erro'] = true;
        $_SESSION['msgusu'] = 'Erro ao alterar o cadastro, tente novamente mais tarde!';
        exit();
    }

}else{

    $id = preg_replace('/\D/','', $_GET['id']);
    $query = "SELECT * FROM TS_USUARIO WHERE PK_ID = $id";
    $result = $objBanco -> query($query);
    $array = $result -> fetch(PDO::FETCH_ASSOC);

    include "../web/src/views/usuarioalterar.php";
}