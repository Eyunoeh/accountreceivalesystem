<?php
require_once("conexao.php");

function validaDados($registro)
{
    $erros = [];

    if (!filter_var($registro->nome_usuario, FILTER_SANITIZE_STRING)) {
        $erros["nome_usuario"] =  "Name: Empty field and/or invalid information!";
    }

    if (!filter_var($registro->email_usuario, FILTER_VALIDATE_EMAIL)) {
        $erros["email_usuario"] =  "E-mail: Empty field and/or invalid information!";
    }

    if (!filter_var($registro->login_usuario, FILTER_SANITIZE_STRING)) {
        $erros["login_usuario"] =  "Login: Empty field and/or invalid information!";
    }

    if (!filter_var($registro->senha_usuario, FILTER_SANITIZE_STRING)) {
        $erros["senha_usuario"] =  "Password: Empty field and or invalid information!";
    }

    $conexao = new PDO("mysql:host=" . SERVIDOR . ";dbname=" . BANCO, USUARIO, SENHA);
    //validando o login
    $sql = "select * from usuario where login = ?";
    $pre = $conexao->prepare($sql);
    $pre->execute(array(
        $registro->login_usuario
    ));
    $resultado = $pre->fetch();
    if ($resultado) {
        if (!$registro->id_usuario == $resultado['id']) {
            throw new Exception("Login: Login already registered!");
        }
    }

    if (count($erros) > 0) {
        $_SESSION["erros"] = $erros;
        throw new Exception("Error in information!");
    }
}
