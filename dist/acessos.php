<?php
session_start();

include "sweetalert.html";
include "conexaoDB.php";

function consultaUser()
{
    $parametros = parametros();
    $conexao = conexaoBanco();
    $query_user =  "select " . $parametros['on1'] . ", " . $parametros['nome'] . " as name, tipo, pk_permissao, grupo_salas from " . $parametros['tabela'] . " left join reservas.user_permissao on " . $parametros['on1'] . " = " . $parametros['on2'] . " left join reservas.permissao on pk_permissao = fk_permissao";
    //echo $query_user;
    $dados = mysqli_query($conexao, $query_user) or die("Error in query_user: $query_user." . mysqli_error($conexao));
    return  $dados;
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

    <title>Acessos</title>

    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <link href='../lib/main.css' rel='stylesheet' />
    <script src='../lib/main.js'></script>
</head>

<body id="sb-nav-fixed">

    <?php
    include("header.php");
    $parametros = parametros();
    $dados = consultaUser();
    $_SESSION['reservaPermissoaAcesso'] == "1" ? "" : header("location: index.php"); ?>
    <!-- Page Wrapper -->
    <div id="layoutSidenav">

        <!-- Sidebar -->
        <?php if (isset($_SESSION['text'])) {

            include("nav.php");
        } ?>
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
                            <h6 class="m-0 font-weight-bold text">Acessos</h6>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTableSetor" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Grupo de Salas</th>
                                            <th>Tipo de acesso</th>
                                            <th>Ver</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Grupo de Salas</th>
                                            <th>Tipo de acesso</th>
                                            <th>Ver</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        if (mysqli_num_rows($dados) > 0) {
                                            while ($linha = mysqli_fetch_assoc($dados)) {
                                        ?>
                                                <tr class="odd gradeX">
                                                    <td><?= $linha["name"] ?></td>
                                                    <td><?php
                                                        if ($linha["tipo"] == "Administrador" || !isset($linha["tipo"])) {
                                                            echo "--";
                                                        } else {
                                                            echo $linha["grupo_salas"] == 1 ? "CAFF Working" : "Reserva de Espaços demais espaços";
                                                        } ?>
                                                    </td>
                                                    <td><?= isset($linha["tipo"]) ? $linha["tipo"] : "Básico"; ?></td>
                                                    <td align="center">

                                                        <form action="updateAcesso.php" method="post">
                                                            <input type="hidden" id="passaNome" name="passaNome" value="<?= $linha["name"] ?>" />
                                                            <input type="hidden" id="inputAcesso" name="inputAcesso" value="<?= isset($linha["pk_permissao"]) ? $linha["pk_permissao"] : "0"; ?>" />
                                                            <input type="hidden" name="listarAcesso" value="1" />

                                                            <button type="submit" class="btn btn-info btn-circle btn-sm" id="deleteamc" name="identificadorUser" value="<?= $linha[$parametros['on1']] ?>" data-toggle="tooltip" data-placement="top" tittle="teste">
                                                                <i class="fas fa-search"></i>
                                                            </button>
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
        $(document).ready(function() {
            var table = $('#dataTableSetor').DataTable({
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
    </script>

</body>

</html>