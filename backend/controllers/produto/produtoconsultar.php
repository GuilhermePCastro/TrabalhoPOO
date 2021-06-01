<?php
include_once "./../../config/db.php";

//Validando sessão
(__DIR__);
include_once "./../../factorys/factorySessao.php";
$sessao = new FactorySessao();
$sessao = $sessao::criaSessao("Login");
$sessao->validaUser();

$codigo     = isset($_GET['codigo']) ? $_GET['codigo'] : '0';
$nome        = isset($_GET['nome']) ? $_GET['nome'] : '0';
$categoria  = isset($_GET['categoria']) ? $_GET['categoria'] : '0';

//Objeto de produto
(__DIR__);
include_once "./../../factorys/factoryProduto.php";
$produto = new FactoryProduto();
$produto = $produto::criaProduto("Produto");

//Função que traz os registros e mostra na tela
$result = $produto->consulta($codigo, $nome, $categoria);
$count = $result;

include "../../../web/src/views/produto/pg-products.php";