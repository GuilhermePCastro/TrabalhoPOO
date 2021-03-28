<?php 

class Cliente{

    public function validaCPF($cpf){
        //verificando CPF
        $objSmtm = $objBanco -> prepare("SELECT NR_CPF FROM TB_CLIENTE WHERE NR_CPF = :CPF");
        $cpfval = $cpf ?? '';
        $objSmtm -> bindparam(':CPF',$cpfval);
        $objSmtm -> execute();
        $result = $objSmtm -> fetch(PDO::FETCH_ASSOC);
        return $result;

    }


    public function validaDigitoCPF($pessoa, $cpf){
        if($pessoa == 'F'){
            if(strlen($cpf) != 11){
                return false;
            }
        }else{
            if(strlen($cpf) != 14){
                return false;
            }
        }
    }

    public function validaCEP($cep){
        if(strlen($cep) != 8){
            return false;
        }
    }

    public function incluir(){
        //query de insert
        $queryInsert = "INSERT INTO tb_cliente (DS_FANTASIA, 
                                                    DS_RAZAO, 
                                                    TG_PESSOA, 
                                                    NR_CPF, 
                                                    DS_EMAIL, 
                                                    DS_TELEFONE, 
                                                    DS_CELULAR, 
                                                    DS_CEP, 
                                                    DS_ENDERECO, 
                                                    DS_NUMERO, 
                                                    DS_CIDADE, 
                                                    DS_COMPLEMENTO, 
                                                    DS_REFERENCIA, 
                                                    DS_OBSERVACAO, 
                                                    TG_INATIVO, 
                                                    DH_INCLUSAO,  
                                                    FK_USUCRIADOR, 
                                                    FK_ESTADO) 
                                                    VALUES (:fantasia,
                                                    :razao,
                                                    :pessoa,
                                                    :cpf,
                                                    :email,
                                                    :telefone,
                                                    :celular,
                                                    :cep,
                                                    :endereco,
                                                    :numero,
                                                    :cidade,
                                                    :complemento,
                                                    :referencia,
                                                    :observacao,
                                                    :inativo,
                                                    now(),
                                                    :usu,
                                                    :estado)";

        //preparando query
        $objSmtm = $objBanco -> prepare($queryInsert);

        // substituindo os valores
        $fantasia = $_POST['fantasia'] ?? '';
        $objSmtm -> bindparam(':fantasia',$fantasia);

        $razao = $_POST['razao'] ?? '';
        $objSmtm -> bindparam(':razao',$razao);

        $pessoa = $_POST['pessoa'] ?? '';
        $objSmtm -> bindparam(':pessoa',$pessoa);

        $objSmtm -> bindparam(':cpf', $cpfval );

        $email = $_POST['email'] ?? '';
        $objSmtm -> bindparam(':email', $email );

        $telefone = $_POST['telefone'] ?? '';
        $objSmtm -> bindparam(':telefone', $telefone);

        $celular = $_POST['celular'] ?? '';
        $objSmtm -> bindparam(':celular', $celular);

        $cep = $_POST['cep'] ?? '';
        $objSmtm -> bindparam(':cep', $cep);

        $endereco = $_POST['endereco'] ?? '';
        $objSmtm -> bindparam(':endereco', $endereco);

        $numero = $_POST['numero'] ?? '';
        $objSmtm -> bindparam(':numero', $numero) ;

        $cidade = $_POST['cidade'] ?? '';
        $objSmtm -> bindparam(':cidade', $cidade);

        $complemento = $_POST['complemento'] ?? '';
        $objSmtm -> bindparam(':complemento', $complemento);

        $referencia = $_POST['referencia'] ?? '';
        $objSmtm -> bindparam(':referencia', $referencia);

        $observacao = $_POST['observacao'] ?? '';
        $objSmtm -> bindparam(':observacao', $observacao);

        $estado = $_POST['estado'] ?? '';
        $objSmtm -> bindparam(':estado', $estado);

        $usercriador = intval($_SESSION['usersessao']['idusuario']);
        $objSmtm -> bindparam(':usu', $usercriador);

        $inativo = $_POST['inativo'] == '1' ? 1 : 0;
        $objSmtm -> bindparam(':inativo', $inativo);

        $return = $objSmtm -> execute();
        $a = $objSmtm -> errorInfo();

        return $return;

        //-------------------------------------------
        if($return){

            (__DIR__);
            include './functions/gravalog.php';

            // grava log
            $objSmtm = $objBanco -> prepare("SELECT MAX(PK_ID) AS 'PK_ID' FROM TB_CLIENTE");
            $objSmtm -> execute();
            $result = $objSmtm -> fetch(PDO::FETCH_ASSOC);

            $ret = Gravalog(intval($result['PK_ID']), 'TB_CLIENTE', 'Incluiu', 'Cliente incluir');


            header('Location: ../web/src/views/register-client.php');
            $_SESSION['erro'] = false;
            $_SESSION['msgusu'] = 'Registro salvo com sucesso!';
            exit(); 
        }else{
            header('Location: ../web/src/views/register-client.php'); 
            $_SESSION['erro'] = true;
            $_SESSION['msgusu'] = 'Erro ao salvar cadastro, tente novamente mais tarde!';
            exit();
        }
    }

    public function alterar(){
        $objSmtm = $objBanco -> prepare("UPDATE TB_CLIENTE SET
                                        DS_FANTASIA     = :fantasia,
                                        DS_RAZAO        = :razao,
                                        TG_PESSOA       = :pessoa,
                                        NR_CPF          = :cpf,
                                        DS_EMAIL        = :email,
                                        DS_TELEFONE     = :telefone,
                                        DS_CELULAR      = :celular,
                                        DS_CEP          = :cep,
                                        DS_ENDERECO     = :endereco,
                                        DS_NUMERO       = :numero,
                                        DS_CIDADE       = :cidade,
                                        DS_COMPLEMENTO  = :complemento,
                                        DS_REFERENCIA   = :referencia,
                                        DS_OBSERVACAO   = :observacao,
                                        TG_INATIVO      = :inativo,
                                        FK_ESTADO       = :estado,
                                        DH_ALTERACAO    = now()
                                    WHERE
                                        PK_ID = $id");

        // substituindo os valores
        $fantasia = $_POST['fantasia'] ?? '';
        $objSmtm -> bindparam(':fantasia',$fantasia);

        $razao = $_POST['razao'] ?? '';
        $objSmtm -> bindparam(':razao',$razao);

        $pessoa = $_POST['pessoa'] ?? '';
        $objSmtm -> bindparam(':pessoa',$pessoa);

        $objSmtm -> bindparam(':cpf', $cpfval );

        $email = $_POST['email'] ?? '';
        $objSmtm -> bindparam(':email', $email );

        $telefone = $_POST['telefone'] ?? '';
        $objSmtm -> bindparam(':telefone', $telefone);

        $celular = $_POST['celular'] ?? '';
        $objSmtm -> bindparam(':celular', $celular);

        $cep = $_POST['cep'] ?? '';
        $objSmtm -> bindparam(':cep', $cep);

        $endereco = $_POST['endereco'] ?? '';
        $objSmtm -> bindparam(':endereco', $endereco);

        $numero = $_POST['numero'] ?? '';
        $objSmtm -> bindparam(':numero', $numero) ;

        $cidade = $_POST['cidade'] ?? '';
        $objSmtm -> bindparam(':cidade', $cidade);

        $complemento = $_POST['complemento'] ?? '';
        $objSmtm -> bindparam(':complemento', $complemento);

        $referencia = $_POST['referencia'] ?? '';
        $objSmtm -> bindparam(':referencia', $referencia);

        $observacao = $_POST['observacao'] ?? '';
        $objSmtm -> bindparam(':observacao', $observacao);

        $estado = $_POST['estado'] ?? '';
        $objSmtm -> bindparam(':estado', $estado);

        $inativo = isset($_POST['inativo']) ? 1 : 0;
        $objSmtm -> bindparam(':inativo', $inativo);

        return $objSmtm -> execute();

        //--------------------------------------------------------------------
        if($objSmtm -> execute()){

            (__DIR__);
            include './functions/gravalog.php';

            $ret = Gravalog(intval($id), 'TB_CLIENTE', 'Alterou', 'Cliente alterar');


            header('Location: ./clienteconsultar.php');
            $_SESSION['erro'] = false;
            $_SESSION['msgusu'] = 'Registro alterado com sucesso!';
            exit(); 
        }else{
            header('Location: ./clienteconsultar.php'); 
            $_SESSION['erro'] = true;
            $_SESSION['msgusu'] = 'Erro ao alterar o cadastro, tente novamente mais tarde!';
            exit();
        }
    }

    public function consulta($fantasia, $cpf){
        if(!$fantasia && !$cpf){
            $query = "SELECT PK_ID, DS_FANTASIA, NR_CPF FROM TB_CLIENTE WHERE TG_INATIVO = 0";
            $objsmtm = $objBanco -> prepare($query);
            $objsmtm -> execute();
            $result = $objsmtm -> fetchall();
            $count = $objsmtm -> fetchall();
            include "../web/src/views/pg-clientes.php";
         
        }else{
        
            $fantasia  =    $fantasia ?? '';
            $cpf       =    $cpf ?? '';
        
            $query = "SELECT PK_ID, DS_FANTASIA, NR_CPF FROM TB_CLIENTE WHERE TG_INATIVO = 0";
        
            //Adicionando as condições para pesquisa
            if($fantasia != ''){
                $query = $query . " AND DS_FANTASIA LIKE :fantasia";
            }
            if($cpf != ''){
                $query = $query . " AND NR_CPF = :cpf";
            }
        
            //Trocando as condições
            $objSmtm = $objBanco -> prepare($query);
            if($fantasia != ''){
                $likefantasia = $fantasia . '%';
                $objSmtm -> bindparam(':fantasia', $likefantasia);
            }
            if($cpf != 0){
                $objSmtm -> bindparam(':cpf',$cpf);
            }
        
            //Passando para a tela
            $objSmtm -> execute();
            $result = $objSmtm -> fetchall();
            $count = $objSmtm -> fetchall();
        
            include "../web/src/views/pg-clientes.php";
        
        }
    }

    public function deleta($id){
        $id = preg_replace('/\D/','', $id);
        return $objBanco -> Query("DELETE FROM TB_CLIENTE WHERE PK_ID = $id");
    }
    
}