// Função para validar as perguntas da satisfação
$(function () {
    $.validator.messages.required = 'Campo obrigatório';

    var currentGfgStep, nextGfgStep, previousGfgStep;
    var opacity;
    var current = 1;
    var formularioSatisfacao = $('#satisfacao');
    var steps = $("fieldset").length;

    // setProgressBar(current);

    function next(elem) {
        atual_fs = $(elem).parent();
        next_fs = $(elem).parent().next();

        $('#progress li').eq($('fieldset').index(next_fs)).addClass('ativo');
        atual_fs.hide(800);
        next_fs.show(800);
    }

    // Validar dados da etapa 1 do formulário
    $('input[name=nextstep1]').click(function () {
        // var array = formularioSatisfacao.serializeArray();
        var formularioSatisfacao = $("#satisfacao");
        formularioSatisfacao.validate({
            rules: {
                inputEmail: {
                    required: true
                },
                inputNome: {
                    required: true
                },
            },
        });
        if (formularioSatisfacao.valid() == true) {
            currentGfgStep = $(this).parent();
            nextGfgStep = $(this).parent().next();

            nextGfgStep.show();

            currentGfgStep.animate({
                opacity: 0
            }, {
                step: function (now) {
                    opacity = 1 - now;

                    currentGfgStep.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    nextGfgStep.css({
                        'opacity': opacity
                    });
                },
                duration: 500
            });
            setProgressBar(++current);
        }
    });

    // Validar dados da etapa 2 do formulário
    $('input[name=nextstep2]').click(function () {
        var formularioSatisfacao = $("#satisfacao");

        if (formularioSatisfacao.valid() == true) {
            currentGfgStep = $(this).parent();
            nextGfgStep = $(this).parent().next();

            nextGfgStep.show();

            currentGfgStep.animate({
                opacity: 0
            }, {
                step: function (now) {
                    opacity = 1 - now;

                    currentGfgStep.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    nextGfgStep.css({
                        'opacity': opacity
                    });
                },
                duration: 500
            });
            setProgressBar(++current);
        } else {
            swal({
                title: 'Favor preencher todos os campos!',
                text: 'Alguns campos ficaram em branco!',
                type: 'info',
                timer: 2000
            },
            )

        }
    });

    // Validar dados da etapa 3 do formulário
    $('input[name=finalizar]').click(function () {
        var formularioSatisfacao = $("#satisfacao");
        var send = $("#finalizar");

        if (formularioSatisfacao.valid() == true) {
            send.attr('disabled', 'disabled');
            send.val('Aguarde...');
            document.getElementById("satisfacao").submit();
        } else {
            swal({
                title: 'Favor preencher todos os campos!',
                text: 'Alguns campos ficaram em branco!',
                type: 'info',
                timer: 2000
            },
            )
        }
    });

    $(".previous-step").click(function () {

        currentGfgStep = $(this).parent();
        previousGfgStep = $(this).parent().prev();

        previousGfgStep.show();

        currentGfgStep.animate({
            opacity: 0
        }, {
            step: function (now) {
                opacity = 1 - now;

                currentGfgStep.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previousGfgStep.css({
                    'opacity': opacity
                });
            },
            duration: 500
        });
        setProgressBar(--current);
    });

    function setProgressBar(currentStep) {
        var percent = parseFloat(100 / steps) * current;
        percent = percent.toFixed();
        $(".progress-bar")
            .css("width", percent + "%")
    }
});

//Gerar Relatório de Pesquisa de Satisfação
function gerarSatisfacao() {
    var inputValores = {
        'requestData': $('input[name=inputData]').val(), //Store name fields value
        'requestDataFim': $('input[name=inputDataFim]').val(), //Store name fields value
        'requestEspacos': $('select[name=inputEspacos]').val(), //Store name fields value
        'requestSecretarias': $('select[name=inputSecretarias]').val(), //Store name fields value
        'requestQuestao': $('select[name=inputQuestao]').val(), //Store name fields value
        'requestDiaSemana': $('select[name=inputDiaSemana]').val() //Store name fields value
    };

    const response = $.ajax({
        url: "gerarSatisfacao.php",
        type: "POST",
        data: inputValores,
        success: function (resultado) {
            //console.log(resultado);
            $("#visul_usuario").html(resultado);
            //$('#visulUsuarioModal').modal('show');


        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
}

// Função para validar as etapas do cadastro das reservas
$(function () {
    var atual_fs, next_fs, prev_fs;
    var formulario = $('#solicReserva');

    function next(elem) {
        atual_fs = $(elem).parent();
        next_fs = $(elem).parent().next();

        $('#progress li').eq($('fieldset').index(next_fs)).addClass('ativo');
        atual_fs.hide(800);
        next_fs.show(800);
    }

    $('.prev').click(function () {
        atual_fs = $(this).parent();
        prev_fs = $(this).parent().prev();

        $('#progress li').eq($('fieldset').index(atual_fs)).removeClass('ativo');
        atual_fs.hide(800);
        prev_fs.show(800);
    });

    $('input[name=next1]').click(function () {
        var array = formulario.serializeArray();
        var form = $("#solicReserva");

        form.validate({
            rules: {
                inputHora: {
                    required: true
                },
                inputHoraFim: {
                    required: true
                },
                inputData: {
                    required: true
                },
                inputDataFim: {
                    required: true
                },
            },
            messages: {
                inputData: {
                    min: jQuery.validator.format("Por favor, forneça um valor maior ou igual a {0}."),

                },
                inputDataFim: {
                    min: jQuery.validator.format("Por favor, forneça um valor maior ou igual a {0}."),

                },
                inputHora: {
                    min: jQuery.validator.format("Por favor, forneça um valor maior ou igual a {0}."),
                    max: jQuery.validator.format("Por favor, forneça um valor maior ou igual a {0}."),

                },
                inputHoraFim: {
                    min: jQuery.validator.format("Por favor, forneça um valor maior ou igual a {0}."),
                    max: jQuery.validator.format("Por favor, forneça um valor menor ou igual a {0}.")
                },
                inputEspacos: {
                    required: "Favor, escolha um espaço!",
                },
            }
        });
        if (form.valid() == true) {
            next($(this));
        }
    });

    $('input[name=next2]').click(function () {
        var array = formulario.serializeArray();
        var form = $("#solicReserva");

        form.validate({
            rules: {
                inputObjetivo: {
                    required: true
                },
            },
        });

        if (form.valid() == true) {
            next($(this));
        }
    });

    $('input[name=solicres]').click(function () {
        var array = formulario.serializeArray();
        var form = $("#solicReserva");
        var send = $("#solicres");

        form.validate({
            rules: {
                inputContato: {
                    required: true
                },
                inputTelefoneRamal: {
                    required: true
                },
                inputEmail: {
                    required: true
                }
            },
        });

        if (form.valid() == true) {
            mostrarTermos();
            send.attr('disabled', 'disabled');
            send.val('Aguarde...');

        }

    });
});

// Função mascára para celular de 8 ou 9 digitos
function mascara(o, f) {
    v_obj = o
    v_fun = f
    setTimeout("execmascara()", 1)
}
function execmascara() {
    v_obj.value = v_fun(v_obj.value)
}
function mtel(v) {
    numero = v.length;
    v = v.replace(/\D/g, "");             //Remove tudo o que não é dígito
    if (numero >= 8) {
        v = v.replace(/^(\d{2})(\d)/g, "($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
        v = v.replace(/(\d)(\d{4})$/, "$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
    }
    return v;
}
function id(el) {
    return document.getElementById(el);
}

// Função para buscar salas disponíveis conforme a data e horário informados pelo usuário
function buscaSalas() {
    var inputValores = {
        'dataInicial': $('input[name=inputData]').val(), //Store name fields value
        'dataFinal': $('input[name=inputDataFim]').val(),
        'horaInicial': $('input[name=inputHora]').val(),
        'horaFinal': $('input[name=inputHoraFim]').val(),
        'requestEspacos': $('option[name=requestEspacos]').val()
    };

    if (inputValores['dataInicial'] != "" && inputValores['horaInicial'] != "" && inputValores['horaFinal'] != "") {
        const response = $.ajax({
            url: "carrega_salas.php",
            type: "POST",
            data: inputValores,
            success: function (resultado) {
                //console.log(result);
                $(".resultAjax").html(resultado);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

// Função para validar horário de abertura das salas
function validaHorarioAbertura() {
    var horaInicial = { //Fetch form data
        'idEspaco': $('#inputEspacos').val(),
        'horaInicial': $('input[name=inputHora]').val()
    };

    if (horaInicial['idEspaco'] != null && horaInicial['horaInicial'] != "") {

        const response = $.ajax({
            url: "valida_horario_abertura.php",
            type: "POST",
            data: horaInicial,
            success: function (resultado) {
                $('#inputHora').prop('min', resultado);
                if (document.getElementById('maisDiaCheck').checked) {
                    $('#inputHoraFim').prop('min', resultado);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

// Função para validar horário de fechamento das salas
function validaHorarioFechamento() {
    var horaFinal = { //Fetch form data
        'idEspaco': $('#inputEspacos').val(),
        'horaFinal': $('input[name=inputHoraFim]').val()
    };

    if (horaFinal['idEspaco'] != null && horaFinal['horaFinal'] != "") {
        const response = $.ajax({
            url: "valida_horario_fechamento.php",
            type: "POST",
            data: horaFinal,
            success: function (resultado) {
                $('#inputHoraFim').prop('max', resultado);
                if (document.getElementById('maisDiaCheck').checked) {
                    $('#inputHora').prop('max', resultado);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

// Função para mostrar termos de compromisso
function mostrarTermos(termosID) {
    const termos = document.getElementById(termosID);
    var valPdf = "";
    var varEspaco = $('#inputEspacos').val();
    var varObjetivo = $('#inputObjetivo').val();
    var varResponsavel = $('#inputContato').val();
    var varTel = $('#inputTelefoneRamal').val();
    var validaTermo = valPdf.concat("../dist/uploads/Espacos/", String($("#inputEspacos").val()), "/termodecompromisso.pdf");
    var send = $("#solicres");

    fetch(validaTermo).then(function (response) {
        if (!response.ok) {
            throw Error();
        }
        return response;
    }).then(function (response) {
        result = true;
        return result;
    }).catch(function (error) {
        result = false;
        return result;
    });

    if (termos && varEspaco != null && varObjetivo != "" && varResponsavel != "" && varTel != "") {
        if (result != false) {
            termos.classList.add('mostrar');
            $("#termo").attr('src', validaTermo);

            termos.addEventListener('click', (evento) => {
                if (evento.target.id == termosID || evento.target.className == 'fechar') {
                    termos.classList.remove('mostrar');
                    send.attr('disabled', false);
                    send.val('Solicitar Reserva');
                }
            });
        } else {
            document.getElementById("solicReserva").submit();
        }
    }
    if ($('#submitTermosCheck').is(':checked')) {
        $("#solicReserva").submit();
    }
}

const popup = document.querySelector('#solicres');
const form = document.querySelector('#solicReserva');
popup.addEventListener('click', () => mostrarTermos('popup-container'));

function buscaInfo(pk_reservas) {
    var inputValores = {
        'pk_reservas': pk_reservas //Store name fields value
    };

    //console.log(getData);
    if (inputValores['pk_reservas'] != "" && inputValores['pk_reservas'] != null) {
        const response = $.ajax({
            url: "buscaInfo.php",
            type: "POST",
            data: inputValores,
            success: function (resultado) {
                //console.log(resultado);
                $("#visul_usuario").html(resultado);
                $('#visulUsuarioModal').modal('show');

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

function buscaInfoCalendar(pk_eventos) {
    var inputValores = {
        'pk_eventos': pk_eventos //Store name fields value
    };
    if (inputValores['pk_eventos'] != "" && inputValores['pk_eventos'] != null) {
        const response = $.ajax({
            url: "buscaInfoCalendar.php",
            type: "POST",
            data: inputValores,
            success: function (resultado) {
                $("#visul_usuario").html(resultado);
                $('#visulUsuarioModal').modal('show');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

function gerarRelatorio() {
    var inputValores = {
        'requestData': $('input[name=inputData]').val(), //Store name fields value
        'requestDataFim': $('input[name=inputDataFim]').val(), //Store name fields value
        'requestEspacos': $('select[name=inputEspacos]').val(), //Store name fields value
        'requestSecretarias': $('select[name=inputSecretarias]').val(), //Store name fields value
        'requestStatus': $('select[name=enunciado]').val(), //Store name fields value
        'requestDiaSemana': $('select[name=inputDiaSemana]').val() //Store name fields value
    };

    const response = $.ajax({
        url: "gerarRelatorio.php",
        type: "POST",
        data: inputValores,
        success: function (resultado) {
            //console.log(resultado);
            $("#visul_usuario").html(resultado);
            //$('#visulUsuarioModal').modal('show');


        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
}

function changeFunc() {
    var inputData = document.getElementById("inputData");
    var inputDataFim = document.getElementById("inputDataFim");
    var inputDiaSemana = document.getElementById("inputDiaSemana");

    var selectedValue = inputDiaSemana.options[inputDiaSemana.selectedIndex].value;
    if (!selectedValue) {
        inputData.removeAttribute("disabled", "");
        inputDataFim.removeAttribute("disabled", "");
    }
}