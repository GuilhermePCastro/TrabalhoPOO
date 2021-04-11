<?php
session_start();
include_once "./../../config/db.php";

$_GET['id'] = $_GET['id'] ?? false;

//Verificando se o usuário tem permissão
if($_SESSION['usersessao']['adm'] == 0){
    header('Location: ./../../usuarioconsultar.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Seu usuário não tem permissão para essa ação!';
    exit();
}

if($_GET['id']){
   
    //Pega o ID
    $id = preg_replace('/\D/','', $_GET['id']);

    //Objeto de cliente
    (__DIR__);
    include_once "./../../classes/clienteClass.php";
    $cliente = new Cliente();

    //Função que deleta no banco
    $result = $cliente->deleta($id);

    // retornando resultado
    if($result !== false){

        //Grava Log
        (__DIR__);
        include './../../functions/gravalog.php';
        $ret = Gravalog(intval($id), 'TB_CLIENTE', 'Deletou', 'Cliente deletar');

        //Retorna o Sucesso
        header('Location: ./../../clienteconsultar.php'); 
        $_SESSION['erro'] = false;
        $_SESSION['msgusu'] = "Cliente $id deletado com sucesso!";
        exit();
    }else{
        //Retorna o erro
        header('Location: ./../../clienteconsultar.php'); 
        $_SESSION['erro'] = true;
        $_SESSION['msgusu'] = 'Erro ao deletar o registro, tente novamente mais tarde!';
        exit();
    }
}else{

    //Retorna o erro
    header('Location: ./../../clienteconsultar.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Erro ao deletar o registro, tente novamente mais tarde!';
    exit();
}