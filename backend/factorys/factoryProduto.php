<?php

include_once((__DIR__) . './../classes/produtoClass.php');

class FactoryProduto {

    static function criaProduto($tipo){

        switch($tipo){
            case "Produto":
                return new Produto;
                break;
        }
    }
}