<?php

include_once((__DIR__) . './../classes/loginClass.php');

class FactoryLogin {

    static function criaLogin($tipo){

        switch($tipo){
            case "Normal":
                return new Login;
                break;
        }
    }
}