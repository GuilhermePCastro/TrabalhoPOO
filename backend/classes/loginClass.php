<?php
include_once((__DIR__) . './bdClass.php');
class Login extends BD{

    protected $login;
    protected $senha;
    protected $userId;
    protected $email;
    protected $adm;

    public function setDados($dados){

        if(!$dados['login'] || !$dados['login']){   
            return false;
        }

        $this->login = $dados['login'];
        $this->senha = $dados['senha'];
    }

    public function validaLogin(){

        // Query para buscar usuário e senha no banco
        $objSmtm = $this->objBanco -> prepare("SELECT PK_ID, DS_SENHA, DS_LOGIN, DS_EMAIL, TG_ADM FROM TS_USUARIO WHERE DS_LOGIN = :LOGIN");

        // Substituindo valores e executando
        $objSmtm -> bindparam(':LOGIN',$this->login);
        $objSmtm -> execute();

        // Transformando em array
        $result = $objSmtm -> fetch(PDO::FETCH_ASSOC);

        if(password_verify($this->senha, $result['DS_SENHA'])){
            $this->userId = $dados['TG_ADM'];
            $this->email  = $dados['DS_EMAIL'];  
            $this->adm    = $dados['TG_ADM']; 

            return true;
        }else{
            return false;
        }
    }

    public function criaSession(){

        $_SESSION['usersessao'] = array('usuario' => $this->login, 
                                        'idusuario' => preg_replace('/\D/','', $this->userId), 
                                        'emailusuario' => $this->email, 
                                        'adm' => preg_replace('/\D/','',$this->adm));
    }

    public function logout(){
        session_start();
        session_destroy();
        header('Location: ../../../web/src/views/pg-login.html');
        exit();
    }



}