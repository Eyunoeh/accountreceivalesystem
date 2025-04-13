<?php

function validaDados($registro)
{
    $erros = [];

    if (!filter_var($registro->descricao_categoria, FILTER_SANITIZE_STRING)) {
        $erros["descricao_categoria"] =  "Description: Empty field and/or invalid information!";
    }

    if (count($erros) > 0) {
        $_SESSION["erros"] = $erros;
        throw new Exception("Erro nas informações!");
    }
}
