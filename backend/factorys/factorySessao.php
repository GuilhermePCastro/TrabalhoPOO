<?php

include_once((__DIR__) . './../classes/sessaoClass.php');

class FactorySessao {

    static function criaSessao($tipo){

        switch($tipo){
            case "Login":
                return new Sessao;
                break;
        }
    }
}