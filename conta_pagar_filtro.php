<?php

function validaDados($registro){
    $erros = [];

    if (!filter_var($registro->descricao_contapagar, FILTER_SANITIZE_STRING)) {
        $erros["descricao_contapagar"] =  "Description: Empty field and/or invalid information!";
    }

    if (!filter_var($registro->favorecido_id_contapagar, FILTER_SANITIZE_STRING)) {
        $erros["favorecido_id_contapagar"] =  "Payee: Empty field and/or invalid information!";
    }

    //retirar a máscara nessa sequência

    if (!filter_var($registro->valor_contapagar, FILTER_VALIDATE_FLOAT)) {
        $erros["valor_contapagar"] =  "Value: Empty field and/or invalid information!";
    }

    if (!filter_var($registro->datavencimento_contapagar, FILTER_SANITIZE_STRING)) {
        $erros["datavencimento_contapagar"] =  "Due Date: Empty field and/or invalid information!";
    }

    if (!filter_var($registro->categoria_id_contapagar, FILTER_SANITIZE_STRING)) {
        $erros["categoria_id_contapagar"] =  "Category: Empty field and/or invalid information!";
    }

    if (count($erros) > 0) {
        $_SESSION["erros"] = $erros;
        throw new Exception("Erro nas informações!");
    }
}