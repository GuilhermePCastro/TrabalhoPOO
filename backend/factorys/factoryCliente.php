<?php

include_once((__DIR__) . './../classes/clienteClass.php');

class FactoryCliente {

    static function criaCliente($tipo){

        switch($tipo){
            case "Cliente":
                return new Cliente;
                break;
        }
    }
}