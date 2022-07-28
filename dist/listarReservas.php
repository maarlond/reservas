<?php
session_start();
include "conexaoDB.php";
include "sweetalert.html";
include("header.php");
require "verificarAcesso.php";

//print_r($_SESSION['sistemaGrupoSalas']);exit();

/*if (isset($_REQUEST['pk_reservas'])) {
    $query_info = "SELECT pk_reservas, titulo, espaços.nome, hr_ini, hr_fim, reservas.status, motivo
    FROM reservas 
    inner join eventos 
    on fk_eventos = pk_eventos 
    inner join espaços 
    on fk_espacos = pk_espacos
    WHERE grupo_salas = " . $_SESSION['sistemaGrupoSalas'] . "
    AND pk_reservas = " . $_REQUEST['pk_reservas'] . "
    ORDER BY pk_eventos desc";


    $dadosInfo = mysqli_query($conexao, $query_info) or die("Error in query_reservas: $query_info." . mysqli_error($conexao));

    $linhaInfo = mysqli_fetch_assoc($dadosInfo);
}
*/

$query_reservas = "SELECT pk_reservas, titulo, espaços.nome, hr_ini, hr_fim, reservas.status, motivo, DATE_FORMAT(dt_ini, '%d/%m/%Y') as dt_ini, 
    DATE_FORMAT(dt_fim, '%d/%m/%Y') as dt_fim, contato, ramal, select_webex
    FROM reservas 
    inner join eventos 
    on fk_eventos = pk_eventos 
    inner join espaços 
    on fk_espacos = pk_espacos
    WHERE grupo_salas = " . $_SESSION['sistemaGrupoSalas'] . "
    ORDER BY pk_eventos desc";


$dados = mysqli_query($conexao, $query_reservas) or die("Error in query_reservas: $query_reservas." . mysqli_error($conexao));

$linha = mysqli_fetch_assoc($dados);

$caminho = "./uploads/Reservas/";

?>
<!-- <!DOCTYPE html> -->
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Reservas</title>


    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <link href='../lib/main.css' rel='stylesheet' />
    <script src='../lib/main.js'></script>
    <style>
        .swal-popup {
            font-size: 0.6rem !important;
            font-family: Georgia, serif;
        }

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

    <?php

    if ($_SESSION['reservaPermissoaAcesso'] != 1 && ($_SESSION['reservaPermissoaAcesso'] == 2 && $_SESSION['usuarioGrupoSalas'] != $_SESSION['sistemaGrupoSalas'])) {
        header("location: reservar.php");
    }
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
                            <h6 class="m-0 font-weight-bold text">Todas Reservas</h6>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTableSetor" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr align="center">
                                            <th>ID</th>
                                            <th>Espaço</th>
                                            <th>Objetivo</th>
                                            <th>Data Início</th>
                                            <th>Hora Início</th>
                                            <th>Data Fim</th>
                                            <th>Hora Fim</th>
                                            <th>Contato/Telefone</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="thead-dark" align="center">
                                            <th>ID</th>
                                            <th>Espaço</th>
                                            <th>Objetivo</th>
                                            <th>Data Início</th>
                                            <th>Hora Início</th>
                                            <th>Data Fim</th>
                                            <th>Hora Fim</th>
                                            <th>Contato/Telefone</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        if (mysqli_num_rows($dados) > 0) {
                                            do {
                                        ?>
                                                <tr align="center" class="odd gradeX">
                                                    <td><?= $linha["pk_reservas"] ?></td>
                                                    <td><?= $linha["nome"] ?></td>
                                                    <td><?= $linha["titulo"] ?>
                                                        <?php if (count(glob($caminho . $linha['pk_reservas'] . "/*")) !== 0) { ?>
                                                            <?php if (file_exists($caminho . $linha['pk_reservas'] . "/")) { ?>
                                                                <i class="fas fa-paperclip" data-toggle="tooltip" title="Existe Anexo!"></i>
                                                        <?php }
                                                        } ?>
                                                    </td>
                                                    <td><?= $linha["dt_ini"] ?></td>
                                                    <td><?= $linha["hr_ini"] ?></td>
                                                    <td><?= $linha["dt_fim"] ?></td>
                                                    <td><?= $linha["hr_fim"] ?></td>
                                                    <td><?= $linha["contato"]; ?><br><?= $linha["ramal"]; ?></td>
                                                    <td><?= $linha["status"] ?></td>
                                                    <td align="center">
                                                        <!--<form action="aprovarReservas.php" method="post">-->
                                                        <input type="hidden" id="<?= $linha['pk_reservas'] ?>" name="pk_reservas_this" value="<?= $linha['titulo'] ?>" />
                                                        <button style="margin-top: 1em;" type="submit" class="btn btn-info btn-circle btn-sm" id="deleteamc" name="pk_reservas" value="<?= $linha['pk_reservas'] ?>" data-toggle="tooltip" title="Consultar reserva." onclick="buscaInfo(<?= $linha['pk_reservas'] ?>);">
                                                            <i class="fas fa-search"></i>
                                                        </button>
                                                        <!--</form>-->

                                                    </td>
                                                </tr>
                                        <?php
                                            } while ($linha = mysqli_fetch_assoc($dados));
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
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.25/sorting/date-euro.js"></script>
    <script src="js/functions.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

    <link href="https://cdn.jsdelivr.net/sweetalert2/4.2.4/sweetalert2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/sweetalert2/4.2.4/sweetalert2.min.js"></script>

    <script>
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
                    null
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
                    infoFiltered: "(filtrada de _MAX_ total de entradas)",
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
            /*function(isConfirm) {
                var val = document.getElementById('text').value;
                if (val != "" && val != null && isConfirm) {
                    $("input#passaStatus").val("0");
                    $("input#passaMotivo").val(val);
                    $(valor).trigger('click');
                } else {
                    swal('Favor, descreva o motivo do cancelamento!');
                }
            });*/
            //swal.clickConfirm();
        });

        $(document).on('click', '.SwalBtn3', function() {
            valor = this.value;
            //Some code 2 
            $("input#passaStatus").val("1");
            $("input#pk_reservas").val(valor);
            $('#updateStatus').submit();
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
                $("input#passaStatus").val("0");
                $("input#passaMotivo").val(val);
                //$(valor).trigger();
                //$('#updateStatus').append($(valor));
                $("input#pk_reservas").val(valor);
                $('#updateStatus').submit();
            } else {
                swal('Favor, descreva o motivo do cancelamento!');
            }
        });

        $('.btn-success').on('click', function(e) {
            valor = $(this);
            e.preventDefault();
            var idReserva = this.value;
            swal({
                title: "Confirmar reserva?",
                type: "warning",
                text: $("#" + valor.val()).val(),
                html: '<button type="button" role="button" tabindex="0" class="SwalBtn1 customSwalBtn" value="">' + 'Voltar' + '</button>' +
                    '<button type="button" role="button" tabindex="0" class="SwalBtn2 customSwalBtn" value="' + idReserva + '">' + 'Cancelar' + '</button>' +
                    '<button type="button" role="button" tabindex="0" class="SwalBtn3 customSwalBtn" value="' + idReserva + '">' + 'Confirmar' + '</button>',
                showCancelButton: false,
                showConfirmButton: false
            });

        });
    </script>

</body>

</html>