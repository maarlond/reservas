<?php
include "conexaoDB.php";
include "funcoesNotificacoes.php";


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Configuração de envio de emails">
    <meta name="author" content="Diego Santos">

    <title>Configurar Mensagens de Alertas</title>

    <link href="css/styles.css" rel="stylesheet" />

    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <link href='../lib/main.css' rel='stylesheet' />
    <script src='../lib/main.js'></script>
</head>

<body id="sb-nav-fixed">

    <?php
    include("header.php");
    $_SESSION['reservaPermissoaAcesso'] == "1" ? "" : header("location: index.php"); ?>
    <!-- Page Wrapper -->

    <div id="layoutSidenav">

        <!-- Sidebar -->
        <?php if (isset($_SESSION['text'])) {
            include("nav.php"); ?>

        <?php } ?>
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
                            <h6 class="m-0 font-weight-bold text">Notificação na Tela de Reservas</h6>
                        </div>
                        <label required class="small mb-1" id="labelData" for="inputLogin" style="margin: 2%;">
                            Os campos abaixo devem ser inciados por &lt;div class="alert alert-warning text-center"&gt texto desejado e finalizados por &lt;/div&gt
                            Para mundaça de cor :<br>
                            class = "alert alert-warning text-center" Amarelo<br>
                            class = "alert alert-danger text-center" Vernmelho<br>
                            class = "alert alert-primary text-center" Azul<br>
                            class = "alert alert-success text-center" Verde<br>
                            Se estiver vazio não exibe nenhuma notificação.
                        </label>
                        <div class="card-body">
                            <form action="mensagensUpdate.php" method="post">
                                <div class="col-md-12">
                                    <label required class="small mb-2" id="labelData" for="inputLogin" style="margin-top: 2%;">Notificação 1 na tela de Reservas</label>
                                    <a style="color:red;" title="Campo obrigatório"> * </a>
                                    <textarea class="form-control py-2 valor" rows="3" name="inputTextoNotificacao1" type="text" maxlength="500"><?php echo buscaNotificacao1($conexao); ?></textarea>
                                </div>
                                <div class="col-md-12">
                                    <label class=" small mb-2" id="labelDataFim" for="inputPass" style="margin-top: 2%;">Notificação 2 na tela de Reservas</label>
                                    <a style="color:red;" title="Campo obrigatório"> * </a>
                                    <textarea class=" form-control py-2 valor" rows="3" name="inputTextoNotificacao2" type="text" maxlength="500"><?php echo buscaNotificacao2($conexao); ?></textarea>
                                </div>
                                <br>
                                <button type="input" class="btn btn-success btn-circle btn-sm float-right" name="AtualizarNotificacoes" value="1">
                                    Alterar
                                </button>
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
</body>

</html>