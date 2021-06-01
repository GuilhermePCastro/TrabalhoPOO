<?php

include_once((__DIR__) . './../classes/usuarioClass.php');

class FactoryUsuario {

    static function criaUsuario($tipo){

        switch($tipo){
            case "Usuario":
                return new Usuario;
                break;
        }
    }
}