<?php
include_once((__DIR__) . './bdClass.php');
class Usuario extends BD{


    protected $id;
    protected $login;
    protected $email;
    protected $adm;
    protected $senha;
    protected $senhacon;
    protected $usercriador;
    protected $inativo;


    public function setDados(array $dados): void{
        $this->login        = $dados['ds_login'] ?? '';
        $this->email        = $dados['ds_email'] ?? '';
        $this->adm          = isset($dados['tg_adm']) ? 1 : 0;
        $this->senha        = $dados['ds_senha'] ?? '';
        $this->senhacon     = $dados['ds_senhacon'] ?? '';
        $this->usercriador  = intval($_SESSION['usersessao']['idusuario']);
        $this->inativo      = isset($dados['inativo']) ? 1 : 0;
        $this->id           = $dados['pk_id'] ?? 0;

    }

    public function comparaSenha(){
        if($this->senha != $this->senhacon){
            return false;
        }else{
            return true;
        }
    }

    public function validaLogin(){
        if($this->id <> 0){
            $objSmtm = $this->objBanco->prepare("SELECT DS_LOGIN FROM TS_USUARIO WHERE DS_LOGIN = :LOGIN AND PK_ID <> $this->id");
            $objSmtm -> bindparam(':LOGIN',$this->login);
            $objSmtm -> execute();
            return $objSmtm -> fetch(PDO::FETCH_ASSOC);
        }else{
            $objSmtm = $this->objBanco->prepare("SELECT DS_LOGIN FROM TS_USUARIO WHERE DS_LOGIN = :LOGIN");
            $objSmtm -> bindparam(':LOGIN',$this->login);
            $objSmtm -> execute();
            return $objSmtm -> fetch(PDO::FETCH_ASSOC);
        }
    }

    public function validaEmail(){
        $objSmtm = $this->objBanco -> prepare("SELECT DS_EMAIL FROM TS_USUARIO WHERE DS_EMAIL = :EMAIL");
        $objSmtm -> bindparam(':EMAIL',$this->email );
        $objSmtm -> execute();
        return $objSmtm -> fetch(PDO::FETCH_ASSOC);
    }

    public function incluir(){

        //Criptografando
        $this->senha  = password_hash($this->senha,PASSWORD_DEFAULT);

        //query de insert
        $queryInsert = "insert into ts_usuario (DS_LOGIN, DS_EMAIL, DS_SENHA, TG_ADM, DH_INCLUSAO, FK_USUCRIADOR) 
        values (:ds_login, :ds_email,  :ds_senha, :tg_adm, now(), :fk_usucriador)";

        //preparando query
        $objSmtm = $this->objBanco->prepare($queryInsert);

        // substituindo os valores
        $objSmtm -> bindparam(':ds_login',$this->login);
        $objSmtm -> bindparam(':ds_email',$this->email);
        $objSmtm -> bindparam(':ds_senha',$this->senha);
        $objSmtm -> bindparam(':tg_adm',$this->adm);
        $objSmtm -> bindparam(':fk_usucriador',$this->usercriador);

        return $objSmtm -> execute();
    }

    public function montaRegistro(){

        $query = "SELECT * FROM TS_USUARIO WHERE PK_ID = $this->id";
        $result = $this->objBanco->query($query);
        return $result -> fetch(PDO::FETCH_ASSOC);
    }

    public function alterar(){

        //Criptografando
        $this->senha  = password_hash($this->senha,PASSWORD_DEFAULT);

        $objSmtm = $this->objBanco -> prepare("UPDATE TS_USUARIO SET
                                                DS_LOGIN = :DS_LOGIN, 
                                                DS_SENHA = :DS_SENHA, 
                                                TG_ADM   = :TG_ADM,
                                                DH_ALTERACAO = now()
                                            WHERE
                                                PK_ID = :ID");

        $objSmtm -> bindParam(':DS_LOGIN',$this->login);
        $objSmtm -> bindParam(':DS_SENHA',$this->senha);
        $objSmtm -> bindParam(':TG_ADM',$this->adm);
        $objSmtm -> bindParam(':ID',$this->id);

        return $objSmtm -> execute();
    }

    public function deleta(){
        $objSmtm = $this->objBanco->prepare("DELETE FROM TS_USUARIO WHERE PK_ID = :id");
        $objSmtm -> bindparam(':id', $this->id);
        return $objSmtm->execute();
    }

    //Função que consulta o registro no banco
    public function consulta($login, $email){
        
        //Se não tiver filtro traz tudo
        if(!$login && !$email){

            $query = "SELECT PK_ID, DS_LOGIN, DS_EMAIL FROM TS_USUARIO WHERE TG_INATIVO = 0";
            $objSmtm = $this->objBanco -> prepare($query);

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
        
        }

        //Passando para a tela
        $objSmtm -> execute();
        $result = $objSmtm -> fetchall();
        return $result;
        
    }
}