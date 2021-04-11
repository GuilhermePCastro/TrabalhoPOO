<?php 
session_start();
include_once "./../../config/db.php";


// validando usuário
if($_SESSION['usersessao']['idusuario'] == 0){
    header('Location: ./../../pg-login.html');
    exit();
}

// verificando se é uma alteração   
if(isset($_POST['pk_id'])){

    $id = preg_replace('/\D/','', $_POST['pk_id']);
    
    //Objeto de produto
    (__DIR__);
    include_once "./../../classes/produtoClass.php";
    $produto = new Produto();

    //pegando variaveis
    $marca      = intval($_POST['marca']) ?? 0;
    $categoria  = intval($_POST['categoria']) ?? 0;


    //verificando marca
    if($marca == 0){
        header("Location: ./../../produtoalterar.php?id=$id");
        $_SESSION['erro'] = true;
        $_SESSION['msgusu'] = 'Marca não pode está vazia!';
        exit();
        
    }
    
    //verificando categoria
    if($categoria == 0){
        header("Location: ./../../produtoalterar.php?id=$id");
        $_SESSION['erro'] = true;
        $_SESSION['msgusu'] = 'categoria não pode está vazia!';
        exit();
    }

    //alterando no banco
    $return = $produto->alterar($id);

    if($return){

        //grava log
        (__DIR__);
        include './../../functions/gravalog.php';
        $ret = Gravalog(intval($id), 'TB_PRODUTO', 'Alterou', 'Produto alterar');


        header('Location: ./../../produtoconsultar.php');
        $_SESSION['erro'] = false;
        $_SESSION['msgusu'] = 'Registro alterado com sucesso!';
        exit(); 
    }else{
        header('Location: ./../../produtoconsultar.php'); 
        $_SESSION['erro'] = true;
        $_SESSION['msgusu'] = 'Erro ao alterar o cadastro, tente novamente mais tarde!';
        exit();
    }

}else{

    $id = preg_replace('/\D/','', $_GET['id']);
    $query = "SELECT * FROM TB_PRODUTO WHERE PK_SKU = $id";
    $result = $objBanco -> query($query);
    $array = $result -> fetch(PDO::FETCH_ASSOC);

    $queryCT = "SELECT * FROM TB_CATEGORIA";
    $resultCT = $objBanco -> query($queryCT);
    $arrayCT = $resultCT -> fetch(PDO::FETCH_ASSOC);

    $queryMA = "SELECT * FROM TB_MARCA";
    $resultMA = $objBanco -> query($queryMA);
    $arrayMA = $resultMA -> fetch(PDO::FETCH_ASSOC);

    include "../../../web/src/views/produtoalterar.php";
}