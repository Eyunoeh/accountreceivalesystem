<?php
require_once("valida_acesso.php");
?>
<?php
require_once("conexao.php");

if (filter_input(INPUT_SERVER, "REQUEST_METHOD") === "POST") {
    try {
        $erros = [];
        $id = filter_input(INPUT_POST, "id_usuario", FILTER_VALIDATE_INT);
        $pagina = filter_input(INPUT_POST, "pagina_usuario", FILTER_VALIDATE_INT);
        $texto_busca = filter_input(INPUT_POST, "texto_busca_usuario", FILTER_SANITIZE_STRING);

        $sql = "select * from usuario where id = ?";

        $conexao = new PDO("mysql:host=" . SERVIDOR . ";dbname=" . BANCO, USUARIO, SENHA);

        $pre = $conexao->prepare($sql);
        $pre->execute(array(
            $id
        ));

        $resultado = $pre->fetch(PDO::FETCH_ASSOC);
        if (!$resultado) {
            throw new Exception("Não foi possível realizar a consulta!");
        }
    } catch (Exception $e) {
        $erros[] = $e->getMessage();
        $_SESSION["erros"] = $erros;
    } finally {
        $conexao = null;
    }
}
?>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4 d-flex justify-content-start">
                    <h4>Edit User</h4>
                </div>
                <div class="col-md-4 d-flex justify-content-center">
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" title="Home" id="home_index_usuario"><i class="fas fa-home"></i>
                                    <span>Home</span></a></li>
                            <li class="breadcrumb-item"><a href="#" title="Usuário" id="usuario_index"><i class="fas fa-user-cog"></i> <span>User</span></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <hr>
            <?php
            if (isset($_SESSION["erros"])) {
                echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>";
                echo "<button type='button' class='btn-close btn-sm' data-bs-dismiss='alert'
                aria-label='Close'></button>";
                foreach ($_SESSION["erros"] as $chave => $valor) {
                    echo $valor . "<br>";
                }
                echo "</div>";
            }
            unset($_SESSION["erros"]);
            ?>
            <div class="alert alert-info alert-dismissible fade show" style="display: none;" id="div_mensagem_registro_usuario">
                <button type="button" class="btn-close btn-sm" aria-label="Close" id="div_mensagem_registro_botao_usuario"></button>
                <p id="div_mensagem_registro_texto_usuario"></p>
            </div>
            <hr>
            <div class="col-md-12">
                <form enctype="multipart/form-data" method="post" accept-charset="utf-8" id="usuario_dados" role="form" action="">
                    <ul class="nav nav-tabs" id="tab_usuario" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="dadostab_usuario" data-bs-toggle="tab" data-bs-target="#dados_usuario" type="button" role="tab" aria-controls="dados_usuario" aria-selected="true">Data</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="segurancatab_usuario" data-bs-toggle="tab" data-bs-target="#seguranca_usuario" type="button" role="tab" aria-controls="seguranca_usuario" aria-selected="false">Security</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="tabdados_usuario">
                        <div class="tab-pane fade show active" id="dados_usuario" role="tabpanel" aria-labelledby="dados_usuario">
                            <div class="col-md-6">
                                <label for="nome" class="form-label">Name</label>
                                <input type="text" class="form-control" id="nome_usuario" name="nome_usuario" maxlength="50" value="<?php echo isset($resultado['nome']) ? $resultado['nome'] : ''; ?>" autofocus>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email_usuario" name="email_usuario" maxlength="100" value="<?php echo isset($resultado['email']) ? $resultado['email'] : ''; ?>">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="seguranca_usuario" role="tabpanel" aria-labelledby="seguranca_usuario">
                            <div class="col-md-6">
                                <label for="login" class="form-label">Login</label>
                                <input type="text" class="form-control" id="login_usuario" name="login_usuario" maxlength="15" value="<?php echo isset($resultado['login']) ? $resultado['login'] : ''; ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="senha_usuario" class="form-label">Password</label>

                                <div class="position-relative">
                                    <input type="password" class="form-control pe-5" id="senha_usuario" name="senha_usuario" value="">

                                    <span id="toggleSenha" class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;">
                                    <i class="fa-solid fa-eye" id="toggleIcon"></i>
                                    </span>
                                </div>
                            </div>

                            <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo isset($id) ? $id : '' ?>" />
                        </div>
                    </div>
                    <br>
                    <div>
                        <button type="button" class="btn btn-primary" id="botao_salvar_usuario">Save</button>
                        <button type="reset" class="btn btn-secondary" id="botao_limpar_usuario">Clear</button>
                    </div>
                </form>
            </div>
            <div>
                <input type="hidden" id="pagina_usuario" name="pagina_usuario" value="<?php echo isset($pagina) ? $pagina : '' ?>" />
                <input type="hidden" id="texto_busca_usuario" name="texto_busca_usuario" value="<?php echo isset($texto_busca) ? $texto_busca : '' ?>" />
            </div>
        </div>
    </div>
</div>

<!--modal de salvar-->
<div class="modal fade" id="modal_salvar_usuario" tabindex="-1" aria-labelledby="logoutlabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutlabel_usuario">Question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Do you want to save the record?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="modal_salvar_sim_usuario">Yes</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>

<script>
    var url = "./js/sistema/usuario.js";
    $.getScript(url);
</script>
<script>
  function setupPasswordToggle(inputId, toggleId, iconId) {
    const passwordInput = document.getElementById(inputId);
    const toggleBtn = document.getElementById(toggleId);
    const icon = document.getElementById(iconId);

    toggleBtn.addEventListener('click', () => {
      const isPassword = passwordInput.type === 'password';
      passwordInput.type = isPassword ? 'text' : 'password';
      icon.classList.toggle('fa-eye');
      icon.classList.toggle('fa-eye-slash');
    });
  }

  setupPasswordToggle('senha_usuario', 'toggleSenha', 'toggleIcon');
</script>
