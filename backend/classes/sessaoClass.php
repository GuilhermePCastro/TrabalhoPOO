<?php
include_once((__DIR__) . './bdClass.php');

class Sessao extends BD{

    protected $login;
    protected $userId;
    protected $email;
    protected $adm;
    
    public function setDados($dados){

        $this->login = $dados['login'];
        $this->userId = $dados['userId'];
        $this->email = $dados['email'];
        $this->adm = $dados['adm'];
    }

    public function criaSession(){

        $_SESSION['usersessao'] = array('usuario' => $this->login, 
                                        'idusuario' => preg_replace('/\D/','', $this->userId), 
                                        'emailusuario' => $this->email, 
                                        'adm' => preg_replace('/\D/','',$this->adm));
    }

    public function validaUser(){
        session_start();
        // Se não tem sessão, volta para o login
        if(!$_SESSION['usersessao']){
            header('Location: ../../../web/src/views/pg-login.html');
            exit();
        }

    }
}