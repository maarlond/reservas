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
                        <h1 class="h4 text-primary">Dashboard Satisfação</h1>
                    </div> -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard Pesquisa de Satisfação</li>
                        </ol>
                    </nav>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card ">
                                <div class="card shadow mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Total de respostas das salas <?php echo $grupo == '1' ? "do Caff Working" : " das Demais Salas"; ?>
                                    </div>
                                </div>
                                <div class="card-body text-center ">
                                    <div class="card-body"><canvas id="myPieChart"></canvas></div>
                                    <div class="legend">
                                        <i class="fa fa-circle text-danger"></i> Muito Insatisfeito
                                        <i class="fa fa-circle text-warning"></i> Insatisfeito
                                        <i class="fa fa-circle text-secondary"></i> Neutro
                                        <i class="fa fa-circle text-info "></i> Satisfeito
                                        <i style='color: #1CC88A' class="fa fa-circle"></i> Muito Satisfeito
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card ">
                                <div class="card shadow mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Desempenho da pesquisa de satisfação dos últimos 6 meses
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
                                        Salas melhores avaliadas
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
                                        Salas piores avaliadas
                                    </div>
                                </div>
                                <div class="card-body"><canvas id="myBarChartSecretarias" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <!-- Footer -->
            <?php include "direitos.php"; ?>
            <!-- End of Footer -->
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
                labels: ['Muito Satisfeito', 'Satisfeito', 'Neutro', 'Insatisfeito', 'Muito Insatisfeito'],
                datasets: [{
                    data: [<?php echo buscaRespostas($grupo, 'MuitoSatisfeito'); ?>,
                        <?php echo buscaRespostas($grupo, 'Satisfeito'); ?>,
                        <?php echo buscaRespostas($grupo, 'Neutro'); ?>,
                        <?php echo buscaRespostas($grupo, 'Insatisfeito'); ?>,
                        <?php echo buscaRespostas($grupo, 'Muito Insatisfeito'); ?>
                    ],
                    backgroundColor: ['#1cc88a', '#17a2b8', '#A0A0A0', '#f6c23e', '#e74a3b'],
                    hoverBackgroundColor: ['#0D8358', '#0C7A8B', '#606060', '#C69920', '#B52919'],
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
                labels: <?php echo json_encode(array_values(buscaDatas($grupo, "LabelDias"))); ?>,
                datasets: [{
                    label: "Avaliação total",
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
                    data: <?php echo json_encode(array_values(buscaDatas($grupo, "DataDados"))); ?>
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
                labels: <?php echo json_encode(array_values(buscaMelhoresSalas($grupo, "BuscaNome"))); ?>,
                datasets: [{
                    label: "Nota total",
                    backgroundColor: <?php echo json_encode(array_values(buscaMelhoresSalas($grupo, "BuscaCor"))); ?>,
                    borderColor: "rgba(2,117,216,1)",
                    data: <?php echo json_encode(array_values(buscaMelhoresSalas($grupo, "BuscaValor"))); ?>,
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
                labels: <?php echo json_encode(array_values(buscaPioresSalas($grupo, "BuscaNome"))); ?>,
                datasets: [{
                    label: "Total",
                    backgroundColor: <?php echo json_encode(array_values(buscaPioresSalas($grupo, "BuscaCor"))); ?>,
                    borderColor: "rgba(2,117,216,1)",
                    data: <?php echo json_encode(array_values(buscaPioresSalas($grupo, "BuscaValor"))); ?>,
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
        })
    </script>

</body>

</html>