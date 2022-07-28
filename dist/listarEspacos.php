<?php

if (isset($_GET['id']) == 1) {
    $img = $_GET['caminho'] . $_GET['arquivo'];
    //echo $img;
    if (file_exists($img)) unlink($img);
}

include "conexaoDB.php";

function buscaEspacos($conexao)
{
    $query_espacos = "SELECT * FROM espaços WHERE grupo_salas = " . $_SESSION['sistemaGrupoSalas'] . " ORDER BY pk_espacos desc";
    $dados = mysqli_query($conexao, $query_espacos) or die("Error in query_espacos: $query_espacos." . mysqli_error($conexao));
    return $dados;
}
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
</head>

<body id="sb-nav-fixed">

    <?php include("header.php");
    require "verificarAcesso.php";
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
                            <h6 class="m-0 font-weight-bold text">Lista de espaços</h6>
                        </div>
                        <div class="card-body">
                            <form action="espacos.php" method="post">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTableSetor" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Localização</th>
                                                <th>Capacidade</th>
                                                <th>Ativa</th>
                                                <th>Visualizar</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Localização</th>
                                                <th>Capacidade</th>
                                                <th>Ativa</th>
                                                <th>Visualizar</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php

                                            $dados = buscaEspacos($conexao);

                                            if (mysqli_num_rows($dados) > 0) {
                                                while ($linha = mysqli_fetch_assoc($dados)) {
                                            ?>
                                                    <tr class="odd gradeX">
                                                        <td><?= $linha["nome"] ?></td>
                                                        <td><?= $linha["localizacao"] ?></td>
                                                        <td><?= $linha["capacidade"] ?></td>
                                                        <td><?= $linha["status"] == 1 ? "Ativo" : "Inativo";  ?></td>
                                                        <td align="center">
                                                            <button type="submit" class="btn btn-info btn-circle btn-sm" name="pk_espacos" value="<?= $linha['pk_espacos'] ?>">
                                                                <i class="fas fa-search"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>


    <!-- HTML5 export buttons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>

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

            var table = $('#dataTableSetor').DataTable({
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-3'f><'col-sm-12 col-md-3'B>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-4'><'col-sm-12 col-md-4'p>>",
                buttons: [{
                        extend: 'pdfHtml5',
                        filename: 'Contratos - ' + d,
                        text: 'PDF',
                        className: 'btn btn-xs btn-primary m-0 width-35 assets-export-btn export-pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        exportOptions: {
                            modifier: {
                                page: 'current'
                            }
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        filename: 'Contratos - ' + d,
                        text: 'EXCEL',
                        className: 'btn btn-xs btn-primary m-0 width-35 assets-export-btn export-pdf'
                    },
                    {
                        extend: 'csvHtml5',
                        filename: 'Contratos - ' + d,
                        text: 'CSV',
                        fieldSeparator: ';',
                        className: 'btn btn-xs btn-primary m-0 width-35 assets-export-btn export-print'
                    },
                    {
                        extend: 'copyHtml5',
                        text: 'COPIAR',
                        filename: 'Contratos - ' + d,
                        className: 'btn btn-xs btn-primary m-0 width-35 assets-export-btn export-pdf'
                    },
                ],
                columnDefs: [{
                    targets: [4],
                    orderable: false
                }],
                order: [
                    [1, "asc"]
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