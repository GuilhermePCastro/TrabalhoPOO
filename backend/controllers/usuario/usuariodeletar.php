<?php
include_once "./../../config/db.php";

//Validando sessão
(__DIR__);
include_once "./../../factorys/factorySessao.php";
$sessao = FactorySessao::criaSessao("Login");
$sessao->validaUser();

//Objeto de usuário
(__DIR__);
include_once "./../../factorys/factoryUsuario.php";
$usuario = FactoryUsuario::criaUsuario("Usuario");

$_GET['id'] = $_GET['id'] ?? false;

//  Verificando se tem permissão
if($_SESSION['usersessao']['adm'] == 0){
    header('Location: ./usuarioconsultar.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Seu usuário não tem permissão para essa ação!';
    exit();
}

// Verificando se é o mesmo usuário
if($_SESSION['usersessao']['idusuario'] == $_GET['id']){
    header('Location: ./usuarioconsultar.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Não pode excluir o usuário logado atualmente!';
    exit();
}


if($_GET['id']){
   
    $dados['pk_id'] = preg_replace('/\D/','', $_GET['id']);

    $usuario->setDados($dados);

    // retornando resultado
    if($usuario->deleta()){

        //Grava o Log
        (__DIR__);
        include_once "./../../factorys/factoryLog.php";
        $log = FactoryLog::criaLog("LogBanco");

        $ret = $log->Gravalog(intval($id), 'TS_USUARIO', 'Deletou', 'Usuário deletar');

        header('Location: ./usuarioconsultar.php'); 
        $_SESSION['erro'] = false;
        $_SESSION['msgusu'] = "Usuário $id deletado com sucesso!";
        exit();
    }else{
        header('Location: ./usuarioconsultar.php'); 
        $_SESSION['erro'] = true;
        $_SESSION['msgusu'] = 'Erro ao deletar o registro, tente novamente mais tarde!';
        exit();
    }
}else{

    header('Location: ./usuarioconsultar.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Erro ao deletar o registro, tente novamente mais tarde!';
    exit();
}