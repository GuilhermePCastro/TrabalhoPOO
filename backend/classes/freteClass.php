<?php

//Possível implementação de frete (Usado para o conceito de OCP)
include_once((__DIR__) . './../iEmpresaDeLogistica.php');

class Correios implements iEmpresaDeLogistica{
    public function setPeso(){
        //logica
    }

    public function setDestino(){
        //logica
    }

    public function setOrigem(){
        //logica
    }

    public function setTamanho(){
        //logica
    }

    public function calcular(){
        //logica
    }
}

class TotalExpress implements iEmpresaDeLogistica{
    public function setPeso(){
        //logica
    }

    public function setDestino(){
        //logica
    }

    public function setOrigem(){
        //logica
    }

    public function setTamanho(){
        //logica
    }

    public function calcular(){
        //logica
    }
}

class DHL implements iEmpresaDeLogistica{
    public function setPeso(){
        //logica
    }

    public function setDestino(){
        //logica
    }

    public function setOrigem(){
        //logica
    }

    public function setTamanho(){
        //logica
    }

    public function calcular(){
        //logica
    }
}

class Frete{

    private $empresa;

    public function __construct(iEmpresaDeLogistica $empresa){
        $this->empresa = $empresa;
    }

    public function calcular(){
        //lógica do calculo com os métodos definos na interface
        $this->empresa->setPeso();
        $this->empresa->setDestino();
        $this->empresa->setOrigem();
        $this->empresa->setTamanho();
        $this->empresa->calcular();
    }
}

