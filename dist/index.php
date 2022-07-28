<?php
include "conexaoDB.php";
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Reservas de Espaços - Grupo de salas</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php include "header.php" ?>
    <main>
        <div style="margin-top: 10%; text-align:center; justify-content:center; ">
            <h1 class="mt-1">Seja bem-vindo ao Sistema de Reservas do CAFF!</h1>
            <p class="btn-lg" style="margin-top: 5%;">Escolha a opção abaixo:</p>
            <?php if ($_SESSION['reservaPermissoaAcesso'] == "1") {
                $action = "dashboardReservas.php";
            } else {
                $action = "reservar.php";
            }
            ?>
            <form action="<?= $action ?>" method="POST">
                <div class="row" style="justify-content:center;">
                    <div class="col-xl-5 col-md-6">
                        <div class="card bg-warning text-dark mb-4">
                            <button style="padding: 1.25rem;border: 1px solid rgba(0, 0, 0, 0);" class="bg-warning text-black btn-lg" name="GrupoSalas" value="1"><a>Reservas CAFF Working</a></button>
                        </div>
                    </div>

                    <div class="col-xl-5 col-md-6">
                        <div class="card bg-success text-white mb-4">
                            <button style="padding: 1.25rem;border: 1px solid rgba(0, 0, 0, 0);" class="bg-success text-white btn-lg" name="GrupoSalas" value="2">Reservas demais salas de reuniões do CAFF</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>

</body>

</html>