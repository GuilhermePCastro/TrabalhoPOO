<?php

// Exemplo de classe para respeitar o conceito de Liskov

abstract class Email{

    public function abreConexao(){
        //lógica
    }

    public function enviarEmail(){
        //lógica
    }
}

class EmailGmail{

    public function abreConexao(){
        //logica
        parent::abreConexao();
    }

    public function enviarEmail(){
        //lógica
        parent::enviarEmail();
    }
}

class EmailOutlook{

    public function abreConexao(){
        //logica
        parent::abreConexao();
    }

    public function enviarEmail(){
        //lógica
        parent::enviarEmail();
    }
}