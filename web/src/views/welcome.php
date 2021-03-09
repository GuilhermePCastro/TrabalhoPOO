<?php
  session_start();
  
  // validando usuário
  if($_SESSION['usersessao']['idusuario'] == 0){
      header('Location: ./pg-login.html');
      exit();
  }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel</title>
  <script src="../assets/js/menu.js"></script>
  <link rel="stylesheet" href="../assets/styles/css/menu.css">
  <link rel="stylesheet" href="../assets/styles/css/header.css">
  <link rel="stylesheet" href="../assets/styles/css/main.css">
  <link rel="stylesheet" href="../assets/styles/css/pg-users.css">
  <link href="https://fonts.googleapis.com/css2?family=Rhodium+Libre&display=swap" rel="stylesheet">
</head>
<body>
  <header>
    <div class="bg-blue">
    </div>
    <div class="bg-yellow">
    </div>
  </header>
  <main class="main">
    <nav class="sidebar">
        <ul class="sidebar__nav">
          <li class="nav__item hide-children">
            <span class="item__title">
              Cadastros 
              <img class="title__icon" src="../assets/svgs/arrow-down.svg" alt="arrow down">
            </span>
            <ul class="item__subnav">
              <li class="subnav__item">
                <a class="item__link" href="../../../backend/clienteconsultar.php">Clientes</a>
              </li>
              <li class="subnav__item">
              <a class="item__link" href="../../../backend/produtoconsultar.php">Produtos</a>
              </li>
              <li class="subnav__item">
                <a class="item__link" href="../../../backend/usuarioconsultar.php">Usuários</a>
              </li>
            </ul>
          </li>
          <li class="nav__item hide-children">
            <span class="item__title">
              Mais
              <img
                class="title__icon"
                src="../assets/svgs/arrow-down.svg"
                alt="arrow down"
              />
            </span>
            <ul class="item__subnav">
              <li class="subnav__item">
                <a class="item__link" href="../../../backend/logsconsultar.php">Logs</a>
              </li>
              <li class="subnav__item">
                <a class="item__link" href="../../../backend/functions/logout.php">Logout</a>
              </li>
            </ul>
          </li>
        </ul>
        <a href="#">
          <img src="../assets/images/logo.png" alt="netuno">
        </a>
    </nav>
    <section class="main__page-content right-container">
      <h2 class="page-title txt-center">Bem vindo, <?php echo"{$_SESSION['usersessao']['usuario']}";?> !</h2>
    </section>
  </main>
</body>
</html>