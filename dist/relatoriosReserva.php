<?php
session_start();
include "conexaoDB.php";
include "sweetalert.html";

//print_r($_REQUEST);exit();
$datainicial = date("Y-m-d");

if (isset($_REQUEST['requestRelatorio'])) {
    if (empty($_REQUEST['inputDataFim'])) {
        $data = !empty($_REQUEST['inputData']) ? "('" . $_REQUEST['inputData'] . "'" .  " BETWEEN dt_ini AND(IF(dt_fim = 'NULL', dt_ini, dt_fim))" . ') AND' : "";
    } else if (empty($_REQUEST['inputData']) && !empty($_REQUEST['inputDataFim'])) {
        $dataIni = '2021-04-01';
        $data = !empty($_REQUEST['inputDataFim']) ? "('" . $_REQUEST['inputDataFim'] . "'" .  " BETWEEN dt_ini AND(IF(dt_fim = 'NULL', dt_ini, dt_fim)) OR dt_ini BETWEEN '" . $dataIni . "' AND '" . $_REQUEST['inputDataFim'] . "' OR (IF(dt_fim = 'NULL',dt_ini,dt_fim)) BETWEEN '" . $dataIni . "' AND '" . $_REQUEST['inputDataFim'] . "'" . ') AND ' : "";
    } else {
        $data = !empty($_REQUEST['inputDataFim']) ? "('" . $_REQUEST['inputDataFim'] . "'" .  " BETWEEN dt_ini AND(IF(dt_fim = 'NULL', dt_ini, dt_fim)) OR dt_ini BETWEEN '" . $_REQUEST['inputData'] . "' AND '" . $_REQUEST['inputDataFim'] . "' OR (IF(dt_fim = 'NULL',dt_ini,dt_fim)) BETWEEN '" . $_REQUEST['inputData'] . "' AND '" . $_REQUEST['inputDataFim'] . "'" . ') AND ' : "";
    }

    $espacos = !empty($_REQUEST['inputEspacos']) ? "(fk_espacos = " . $_REQUEST['inputEspacos'] . ') AND' : "";
    $status = !empty($_REQUEST['inputStatus']) ? "(reservas.status = " . "'" . $_REQUEST['inputStatus'] . "'" . ') AND' : "";
    $secretarias = !empty($_REQUEST['inputSecretarias']) ? "(secretaria = " . "'" . $_REQUEST['inputSecretarias'] . "'" . ') AND' : "";
    $diaSemana = !empty($_REQUEST['inputDiaSemana']) ? "(DAYOFWEEK (dt_ini) = " . "'" . $_REQUEST['inputDiaSemana'] . "'" . ') AND' : "";

    $query_reservas = "SELECT pk_reservas, fk_espacos, titulo, secretaria, espaços.nome, hr_ini, hr_fim, reservas.status, motivo, DATE_FORMAT(dt_ini, '%d/%m/%Y') as dt_ini,
                    DATE_FORMAT(dt_fim, '%d/%m/%Y') as dt_fim, contato, ramal, select_webex
                    FROM reservas 
                    inner join eventos
                    on fk_eventos = pk_eventos 
                    inner join espaços 
                    on fk_espacos = pk_espacos
                    WHERE $data 
                    $espacos
                    $status
                    $secretarias
                    $diaSemana
                    (grupo_salas = " . $_SESSION['sistemaGrupoSalas'] . ")
                    ORDER BY pk_eventos desc";
    $dadosInfo = mysqli_query($conexao, $query_reservas) or die("Error in query_reservas: $query_reservas." . mysqli_error($conexao));
    //print_r($dadosInfo);exit();
}

#Lista de secretarias
$querySecretarias = 'SELECT DISTINCT (secretaria) FROM reservas INNER JOIN eventos ON fk_eventos = pk_eventos';
$dados_secretarias = mysqli_query($conexao, $querySecretarias) or die("Error in query_reserva: $querySecretarias." . mysqli_error($conexao));

#Lista de status
$queryStatus = 'SELECT DISTINCT status FROM reservas';
$dados_status = mysqli_query($conexao, $queryStatus) or die("Error in query_reserva: $queryStatus." . mysqli_error($conexao));

#Lista de espaços
$queryEspacos = 'SELECT esp.pk_espacos, esp.nome, esp.localizacao, esp.capacidade, esp.status,
                esp.grupo_salas, esp.horario_abertura, esp.horario_fechamento, esp.intervalo_horarios,
                esp.email as "E-mail de Aprovador para notificação",
                COUNT(*) as "Quantidade de reservas"
                FROM espaços AS esp
                INNER JOIN reservas AS r ON esp.pk_espacos = r.fk_espacos
                INNER JOIN eventos AS ev ON r.fk_eventos = ev.pk_eventos
                WHERE esp.grupo_salas = "'  . $_SESSION['sistemaGrupoSalas']  . '"
                GROUP BY esp.pk_espacos';

$dados_espacos = mysqli_query($conexao, $queryEspacos) or die("Error in query_reserva: $queryEspacos." . mysqli_error($conexao));

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
</head>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
<style type="text/css">
    div.dt-buttons {
        float: right;
    }

    div.dataTables_filter {
        float: right;
    }
</style>
<script>
    //Controle de horas e datas conforme a checagem de dias
    function controlStart() {
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
    }

    function desabilitaDia() {
        document.getElementById("inputData").disabled = true;
        document.getElementById("inputData").value = "";
        document.getElementById("inputDataFim").disabled = true;
        document.getElementById("inputDataFim").value = "";

    }
</script>

<body class="sb-nav-fixed">

    <!-- Incluindo menu header -->
    <?php include "header.php"; ?>

    <!-- Incluindo menu header -->
    <div id="layoutSidenav">
        <!-- Incluindo menu esquerdo -->
        <?php include "nav.php" ?>
        <!-- Incluindo menu esquerdo -->
        <div id="layoutSidenav_content">
            <main>
                <!-- End Navbar -->
                <div class="container-fluid">
                    <form action="relatoriosReserva.php" method="post">
                        <!-- Page Heading -->
                        <div class="mb-4 mt-4">
                            <h1 class="h4 text-primary">Relatórios Reservas</h1>
                        </div>

                        <div class="row">
                            <!-- Begin Page Content -->
                            <div class="container-fluid">
                                <div class="form-row">
                                    <?php if (!empty($_REQUEST['inputDiaSemana'])) {
                                        $checkDiaSemana = "disabled";
                                    } ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" id="labelData" for="inputData">Data Início:</label>
                                            <input class="form-control py-2 valor" id="inputData" name="inputData" max=<?= $datainicial; ?> <?= !empty($checkDiaSemana) ? $checkDiaSemana : ""; ?> type="date" onchange="controlStart();" value="<?= isset($_REQUEST['requestRelatorio']) ? $_REQUEST["inputData"] : ""; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" id="labelData" for="inputDataFim">Data Fim:</label>
                                            <input class="form-control py-2 valor" id="inputDataFim" name="inputDataFim" type="date" <?= !empty($checkDiaSemana) ? $checkDiaSemana : ""; ?> onchange="controlStart();" value="<?= isset($_REQUEST['requestRelatorio']) ? $_REQUEST["inputDataFim"] : ""; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label for="exampleFormControlSelect1">Dia da semana</label>
                                        <select selected id="inputDiaSemana" name="inputDiaSemana" class="form-group form-control" id="exampleFormControlSelect1" onchange="desabilitaDia(); changeFunc();" value="<?= isset($_REQUEST['requestRelatorio']) ? $_REQUEST["inputDiaSemana"] : ""; ?>">
                                            <option value="">Todos</option>
                                            <option value="2" <?php echo $_REQUEST['inputDiaSemana'] == '2' ? 'selected' : ''; ?>>Segunda-feira</option>
                                            <option value="3" <?php echo $_REQUEST['inputDiaSemana'] == '3' ? 'selected' : ''; ?>>Terça-feira</option>
                                            <option value="4" <?php echo $_REQUEST['inputDiaSemana'] == '4' ? 'selected' : ''; ?>>Quarta-feira</option>
                                            <option value="5" <?php echo $_REQUEST['inputDiaSemana'] == '5' ? 'selected' : ''; ?>>Quinta-feira</option>
                                            <option value="6" <?php echo $_REQUEST['inputDiaSemana'] == '6' ? 'selected' : ''; ?>>Sexta-feira</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleFormControlSelect1">Status</label>
                                        <select id="inputStatus" name="inputStatus" class="form-control form-group">
                                            <option value="">Todos</option>
                                            <?php
                                            while ($linha = mysqli_fetch_assoc($dados_status)) {
                                                $selected = $_REQUEST["inputStatus"] == $linha["status"] ? "selected" : "";
                                                echo '<option ' . $selected . ' value="' . $linha['status'] . '">' . $linha['status'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label for="exampleFormControlSelect1">Secretaria</label>
                                        <select id="inputSecretarias" name="inputSecretarias" class="form-group form-control" id="exampleFormControlSelect1">
                                            <option value="">Todas</option>
                                            <?php
                                            while ($linha = mysqli_fetch_assoc($dados_secretarias)) {
                                                $selected = $_REQUEST["inputSecretarias"] == $linha["secretaria"] ? "selected" : "";
                                                echo '<option ' . $selected . ' value="' . $linha['secretaria'] . '">' . strtoupper($linha['secretaria']) . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleFormControlSelect1">Espaços</label>
                                        <select id="inputEspacos" name="inputEspacos" class="form-control form-group">
                                            <option value="">Todos</option>
                                            <?php
                                            while ($linha = mysqli_fetch_assoc($dados_espacos)) {
                                                $selected = $_REQUEST["inputEspacos"] == $linha["pk_espacos"] ? "selected" : "";
                                                echo '<option ' . $selected . ' value="' . $linha['pk_espacos'] . '">' . $linha['nome'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div style="margin-left:auto;">
                                        <input type="submit" class="btn btn-primary" name="requestRelatorio" value="Gerar" onclick="gerarRelatorio();">
                                    </div>
                                </div>
                    </form>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4 mt-3">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Lista de reservas geradas</h6>
                        </div>
                        <div class="card-body">
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table id="visul_usuario" class="table table-bordered" width="100%" cellspacing="0">
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
                                                <th>Secretaria</th>
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
                                                <th>Secretaria</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            if (isset($dadosInfo)) {
                                                if (mysqli_num_rows($dadosInfo) > 0) {
                                                    while ($linha = mysqli_fetch_assoc($dadosInfo)) {
                                            ?>
                                                        <tr class="odd gradeX" align="center">
                                                            <td><?= $linha["pk_reservas"] ?></td>
                                                            <td><?= $linha["nome"] ?></td>
                                                            <td><?= $linha["titulo"] ?></td>
                                                            <td><?= $linha["dt_ini"] ?></td>
                                                            <td><?= $linha["hr_ini"] ?></td>
                                                            <td><?= $linha["dt_fim"] ?></td>
                                                            <td><?= $linha["hr_fim"] ?></td>
                                                            <td><?= $linha["contato"] ?></td>
                                                            <td><?= $linha["status"] ?></td>
                                                            <td><?= $linha["secretaria"] ?></td>
                                                        </tr>
                                            <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                    <!-- Footer -->
                    <?php include "direitos.php"; ?>
                    <!-- End of Footer -->
                </div>
                <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
        </main>
    </div>
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/components/jquery/jquery.min.js"></script>
    <script src="../vendor/components/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->

    <!-- HTML5 export buttons -->
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>

    <!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="js/functions.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="http://jqueryvalidation.org/files/dist/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

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
            var currentDate = new Date()
            var day = currentDate.getDate()
            var month = currentDate.getMonth() + 1
            var year = currentDate.getFullYear()
            var d = day + "-" + month + "-" + year;

            var table = $('#visul_usuario').DataTable({
                dom: "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-3'f><'col-sm-12 col-md-4'B>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-4'><'col-sm-12 col-md-4'p>>",
                buttons: [{
                        extend: 'pdfHtml5',
                        filename: 'Reservas - ' + d,
                        text: 'PDF',
                        className: 'btn btn-xs btn-primary m-0 width-35 assets-export-btn export-pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        title: 'Relatório Reservas',
                        exportOptions: {
                            modifier: {
                                page: 'current'
                            }
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        filename: 'Reservas - ' + d,
                        title: 'Relatório Reservas',
                        text: 'EXCEL',
                        className: 'btn btn-xs btn-primary m-0 width-35 assets-export-btn export-pdf'
                    },
                    {
                        extend: 'csvHtml5',
                        filename: 'Reservas - ' + d,
                        title: 'Relatório Reservas',
                        text: 'CSV',
                        fieldSeparator: ';',
                        className: 'btn btn-xs btn-primary m-0 width-35 assets-export-btn export-print'
                    },
                    {
                        extend: 'copyHtml5',
                        title: 'Relatório Reservas',
                        text: 'COPIAR',
                        filename: 'Reservas - ' + d,
                        className: 'btn btn-xs btn-primary m-0 width-35 assets-export-btn export-pdf'
                    },
                ],
                columnDefs: [{
                        targets: [3],
                        type: 'date-br'
                    },
                    {
                        targets: [5],
                        type: 'date-br'
                    },

                ],

                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "Todos"]
                ],
                language: {
                    lengthMenu: "Exibir _MENU_ registros",
                    zeroRecords: "Nenhum registro encontrado",
                    infoEmpty: "0 registros",
                    info: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    search: "Pesquisar",
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
                    aria: {
                        sortAscending: ": ativar para classificar coluna ascendente",
                        sortDescending: ": ativar para classificar coluna descendente"
                    }
                }
            });
        });
    </script>
</body>

</html>