<?php
session_start();
$acessosGlpi = $_REQUEST['listarAcesso'];

include "conexaoDB.php";
include "sweetalert.html";

function ajustaPermissao($acessosGlpi)
{
    $parametros = parametros();
    $conexao = conexaoBanco();
    $query_user_glpi =  "select * from user_permissao where " . $parametros['on2'] . " = " . $_REQUEST['identificadorUser'];
    $dados = mysqli_query($conexao, $query_user_glpi) or die("Error in query_user_glpi: $query_user_glpi." . mysqli_error($conexao));
    $linha = mysqli_fetch_assoc($dados);

    if (isset($linha) && $acessosGlpi != "1") {

        $update_status_reserva = ("
            UPDATE user_permissao
            SET
            fk_permissao = " . $_REQUEST['inputAcesso'] . ",
            grupo_salas = " . $_SESSION['sistemaGrupoSalas']  . "
            where " . $parametros['on2'] . " = " . $_REQUEST["identificadorUser"] . "
        ");
        $errors[] = isset($_SESSION['sistemaGrupoSalas']) && $_SESSION['sistemaGrupoSalas'] != "";
        $errors[] = mysqli_query($conexao, $update_status_reserva);
        alertConfirm($errors);
    } else if ($acessosGlpi != "1") {

        $insert_acesso = "INSERT INTO `user_permissao` (`pk_user_permissao`, " . $parametros['on2'] . ", `fk_permissao`,grupo_salas) VALUES (NULL, " . $_REQUEST["identificadorUser"] . ", " . $_REQUEST['inputAcesso'] . "," . $_SESSION['sistemaGrupoSalas'] . ")";
        $errors[] = isset($_SESSION['sistemaGrupoSalas']) && $_SESSION['sistemaGrupoSalas'] != "";
        $errors[] = mysqli_query($conexao, $insert_acesso);
        alertConfirm($errors);
    }
}

function alertConfirm($errors)
{
    if ($errors[0] && $errors[1]) {

        echo "<script>
        swal({
            title: 'Sucesso!',
            text: 'Dados alterados com sucesso!',
            type: 'success',
            timer: 2000
        },
        function(){
            window.location.href = 'acessos.php';
        })
        </script>";
        exit();
    } else {
        echo "<script>
        swal({
            title: 'Erro!',
            text: 'Por favor selecione um Grupo de Salas!',
            type: 'error',
            timer: 3000
        },
        function(){
            window.location.href = 'index.php';
        })
        </script>";
        exit();
    }
}
?>
<!DOCTYPE html>
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

<body id="sb-nav-fixed" onload="exibirGrupoSalas();">

    <?php include("header.php");
    ajustaPermissao($acessosGlpi);
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
                            <h6 class="m-0 font-weight-bold text">Acessos</h6>
                        </div>
                        <div class="card-body">

                            <form action="updateAcesso.php" method="post">
                                <br>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputObjetivo">Nome</label>
                                            <input disabled class="form-control py-2" id="passaNome" name="passaNome" type="text" value="<?= $_REQUEST['passaNome'] ?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputEspacos">Tipo de Acesso</label>
                                            <select required class="form-control py-2" name="inputAcesso" id="inputAcessos" on="sala" onchange="exibirGrupoSalas();">
                                                <option value="0" <?= $_REQUEST['inputAcesso'] == "0" ? "selected" : ""; ?>>Básico</option>
                                                <option value="1" <?= $_REQUEST['inputAcesso'] == "1" ? "selected" : ""; ?>>Administrador</option>
                                                <option value="2" <?= $_REQUEST['inputAcesso'] == "2" ? "selected" : ""; ?>>Aprovador</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6" style="display:none;" id="divGrupoSalas">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputEspacos">Grupo de Salas</label>
                                            <select required class="form-control py-2" name="grupoSalas" id="grupoSalas">
                                                <option value="1" <?= $_REQUEST['grupoSalas'] == "1" ? "selected" : ""; ?>>CAFF Working</option>
                                                <option value="2" <?= $_REQUEST['grupoSalas'] == "2" ? "selected" : ""; ?>>Reserva de Espaços Demais Salas</option>
                                            </select>
                                        </div>
                                    </div>


                                </div>
                                <div style="float: right;" class="form-row">
                                    <div class="form-group" style="text-align: right;">
                                        <input type="hidden" id="acao" name="acao" value="realiza" />
                                        <a href="./acessos.php" class="btn btn-primary" type="submit">Cancelar</a>
                                        <button class="btn salvar btn-success" type="submit" name="identificadorUser" value="<?= $_REQUEST['identificadorUser'] ?>">Salvar</button>

                                    </div>
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
        function exibirGrupoSalas() {
            if ($("#inputAcessos").val() == "2") {
                //document.getElementById("divGrupoSalas").style.display = 'block';
            } else {
                // document.getElementById("divGrupoSalas").style.display = 'none';
            }
        }
        $('.salvar').on('click', function(e) {

            valor = $(this);
            event.preventDefault();
            var form = this;

            swal({
                    title: "Confirmar alteração?",
                    text: $("#" + valor.val()).val(),
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Sim, Confirmar!",
                    cancelButtonText: "Não, Cancelar!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $("input#passaStatus").val("1");
                        $(valor).trigger('click');
                    } else {
                        swal.close();
                    }
                });
        });
    </script>

</body>

</html>