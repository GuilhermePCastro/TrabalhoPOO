<?php
session_start();
include_once "./../../config/db.php";

$_GET['id'] = $_GET['id'] ?? false;

if($_SESSION['usersessao']['adm'] == 0){
    header('Location: ./produtoconsultar.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Seu usuário não tem permissão para essa ação!';
    exit();
}

if($_GET['id']){
   
    //Pega o ID
    $dados['pk_id'] = preg_replace('/\D/','', $_GET['id']);
    $dados['codigo'] = $_GET['cod'] ?? '';

    //Objeto de cliente
    (__DIR__);
    include_once "./../../classes/produtoClass.php";
    $produto = new Produto();

    $produto->setDados($dados);

    // retornando resultado
    if($produto->deleta()){

        (__DIR__);
        include './../../functions/gravalog.php';
        $ret = Gravalog(intval($dados['pk_id']), 'TB_PRODUTO', 'Deletou', 'Produto deletar');

        header('Location: ./produtoconsultar.php'); 
        $_SESSION['erro'] = false;
        $_SESSION['msgusu'] = "Produto {$dados['codigo']} deletado com sucesso!";
        exit();
    }else{
        header('Location: ./produtoconsultar.php'); 
        $_SESSION['erro'] = true;
        $_SESSION['msgusu'] = 'Erro ao deletar o registro, tente novamente mais tarde!';
        exit();
    }
}else{

    header('Location: ./produtoconsultar.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Erro ao deletar o registro, tente novamente mais tarde!';
    exit();
}