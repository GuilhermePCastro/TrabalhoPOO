<?php 

include_once((__DIR__) . './bdClass.php');

class Log extends BD{

   public function GravaLog(int $codorigem, string $tabela, string $acao, string $rotina){
    $queryLog = "INSERT INTO ts_log(FK_ORIGEM,
                        DS_TABELAORIGEM,
                        DS_ACAO,
                        DH_ACAO,
                        DS_ROTINA,
                        FK_USUACAO)
                    VALUES( $codorigem,
                        '$tabela',
                        '$acao',
                        now(),
                        '$rotina'," . $_SESSION['usersessao']['idusuario'] . ")";


        $retorno = $this->objBanco->query($queryLog);

        if($retorno){
            return 1;
        }else{
            return 0;
        }
   }

   public function consultaVazia(){
        $query = "SELECT PK_ID, FK_ORIGEM, DS_TABELAORIGEM, DS_ACAO FROM TS_LOG WHERE PK_ID = 0";
        $objsmtm = $this->objBanco -> prepare($query);
        $objsmtm -> execute();
        $result = $objsmtm -> fetchall();

        return $result;
   }

   public function consulta($codigo, $tabela){
        
        //Se não tiver filtro traz tudo
        if(!$codigo && !$tabela){
            
            $query = "SELECT PK_ID, FK_ORIGEM, DS_TABELAORIGEM, DS_ACAO, DATE_FORMAT(DH_ACAO,'%d/%m/%Y %T') AS 'DC_ACAO' FROM TS_LOG ORDER BY DH_ACAO DESC ";
            $objSmtm = $this->objBanco -> prepare($query);
        
        }else{
            
            if($codigo === '0'){
                $codigo = 0;
            }
            if($tabela === '0'){
                $tabela = '';
            }

            $query = "SELECT PK_ID, FK_ORIGEM, DS_TABELAORIGEM, DS_ACAO, DATE_FORMAT(DH_ACAO,'%d/%m/%Y %T') AS 'DC_ACAO', DH_ACAO FROM TS_LOG WHERE PK_ID <> 0 ";
            
            
            //Adicionando as condições para pesquisa
            if($codigo != 0){
                $query = $query . " AND FK_ORIGEM = :cod";
            }
            if($tabela != ''){
                $query = $query . " AND DS_TABELAORIGEM = :tabela";
            }

            //Trocando as condições
            $objSmtm = $this->objBanco->prepare($query);
            if($codigo != 0){
                $objSmtm -> bindparam(':cod', $codigo);
            }
            if($tabela != ''){
                $objSmtm -> bindparam(':tabela', $tabela);
            }

        }

        //Passando para a tela
        $objSmtm -> execute();
        $result = $objSmtm -> fetchall();
        
        return $result;
        
    }

    public function vizualizar($id){
        
        $query = "SELECT LOG.*, USU.DS_LOGIN, DATE_FORMAT(LOG.DH_ACAO,'%d/%m/%Y %T') AS 'DC_ACAO' FROM TS_LOG LOG LEFT JOIN TS_USUARIO USU ON USU.PK_ID = LOG.FK_USUACAO WHERE LOG.PK_ID = $id";
        $result = $this->objBanco -> query($query);
        return $result -> fetch(PDO::FETCH_ASSOC);

    }


}