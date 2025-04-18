<?php
require_once("valida_acesso.php");
?>
<?php
require_once("categoria_crud.php");
require_once("favorecido_crud.php");

//a listagem de categoria é geral poderia ser filtrado por status
if (filter_input(INPUT_SERVER, "REQUEST_METHOD") === "POST") {
    try {
        $erros = [];
        $id = filter_input(INPUT_POST, "id_contapagar", FILTER_VALIDATE_INT);
        $pagina = filter_input(INPUT_POST, "pagina_contapagar", FILTER_VALIDATE_INT);
        $texto_busca = filter_input(INPUT_POST, "texto_busca_contapagar", FILTER_SANITIZE_STRING);

        $sql = "select * from conta_pagar where id = ?";

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
                    <h4>Edit Accounts Payable</h4>
                </div>
                <div class="col-md-3 d-flex justify-content-center">
                </div>
                <div class="col-md-5 d-flex justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" title="Home" id="home_index_contapagar"><i class="fas fa-home"></i>
                                    <span>Home</span></a></li>
                            <li class="breadcrumb-item"><a href="#" title="Contas a Pagar" id="contapagar_index"><i class="fas fa-calendar-plus"></i> <span>Accounts Payable</span></a></li>
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
            <div class="alert alert-info alert-dismissible fade show" style="display: none;" id="div_mensagem_registro_contapagar">
                <button type="button" class="btn-close btn-sm" aria-label="Close" id="div_mensagem_registro_botao_contapagar"></button>
                <p id="div_mensagem_registro_texto_contapagar"></p>
            </div>
            <hr>
            <div class="col-md-12">
                <form enctype="multipart/form-data" method="post" accept-charset="utf-8" id="contapagar_dados" role="form" action="">
                    <ul class="nav nav-tabs" id="tab_contapagar" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="dadostab_contapagar" data-bs-toggle="tab" data-bs-target="#dados_contapagar" type="button" role="tab" aria-controls="dados_contapagar" aria-selected="true">Data</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="complementotab_contapagar" data-bs-toggle="tab" data-bs-target="#complemento_contapagar" type="button" role="tab" aria-controls="complemento_contapagar" aria-selected="false">Complement</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="tabdados_contapagar">
                        <div class="tab-pane fade show active" id="dados_contapagar" role="tabpanel" aria-labelledby="dados_contapagar">
                            <div class="col-md-6">
                                <label for="descricao" class="form-label">Description</label>
                                <input type="text" class="form-control" id="descricao_contapagar" name="descricao_contapagar" maxlength="100" value="<?php echo isset($resultado['descricao']) ? $resultado['descricao'] : ''; ?>" autofocus>
                            </div>
                            <div class="col-md-6">
                                <label for="favorecido_contapagar" class="form-label">Payer</label><select name="favorecido_id_contapagar" id="favorecido_id_contapagar" class="form-select">
                                    <?php
                                    $favorecidos = listarFavorecidoEntrada();
                                    foreach ($favorecidos as $favorecido) {
                                        if ($favorecido["id"] == $resultado['favorecido_id']) {
                                            echo "<option value='" . $favorecido["id"] . "' selected>" . $favorecido["nome"] . "</option>";
                                        } else {
                                            echo "<option value='" . $favorecido["id"] . "'>" . $favorecido["nome"] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="valor" class="form-label">Value</label>
                                <input type="text" class="form-control" id="valor_contapagar" name="valor_contapagar" value="<?php echo isset($resultado['valor']) ?  $resultado["valor"] : ''; ?>">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="complemento_contapagar" role="tabpanel" aria-labelledby="complemento_contapagar">
                            <div class="col-md-6">
                                <label for="valor" class="form-label">Expiration Date</label>
                                <input type="date" class="form-control" id="datavencimento_contapagar" name="datavencimento_contapagar" value="<?php echo isset($resultado['data_vencimento']) ? $resultado['data_vencimento'] : ''; ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="categoria_contapagar" class="form-label">Category</label><select name="categoria_id_contapagar" id="categoria_id_contapagar" class="form-select">
                                    <?php
                                    $categorias = listarCategoriaEntrada();
                                    foreach ($categorias as $categoria) {
                                        if ($categoria["id"] == $resultado['categoria_id']) {
                                            echo "<option value='" . $categoria["id"] . "' selected>" . $categoria["descricao"] . "</option>";
                                        } else {
                                            echo "<option value='" . $categoria["id"] . "'>" . $categoria["descricao"] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <input type="hidden" id="id_contapagar" name="id_contapagar" value="<?php echo isset($id) ? $id : '' ?>" />
                            <input type="hidden" id="usuario_id_contapagar" name="usuario_id_contapagar" value="<?php echo isset($usuario_id) ? $usuario_id : '' ?>" />
                        </div>
                    </div>
                    <br>
                    <div>
                        <button type="button" class="btn btn-primary" id="botao_salvar_contapagar">Save</button>
                    </div>
                </form>
            </div>
            <div>
                <input type="hidden" id="pagina_contapagar" name="pagina_contapagar" value="<?php echo isset($pagina) ? $pagina : '' ?>" />
                <input type="hidden" id="texto_busca_contapagar" name="texto_busca_contapagar" value="<?php echo isset($texto_busca) ? $texto_busca : '' ?>" />
            </div>
        </div>
    </div>
</div>

<!--modal de salvar-->
<div class="modal fade" id="modal_salvar_contapagar" tabindex="-1" aria-labelledby="logoutlabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutlabel_contapagar">Question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Do you want to save the record?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="modal_salvar_sim_contapagar">Yes</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>

<script>
    //devido ao load precisa carregar o arquivo js dessa forma
    var url = "./js/sistema/conta_pagar.js";
    $.getScript(url);
</script>