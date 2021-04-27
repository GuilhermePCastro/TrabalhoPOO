<?php 
include_once "./../../config/db.php";

//Valdiando sessão
(__DIR__);
include_once "./../../classes/loginClass.php";
$login = new Login();
$login->validaUser();

 
$id = preg_replace('/\D/','', $_GET['id']);
$query = "SELECT LOG.*, USU.DS_LOGIN, DATE_FORMAT(LOG.DH_ACAO,'%d/%m/%Y %T') AS 'DC_ACAO' FROM TS_LOG LOG LEFT JOIN TS_USUARIO USU ON USU.PK_ID = LOG.FK_USUACAO WHERE LOG.PK_ID = $id";
$result = $objBanco -> query($query);

$array = $result -> fetch(PDO::FETCH_ASSOC);

include "../../../web/src/views/logs/visualize-logs.php";
