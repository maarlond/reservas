<?php
session_start();
include "conexaoDB.php";
include "sweetalert.html";
include "funcoesNotificacoes.php";

if (isset($_REQUEST['pk_reservas'])) {
    $pk_reserva = $_REQUEST['pk_reservas'];
}
$espaco = 0;
$datainicial = date("Y-m-d");
$query_espacos_disp = "";

function buscaEspacos($conexao)
{
    $query_espacos = "SELECT pk_espacos, nome, cor, intervalo_horarios FROM espaços WHERE status = 1  AND  grupo_salas = " . $_SESSION['sistemaGrupoSalas']  . " ORDER BY nome asc";
    $dados = mysqli_query($conexao, $query_espacos) or die("Error in query_espacos: $query_espacos." . mysqli_error($conexao));
    return $dados;
}

if (isset($pk_reserva)) {
    $query_reserva = "SELECT * FROM reservas INNER JOIN eventos on pk_eventos = fk_eventos WHERE pk_reservas = " . $pk_reserva;
    $dados_reserva = mysqli_query($conexao, $query_reserva) or die("Error in query_reserva: $query_reserva." . mysqli_error($conexao));
    $registro_reserva = mysqli_fetch_assoc($dados_reserva);
}

if (isset($_REQUEST['pk_reservas'])) {

    $caminho = "./uploads/Reservas/" . $_REQUEST['pk_reservas'] . "/";
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Reservas de Espaços</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/etapas.css" rel="stylesheet" />

    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>

    <link href='../lib/main.css' rel='stylesheet' />
    <script src='../lib/main.js'></script>
    <script src='../lib/locales-all.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {

                locale: 'pt-br',
                dayMaxEvents: 3,
                selectable: true,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth listWeek dayGridWeek'
                },
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    eventId = info.event.id;
                    info.el.style.backgroundColor = 'gray';
                    info.el.style.borderColor = 'gray';

                    buscaInfoCalendar(eventId);
                },
                events: {
                    url: './listarEventos.php?espaco=0',
                    extraParams: function() {
                        return {
                            cachebuster: new Date().valueOf()
                        };
                    }
                }
            });

            calendar.render();
        });



        document.addEventListener('DOMContentLoaded', function() {
            show();
        });

        function show() {
            if (document.getElementById('maisDiaCheck').checked) {
                document.getElementById('labelDataFim').style.display = 'block';
                document.getElementById('inputDataFim').style.display = 'block';
            } else {
                $("#inputDataFim").prop("value", "");

                document.getElementById('labelDataFim').style.display = 'none';
                document.getElementById('inputDataFim').style.display = 'none';
            }
        }

        //Controle de horas e datas conforme a checagem de dias
        function controlStart() {
            if (document.getElementById('maisDiaCheck').checked) {
                let data = new Date();
                data.setDate(data.getDate() + 1);
                var dia = data.getDate().toString().padStart(2, '0');
                var mes = (data.getMonth() + 1).toString().padStart(2, '0');
                var dataFim = data.getFullYear() + "-" + mes + "-" + dia;
                document.getElementById("inputDataFim").min = dataFim;

                $('#inputHoraFim').attr('min', "");
                value = document.getElementById("inputDataFim").value;

                //$('#inputHoraFim').attr('required', this.value == 'req');

                if ($("#inputDataFim").val()) {
                    let d = new Date($("#inputDataFim").val());
                    d.setDate(d.getDate());
                    var dia = d.getDate().toString().padStart(2, '0');
                    var mes = (d.getMonth() + 1).toString().padStart(2, '0');

                    var datafinal = d.getFullYear() + "-" + mes + "-" + dia;
                    document.getElementById("inputData").max = datafinal;

                }
                if ($("#inputData").val()) {
                    let d = new Date($("#inputData").val());
                    d.setDate(d.getDate() + 2);
                    var dia = d.getDate().toString().padStart(2, '0');
                    var mes = (d.getMonth() + 1).toString().padStart(2, '0');

                    var datafinal = d.getFullYear() + "-" + mes + "-" + dia;
                    document.getElementById("inputDataFim").min = datafinal;
                }
            } else {
                value = document.getElementById("inputHora").value;
                $('#inputHoraFim').attr('min', value);
            }
            show();
        }
    </script>

    <style>
        .error {
            color: red;
            border-color: red;
        }

        body {
            margin: 0;
            padding: 0;
        }

        #script-warning {
            display: none;
            background: #eee;
            border-bottom: 1px solid #ddd;
            padding: 0 10px;
            line-height: 40px;
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            color: red;
        }

        #loading {
            display: none;
            position: absolute;
            top: 10px;
            right: 10px;
        }

        #calendar {
            max-width: 1060px;
            margin: 40px auto;
            padding: 0 10px;
        }

        .bola {
            margin-left: 10px;
            margin-right: 3px;
            border-radius: 50%;
            display: inline-block;
            height: 12px;
            width: 12px;
        }

        #popup-container {
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            position: fixed;
            top: 0px;
            left: 0px;
            z-index: 2000;
            display: none;
            justify-content: center;
            align-items: center;
        }

        #popup-container.mostrar {
            display: flex;
        }

        #popup {
            background: white;
            min-width: 300px;
            padding: 40px;
            border-radius: 0.7%;
            position: absolute;
        }


        @media only screen and (max-device-width: 1450px) {
            #termo {
                width: 30em;
                height: 30em;
            }
        }

        @media only screen and (min-device-width: 1451px) {
            #termo {
                width: 45em;
                height: 40em;
            }

            #calendar {
                max-width: 1300px;
            }
        }
    </style>

</head>

<body class="sb-nav-fixed">

    <!-- Incluindo menu header -->
    <?php include "header.php";
    require "verificarAcesso.php";
    ?>

    <!-- Incluindo menu header -->
    <div id="layoutSidenav">
        <!-- Incluindo menu esquerdo -->
        <?php include "nav.php" ?>
        <!-- Incluindo menu esquerdo -->
        <div id="layoutSidenav_content">
            <main>
                <!-- Menu para solicitar reserva -->
                <div style="margin-top:0.5%;" class="container-fluid">
                    <form id="solicReserva" action="insertReserva.php" method="POST" enctype="multipart/form-data">
                        <ul id="progress">
                            <li class="ativo"></li>
                            <li></li>
                        </ul>
                        <?php  ?>

                        <?php echo buscaNotificacao1($conexao); ?>

                        <?php echo buscaNotificacao2($conexao); ?>


                        <fieldset id="horario">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" id="labelData" for="inputData">Data Início:</label><a style="color:red;" title="Campo obrigatório"> * </a>
                                        <input required class="form-control py-2 valor" id="inputData" name="inputData" type="date" min=<?= $datainicial; ?> onchange="controlStart(); buscaSalas();" value="<?= isset($_REQUEST['pk_reservas']) ? $registro_reserva["dt_ini"] : "";  ?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" id="labelDataFim" for="inputDataFim">Data Fim: <a style="color:red;" title="Campo obrigatório"> * </a></label>
                                        <input required class=" form-control py-2 valor" id="inputDataFim" name="inputDataFim" type="date" onchange="controlStart(); buscaSalas();" value="<?= isset($_REQUEST['pk_reservas']) ? $registro_reserva["dt_fim"] : ""; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputHora">Hora Início</label><a style="color:red;" title="Campo obrigatório"> * </a>
                                        <input required class="form-control py-2" id="inputHora" name="inputHora" type="time" onchange="controlStart(); buscaSalas(); validaHorarioAbertura();" value="<?= isset($_REQUEST['pk_reservas']) ? $registro_reserva["hr_ini"] : ""; ?>" />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small mb-1" id="labelHoraFim" for="inputHoraFim">Hora Fim</label><a style="color:red;" title="Campo obrigatório"> * </a>
                                        <input required class="form-control py-2" id="inputHoraFim" name="inputHoraFim" type="time" onchange="controlStart(); buscaSalas(); validaHorarioFechamento();" value="<?= isset($_REQUEST['pk_reservas']) ? $registro_reserva["hr_fim"] : ""; ?>" />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputEspacos">Espaços</label><a style="color:red;" title="Campo obrigatório"> * </a>
                                        <select selected disabled hidden required>
                                            <option name="requestEspacos" id="requestEspacos" selected disabled hidden value="<?= isset($pk_reserva) ? $registro_reserva["pk_reservas"] : ""; ?>"></option>
                                        </select>
                                        <select required class="form-control resultAjax py-2" name="inputEspacos" id="inputEspacos" type="sala" placeholder="Escolha a sala<" onclick="controlStart();" onchange="mostrarTermos(); validaHorarioAbertura(); validaHorarioFechamento();">
                                            <option value="" selected disabled hidden>Favor, insira a data e horário para escolher a sala</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" style="float:left">
                                <div class="custom-control custom-checkbox">
                                    <?php
                                    if (isset($_REQUEST['pk_reservas'])) {
                                        $checkedMaisdeUmDia = $registro_reserva["dt_fim"] != "NULL" ? "checked" : "";
                                    }
                                    ?>

                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" id="maisDiaCheck" type="checkbox" name="maisDiaCheck" <?= !empty($checkedMaisdeUmDia) ? $checkedMaisdeUmDia : ""; ?> onchange="show();" onclick="controlStart();" />
                                        <label class="custom-control-label" for="maisDiaCheck">Mais de um dia</label>
                                    </div>
                                </div>
                            </div>

                            <input class="acao next btn btn-primary" type="button" name="next1" value="Próximo">
                        </fieldset>

                        <fieldset id="administrador">
                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputContato">Operador da Reserva</label><a style="color:red;" title="Campo obrigatório"> * </a>
                                        <input required disabled class="form-control py-2" type="text" value="<?= verificaUsuarioSessaoLogado(); ?>" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputContato">Responsável da Reserva</label><a style="color:red;" title="Campo obrigatório"> * </a>
                                        <input required class="form-control py-2" id="inputContato" name="inputContato" type="text" title="Digite o responsável da reunião" placeholder="Responsável da Reserva" value="<?= isset($_REQUEST['pk_reservas']) ? $registro_reserva["contato"] : ""; ?>" />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputEmail">E-mail do Responsável da Reserva</label><a style="color:red;" title="Campo obrigatório"> * </a>
                                        <input required type="email" class="form-control" name="inputEmail" aria-describedby="emailHelp" placeholder="Email do Responsável" value="<?= isset($_REQUEST['pk_reservas']) ? $registro_reserva["email"] : ""; ?>" />
                                    </div>
                                </div>
                                <div class=" col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputObjetivo">Objetivo</label><a style="color:red;" title="Campo obrigatório"> * </a>
                                        <input required class="form-control py-2" id="inputObjetivo" name="inputObjetivo" maxlength="90" type="text" placeholder="Descrição do objetivo" value="<?= isset($_REQUEST['pk_reservas']) ? $registro_reserva["titulo"] : ""; ?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputTelefoneRamal">Telefone/Ramal</label><a style="color:red;" title="Campo obrigatório"> * </a>
                                        <input required class="form-control py-2" id="inputTelefoneRamal" name="inputTelefoneRamal" type="text" maxlength="15" placeholder="(51) XXXXX-XXXX (cel) ou  (51) XXXX-XXXX (fixo)" onblur="mascara(this, mtel)" value="<?= isset($_REQUEST['pk_reservas']) ? $registro_reserva["ramal"] : ""; ?>" />
                                    </div>
                                </div>

                                <div class="col-md-6" style="margin-top: 0.5em;">
                                    <div class="control-group">
                                        <label class="control-label">Anexar documentos (.png, .jpg, .pdf) até 10MB)</label>
                                        <div class="controls">
                                            <div id="anexoVariavel">
                                                <input id="anexo" type="file" multiple name="fotosReserva[]" onchange="validarArquivo();" />
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="control-group">
                                        <?php if (isset($_REQUEST['pk_reservas_this']) && file_exists($caminho)) {
                                            if (count(glob($caminho . "/*")) !== 0) {
                                        ?>
                                                <div class="d-flex flex-row-reverse" style="font-weight: bold;">
                                                    <div class="p-2 col-md-12">
                                                        <?php include "uploadListar.php"; ?>
                                                    </div>
                                                </div>
                                        <?php }
                                        } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" style="float:right;">
                                <div class="col-md-12">
                                    <?php if (isset($_REQUEST['pk_reservas'])) { ?>
                                        <input type="hidden" id="pk_reservas_this" name="pk_reservas_this" value="<?= $registro_reserva['pk_reservas'] ?>" />

                                        <button style="margin-top:19%; font-weight:bold;" class="btn btn-success" type="submit" id="fk_eventos" name="fk_eventos" value="<?= $registro_reserva['fk_eventos']; ?>">Alterar Reserva</button>
                                    <?php } else { ?>
                                        <input style="margin-top:2em;" id="solicres" name="solicres" class="acao btn btn-success" type="button" value="Solicitar Reserva">
                                    <?php } ?>
                                </div>

                            </div>
                            <input style="float:right; margin-top: 2em;" type="button" class="acao prev btn btn-primary" name="prev" value="Anterior">

                        </fieldset>

                        <div class="form-group" style="margin-top: 2%;">
                            <div class="custom-control custom-checkbox">
                                <?php
                                if (isset($_REQUEST['pk_reservas'])) {
                                    $checkedPublico = $registro_reserva["div_publico"] == 1 ? "checked" : "";
                                }
                                if ($_SESSION['titulo'] == "Reserva de Espaços") {
                                    $checkedPublico = "checked";
                                    //$checkPublico  = "hidden";
                                } else if ($_SESSION['titulo'] == "CAFF Working") {
                                    $checkedPublico = "checked";
                                }
                                ?>
                                <div class="custom-control custom-checkbox">
                                    <a data-toggle="tooltip" data-placement="top" title="Evento disponibilizado para visualização no calendário:
Público: no calendário disponível no portal do CAFF aparecerá 
o título da sua reserva, quem reservou, além do dia e horário reservados; 
Privado: no calendário disponíivel no portal do CAFF aparecerá apenas que 
o espaço está reservado.">
                                        <input class="custom-control-input" id="submitPublicoCheck" type="checkbox" name="submitPublicoCheck" <?= !empty($checkedPublico) ? $checkedPublico : ""; ?> />
                                        <label class="custom-control-label" for="submitPublicoCheck" <?= !empty($checkPublico) ? $checkPublico : ""; ?>>Público</label></a>
                                </div>
                            </div>
                        </div>

                        <!--Editar/Cancelar reservas-->
                        <div style="margin-left: 1em;">
                            <?php
                            $dados = buscaEspacos($conexao);
                            if ($dados->num_rows > 0) {
                                echo "<span style='font-weight:bold;'> * Intervalo entre as reservas</span>";
                                echo "<br>";
                                //$dados = mysqli_query($conexao, $query_espacos);
                                while ($linha = mysqli_fetch_assoc($dados)) {
                                    echo "<span class='bola' style='background-color:" . $linha["cor"] . "'></span>";
                                    echo "<span>" . $linha['nome'] . "</span>";
                                    if (isset($linha['intervalo_horarios'])) {
                                        echo "<span> * " . $linha['intervalo_horarios'] . "</span>";
                                    }
                                    echo " |";
                                }
                            }
                            ?>
                        </div>
                        <?php ?>
                    </form>

                    <!-- Mostrar termos de compromisso -->
                    <div id="popup-container" class="form-group">
                        <div id="popup" class="custom-control custom-checkbox">
                            <div id="popup-termo" style="text-align: center;">
                                <iframe id="termo" src="" frameborder="0"></iframe>
                            </div>
                            <div style="margin-top: 5%; float:right;">
                                <input required class="form-check-input" id="submitTermosCheck" type="checkbox" name="submitTermosCheck" onchange="mostrarTermos();">
                                <label class="form-check-label" for="submitTermosCheck"><b>Li e aceito os termos de compromisso</b></label>
                            </div>
                        </div>
                    </div>
                </div>

                <?php include "detalhesReserva.php" ?>

                <div id='script-warning'>
                    <code>../php/get-events.php</code> must be running.
                </div>
                <div id='loading'>loading...</div>

                <div id='calendar'></div>
                <div id='legendas'></div>
            </main>
            <?php include "direitos.php"; ?>
        </div>
    </div>


    <!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>-->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="js/functions.js"></script>
    <script src="js/jquery.validate.pt-br.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="https://jqueryvalidation.org/files/dist/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

    <script>
        $(document).ready(function() {
            buscaSalas();
        });

        function exibirCheckboxTermos() {
            var val = $('#anexo').val().toLowerCase(),
                regexPdf = new RegExp("(.*?)\.(pdf)$");

            if ((regexPdf.test(val))) {
                document.getElementById("termos").hidden = false;
            } else {
                document.getElementById("termos").hidden = true;
            }
        }

        function validarArquivo() {
            var val = $('#anexo').val().toLowerCase(),
                regexArquivos = new RegExp("(.*?)\.(png|pdf|jpg)$");

            var arquivoInput = document.getElementById('#anexo');

            if (!(regexArquivos.test(val))) {
                document.getElementById('anexo').value = ''; // Limpa o campo
                swal({
                    title: 'Erro!',
                    text: 'Extensão de arquivo inválida. <br> Utilize .png .jpg ou .pdf!',
                    html: true,
                    type: 'error'
                }, );
            }
        }
    </script>

</body>

</html>