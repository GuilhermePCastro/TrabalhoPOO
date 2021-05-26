<?php

//Exemplo de código com segregação de interface
interface iRelatorio{

    public function salvaRelatorio();
    public function buscaDados();
}

interface iRelatorioVendas{

    public function totalizaVendas();
}

interface iRelatorioProduto{

    public function totalizaEstoque();
}

class RelatorioProduto implements iRelatorio,iRelatorioProduto{

    public function salvaRelatorio(){

    }

    public function buscaDados(){

    }

    public function totalizaEstoque(){

    }

}

class RelatorioVendas implements iRelatorio,iRelatorioVendas{

    public function salvaRelatorio(){

    }

    public function buscaDados(){

    }

    public function totalizaVendas(){
        
    }

}



