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

$produto->setDados($_POST);

//verificando tamanho do código
if($produto->tamanhoCodigo()){
    
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Código tem mais caracter do que o suportado (Máx 15)!';
    header('Location: ../../../web/src/views/produto/register-product.php'); 
    exit();
}

//verificando Código
if($produto->validaCodigo()){
    
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Código já cadastrado!';
    header('Location: ../../../web/src/views/produto/register-product.php'); 
    exit();
}

//verificando se tem marca
if(!$produto->verifMarca()){
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Marca não pode está vazia!';
    header('Location: ../../../web/src/views/produto/register-product.php'); 
    exit();
}

//verificando se tem categoria
if(!$produto->verifCategoria()){
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'categoria não pode está vazia!';
    header('Location: ../../../web/src/views/produto/register-product.php'); 
    exit();
}

if($produto->incluir()){

    //Grava o Log
    (__DIR__);
    include_once "./../../factorys/factoryLog.php";
    $log = FactoryLog::criaLog("LogBanco");

    // grava log
    $objSmtm = $objBanco -> prepare("SELECT MAX(PK_SKU) AS 'PK_ID' FROM TB_PRODUTO");
    $objSmtm -> execute();
    $result = $objSmtm -> fetch(PDO::FETCH_ASSOC);
    $ret = $log->Gravalog(intval($result['PK_ID']), 'TB_PRODUTO', 'Incluiu', 'Produto incluir');

    $_SESSION['erro'] = false;
    $_SESSION['msgusu'] = 'Registro salvo com sucesso!';
    header('Location: ../../../web/src/views/produto/register-product.php');
    exit(); 
}else{

    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Erro ao salvar cadastro, tente novamente mais tarde!';
    header('Location: ../../../web/src/views/produto/register-product.php');
    exit();
}

