<?php

include_once((__DIR__) . './../classes/logClass.php');

class FactoryLog {

    static function criaLog($tipo){

        switch($tipo){
            case "LogBanco":
                return new Log;
                break;
        }
    }
}