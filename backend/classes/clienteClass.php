<?php 

include_once((__DIR__) . './bdClass.php');
class Cliente extends BD{

    //propriedades de cliente
    protected $id;
    protected $fantasia;
    protected $razao;
    protected $pessoa;
    protected $cpf;
    protected $email;
    protected $telefone;
    protected $celular;
    protected $cep;
    protected $endereco;
    protected $numero;
    protected $cidade;
    protected $complemento;
    protected $referencia;
    protected $observacao;
    protected $estado;
    protected $usercriador;
    protected $inativo;


    // Seta as propriedades da classe
    public function setDados(array $dados): void{
        $this->fantasia     = $dados['fantasia'] ?? '';
        $this->razao        = $dados['razao'] ?? '';
        $this->pessoa       = $dados['pessoa'] ?? '';
        $this->cpf          = $dados['cpf'] ?? '';
        $this->email        = $dados['email'] ?? '';
        $this->telefone     = $dados['telefone'] ?? '';
        $this->celular      = $dados['celular'] ?? '';
        $this->cep          = $dados['cep'] ?? '';
        $this->endereco     = $dados['endereco'] ?? '';
        $this->numero       = $dados['numero'] ?? '';
        $this->cidade       = $dados['cidade'] ?? '';
        $this->complemento  = $dados['complemento'] ?? '';
        $this->referencia   = $dados['referencia'] ?? '';
        $this->observacao   = $dados['observacao'] ?? '';
        $this->estado       = $dados['estado'] ?? '';
        $this->usercriador  = intval($_SESSION['usersessao']['idusuario']);
        $this->inativo      = isset($dados['inativo']) ? 1 : 0;
        $this->id          = $dados['pk_id'] ?? 0;

    }

    //Função que valida o CPF/CNPJ no banco
    public function validaCPF(){
        //verificando CPF
        $objSmtm = $this->objBanco -> prepare("SELECT NR_CPF FROM TB_CLIENTE WHERE NR_CPF = :CPF AND TG_INATIVO = 0");
        $objSmtm -> bindparam(':CPF',$this->cpf);
        $objSmtm -> execute();
        return $objSmtm -> fetch(PDO::FETCH_ASSOC);

    }

    //Função valida email no banco
    public function validaEmail(){
        //verificando CPF
        $objSmtm = $this->objBanco -> prepare("SELECT DS_EMAIL FROM TB_CLIENTE WHERE DS_EMAIL = :EMAIL");
        $objSmtm -> bindparam(':EMAIL',$this->email);
        $objSmtm -> execute();
        return $objSmtm -> fetch(PDO::FETCH_ASSOC);

    }

    //Valida diigtos do CPF/CNPJ
    public function validaDigitoCPF(){
        if($this->pessoa == 'F'){
            if(strlen($this->cpf) != 11){
                return false;
            }
        }else{
            if(strlen($this->cpf) != 14){
                return false;
            }
        }
    }

    //Valida digitos do CEP
    public function validaCEP(){
        if(strlen($this->cep) != 8){
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
        $objSmtm -> bindparam(':fantasia',  $this->fantasia);
        $objSmtm -> bindparam(':razao',     $this->razao);
        $objSmtm -> bindparam(':pessoa',    $this->pessoa);
        $objSmtm -> bindparam(':cpf',       $this->cpf);
        $objSmtm -> bindparam(':email',     $this->email );
        $objSmtm -> bindparam(':telefone',  $this->telefone);
        $objSmtm -> bindparam(':celular',   $this->celular);
        $objSmtm -> bindparam(':cep',       $this->cep);
        $objSmtm -> bindparam(':endereco',  $this->endereco);
        $objSmtm -> bindparam(':numero',    $this->numero) ;
        $objSmtm -> bindparam(':cidade',    $this->cidade);
        $objSmtm -> bindparam(':complemento',$this->complemento);
        $objSmtm -> bindparam(':referencia', $this->referencia);
        $objSmtm -> bindparam(':observacao', $this->observacao);
        $objSmtm -> bindparam(':estado',     $this->estado);
        $objSmtm -> bindparam(':usu',        $this->usercriador);
        $objSmtm -> bindparam(':inativo',    $this->inativo);

        return $objSmtm -> execute();

    }

    //Função que altera o registro no banco
    public function alterar(){
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
                                        PK_ID = :id");

        // substituindo os valores
        $objSmtm -> bindparam(':id',        $this->id);
        $objSmtm -> bindparam(':fantasia',  $this->fantasia);
        $objSmtm -> bindparam(':razao',     $this->razao);
        $objSmtm -> bindparam(':pessoa',    $this->pessoa);
        $objSmtm -> bindparam(':email',     $this->email );
        $objSmtm -> bindparam(':telefone',  $this->telefone);
        $objSmtm -> bindparam(':celular',   $this->celular);
        $objSmtm -> bindparam(':cep',       $this->cep);
        $objSmtm -> bindparam(':endereco',  $this->endereco);
        $objSmtm -> bindparam(':numero',    $this->numero) ;
        $objSmtm -> bindparam(':cidade',    $this->cidade);
        $objSmtm -> bindparam(':complemento',$this->complemento);
        $objSmtm -> bindparam(':referencia', $this->referencia);
        $objSmtm -> bindparam(':observacao', $this->observacao);
        $objSmtm -> bindparam(':estado',     $this->estado);
        $objSmtm -> bindparam(':inativo',    $this->inativo);

        return $objSmtm->execute();

    }

    //Função que consulta o registro no banco
    public function consulta($fantasia, $cpf){
        
        //Se não tiver filtro traz tudo
        if(!$fantasia && !$cpf){
            $query = "SELECT PK_ID, DS_FANTASIA, NR_CPF FROM TB_CLIENTE WHERE TG_INATIVO = 0";
            $objSmtm = $this->objBanco -> prepare($query);
         
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
        
        }

        //Passando para a tela
        $objSmtm -> execute();
        $result = $objSmtm -> fetchall();
        $count = $objSmtm -> fetchall();
        
        return $result;
    }

    //Função que deleta o registro no banco
    public function deleta(){
        $objSmtm = $this->objBanco->prepare("DELETE FROM TB_CLIENTE WHERE PK_ID = :id");
        $objSmtm -> bindparam(':id', $this->id);
        return $objSmtm->execute();
    }

}