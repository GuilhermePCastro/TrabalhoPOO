<?php
include_once "./../../config/db.php";

//Validando sessão
(__DIR__);
include_once "./../../factorys/factorySessao.php";
$sessao = new FactorySessao();
$sessao = $sessao::criaSessao("Login");
$sessao->validaUser();

$_GET['id'] = $_GET['id'] ?? false;

//Verificando se tem permissão para deletar
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

    //Objeto de produto
    (__DIR__);
    include_once "./../../factorys/factoryProduto.php";
    $produto = new FactoryProduto();
    $produto = $produto::criaProduto("Produto");

    //Setando dados
    $produto->setDados($dados);

    // retornando resultado
    if($produto->deleta()){

        //Grava o Log
        (__DIR__);
        include_once "./../../factorys/factoryLog.php";
        $log = new FactoryLog();
        $log = $log::criaLog("LogBanco");
        $ret = $log->Gravalog(intval($dados['pk_id']), 'TB_PRODUTO', 'Deletou', 'Produto deletar');

        //Redireciona para view com msg
        header('Location: ./produtoconsultar.php'); 
        $_SESSION['erro'] = false;
        $_SESSION['msgusu'] = "Produto {$dados['codigo']} deletado com sucesso!";
        exit();
    }else{

        //Redireciona para view com msg
        header('Location: ./produtoconsultar.php'); 
        $_SESSION['erro'] = true;
        $_SESSION['msgusu'] = 'Erro ao deletar o registro, tente novamente mais tarde!';
        exit();
    }
}else{

    //Redireciona para view com msg
    header('Location: ./produtoconsultar.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Erro ao deletar o registro, tente novamente mais tarde!';
    exit();
}