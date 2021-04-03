<?php 

class Produto{

    //objeto com as conexões do banco
    protected $objBanco;

    public function __construct(){
        (__DIR__);
        include "./config/db.php";

        $this->objBanco = $objBanco;
    } 

    //validando tamnho código
    public function tamanhoCodigo($codigo){
        if(strlen($codigo) > 15){
            return false;
        }
    }

    public function validaCodigo($codigo){
        $objSmtm = $this->objBanco -> prepare("SELECT PK_SKU FROM TB_PRODUTO WHERE DS_CODIGO = :CODIGO");
        $objSmtm -> bindparam(':CODIGO',$codigo);
        $objSmtm -> execute();
        return $objSmtm -> fetch(PDO::FETCH_ASSOC);
    }

    public function incluir(){

        //pegando variaveis
        $nome       = $_POST['name'];
        $codigo     = $_POST['codigo'];
        $marca      = intval($_POST['marca']) ?? 0;
        $categoria  = intval($_POST['categoria']) ?? 0;
        $precovenda = intval($_POST['preco-venda']) ?? 0;
        $precocusto = intval($_POST['preco-custo']) ?? 0;
        $estoqueatual   = intval($_POST['estoque-atual']) ?? 0;
        $estoquemin     = intval($_POST['estoque-minimo']) ?? 0;
        $descricao      = $_POST['descricao'];      
        $inativo        = $_POST['inativo'] == '1' ? 1 : 0;

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
        $objSmtm -> bindparam(':DS_CODIGO',$codigo);
        $objSmtm -> bindparam(':DS_NOME',$nome);
        $objSmtm -> bindparam(':DS_DESCRICAO',$descricao);
        $objSmtm -> bindparam(':VL_CUSTO',$precocusto);
        $objSmtm -> bindparam(':VL_VENDA',$precovenda);
        $objSmtm -> bindparam(':QT_ESTOQUEATUAL',$estoqueatual);
        $objSmtm -> bindparam(':QT_ESTOQUEMAX',$estoquemin);
        $objSmtm -> bindparam(':TG_INATIVO',$inativo);
        $objSmtm -> bindparam(':FK_CATEGORIA',$categoria);
        $objSmtm -> bindparam(':FK_MARCA',$marca);
        $objSmtm -> bindparam(':FK_USUCRIADOR',$_SESSION['usersessao']['idusuario']);

        return $objSmtm -> execute();

    }

    public function alterar($id){

        $nome       = $_POST['name'];
        $codigo     = $_POST['codigo'];
        $marca      = intval($_POST['marca']) ?? 0;
        $categoria  = intval($_POST['categoria']) ?? 0;
        $precovenda = intval($_POST['preco-venda']) ?? 0;
        $precocusto = intval($_POST['preco-custo']) ?? 0;
        $estoqueatual   = intval($_POST['estoque-atual']) ?? 0;
        $estoquemin     = intval($_POST['estoque-minimo']) ?? 0;
        $descricao      = $_POST['descricao'];      
        $inativo        = isset($_POST['inativo']) == true ? 1 : 0;

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
                                        PK_SKU = $id");

        // substituindo os valores
        $objSmtm -> bindparam(':DS_NOME',$nome);
        $objSmtm -> bindparam(':DS_DESCRICAO',$descricao);
        $objSmtm -> bindparam(':VL_CUSTO',$precocusto);
        $objSmtm -> bindparam(':VL_VENDA',$precovenda);
        $objSmtm -> bindparam(':QT_ESTOQUEATUAL',$estoqueatual);
        $objSmtm -> bindparam(':QT_ESTOQUEMAX',$estoquemin);
        $objSmtm -> bindparam(':TG_INATIVO',$inativo);
        $objSmtm -> bindparam(':FK_CATEGORIA',$categoria);
        $objSmtm -> bindparam(':FK_MARCA',$marca);

        return $objSmtm -> execute();
    }

    public function deleta($id){
       return $this->objBanco -> Query("DELETE FROM TB_PRODUTO WHERE PK_SKU = $id");
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
            $objsmtm = $this -> objBanco -> prepare($query);
            $objsmtm -> execute();
            $result = $objsmtm -> fetchall();
            $count = $objsmtm -> fetchall();
            include "../web/src/views/pg-products.php";
         
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
        
            //Passando para a tela
            $objSmtm -> execute();
            $result = $objSmtm -> fetchall();
            $count = $objSmtm -> fetchall();
        
            include "../web/src/views/pg-products.php";
        }
        
    }


}