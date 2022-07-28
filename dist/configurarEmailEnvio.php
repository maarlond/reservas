<?php
include "UpdateEmail.php";

// print_r($_SESSION);
// die();
?>
<!-- <!DOCTYPE html> -->
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Configuração de envio de emails">
    <meta name="author" content="Diego Santos">

    <title>Configurar envio de emails</title>

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
                            <h6 class="m-0 font-weight-bold text">Configuração de envio de emails</h6>
                        </div>
                        <div class="card-body">
                            <form action="UpdateEmail.php" method="post">

                                <div class="col-md-6">
                                    <label required class="small mb-1" id="labelData" for="inputLogin" style="margin-top: 2%;">Login Email (Ex: secretaria-usuário, sem informar o @)</label>
                                    <a style="color:red;" title="Campo obrigatório"> * </a>
                                    <input required class="form-control py-2 valor" id="inputLogin" name="inputLogin" type="text" maxlength="32" placeholder="secretaria-nome-sobrenome" value="<?php echo buscaParametros($conexao); ?>" />
                                </div>
                                <div class="col-md-6">
                                    <label class=" small mb-2" id="labelDataFim" for="inputPass" style="margin-top: 2%;">Senha</label>
                                    <a style="color:red;" title="Campo obrigatório"> * </a>
                                    <input required class=" form-control py-2 valor" id="inputPass" name="inputPass" type="password" maxlength="16">
                                    <label class="small mb-1">
                                        *Senha do email nunca é exibida, serve somente para alteração ou inserção, para testar se as credenciais estão certas faça um teste de envio.
                                    </label>
                                </div>
                                <br>
                                <br>

                                <button type="input" class="btn btn-success btn-circle btn-sm float-right" style="margin-left: 0.5%;" id="salvar" name="salvar" value="1">
                                    Salvar
                                </button>
                                <a type="input" class="btn btn-danger btn-circle btn-sm float-right" href="./index.php">
                                    Cancelar
                                </a>

                            </form>

                            <form action="UpdateEmail.php" method="post">
                                <button type="input" class="btn btn-warning btn-circle btn-sm " id="testeEnvio" name="testeEnvio" value="1">
                                    Teste de Envio
                                </button>
                            </form>
                        </div>
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text">Parametrização de email</h6>
                        </div>
                        <label required class="small mb-1" id="labelData" for="inputLogin" style="margin: 2%;">
                            Os campos abaixo servem de modelo de disparo dos emails do Reservas;
                            Existem três parâmetros dinâmicos @user, @id_reserva e @status!
                        </label>
                        <div class="card-body">
                            <form action="UpdateEmail.php" method="post">

                                <div class="col-md-6">
                                    <label required class="small mb-1" id="labelData" for="inputLogin" style="margin-top: 2%;">Título do email de cadastro pré-reserva:</label>
                                    <a style="color:red;" title="Campo obrigatório"> * </a>
                                    <input required class="form-control py-2 valor" id="inputTituloEmailPrereserva" name="inputTituloEmailPrereserva" type="text" maxlength="32" value="<?php echo tituloEmailPrereserva($conexao);  ?>" />
                                </div>
                                <div class="col-md-12">
                                    <label class=" small mb-2" id="labelDataFim" for="inputPass" style="margin-top: 2%;">Texto de email de cadastro pré-reserva:</label>
                                    <a style="color:red;" title="Campo obrigatório"> * </a>
                                    <input required class=" form-control py-2 valor" id="inputTextoEmailPrereserva" name="inputTextoEmailPrereserva" type="text" maxlength="400" value="<?php echo textoEmailPrereserva($conexao);  ?>">
                                </div>
                                <br>
                                <br>
                                <button type="input" class="btn btn-success btn-circle btn-sm float-right" id="AtualizarEmailPrereserva" name="AtualizarEmailPrereserva" value="1">
                                    Alterar
                                </button>

                            </form>
                            <form action="UpdateEmail.php" method="post">

                                <div class="col-md-6">
                                    <label required class="small mb-1" id="labelData" for="inputLogin" style="margin-top: 2%;">Título do email de retorno da reserva para usuário:</label>
                                    <a style="color:red;" title="Campo obrigatório"> * </a>
                                    <input required class="form-control py-2 valor" id="inputTituloEmailRetornoPrereserva" name="inputTituloEmailRetornoPrereserva" type="text" maxlength="32" value="<?php echo tituloEmailRetornoStatusPrereserva($conexao); ?>" />
                                </div>
                                <div class="col-md-12">
                                    <label class=" small mb-2" id="labelDataFim" for="inputPass" style="margin-top: 2%;">Texto do email de retorno da reserva para usuário:</label>
                                    <a style="color:red;" title="Campo obrigatório"> * </a>
                                    <input required class=" form-control py-2 valor" id="inputTextoEmailRetornoPrereserva" name="inputTextoEmailRetornoPrereserva" type="text" maxlength="400" value="<?php echo textoEmailRetornoStatusPrereserva($conexao); ?>">
                                </div>
                                <br>
                                <br>
                                <button type="input" class="btn btn-success btn-circle btn-sm float-right" id="AtualizarEmailRetornoPrereserva" name="AtualizarEmailRetornoPrereserva" value="1">
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