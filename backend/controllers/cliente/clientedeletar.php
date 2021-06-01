<?php
include_once "./../../config/db.php";

//Validando sessão
(__DIR__);
include_once "./../../factorys/factorySessao.php";
$sessao = new FactorySessao();
$sessao = $sessao::criaSessao("Login");
$sessao->validaUser();

$_GET['id'] = $_GET['id'] ?? false;

//Verificando se o usuário tem permissão
if($_SESSION['usersessao']['adm'] == 0){
    header('Location: ./clienteconsultar.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Seu usuário não tem permissão para essa ação!';
    exit();
}

if($_GET['id']){
   
    //Pega o ID
    $dados['pk_id'] = preg_replace('/\D/','', $_GET['id']);

    //Objeto de cliente
    (__DIR__);
    include_once "./../../factorys/factoryCliente.php";
    $cliente = new FactoryCliente();
    $cliente = $cliente::criaCliente("Cliente");

    $cliente->setDados($dados);

    //Função que deleta no banco
    // retornando resultado
    if($cliente->deleta()){

         //Grava o Log
        //Grava o Log
        (__DIR__);
        include_once "./../../factorys/factoryLog.php";
        $log = new FactoryLog();
        $log = $log::criaLog("LogBanco");
        $ret = $log->Gravalog(intval($dados['pk_id']), 'TB_CLIENTE', 'Deletou', 'Cliente deletar');

        //Retorna o Sucesso
        header('Location: ./clienteconsultar.php'); 
        $_SESSION['erro'] = false;
        $_SESSION['msgusu'] = "Cliente {$dados['pk_id']} deletado com sucesso!";
        exit();
    }else{
        //Retorna o erro
        header('Location: ./clienteconsultar.php'); 
        $_SESSION['erro'] = true;
        $_SESSION['msgusu'] = 'Erro ao deletar o registro, tente novamente mais tarde!';
        exit();
    }
}else{

    //Retorna o erro
    header('Location: ./clienteconsultar.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Erro ao deletar o registro, tente novamente mais tarde!';
    exit();
}