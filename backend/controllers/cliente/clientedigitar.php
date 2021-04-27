<?php
include_once "./../../config/db.php";

//Valdiando sessão
(__DIR__);
include_once "./../../classes/loginClass.php";
$login = new Login();
$login->validaUser();

//Objeto de cliente
(__DIR__);
include_once "./../../classes/clienteClass.php";
$cliente = new Cliente();

//setando os dados do cliente
$cliente->setDados($_POST);

if($cliente->validaCPF()){
    header('Location: ../../../web/src/views/cliente/register-client.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'CPF/CPNJ já cadastrado!';
    exit();
}

//Validando digitos de CPF/CNPJ
if($cliente->validaDigitoCPF()){
    header('Location: ../../../web/src/views/cliente/register-client.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Número de dígitos para o tipo de pessoa inválido!';
    exit();
}

//Validando digitos de CEP
if($cliente->validaCEP()){
    header('Location: ../../../web/src/views/cliente/register-client.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Número de dígitos para o CEP inválido!';
    exit();
}

//Validando E-mail
if($cliente->validaEmail()){
    header('Location: ../../../web/src/views/cliente/register-client.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'E-mail já cadastrado!';
    exit();
}

//Salva no Banco
if($cliente->incluir()){

    (__DIR__);
    include './../../functions/gravalog.php';

    // grava log
    $objSmtm = $objBanco -> prepare("SELECT MAX(PK_ID) AS 'PK_ID' FROM TB_CLIENTE");
    $objSmtm -> execute();
    $result = $objSmtm -> fetch(PDO::FETCH_ASSOC);

    Gravalog(intval($result['PK_ID']), 'TB_CLIENTE', 'Incluiu', 'Cliente incluir');


    header('Location: ../../../web/src/views/cliente/register-client.php');
    $_SESSION['erro'] = false;
    $_SESSION['msgusu'] = 'Registro salvo com sucesso!';
    exit(); 
}else{
    header('Location: ../../../web/src/views/cliente/register-client.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Erro ao salvar cadastro, tente novamente mais tarde!';
    exit();
}

