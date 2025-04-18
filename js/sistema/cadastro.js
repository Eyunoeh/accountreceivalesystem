$(document).ready(function () {
    $("#botao_limpar").click(function () {
        $("#nome").focus();
        $("#usuario_cadastro").each(function () {
            $(this).find(":input").removeClass("is-invalid");
            $(this).find(":input").removeAttr("value");
        });
    });

    $("#usuario_cadastro").validate({
        rules: {
            nome: {
                required: true
            },
            email: {
                required: true
            },
            login: {
                required: true
            },
            senha: {
                required: true
            }
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
        errorElement: "div",
        errorClass: "invalid-feedback",
        errorPlacement: function (error, element) {
            if (element.parent(".input-group-prepend").length) {
                $(element).siblings(".invalid-feedback").append(error);
            } else {
                error.insertAfter(element);
            }
        },
        messages: {
            nome: {
                required: "This field cannot be empty!"
            },
            email: {
                required: "This field cannot be empty!",
                email: "Email with invalid format"
            },
            login: {
                required: "This field cannot be empty!"
            },
            senha: {
                required: "This field cannot be empty!",
            }
        }
    });
});