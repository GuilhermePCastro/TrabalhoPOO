<?php
session_start();
include_once "./../../config/db.php";

// validando usuário
if($_SESSION['usersessao']['idusuario'] == 0){
    header('Location: ./../../pg-login.html');
    exit();
}

//Objeto de cliente
(__DIR__);
include_once "./../../classes/clienteClass.php";
$cliente = new Cliente();

//Validando o CPF/CNPJ
$cpfval = $_POST['cpf'] ?? '';
$result = $cliente->validaCPF($cpfval);
if($result){
    header('Location: ../../../web/src/views/register-client.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'CPF/CPNJ já cadastrado!';
    exit();
}

//Validando digitos de CPF/CNPJ
$result = $cliente->validaDigitoCPF($_POST['pessoa'],$cpfval);
if($_POST['pessoa'] == 'F'){
    if($result){
        header('Location: ../../../web/src/views/register-client.php'); 
        $_SESSION['erro'] = true;
        $_SESSION['msgusu'] = 'Número de dígitos para o tipo de pessoa inválido! (CPF)';
        exit();
    }
}else{
    if($result){
        header('Location: ../../../web/src/views/register-client.php'); 
        $_SESSION['erro'] = true;
        $_SESSION['msgusu'] = 'Número de dígitos para o tipo de pessoa inválido! (CNPJ)';
        exit();
    }
}

//Validando digitos de CEP
$result = $cliente->validaCEP($_POST['cep']);
if($result){
    header('Location: ../../../web/src/views/register-client.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Número de dígitos para o CEP inválido!';
    exit();
}

//Validando E-mail
$result = $cliente->validaEmail($_POST['email']);
if($result){
    header('Location: ../../../web/src/views/register-client.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'E-mail já cadastrado!';
    exit();
}

//Salva no Banco
$return = $cliente->incluir();
if($return){

    (__DIR__);
    include './../../functions/gravalog.php';

    // grava log
    $objSmtm = $objBanco -> prepare("SELECT MAX(PK_ID) AS 'PK_ID' FROM TB_CLIENTE");
    $objSmtm -> execute();
    $result = $objSmtm -> fetch(PDO::FETCH_ASSOC);

    $ret = Gravalog(intval($result['PK_ID']), 'TB_CLIENTE', 'Incluiu', 'Cliente incluir');


    header('Location: ../../../web/src/views/register-client.php');
    $_SESSION['erro'] = false;
    $_SESSION['msgusu'] = 'Registro salvo com sucesso!';
    exit(); 
}else{
    header('Location: ../../../web/src/views/register-client.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Erro ao salvar cadastro, tente novamente mais tarde!';
    exit();
}

