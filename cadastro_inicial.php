<?php
session_start();
?>
<?php
require_once("conexao.php");
//verificando se é uma requisição post para efetuar o cadastro
if (filter_input(INPUT_SERVER, "REQUEST_METHOD") === "POST") {
    try {
        $erros = [];
        $dados = [];

        $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_STRING);
        if (!$nome) {
            $erros["nome"] =  "Nome: Campo vazio e ou informação inválida!";
        }
        $dados["nome"] = $nome;

        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        if (!$email) {
            $erros["email"] =  "E-mail: Campo vazio e ou informação inválida!";
        }
        $dados["email"] = $email;

        $login = filter_input(INPUT_POST, "login", FILTER_SANITIZE_STRING);
        if (!$login) {
            $erros["login"] =  "Login: Campo vazio e ou informação inválida!";
        }
        $dados["login"] = $login;

        $senha = filter_input(INPUT_POST, "senha", FILTER_SANITIZE_STRING);
        if (!$senha) {
            $erros["senha"] =  "Senha: Campo vazio e ou informação inválida!";
        }
        $dados["senha"] = $senha;
        $_SESSION["dados"] = $dados;

        if (count($erros) > 0) {
            throw new Exception("Erro nas informações!");
        }

        $conexao = new PDO("mysql:host=" . SERVIDOR . ";dbname=" . BANCO, USUARIO, SENHA);

        //validando o login
        $sql = "select * from usuario where login = ?";
        $pre = $conexao->prepare($sql);
        $pre->execute(array(
            $login
        ));
        $resultado = $pre->fetch();
        if ($resultado) {
            throw new Exception("Login: Login já cadastrado!");
        }

        $senha = password_hash($senha, PASSWORD_DEFAULT);

        //cadastrando o usuário
        $sql = "insert into usuario(nome, email, login, senha) VALUES (?, ?, ?, ?)";

        $pre = $conexao->prepare($sql);
        $pre->execute(array(
            $nome,
            $email,
            $login,
            $senha
        ));

        header("HTTP 1/1 302 Redirect");
        header("Location: login.php");
    } catch (Exception $e) {
        $erros[] = $e->getMessage();
        $_SESSION["erros"] = $erros;
    } finally {
        $conexao = null;
    }
}
?>

<!doctype html>
<html lang="pt-BR">

<head>
    <title>Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="./css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="./css/fontawesome/fontawesome.min.css" rel="stylesheet">
    <link href="./css/fontawesome/brands.min.css" rel="stylesheet">
    <link href="./css/fontawesome/solid.min.css" rel="stylesheet">
    <link href="./css/sistema/landpage.css" rel="stylesheet">
    <link href="./css/sistema/cadastro.css" rel="stylesheet">
</head>

<body>
    <header id="topo">
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
            
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item"><a class="nav-link" href="login.php"><i class="fas fa-id-card"></i>&nbsp;Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="form-cadastro">
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
        <h4> Initial user registration</h4>
        <form id="usuario_cadastro" action="cadastro_inicial.php" method="post">
            <div class="row mb-3">
                <label for="nome" class="col-sm-2 col-form-label col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control" maxlength="50" id="nome" name="nome" value="<?php echo isset($_SESSION['dados']['nome']) ? $_SESSION['dados']['nome'] : '' ?>" autofocus>
                </div>
            </div>
            <div class="row mb-3">
                <label for="email" class="col-sm-2 col-form-label col-form-label">E-mail</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control form-control" maxlength="100" id="email" name="email" value="<?php echo isset($_SESSION['dados']['email']) ? $_SESSION['dados']['email'] : '' ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label for="login" class="col-sm-2 col-form-label col-form-label">Username</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control" maxlength="15" id="login" name="login" value="<?php echo isset($_SESSION['dados']['login']) ? $_SESSION['dados']['login'] : '' ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label for="senha" class="col-sm-2 col-form-label col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control form-control" maxlength="10" id="senha" name="senha" value="<?php echo isset($_SESSION['dados']['senha']) ? $_SESSION['dados']['senha'] : '' ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary" id="botao_cadastrar">Submit</button>
            <button type="reset" class="btn btn-secondary" id="botao_limpar">Clear</button>
        </form>

        <?php
        unset($_SESSION["dados"]);
        ?>
    </main>

    <footer class="container">
        <hr class="featurette-divider">
        <p>
            &copy; 2024–<script>
                document.write(new Date().getFullYear())
            </script>
            | KDS Account Receivable System |
        </p>
    </footer>

    <script src="./js/jquery/jquery.min.js"></script>
    <script src="./js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="./js/fontawesome/fontawesome.min.js"></script>
    <script src="./js/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="./js/sistema/cadastro.js"></script>
</body>

</html>