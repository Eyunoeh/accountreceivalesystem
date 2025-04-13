<?php
require_once("valida_acesso.php");
?>
<!doctype html>
<html lang="pt-BR">

<head>
  <title>Menu</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="./css/bootstrap/bootstrap.min.css" rel="stylesheet">
  <link href="./css/fontawesome/fontawesome.min.css" rel="stylesheet">
  <link href="./css/fontawesome/brands.min.css" rel="stylesheet">
  <link href="./css/fontawesome/solid.min.css" rel="stylesheet">
  <link href="./css/datatables/datatables.min.css" rel="stylesheet">
  <link href="./css/sistema/menu.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body id="body">
  <header class="header" id="header">
    <div class="header_toggle">
      <i class="fas fa-bars" id="header-toggle"></i>
    </div>
    <div class="header_user">
      <?php
      if (isset($_SESSION["usuario"])) {
        echo "<h6>" . $_SESSION["usuario"] . "</h6>";
      }
      ?>

    </div>
  </header>
  <div class="l-navbar bg-danger text-white" id="nav-bar">
    <nav class="navmenu">
      <div>
        <a class="nav_logo" title="Home" id="home_link"> <i class="fas fa-home nav_logo-icon"></i> <span class="nav_logo-name">KDS (AR)</span>
        </a>
        <div class="nav_list text-light">
          <a href="#" class="nav_link" title="Categoria" id="categoria_link">
            <i class="fas fa-tag nav_icon"></i> <span class="nav_name">Category</span>
          </a>
          <a href="#" class="nav_link" title="Favorecido" id="favorecido_link">
            <i class="fas fa-university nav_icon"></i> <span class="nav_name">Payer</span>
          </a>
          <a href="#" class="nav_link" title="Contas a Receber" id="contareceber_link">
            <i class="fas fa-calendar-plus nav_icon"></i>
            <span class="nav_name">Accounts receivable</span>
          </a>
          <a href="#" class="nav_link" title="Contas a Pagar" id="contapagar_link">
            <i class="fas fa-calendar-minus nav_icon"></i>
            <span class="nav_name">Accounts Payable
            </span>
          </a>
          <a class="nav_link" title="Usuário" id="usuario_link">
            <i class="fas fa-user-cog nav_icon"></i>
            <span class="nav_name">User</span>
          </a>
          <a class="nav_link" title="Sobre" id="sobre_link">
            <i class="fas fa-question-circle nav_icon"></i>
            <span class="nav_name">Info</span>
          </a>
        </div>
      </div>
      <a href="#" class="nav_link" id="logout_link" title="Logout"> <i class="fas fa-sign-out-alt nav_icon"></i>
        <span class="nav_name">Logout</span>
      </a>
    </nav>
  </div>
  <!--div main-->
  <div class="height-10" id="conteudo">
    <br>
    <div class="container">
      <div class="row">
        <div id="carregando_menu" class="d-none text-center">
          <img src="./imagens/carregando.gif" />
        </div>
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-4 d-flex justify-content-start">
              <h4>Dashboard</h4>
            </div>
            <div class="col-md-4 d-flex justify-content-center">
            </div>
            <div class="col-md-4 d-flex justify-content-end">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-home"></i>
                    <span>Home</span></a>
                  </li>
                </ol>
              </nav>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-4 d-flex justify-content-start">
            </div>
            <div class="col-md-4 d-flex justify-content-center">
              <select name="ano" id="ano">
                <?php
                for ($i = 0; $i < 10; $i++) {
                  if ($i == 0) {
                    echo "<option value='2021'>2021</option>";
                  } else {
                    $conta = 2021 + $i;
                    echo "<option value='$conta'>$conta</option>";
                  }
                }
                ?>
              </select>
              <a id="botao_pesquisar_grafico" class="btn btn-primary btn-sm" title="Pesquisar"><i class="fas fa-search"></i>&nbsp;Search</a>
            </div>
            <div class="col-md-4 d-flex justify-content-end">
              <input type="hidden" id="usuario_id_menu" name="usuario_id_menu" value="<?php echo isset($_SESSION["usuario_id"]) ?  $_SESSION["usuario_id"] : 0; ?>" />
            </div>
          </div>
          <hr>
        </div>
        <div class="alert alert-info alert-dismissible fade show" style="display: none;" id="div_mensagem_menu">
          <button type="button" class="btn-close btn-sm" aria-label="Close" id="div_mensagem_botao_menu"></button>
          <p id="div_mensagem_texto_menu"></p>
        </div>
        <div id="div_grafico" class="col-md-12" style="height:400px;">
          <canvas id="grafico"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!--fim div main-->

  <!--modal de sobre-->
  <div class="modal fade" id="sobre_modal" tabindex="-1" aria-labelledby="logoutlabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="logoutlabel">Information</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Syscash - Financial system   </p>
          <p>Since 2024–<script>
              document.write(new Date().getFullYear())
            </script>
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>

  <!--modal de logout-->
  <div class="modal fade" id="logout_modal" tabindex="-1" aria-labelledby="logoutlabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="logoutlabel">Question</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        Do you want to log out?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="logout_modal_sim">Yes</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        </div>
      </div>
    </div>
  </div>

  <script src="./js/jquery/jquery.min.js"></script>
  <script src="./js/bootstrap/bootstrap.bundle.min.js"></script>
  <script src="./js/datatables/datatables.min.js"></script>
  <script src="./js/jquery-validation/dist/jquery.validate.min.js"></script>
  <script src="./js/inputmask/jquery.inputmask.js"></script>
  <script src="./js/chartjs/chart.min.js"></script>
  <script src="./js/sistema/menu.js"></script>
</body>

</html>