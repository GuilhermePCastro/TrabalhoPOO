<?php

class Usuario{

    //objeto com as conexões do banco
    protected $objBanco;

    public function __construct(){
        (__DIR__);
        include "./config/db.php";

        $this->objBanco = $objBanco;
    } 

    function validaLogin($login, $id){
        if($id <> 0){
            $objSmtm = $this->objBanco->prepare("SELECT DS_LOGIN FROM TS_USUARIO WHERE DS_LOGIN = :LOGIN AND PK_ID <> $id");
            $objSmtm -> bindparam(':LOGIN',$login);
            $objSmtm -> execute();
            return $objSmtm -> fetch(PDO::FETCH_ASSOC);
        }else{
            $objSmtm = $this->objBanco->prepare("SELECT DS_LOGIN FROM TS_USUARIO WHERE DS_LOGIN = :LOGIN");
            $objSmtm -> bindparam(':LOGIN',$login);
            $objSmtm -> execute();
            return $objSmtm -> fetch(PDO::FETCH_ASSOC);
        }
    }

    function validaEmail($email){
        $objSmtm = $this->objBanco -> prepare("SELECT DS_EMAIL FROM TS_USUARIO WHERE DS_EMAIL = :EMAIL");
        $objSmtm -> bindparam(':EMAIL',$email );
        $objSmtm -> execute();
        return $objSmtm -> fetch(PDO::FETCH_ASSOC);
    }

    function incluir(){

        $login    = $_POST['ds_login'];
        $email    = $_POST['ds_email'];
        $adm      = $_POST['tg_adm'] == '1' ? 1 : 0;

        //Criptografando
        $senha    = password_hash($$_POST['ds_senha'],PASSWORD_DEFAULT);

        //query de insert
        $queryInsert = "insert into ts_usuario (DS_LOGIN, DS_EMAIL, DS_SENHA, TG_ADM, DH_INCLUSAO, FK_USUCRIADOR) 
        values (:ds_login, :ds_email,  :ds_senha, :tg_adm, now(), :fk_usucriador)";

        //preparando query
        $objSmtm = $this->objBanco->prepare($queryInsert);

        // substituindo os valores
        $objSmtm -> bindparam(':ds_login',$login);
        $objSmtm -> bindparam(':ds_email',$email);
        $objSmtm -> bindparam(':ds_senha',$senha);
        $objSmtm -> bindparam(':tg_adm',$adm);
        $objSmtm -> bindparam(':fk_usucriador',$_SESSION['usersessao']['idusuario']);

        return $objSmtm -> execute();
    }

    function montaRegistro($id){

        $query = "SELECT * FROM TS_USUARIO WHERE PK_ID = $id";
        $result = $objBanco -> query($query);
        return $result -> fetch(PDO::FETCH_ASSOC);
    }

    function alterar($id){

         //pegando variaveis
        $login    = $_POST['ds_login'];
        $senha    = $_POST['ds_senha'];
        $senhacon = $_POST['ds_senhacon'];
        $adm      = $_POST['tg_adm'] ?? 0;

        //Criptografando
        $senha = password_hash($senha,PASSWORD_DEFAULT);

        $objSmtm = $this->objBanco -> prepare("UPDATE TS_USUARIO SET
                                                DS_LOGIN = :DS_LOGIN, 
                                                DS_SENHA = :DS_SENHA, 
                                                TG_ADM   = :TG_ADM,
                                                DH_ALTERACAO = now()
                                            WHERE
                                                PK_ID = $id");

        $objSmtm -> bindParam(':DS_LOGIN',$login);
        $objSmtm -> bindParam(':DS_SENHA',$senha);
        $objSmtm -> bindParam(':TG_ADM',$adm);

        return $objSmtm -> execute();
    }

    function deletar($id){
        return $this->objBanco -> Query("DELETE FROM TS_USUARIO WHERE PK_ID = $id");
    }

    //Função que consulta o registro no banco
    public function consulta($login, $email){
        
        //Se não tiver filtro traz tudo
        if(!$login && !$email){

            $query = "SELECT PK_ID, DS_LOGIN, DS_EMAIL FROM TS_USUARIO WHERE TG_INATIVO = 0";
            $objsmtm = $this->objBanco -> prepare($query);
            $objsmtm -> execute();
            $result = $objsmtm -> fetchall();
            $count = $objsmtm -> fetchall();
            include "../web/src/views/pg-user.php";
        }else{
            
            if($login === '0'){
                $login = '';
            }
            if($email === '0'){
                $email = '';
            }

            $query = "SELECT PK_ID, DS_LOGIN, DS_EMAIL FROM TS_USUARIO WHERE TG_INATIVO = 0";

            //Adicionando as condições para pesquisa
            if($login != ''){
                $query = $query . " AND DS_LOGIN LIKE :login";
            }
            if($email != ''){
                $query = $query . " AND DS_EMAIL LIKE :email";
            }
        
            //Trocando as condições
            $objSmtm = $this->objBanco -> prepare($query);
            if($login != ''){
                $likelogin = $login . '%';
                $objSmtm -> bindparam(':login', $likelogin);
            }
            if($email != ''){
                $likeemail = $email . '%';
                $objSmtm -> bindparam(':email',$likeemail);
            }
        
            //Passando para a tela
            $objSmtm -> execute();
            $result = $objSmtm -> fetchall();
            $count = $objSmtm -> fetchall();
        
            include "../web/src/views/pg-user.php";
        }
    }
}