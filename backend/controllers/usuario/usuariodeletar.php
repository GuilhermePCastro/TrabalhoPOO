<?php
session_start();
include_once "./../../config/db.php";

(__DIR__);
include_once "./../../classes/usuarioClass.php";
$usuario = new Usuario();

$_GET['id'] = $_GET['id'] ?? false;

if($_SESSION['usersessao']['adm'] == 0){
    header('Location: ./../../usuarioconsultar.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Seu usuário não tem permissão para essa ação!';
    exit();
}

if($_SESSION['usersessao']['idusuario'] == $_GET['id']){
    header('Location: ./../../usuarioconsultar.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Não pode excluir o usuário logado atualmente!';
    exit();
}


if($_GET['id']){
   
    $id = preg_replace('/\D/','', $_GET['id']);

    $result = $usuario->deletar($id);

    // retornando resultado
    if($result !== false){

        (__DIR__);
        include './../../functions/gravalog.php';

        $ret = Gravalog(intval($id), 'TS_USUARIO', 'Deletou', 'Usuário deletar');

        header('Location: ./../../usuarioconsultar.php'); 
        $_SESSION['erro'] = false;
        $_SESSION['msgusu'] = "Usuário $id deletado com sucesso!";
        exit();
    }else{
        header('Location: ./../../usuarioconsultar.php'); 
        $_SESSION['erro'] = true;
        $_SESSION['msgusu'] = 'Erro ao deletar o registro, tente novamente mais tarde!';
        exit();
    }
}else{

    header('Location: ./../../usuarioconsultar.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Erro ao deletar o registro, tente novamente mais tarde!';
    exit();
}