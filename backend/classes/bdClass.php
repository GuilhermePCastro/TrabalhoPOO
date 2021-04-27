<?php

abstract class BD{

     //objeto com as conexões do banco
     private $DSN;
     private $DBUSER;
     private $DBPASS;
     protected $objBanco;

     public function __construct(){

        $this->DSN = 'mysql:dbname=netunopi;host=localhost';
        $this->DBUSER = 'root';
        $this->DBPASS = '';

        try{
            $objBanco = new PDO($this->DSN, $this->DBUSER, $this->DBPASS);
        }
        catch(PDOException $objerro){
        
            echo "Erro ao conectar-se ao banco de dados! <br> Erro:" . $objerro -> getMessage();
            exit();
        }

        $this->objBanco = $objBanco;
       
    }
}