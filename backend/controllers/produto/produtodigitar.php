<?php

include_once "./../../config/db.php";

// validando usuário
include "./../../functions/valida_user.php";

//classe de produtos
(__DIR__);
include_once "./../../classes/produtoClass.php";
$produto = new Produto();


//pegando variaveis
$marca      = intval($_POST['marca']) ?? 0;
$categoria  = intval($_POST['categoria']) ?? 0;

//verificando tamanho do código
$result = $produto->tamanhoCodigo($_POST['codigo']);
if($result){
    
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Código tem mais caracter do que o suportado (Máx 15)!';
    header('Location: ../../../web/src/views/register-product.php'); 
    exit();
}

//verificando Código
$result = $produto->validaCodigo($_POST['codigo']);
// se cair aqui, já existe cadastrado
if($result){
    
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Código já cadastrado!';
    header('Location: ../../../web/src/views/register-product.php'); 
    exit();
}

//verificando se tem marca
if($marca == 0){
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Marca não pode está vazia!';
    header('Location: ../../../web/src/views/register-product.php'); 
    exit();
}

//verificando se tem categoria
if($categoria == 0){
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'categoria não pode está vazia!';
    header('Location: ../../../web/src/views/register-product.php'); 
    exit();
}

//incluindo no banco
$return = $produto->incluir();

if($return){

    (__DIR__);
    include './../../functions/gravalog.php';

    // grava log
    $objSmtm = $objBanco -> prepare("SELECT MAX(PK_SKU) AS 'PK_ID' FROM TB_PRODUTO");
    $objSmtm -> execute();
    $result = $objSmtm -> fetch(PDO::FETCH_ASSOC);
    $ret = Gravalog(intval($result['PK_ID']), 'TB_PRODUTO', 'Incluiu', 'Produto incluir');

    $_SESSION['erro'] = false;
    $_SESSION['msgusu'] = 'Registro salvo com sucesso!';
    header('Location: ../../../web/src/views/register-product.php');
    exit(); 
}else{

    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Erro ao salvar cadastro, tente novamente mais tarde!';
    header('Location: ../../../web/src/views/register-product.php');
    exit();
}

