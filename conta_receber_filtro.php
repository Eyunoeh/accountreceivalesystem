<?php

function validaDados($registro)
{
    $erros = [];

    if (!filter_var($registro->descricao_contareceber, FILTER_SANITIZE_STRING)) {
        $erros["descricao_contareceber"] =  "Description: Empty field and/or invalid information!";
    }

    if (!filter_var($registro->favorecido_id_contareceber, FILTER_SANITIZE_STRING)) {
        $erros["favorecido_id_contareceber"] =  "Payer: Empty field and/or invalid information!";
    }

    //retirar a máscara nessa sequência

    if (!filter_var($registro->valor_contareceber, FILTER_VALIDATE_FLOAT)) {
        $erros["valor_contareceber"] =  "Value: Empty field and/or invalid information!";
    }

    if (!filter_var($registro->datavencimento_contareceber, FILTER_SANITIZE_STRING)) {
        $erros["datavencimento_contareceber"] =  "Due Date: Empty field and/or invalid information!";
    }

    if (!filter_var($registro->categoria_id_contareceber, FILTER_SANITIZE_STRING)) {
        $erros["categoria_id_contareceber"] =  "Category: Empty field and/or invalid information!";
    }

    if (count($erros) > 0) {
        $_SESSION["erros"] = $erros;
        throw new Exception("Error Information");
    }
}