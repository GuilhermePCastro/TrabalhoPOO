<?php 
include_once((__DIR__) . './bdClass.php');
class Produto extends BD{


    protected $sku;
    protected $nome;
    protected $codigo;
    protected $marca;
    protected $categoria;
    protected $precovenda;
    protected $precocusto;
    protected $estoqueatual;
    protected $estoquemin;
    protected $descricao;      
    protected $inativo;
    protected $usercriador;
 
    // Seta as propriedades da classe
    public function setDados(array $dados): void{
        $this->sku         = $dados['pk_id'] ?? 0;
        $this->nome        = $dados['name'] ?? '';
        $this->codigo      = $dados['codigo'] ?? '';
        $this->marca       = $dados['marca'] ?? 0;
        $this->precovenda  = $dados['preco-venda'] ?? 0;
        $this->precocusto  = $dados['preco-custo'] ?? 0;
        $this->categoria   = $dados['categoria'] ?? 0;
        $this->estoqueatual= $dados['estoque-atual'] ?? 0;
        $this->estoquemin  = $dados['estoque-minimo'] ?? 0;
        $this->descricao   = $dados['descricao'] ?? '';
        $this->usercriador = intval($_SESSION['usersessao']['idusuario']);
        $this->inativo     = isset($dados['inativo']) ? 1 : 0;

    }

    //validando tamnho código
    public function tamanhoCodigo(){
        if(strlen($this->codigo) > 15){
            return false;
        }
    }

    //Verificando a marca
    public function verifMarca(){
        if(!$this->marca){
            return false;
        }else{
            return true;
        }
    }

    //Verificando a categoria
    public function verifCategoria(){
        if(!$this->categoria){
            return false;
        }else{
            return true;
        }
    }

    public function validaCodigo(){
        $objSmtm = $this->objBanco-> prepare("SELECT PK_SKU FROM TB_PRODUTO WHERE DS_CODIGO = :CODIGO");
        $objSmtm -> bindparam(':CODIGO',$this->codigo);
        $objSmtm -> execute();
        return $objSmtm -> fetch(PDO::FETCH_ASSOC);
    }

    public function incluir(){

        //query de insert
        $queryInsert = "INSERT INTO TB_PRODUTO(DS_CODIGO,
                                                DS_NOME,
                                                DS_DESCRICAO,
                                                VL_CUSTO,
                                                VL_VENDA,
                                                QT_ESTOQUEATUAL,
                                                QT_ESTOQUEMAX,
                                                TG_INATIVO,
                                                DH_INCLUSAO,
                                                FK_USUCRIADOR,
                                                FK_MARCA,
                                                FK_CATEGORIA)
                                                VALUES(:DS_CODIGO,
                                                :DS_NOME,
                                                :DS_DESCRICAO,
                                                :VL_CUSTO,
                                                :VL_VENDA,
                                                :QT_ESTOQUEATUAL,
                                                :QT_ESTOQUEMAX,
                                                :TG_INATIVO,
                                                NOW(),
                                                :FK_USUCRIADOR,
                                                :FK_MARCA,
                                                :FK_CATEGORIA)";

        //preparando query
        $objSmtm = $this->objBanco -> prepare($queryInsert);

        // substituindo os valores
        $objSmtm -> bindparam(':DS_CODIGO',     $this->codigo);
        $objSmtm -> bindparam(':DS_NOME',       $this->nome);
        $objSmtm -> bindparam(':DS_DESCRICAO',  $this->descricao);
        $objSmtm -> bindparam(':VL_CUSTO',      $this->precocusto);
        $objSmtm -> bindparam(':VL_VENDA',      $this->precovenda);
        $objSmtm -> bindparam(':QT_ESTOQUEATUAL',$this->estoqueatual);
        $objSmtm -> bindparam(':QT_ESTOQUEMAX', $this->estoquemin);
        $objSmtm -> bindparam(':TG_INATIVO',    $this->inativo);
        $objSmtm -> bindparam(':FK_CATEGORIA',  $this->categoria);
        $objSmtm -> bindparam(':FK_MARCA',      $this->marca);
        $objSmtm -> bindparam(':FK_USUCRIADOR', $this->usercriador);

        return $objSmtm->execute();

    }

    public function alterar(){

        $objSmtm = $this->objBanco -> prepare("UPDATE TB_PRODUTO SET
                                        DS_NOME        = :DS_NOME,
                                        DS_DESCRICAO   = :DS_DESCRICAO,
                                        VL_CUSTO       = :VL_CUSTO,
                                        VL_VENDA       = :VL_VENDA,
                                        QT_ESTOQUEATUAL = :QT_ESTOQUEATUAL,
                                        QT_ESTOQUEMAX   = :QT_ESTOQUEMAX,
                                        TG_INATIVO      = :TG_INATIVO,
                                        FK_MARCA        = :FK_MARCA,
                                        FK_CATEGORIA    = :FK_CATEGORIA,
                                        DH_ALTERACAO    = now()
                                    WHERE
                                        PK_SKU = :SKU");

        // substituindo os valores
        $objSmtm -> bindparam(':DS_NOME',       $this->nome);
        $objSmtm -> bindparam(':DS_DESCRICAO',  $this->descricao);
        $objSmtm -> bindparam(':VL_CUSTO',      $this->precocusto);
        $objSmtm -> bindparam(':VL_VENDA',      $this->precovenda);
        $objSmtm -> bindparam(':QT_ESTOQUEATUAL',$this->estoqueatual);
        $objSmtm -> bindparam(':QT_ESTOQUEMAX', $this->estoquemin);
        $objSmtm -> bindparam(':TG_INATIVO',    $this->inativo);
        $objSmtm -> bindparam(':FK_CATEGORIA',  $this->categoria);
        $objSmtm -> bindparam(':FK_MARCA',      $this->marca);
        $objSmtm -> bindparam(':SKU',           $this->sku);

        return $objSmtm -> execute();
    }

    public function deleta(){
        $objSmtm = $this->objBanco->prepare("DELETE FROM TB_PRODUTO WHERE PK_SKU = :id");
        $objSmtm -> bindparam(':id', $this->sku);
        return $objSmtm->execute();
    }

    //Função que consulta o registro no banco
    public function consulta($codigo, $nome, $categoria){
        
        //Se não tiver filtro traz tudo
        if(!$codigo && !$nome && !$categoria){
            
            $query = "SELECT 
                            PRO.PK_SKU, 
                            PRO.DS_CODIGO, 
                            PRO.DS_NOME, 
                            CAT.DS_CATEGORIA 
                        FROM 
                            TB_PRODUTO AS PRO 
                            LEFT JOIN TB_CATEGORIA AS CAT ON CAT.PK_ID = PRO.FK_CATEGORIA 
                        WHERE 
                            PRO.TG_INATIVO = 0";
            $objSmtm = $this -> objBanco -> prepare($query);
         
        }else{
            
            if($codigo === '0'){
                $codigo = '';
            }
            if($nome === '0'){
                $nome = '';
            }
            if($categoria === '0'){
                $categoria = 0;
            }


            $query = "SELECT 
                            PRO.PK_SKU, 
                            PRO.DS_CODIGO, 
                            PRO.DS_NOME, 
                            CAT.DS_CATEGORIA 
                        FROM 
                            TB_PRODUTO AS PRO 
                            LEFT JOIN TB_CATEGORIA AS CAT ON CAT.PK_ID = PRO.FK_CATEGORIA 
                        WHERE 
                            PRO.TG_INATIVO = 0";
        
            //Adicionando as condições para pesquisa
            if($codigo != ''){
                $query = $query . " AND PRO.DS_CODIGO LIKE :codigo";
            }
            if($nome != ''){
                $query = $query . " AND PRO.DS_NOME LIKE :nome";
            }
            if($categoria != 0){
                $query = $query . " AND PRO.FK_CATEGORIA = :categoria";
            }
        
            //Trocando as condições
            $objSmtm = $this->objBanco -> prepare($query);
            if($codigo != ''){
                $likecodigo = $codigo . '%';
                $objSmtm -> bindparam(':codigo', $likecodigo);
            }
            if($nome != ''){
                $likenome = $nome . '%';
                $objSmtm -> bindparam(':nome', $likenome);
            }
            if($categoria != 0){
                $objSmtm -> bindparam(':categoria',$categoria);
            }
    
        }

        //Passando para a tela
        $objSmtm -> execute();
        $result = $objSmtm -> fetchall();
        
        return $result;
        
    }



}