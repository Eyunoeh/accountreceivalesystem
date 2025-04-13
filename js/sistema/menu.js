//para funcionar navegação via ajax os ids devem ser únicos em cada tela
$(document).ready(function () {
    //clicar no botão da div de erros e escondendo as mensagens de erros
    $("#div_mensagem_botao_menu").click(function () {
        $("#div_mensagem_menu").hide();
    });

    $('#botao_pesquisar_grafico').click(function (e) {
        var ano = $("#ano").val();
        var id_usuario = $("#usuario_id_menu").val();

        $("#div_grafico").html("");
        $("#div_grafico").append("<canvas id='grafico'></canvas>");

        var grafico_canva = $("#grafico");
        const graficoBarra = new Chart(
            grafico_canva, {
                type: "bar",
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 
                        'October', 'November', 'December'],
                    datasets: [{
                        label: "Accounts receivable",
                        backgroundColor: "#4080bf",
                        borderColor: "#3973ac",
                        hoverBackgroundColor: "#ccccff",
                        hoverBorderColor: "#b3b3ff",
                        borderWidth: 1,
                        data: []
                    }, {
                        label: "Accounts Payable",
                        backgroundColor: "#bf4040",
                        borderColor: "#bf4040",
                        hoverBackgroundColor: "#bf4040",
                        hoverBorderColor: "#bf4040",
                        borderWidth: 1,
                        data: []
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: "top",
                        },
                        title: {
                            display: true,
                            text: "Accounts Payable and Receivable -" + ano
                        }
                    },
                    scales: {
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: "Value",
                                color: "#000000",
                                font: {
                                    weight: "bold",
                                }
                            }
                        },
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: "Months of the year",
                                color: "#000000",
                                font: {
                                    weight: "bold",
                                }
                            }
                        }
                    }
                }
            }
        );

        $.ajax({
            type: "POST",
            cache: false,
            url: "conta_receber_crud.php",
            data: {
                acao: "grafico",
                ano: ano,
                usuario: id_usuario
            },
            dataType: "json",
            success: function (data) {
                const dados = Object.values(data[0]);
                graficoBarra.data.datasets[0].data = dados
                graficoBarra.update()
            },
            error: function (e) {
                $("#div_mensagem_texto_menu").empty().append(e.responseText);
                $("#div_mensagem_menu").show();
            },
            beforeSend: function () {
                $("#carregando_menu").removeClass("d-none");
            },
            complete: function () {
                $("#carregando_menu").addClass("d-none");
            }
        });


        $.ajax({
            type: "POST",
            cache: false,
            url: "conta_pagar_crud.php",
            data: {
                acao: "grafico",
                ano: ano,
                usuario: id_usuario
            },
            dataType: "json",
            success: function (data) {
                const dados = Object.values(data[0]);
                graficoBarra.data.datasets[1].data = dados
                graficoBarra.update()
            },
            error: function (e) {
                $("#div_mensagem_texto_menu").empty().append(e.responseText);
                $("#div_mensagem_menu").show();
            },
            beforeSend: function () {
                $("#carregando_menu").removeClass("d-none");
            },
            complete: function () {
                $("#carregando_menu").addClass("d-none");
            }
        });
    });

    $("#home_link").click(function () {
        $(location).prop("href", "menu.php");
    });

    $("#categoria_link").click(function (e) {
        $("#conteudo").load("categoria_index.php");
    });

    $("#favorecido_link").click(function (e) {
        $("#conteudo").load("favorecido_index.php");
    });

    $("#contareceber_link").click(function (e) {
        $("#conteudo").load("conta_receber_index.php");
    });

    $("#contapagar_link").click(function (e) {
        $("#conteudo").load("conta_pagar_index.php");
    });

    $("#usuario_link").click(function (e) {
        $("#conteudo").load("usuario_index.php");
    });

    $("#logout_modal_sim").click(function (e) {
        $(location).attr("href", "logout.php");
    });

    $("#sobre_link").click(function () {
        $("#sobre_modal").modal("show");
    });

    $("#logout_link").click(function () {
        $("#logout_modal").modal("show");
    });


    const showNavbar = (toggleId, navId, bodyId, headerId) => {
        const toggle = document.getElementById(toggleId),
            nav = document.getElementById(navId),
            bodypd = document.getElementById(bodyId),
            headerpd = document.getElementById(headerId)

        // Validate that all variables exist
        if (toggle && nav && bodypd && headerpd) {
            toggle.addEventListener('click', () => {
                // show navbar
                nav.classList.toggle('showtab')
                // change icon
                toggle.classList.toggle('fa-times')
                // add padding to body
                bodypd.classList.toggle('body')
                // add padding to header
                headerpd.classList.toggle('body')
            })
        }
    }

    showNavbar('header-toggle', 'nav-bar', 'body', 'header');

    /*===== LINK ACTIVE =====*/
    const linkColor = document.querySelectorAll('.nav_link');

    function colorLink() {
        if (linkColor) {
            linkColor.forEach(l => l.classList.remove('activemenu'));
            this.classList.add('activemenu');
        }
    }
    linkColor.forEach(l => l.addEventListener('click', colorLink));

});