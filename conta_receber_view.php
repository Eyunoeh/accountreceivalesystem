<?php
require_once("valida_acesso.php");
?>
<?php
require_once("conexao.php");
require_once("categoria_crud.php");
require_once("favorecido_crud.php");

if (filter_input(INPUT_SERVER, "REQUEST_METHOD") === "POST") {
    try {
        $erros = [];
        $id = filter_input(INPUT_POST, "id_contareceber", FILTER_VALIDATE_INT);
        $pagina = filter_input(INPUT_POST, "pagina_contareceber", FILTER_VALIDATE_INT);
        $texto_busca = filter_input(INPUT_POST, "texto_busca_contareceber", FILTER_SANITIZE_STRING);

        $sql = "select * from conta_receber where id = ?";

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
                    <h4>
                    View Accounts Receivable</h4>
                </div>
                <div class="col-md-3 d-flex justify-content-center">
                </div>
                <div class="col-md-5 d-flex justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" title="Home" id="home_index_contareceber"><i class="fas fa-home"></i>
                                    <span>Home</span></a></li>
                            <li class="breadcrumb-item"><a href="#" title="Contas a Receber" id="contareceber_index"><i class="fas fa-calendar-plus"></i> <span>Accounts receivable</span></a></li>
                            <li class="breadcrumb-item active" aria-current="page">View</li>
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
            <hr>
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs" id="tab_contareceber" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="dadostab_contareceber" data-bs-toggle="tab" data-bs-target="#dados_contareceber" type="button" role="tab" aria-controls="dados_contareceber" aria-selected="true">Data</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="complementotab_contareceber" data-bs-toggle="tab" data-bs-target="#complemento_contareceber" type="button" role="tab" aria-controls="complemento_contareceber" aria-selected="false">Complement</button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="tabdados_contareceber">
                        <div class="tab-pane fade show active" id="dados_contareceber" role="tabpanel" aria-labelledby="dados_contareceber">
                            <h4>
                                <b><?= isset($resultado["id"]) ? $resultado["id"] : "" ?></b>
                                <b><?= " - "  ?></b>
                                <b><?= isset($resultado["descricao"]) ? $resultado["descricao"] : "" ?></b>
                            </h4>
                            <br>
                            <dl>
                                <dt>Description</dt>
                                <dd>
                                    <?= isset($resultado["descricao"]) ? $resultado["descricao"] : ""; ?>
                                </dd>
                            </dl>
                            <dl>
                                <dt>Payer</dt>
                                <dd>
                                    <?= isset($resultado["valor"]) ? buscarFavorecido($resultado["favorecido_id"])[0]["nome"] : ""; ?>
                                </dd>
                            </dl>
                            <dl>
                                <dt>Value</dt>
                                <dd>
                                    ₱<?= isset($resultado["valor"]) ? number_format($resultado["valor"],2) : ""; ?>
                                </dd>
                            </dl>
                        </div>
                        <div class="tab-pane fade" id="complemento_contareceber" role="tabpanel" aria-labelledby="complemento_contareceber">
                            <dl>
                                <dt>Due Date</dt>
                                <dd>
                                    <?= isset($resultado["data_vencimento"]) ?
                                        date("d/m/Y", strtotime($resultado["data_vencimento"])) : ""; ?>
                                </dd>
                            </dl>
                            <dl>
                                <dt>Category</dt>
                                <dd>
                                    <?= isset($resultado["valor"]) ? buscarCategoria($resultado["categoria_id"])[0]["descricao"] : ""; ?>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <input type="hidden" id="pagina_contareceber" name="pagina" value="<?php echo isset($pagina) ? $pagina : '' ?>" />
                    <input type="hidden" id="texto_busca_contareceber" name="texto_busca_contareceber" value="<?php echo isset($texto_busca) ? $texto_busca : '' ?>" />
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //devido ao load precisa carregar o arquivo js dessa forma
    var url = "./js/sistema/conta_receber.js";
    $.getScript(url);
</script>