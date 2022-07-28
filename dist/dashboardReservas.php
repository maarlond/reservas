<?php
session_start();

include "conexaoDB.php";
include "sweetalert.html";
include "funcoesDashboard.php";


setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set("America/Sao_Paulo");

if (isset($_REQUEST['GrupoSalas'])) {
    $grupo = $_REQUEST['GrupoSalas'];
} else {
    $grupo = $_SESSION['sistemaGrupoSalas'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard Reservas</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/etapas.css" rel="stylesheet" />

    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>

    <link href='../lib/main.css' rel='stylesheet' />
    <script src='../lib/main.js'></script>
    <script src='../lib/locales-all.js'></script>

</head>

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
                <!-- Menu para solicitar reserva -->
                <div class="container-fluid">
                    <!-- <div class="mb-4 mt-4">
                        <h1 class="h4 text-primary">Dashboard de Reservas</h1>
                    </div> -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard de Reservas</li>
                        </ol>
                    </nav>
                    <div class="row">
                        <div class="col-xl-12 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total de reservas</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo buscaReservas($grupo, "TotalReservas"); ?></div>
                                        </div>
                                        <div class="col ml-5">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total de Reservas Confirmadas até o momento</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo buscaReservas($grupo, "TotalReservasConfirmadas"); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card ">
                                <div class="card shadow mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Total de reservas realizadas por status
                                    </div>
                                </div>
                                <div class="card-body text-center ">
                                    <div class="card-body"><canvas id="myPieChart"></canvas></div>
                                    <div class="legend">
                                        <i class="fa fa-circle text-info "></i> Novo
                                        <i class="fa fa-circle text-danger"></i> Cancelado
                                        <i class="fa fa-circle text-warning"></i> Editado
                                        <i style='color: #1CC88A' class="fa fa-circle"></i> Confirmado

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card ">
                                <div class="card shadow mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Reservas realizadas nos últimos 30 dias
                                    </div>
                                </div>
                                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>

                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card shadow mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Top 5 Espaços
                                    </div>
                                </div>
                                <div class="card-body"><canvas id="myBarChartEspacos" width="100%" height="40"></canvas></div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card shadow mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Top 5 Secretarias
                                    </div>
                                </div>
                                <div class="card-body"><canvas id="myBarChartSecretarias" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                    </div>
                    <!-- Footer -->
                    <?php include "direitos.php"; ?>
                    <!-- End of Footer -->
                </div>

            </main>
        </div>
    </div>


    <!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>-->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="js/functions.js"></script>
    <script src="js/jquery.validate.pt-br.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="http://jqueryvalidation.org/files/dist/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

    <!--  Chart Plugin  -->
    <script src="../vendor/chart.js/Chart.js"></script>

    <script>
        var ctx = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx, {
            type: "pie",
            data: {
                labels: ["Confirmado", "Cancelado", "Editado", "Novo"],
                datasets: [{
                    data: [<?php echo buscaReservasStatus($grupo, "StatusConfirmado"); ?>,
                        <?php echo buscaReservasStatus($grupo, "StatusCancelado"); ?>,
                        <?php echo buscaReservasStatus($grupo, "StatusEditado"); ?>,
                        <?php echo buscaReservasStatus($grupo, "StatusNovo"); ?>
                    ],
                    backgroundColor: ['#1cc88a', '#e74a3b', '#f6c23e', '#17a2b8'],
                    hoverBackgroundColor: ['#0D8358', '#B52919', '#C69920', '#0C7A8B'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: false
                },
            },
        });

        var ctxArea = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctxArea, {

            type: 'line',
            data: {
                labels: <?php echo json_encode(array_values(buscaReservasMes($grupo, "LabelDias"))); ?>,
                datasets: [{
                    label: "Reservas",
                    lineTension: 0.3,
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(2,117,216,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(2,117,216,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: <?php echo json_encode(array_values(buscaReservasMes($grupo, "DataDados"))); ?>,
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });

        var ctx = document.getElementById("myBarChartEspacos");
        var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_values(buscaEspacos($grupo, "EspacoNome"))); ?>,
                datasets: [{
                    label: "Total",
                    backgroundColor: <?php echo json_encode(array_values(buscaEspacos($grupo, "EspacoCor"))); ?>,
                    borderColor: "rgba(2,117,216,1)",
                    data: <?php echo json_encode(array_values(buscaEspacos($grupo, "EspacoValor"))); ?>,
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'month'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 5
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            display: true
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });


        var ctx = document.getElementById("myBarChartSecretarias");
        var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_values(buscaSecretarias($grupo, "SecretariaNome"))); ?>,
                datasets: [{
                    label: "Total",
                    backgroundColor: "rgba(2,117,216,1)",
                    borderColor: "rgba(2,117,216,1)",
                    data: <?php echo json_encode(array_values(buscaSecretarias($grupo, "SecretariaValor"))); ?>,
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'month'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 5
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            display: true
                        }
                    }],
                },
                legend: {
                    display: false,
                }
            }
        });
    </script>

</body>

</html>