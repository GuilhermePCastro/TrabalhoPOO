<?php 

class Cliente{

    //objeto com as conexões do banco
    protected $objBanco;

    public function __construct(){
        (__DIR__);
        include "./../../config/db.php";

        $this->objBanco = $objBanco;
    }

    //Função que valida o CPF/CNPJ no banco
    public function validaCPF($cpf){
        //verificando CPF
        $objSmtm = $this->objBanco -> prepare("SELECT NR_CPF FROM TB_CLIENTE WHERE NR_CPF = :CPF");
        $cpfval = $cpf ?? '';
        $objSmtm -> bindparam(':CPF',$cpfval);
        $objSmtm -> execute();
        $result = $objSmtm -> fetch(PDO::FETCH_ASSOC);
        return $result;

    }

    //Função valida email no banco
    public function validaEmail($email){
        //verificando CPF
        $objSmtm = $this->objBanco -> prepare("SELECT DS_EMAIL FROM TB_CLIENTE WHERE DS_EMAIL = :EMAIL");
        $email = $email ?? '';
        $objSmtm -> bindparam(':EMAIL',$email);
        $objSmtm -> execute();
        $result = $objSmtm -> fetch(PDO::FETCH_ASSOC);
        return $result;

    }

    //Valida diigtos do CPF/CNPJ
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

    //Valida digitos do CEP
    public function validaCEP($cep){
        if(strlen($cep) != 8){
            return false;
        }
    }

    //Função que inclui o registro no banco
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
        $objSmtm = $this->objBanco -> prepare($queryInsert);

        // substituindo os valores
        $fantasia = $_POST['fantasia'] ?? '';
        $objSmtm -> bindparam(':fantasia',$fantasia);

        $razao = $_POST['razao'] ?? '';
        $objSmtm -> bindparam(':razao',$razao);

        $pessoa = $_POST['pessoa'] ?? '';
        $objSmtm -> bindparam(':pessoa',$pessoa);

        $cpf = $_POST['cpf'] ?? '';
        $objSmtm -> bindparam(':cpf', $cpf);

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

        return $return;
    }

    //Função que altera o registro no banco
    public function alterar($id){
        $objSmtm = $this->objBanco -> prepare("UPDATE TB_CLIENTE SET
                                        DS_FANTASIA     = :fantasia,
                                        DS_RAZAO        = :razao,
                                        TG_PESSOA       = :pessoa,
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

    }

    //Função que consulta o registro no banco
    public function consulta($fantasia, $cpf){
        
        //Se não tiver filtro traz tudo
        if(!$fantasia && !$cpf){
            $query = "SELECT PK_ID, DS_FANTASIA, NR_CPF FROM TB_CLIENTE WHERE TG_INATIVO = 0";
            $objsmtm = $this->objBanco -> prepare($query);
            $objsmtm -> execute();
            $result = $objsmtm -> fetchall();
            $count = $objsmtm -> fetchall();
            include "../../../web/src/views/cliente/pg-clientes.php";
         
        }else{
            
            if($fantasia === '0'){
                $fantasia = '';
            }
            if($cpf === '0'){
                $cpf = '';
            }

        
            $query = "SELECT PK_ID, DS_FANTASIA, NR_CPF FROM TB_CLIENTE WHERE TG_INATIVO = 0";
        
            //Adicionando as condições para pesquisa
            if($fantasia !== ''){
                $query = $query . " AND DS_FANTASIA LIKE :fantasia";
            }
            if($cpf !== ''){
                $query = $query . " AND NR_CPF = :cpf";
            }
        
            //Trocando as condições
            $objSmtm = $this->objBanco -> prepare($query);
            if($fantasia != ''){
                $likefantasia = $fantasia . '%';
                $objSmtm -> bindparam(':fantasia', $likefantasia);
            }
            if($cpf != ''){
                $objSmtm -> bindparam(':cpf',$cpf);
            }
        
            //Passando para a tela
            $objSmtm -> execute();
            $result = $objSmtm -> fetchall();
            $count = $objSmtm -> fetchall();
        
            include "../../../web/src/views/cliente/pg-clientes.php";
        
        }
    }

    //Função que deleta o registro no banco
    public function deleta($id){
        $id = preg_replace('/\D/','', $id);
        return $this->objBanco -> Query("DELETE FROM TB_CLIENTE WHERE PK_ID = $id");
    }

}