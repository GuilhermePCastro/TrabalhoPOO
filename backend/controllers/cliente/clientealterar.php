<?php 
session_start();
include_once "./../../config/db.php";

// validando usuário
if($_SESSION['usersessao']['idusuario'] == 0){
    header('Location: ./pg-login.html') ;
    exit();
}


// verificando se é uma alteração   
if(isset($_POST['pk_id'])){
    
    //pegando o ID
    $id = preg_replace('/\D/','', $_POST['pk_id']);

    //Objeto de cliente
    (__DIR__);
    include_once "./../../classes/clienteClass.php";
    $cliente = new Cliente();

    //Valida o tamanho do CEP
    $result = $cliente->validaCEP($_POST['cep']);
    if($result){
        header("Location: ./clientealterar.php?id=$id");
        $_SESSION['erro'] = true;
        $_SESSION['msgusu'] = 'Número de dígitos para o CEP inválido!';
        exit();
    }
    
    //Grava a alteração no banco
    $return = $cliente->alterar($id);
    if($return){

        //Grava o Log
        (__DIR__);
        include './../../functions/gravalog.php';
        $ret = Gravalog(intval($id), 'TB_CLIENTE', 'Alterou', 'Cliente alterar');

        //Retorna o sucesso
        header('Location: ./clienteconsultar.php');
        $_SESSION['erro'] = false;
        $_SESSION['msgusu'] = 'Registro alterado com sucesso!';
        exit(); 
        
    }else{

        //Se der erro, retorna o erro
        header('Location: ./clienteconsultar.php'); 
        $_SESSION['erro'] = true;
        $_SESSION['msgusu'] = 'Erro ao alterar o cadastro, tente novamente mais tarde!';
        exit();
    }

}else{

    //Montando a alteração
    $id = preg_replace('/\D/','', $_GET['id']);
    $query = "SELECT * FROM TB_CLIENTE WHERE PK_ID = $id";
    $result = $objBanco -> query($query);
    $array = $result -> fetch(PDO::FETCH_ASSOC);

    $queryES = "SELECT * FROM TB_ESTADO";
    $resultES = $objBanco -> query($queryES);
    $arrayES = $resultES -> fetch(PDO::FETCH_ASSOC);

    include "../../../web/src/views/cliente/clientealterar.php";
}