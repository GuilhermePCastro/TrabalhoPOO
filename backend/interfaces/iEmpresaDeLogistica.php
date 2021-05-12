<?php

interface iEmpresaDeLogistica{
     
    public function setPeso();
    public function setDestino();
    public function setOrigem();
    public function setTamanho();
    public function calcular();
}