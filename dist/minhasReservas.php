<?php
//ini_set('display_errors',1);
//ini_set('display_startup_erros',1);
//error_reporting(E_ALL);
session_start();
require "verificarAcesso.php";
include "conexaoDB.php";
include "sweetalert.html";

function execute($conexao)
{

    if ($_SESSION['auth'] ==   "SOEAUTH") {
        $filtro = "(fk_soe_users = " . verificaIDSessaoLogado() . "
        OR
        fk_glpi_users = (SELECT fk_glpi_users FROM user_permissao WHERE fk_soe_users = " . verificaIDSessaoLogado() . " ))";
    } else if ($_SESSION['auth'] ==   "GLPI") {
        $filtro = "(fk_glpi_users = " . verificaIDSessaoLogado() . "
        OR
        fk_glpi_users = (SELECT fk_soe_users FROM user_permissao WHERE fk_glpi_users = " . verificaIDSessaoLogado() . " ))";
    }

    $query_reservas = "SELECT pk_reservas, titulo, espaços.nome, hr_ini, hr_fim, reservas.status, dt_ini, dt_fim, DATE_FORMAT(dt_ini, '%d/%m/%Y') as dt_ini_formatado,
                        DATE_FORMAT(dt_fim, '%d/%m/%Y') as dt_fim_formatado, contato, ramal, select_webex
                        FROM reservas
                        inner join eventos
                        on fk_eventos = pk_eventos
                        inner join espaços
                        on fk_espacos = pk_espacos
                        WHERE
                        " . $filtro . "
                        AND
                        grupo_salas =  " . $_SESSION['sistemaGrupoSalas']  . "
                        ORDER BY pk_eventos desc";
    $dados =  mysqli_query($conexao, $query_reservas) or die("Error in query_reservas: $query_reservas." . mysqli_error($conexao));

    return $dados;
}

$caminho = "./uploads/Reservas/";

$dataAtual = date('Y-m-d');

?>
<!-- <!DOCTYPE html> -->
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Minhas Reservas</title>


    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <link href='../lib/main.css' rel='stylesheet' />
    <script src='../lib/main.js'></script>

    <style>
        .customSwalBtn {
            background-color: rgba(214, 130, 47, 1.00);
            border-left-color: rgba(214, 130, 47, 1.00);
            border-right-color: rgba(214, 130, 47, 1.00);
            border: 0;
            border-radius: 3px;
            box-shadow: none;
            color: #fff;
            cursor: pointer;
            font-size: 17px;
            font-weight: 500;
            margin: 30px 5px 0px 5px;
            padding: 10px 32px;
        }

        .SwalBtn3 {
            background-color: rgb(0, 105, 217);
        }

        .SwalBtn1 {
            background-color: white;
            color: black;
        }

        .SwalCancelVoltar {
            background-color: white;
            color: black;
        }
    </style>
</head>


<body id="sb-nav-fixed">

    <?php include("header.php");
    require "verificarAcesso.php";
    $dados = execute($conexao);
    ?>

    <!-- Page Wrapper -->
    <div id="layoutSidenav">

        <!-- Sidebar -->
        <?php include("nav.php"); ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="layoutSidenav_content">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->

                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <br>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text">Minhas Solicitações de Reservas</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTableSetor" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr align="center">
                                            <th>ID</th>
                                            <th>Espaço</th>
                                            <th>Título</th>
                                            <th>Data Início</th>
                                            <th>Hora Início</th>
                                            <th>Data Fim</th>
                                            <th>Hora Fim</th>
                                            <th>Contato/Telefone</th>
                                            <th>Status</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="thead-dark" align="center">
                                            <th>ID</th>
                                            <th>Espaço</th>
                                            <th>Título</th>
                                            <th>Data Início</th>
                                            <th>Hora Início</th>
                                            <th>Data Fim</th>
                                            <th>Hora Fim</th>
                                            <th>Contato/Telefone</th>
                                            <th>Status</th>
                                            <th>Ações</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>

                                        <?php
                                        if (mysqli_num_rows($dados) > 0) {
                                            while ($linha = mysqli_fetch_assoc($dados)) {
                                        ?>
                                                <tr class="odd gradeX" align="center">
                                                    <td><?= $linha["pk_reservas"] ?></td>
                                                    <td><?= $linha["nome"] ?></td>
                                                    <td><?= $linha["titulo"] ?>
                                                        <?php if (count(glob($caminho . $linha['pk_reservas'] . "/*")) !== 0) { ?>
                                                            <?php if (file_exists($caminho . $linha['pk_reservas'] . "/")) { ?>
                                                                <i class="fas fa-paperclip" data-toggle="tooltip" title="Existe Anexo!"></i>
                                                        <?php }
                                                        } ?>
                                                    </td>
                                                    <td><?= $linha["dt_ini_formatado"] ?></td>
                                                    <td><?= $linha["hr_ini"] ?></td>
                                                    <td><?= $linha["dt_fim_formatado"] ?></td>
                                                    <td><?= $linha["hr_fim"] ?></td>
                                                    <td><?= $linha["contato"]; ?><br><?= $linha["ramal"]; ?></td>
                                                    <td><?= $linha["status"] ?></td>

                                                    <td align="center">
                                                        <form id="formulario" name="formulario" action="reservar.php" method="post">
                                                            <input type="hidden" id="pk_reservas" name="pk_reservas" value="" />
                                                            <input type="hidden" id="passaStatus" name="passaStatus" value="" />
                                                            <input type="hidden" id="passaMotivo" name="passaMotivo" value="" />
                                                            <input type="hidden" id="pk_reservas_this" name="pk_reservas_this" value="<?= $linha['pk_reservas'] ?>" />
                                                            <?php if (strtotime($linha['dt_ini']) >= strtotime($dataAtual)) { ?>
                                                                <div class="btn-group d-flex justify-content-center">
                                                                    <button type="submit" class="btn btn-success btn-circle btn-sm" id="pk_reservas" name="pk_reservas" value="<?= $linha['pk_reservas'] ?>" data-toggle="tooltip" data-placement="top" title="Edita a reserva e visualiza as informações da mesma.">
                                                                        <i class="fas fa-edit"></i>
                                                                    </button>
                                                                    <?php if ($linha["status"] != 'Cancelado') { ?>
                                                                        <button type="submit" class="btn btn-danger btn-circle btn-sm" id="pk_reservas" name="pk_reservas" value="<?= $linha['pk_reservas'] ?>" data-toggle="tooltip" data-placement="top" title="Cancela a reserva!">
                                                                            <i class="fas fa-times-circle"></i>
                                                                        </button>
                                                                <?php }
                                                                } ?>
                                                                <input type="hidden" id="<?= $linha['pk_reservas'] ?>" name="pk_reservas_this" value="<?= $linha['titulo'] ?>" />
                                                                <button type="button" class="btn btn-info btn-circle btn-sm" id="deleteamc" name="pk_reservas" value="<?= $linha['pk_reservas'] ?>" data-toggle="tooltip" title="Consultar reserva." onclick="buscaInfo(<?= $linha['pk_reservas'] ?>);">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                                </div>
                                                        </form>

                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <?php include "detalhesReserva.php" ?>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include "direitos.php"; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>


    <!-- HTML5 export buttons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.25/sorting/date-euro.js"></script>
    <script src="js/functions.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

    <link href="https://cdn.jsdelivr.net/sweetalert2/4.2.4/sweetalert2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/sweetalert2/4.2.4/sweetalert2.min.js"></script>
    <script>
        // Ordenação da data (date-br)
        jQuery.extend(jQuery.fn.dataTableExt.oSort, {
            "date-br-pre": function(a) {
                if (a == null || a == "") {
                    return 0;
                }
                var brDatea = a.split('/');
                return (brDatea[2] + brDatea[1] + brDatea[0]) * 1;
            },

            "date-br-asc": function(a, b) {
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },

            "date-br-desc": function(a, b) {
                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        });

        $(document).ready(function() {
            var table = $('#dataTableSetor').DataTable({
                "columns": [
                    null,
                    null,
                    null,
                    {
                        "type": "date-euro"
                    },
                    null,
                    {
                        "type": "date-euro"
                    },
                    null,
                    null,
                    null,
                    null,

                ],
                "order": [
                    [0, "desc"]
                ],
                language: {
                    lengthMenu: "Exibir _MENU_ registros",
                    zeroRecords: "Nenhum registro encontrado",
                    infoEmpty: "0 registros",
                    info: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    search: "Pesquisar",
                    decimal: ",",
                    infoFiltered: "(filtrada de _MAX_ total de entradas)",
                    infoPostFix: "",
                    thousands: ".",
                    loadingRecords: "Carregando...",
                    processing: "Processando...",
                    paginate: {
                        first: "Primeira",
                        last: "Última",
                        next: "Próxima",
                        previous: "Anterior"
                    },
                }
            });
        });
        $(document).on('click', '.SwalBtn1', function() {
            //Some code 1
            swal.close();
        });

        $(document).on('click', '.SwalBtn2', function(e) {
            //Some code 2
            valor = $(this);
            event.preventDefault();
            var idReservaCancelar = this.value;

            swal({
                title: "Motivo do cancelamento:",
                text: "<textarea maxlength='300' rows='7' cols='40' id='text'></textarea>" +
                    '<button type="button" role="button" tabindex="0" class="SwalCancelVoltar customSwalBtn">' + 'Voltar' + '</button>' +
                    '<button type="button" role="button" tabindex="0" class="SwalCancelOk customSwalBtn" value="' + idReservaCancelar + '">' + 'Ok' + '</button>',
                showCancelButton: false,
                showConfirmButton: false
            });
        });

        $(document).on('click', '.SwalCancelVoltar', function() {
            //Some code 1
            swal.close();
        });

        $(document).on('click', '.SwalCancelOk', function(e) {
            //Some code 1
            valor = this.value;

            var val = document.getElementById('text').value;
            if (val != "" && val != null) {
                $("#formulario").attr("action", "updateReservaStatus.php");
                $("input#passaStatus").val("0");
                $("input#passaMotivo").val(val);
                //$(valor).trigger();
                //$('#updateStatus').append($(valor));
                $("input#pk_reservas").val(valor);
                $('#formulario').submit();
            } else {
                swal('Favor, descreva o motivo do cancelamento!');
            }
        });

        $('.btn-danger').on('click', function(e) {
            valor = $(this);
            e.preventDefault();
            var idReserva = this.value;
            swal({
                title: "Deseja cancelar a reserva?",
                text: $("#" + valor.val()).val(),
                type: "warning",
                html: '<button type="button" role="button" tabindex="0" class="SwalBtn1 customSwalBtn" value="">' + 'Voltar' + '</button>' +
                    '<button type="button" role="button" tabindex="0" class="SwalBtn2 customSwalBtn" value="' + idReserva + '">' + 'Cancelar' + '</button>',
                showCancelButton: false,
                showConfirmButton: false
            });

        });
    </script>

</body>

</html>