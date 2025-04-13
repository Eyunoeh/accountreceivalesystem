<?php

function validarDados($registro)
{
    $erros = [];

    if (!filter_var($registro->nome_favorecido, FILTER_SANITIZE_STRING)) {
        $erros["nome_favorecido"] =  "Name: Empty field and/or invalid information!";
    }

    if (count($erros) > 0) {
        $_SESSION["erros"] = $erros;
        throw new Exception("Error in information!");
    }
}