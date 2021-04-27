<?php 
include_once "./../../config/db.php";

//Valdiando sessão
(__DIR__);
include_once "./../../classes/loginClass.php";
$login = new Login();
$login->validaUser();

// Verificando se tem permissão
if($_SESSION['usersessao']['adm'] == 0){
    header('Location: ./../../usuarioconsultar.php'); 
    $_SESSION['erro'] = true;
    $_SESSION['msgusu'] = 'Você não tem permissão para alterar usuários!';
    exit();
}

(__DIR__);
include_once "./../../classes/usuarioClass.php";
$usuario = new Usuario();


// verificando se é uma alteração   
if(isset($_POST['pk_id'])){

    $_POST['pk_id'] = preg_replace('/\D/','', $_POST['pk_id']);

    $usuario->setDados($_POST);
    
    if(!$usuario->comparaSenha()){

        //montando o registro para alterar
        $array = $usuario->montaRegistro();

        //substituindo os valores para continuar com o que foi digitado
        $login = $array['DS_LOGIN'];
        $adm   = $array['TG_ADM'] ;

        //passando para a tela
        $_SESSION['erro'] = true;
        $_SESSION['msgusu'] = 'As senhas não são iguais!';
        include "../../../web/src/views/usuario/usuarioalterar.php";
        exit();
    }

    //verificando login
    if($usuario->validaLogin()){
        
        //montando o registro para alterar
        $array = $usuario->montaRegistro();

        //substituindo os valores para continuar com o que foi digitado
        $login = $array['DS_LOGIN'];
        $adm   = $array['TG_ADM'] ;
 
        //passando para a tela
        $_SESSION['erro'] = true;
        $_SESSION['msgusu'] = 'Login já cadastrado!';
        include "../../../web/src/views/usuario/usuarioalterar.php";
        
        exit();
    }
    
    if($usuario->alterar()){

        (__DIR__);
        include './../../functions/gravalog.php';

        $ret = Gravalog(intval($_POST['pk_id']), 'TS_USUARIO', 'Alterou', 'Usuário alterar');

        header('Location: ./usuarioconsultar.php');
        $_SESSION['erro'] = false;
        $_SESSION['msgusu'] = 'Registro alterado com sucesso!';
        exit(); 
    }else{
        header('Location: ./usuarioconsultar.php'); 
        $_SESSION['erro'] = true;
        $_SESSION['msgusu'] = 'Erro ao alterar o cadastro, tente novamente mais tarde!';
        exit();
    }

}else{

    $id = preg_replace('/\D/','', $_GET['id']);
    $query = "SELECT * FROM TS_USUARIO WHERE PK_ID = $id";
    $result = $objBanco -> query($query);
    $array = $result -> fetch(PDO::FETCH_ASSOC);

    include "../../../web/src/views/usuario/usuarioalterar.php";
}