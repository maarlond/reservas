<?php
// session_start();
include "conexaoDB.php";
include "sweetalert.html";
include "funcoesNotificacoes.php";

$query_satisfacao = "SELECT pk_reservas, espaços.nome, reservas.contato,eventos.dt_ini,  reservas.status, pk_satisfacao, DATE_FORMAT(dt_ini, '%d/%m/%Y') as dt_ini
                    FROM  satisfacao INNER JOIN reservas on fk_reservas = pk_reservas INNER JOIN espaços on fk_espacos = pk_espacos 
                    INNER JOIN eventos ON fk_eventos = pk_eventos  
                    WHERE reservas.status = 'Confirmado' ORDER BY eventos.dt_ini  DESC LIMIT 500 ";
$dados = mysqli_query($conexao, $query_satisfacao);
$linha = mysqli_fetch_assoc($dados);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Pesquisa de Satisfação</title>

    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <link href='../lib/main.css' rel='stylesheet' />
    <script src='../lib/main.js'></script>

</head>

<body class="sb-nav-fixed">

    <!-- Incluindo menu header -->
    <?php include "header.php";
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

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <br>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text">Todas Pesquisas de Satisfação</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTableSetor" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr align="center">
                                            <th>ID</th>
                                            <th>Espaço</th>
                                            <th>Usuário</th>
                                            <th>Data</th>
                                            <th>Status</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>

                                    <tfoot>
                                        <tr class="thead-dark" align="center">
                                            <th>ID</th>
                                            <th>Espaço</th>
                                            <th>Usuário</th>
                                            <th>Data</th>
                                            <th>Status</th>
                                            <th>Ação</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php

                                        if (mysqli_num_rows($dados) > 0) {
                                            do {
                                        ?>
                                                <tr align="center" class="odd gradeX">
                                                    <td>
                                                        <?php echo $linha["pk_reservas"] ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $linha["nome"] ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $linha["contato"] ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $linha["dt_ini"] ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $linha["status"] ?>
                                                    </td>
                                                    <td align="center">
                                                        <form action="detalhesSatisfacao.php" method="POST">
                                                            <input type="hidden" name="contato" value="<?php echo $linha["contato"]; ?>">
                                                            <input type="hidden" name="nome" value="<?php echo $linha["nome"]; ?>">
                                                            <input type="hidden" name="pk_reserva" value="<?php echo $linha["pk_reservas"]; ?>">
                                                            <button id="segundo" type="submit" class="btn btn-primary" onclick="detalhes()">Ver detalhes</button>

                                                        </form>

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
                    </div>
                </div>
            </div>

            <?php include "direitos.php"; ?>
        </div>
    </div>


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
            var table = $('#dataTableSetor').dataTable({
                "sPaginationType": "full_numbers",
                language: {
                    lengthMenu: "Exibir _MENU_ registros",
                    zeroRecords: "Nenhum registro encontrado",
                    infoEmpty: "0 registros",
                    info: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    search: "Pesquisar",
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
    </script>

</body>

</html>