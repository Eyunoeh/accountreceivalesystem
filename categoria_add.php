<?php
require_once("valida_acesso.php");
?>
<?php
if (filter_input(INPUT_SERVER, "REQUEST_METHOD") === "POST") {
    try {
        $erros = [];
        $id = filter_input(INPUT_POST, "id_categoria", FILTER_VALIDATE_INT);
        $usuario_id = isset($_SESSION["usuario_id"]) ?  $_SESSION["usuario_id"] : 0;
        $pagina = filter_input(INPUT_POST, "pagina_categoria", FILTER_VALIDATE_INT);
        $texto_busca = filter_input(INPUT_POST, "texto_busca_categoria", FILTER_SANITIZE_STRING);

        if (!isset($pagina)) {
            $pagina = 1;
        }
    } catch (Exception $e) {
        $erros[] = $e->getMessage();
        $_SESSION["erros"] = $erros;
    }
}
?>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4 d-flex justify-content-start">
                    <h4>Add Category</h4>
                </div>
                <div class="col-md-4 d-flex justify-content-center">
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" title="Home" id="home_index_categoria"><i class="fas fa-home"></i>
                                    <span>Home</span></a></li>
                            <li class="breadcrumb-item"><a href="#" title="Categoria" id="categoria_index"><i class="fas fa-tag"></i> <span>Category</span></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add</li>
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
            <div class="alert alert-info alert-dismissible fade show" style="display: none;" id="div_mensagem_registro_categoria">
                <button type="button" class="btn-close btn-sm" aria-label="Close" id="div_mensagem_registro_botao_categoria"></button>
                <p id="div_mensagem_registro_texto_categoria"></p>
            </div>
            <hr>
            <div class="col-md-12">
                <form enctype="multipart/form-data" method="post" accept-charset="utf-8" id="categoria_dados" role="form" action="">
                    <ul class="nav nav-tabs" id="tab_categoria" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="dadostab_categoria" data-bs-toggle="tab" data-bs-target="#dados_categoria" type="button" role="tab" aria-controls="dados_categoria" aria-selected="true">Data</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="tabdados_categoria">
                        <div class="tab-pane fade show active" id="dados_categoria" role="tabpanel" aria-labelledby="dados_categoria">
                            <div class="col-md-6">
                                <label for="descricao" class="form-label">Description</label>
                                <input type="text" class="form-control" id="descricao_categoria" name="descricao_categoria" maxlength="50" autofocus>
                            </div>
                            <div class="col-md-6">
                                <input class="form-check-input" type="radio" name="tipo_categoria" id="tipo_categoria" value="1">
                                <label class="form-check-label" for="tipo_categoria">
                                    Entry
                                </label>
                                <input class="form-check-input" type="radio" name="tipo_categoria" id="tipo_categoria" value="2">
                                <label class="form-check-label" for="tipo_categoria">
                                    Output
                                </label>
                            </div>
                            <input type="hidden" id="id_categoria" value="<?php echo isset($id) ? $id : '' ?>" />
                            <input type="hidden" id="usuario_id_categoria" name="usuario_id_categoria" value="<?php echo isset($usuario_id) ? $usuario_id : '' ?>" />
                        </div>
                    </div>
                    <br>
                    <div>
                        <button type="button" class="btn btn-primary" id="botao_salvar_categoria">Save</button>
                        <button type="reset" class="btn btn-secondary" id="botao_limpar_categoria">Clear</button>
                    </div>
                </form>
            </div>
            <div>
                <input type="hidden" id="pagina_categoria" name="pagina_categoria" value="<?php echo isset($pagina) ? $pagina : '' ?>" />
                <input type="hidden" id="texto_busca_categoria" name="texto_busca_categoria" value="<?php echo isset($texto_busca) ? $texto_busca : '' ?>" />
            </div>
        </div>
    </div>
</div>

<!--modal de salvar-->
<div class="modal fade" id="modal_salvar_categoria" tabindex="-1" aria-labelledby="logoutlabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutlabel_categoria">Question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            Do you want to save the record?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="modal_salvar_sim_categoria">Yes</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>

<script>
     //devido ao load precisa carregar o arquivo js dessa forma
    var url = "./js/sistema/categoria.js";
    $.getScript(url);
</script>