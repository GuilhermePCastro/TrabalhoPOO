<?php 
include_once "./../../config/db.php";

//Validando sessão
(__DIR__);
include_once "./../../factorys/factorySessao.php";
$sessao = FactorySessao::criaSessao("Login");
$sessao->validaUser();

//Objeto de produto
(__DIR__);
include_once "./../../factorys/factoryProduto.php";
$produto = FactoryProduto::criaProduto("Produto");


// verificando se é uma alteração   
if(isset($_POST['pk_id'])){

    $_POST['pk_id'] = preg_replace('/\D/','', $_POST['pk_id']);

    //setando dados
    $produto->setDados($_POST);


    //verificando marca
    if(!$produto->verifMarca()){
        header("Location: ./../../controllers/produto/produtoalterar.php?id=$id");
        $_SESSION['erro'] = true;
        $_SESSION['msgusu'] = 'Marca não pode está vazia!';
        exit();
        
    }
    
    //verificando categoria
    if(!$produto->verifCategoria()){
        header("Location: ./../../controllers/produto/produtoalterar.php?id=$id");
        $_SESSION['erro'] = true;
        $_SESSION['msgusu'] = 'categoria não pode está vazia!';
        exit();
    }

    if($produto->alterar()){

        //Grava o Log
        (__DIR__);
        include_once "./../../factorys/factoryLog.php";
        $log = FactoryLog::criaLog("LogBanco");

        $ret = $log->Gravalog(intval($_POST['pk_id']), 'TB_PRODUTO', 'Alterou', 'Produto alterar');


        header('Location: ./../../controllers/produto/produtoconsultar.php');
        $_SESSION['erro'] = false;
        $_SESSION['msgusu'] = 'Registro alterado com sucesso!';
        exit(); 

    }else{
        
        header('Location: ./../../controllers/produto/produtoconsultar.php'); 
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

    include "../../../web/src/views/produto/produtoalterar.php";
}