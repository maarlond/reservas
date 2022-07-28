<?php
//session_start();
include "conexaoDB.php";
include "sweetalert.html";
include "funcoesNotificacoes.php";

$contato = $_REQUEST['contato'];
$espaco = $_REQUEST["nome"];
$reserva = $_REQUEST["pk_reserva"];
// Retorna todas as respostas com base no Formulario
$retorna_resposta = "SELECT * FROM satisfacao as sat INNER JOIN resposta as res on res.fk_satisfacao = sat.pk_satisfacao 
                    INNER JOIN enunciado as enun on enun.pk_enunciado = res.fk_enunciado INNER JOIN reservas on fk_reservas = pk_reservas INNER JOIN espaços on fk_espacos = pk_espacos 
                    WHERE sat.fk_reservas = $reserva";
$resultado_resposta = mysqli_query($conexao, $retorna_resposta);
$linha = mysqli_fetch_assoc($resultado_resposta);

if (mysqli_num_rows($resultado_resposta) > 0) {

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
        <link href="css/etapas.css" rel="stylesheet" />

        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>

        <link href='../lib/main.css' rel='stylesheet' />
        <script src='../lib/main.js'></script>
        <script src='../lib/locales-all.js'></script>
    </head>

    <body class="sb-nav-fixed">

        <!-- Incluindo menu header -->
        <?php include "header.php";
        require "verificarAcesso.php";
        ?>

        <!-- Incluindo menu header -->
        <div id="layoutSidenav">
            <!-- Incluindo menu esquerdo -->
            <?php include "nav.php" ?>
            <!-- Incluindo menu esquerdo -->
            <div id="layoutSidenav_content">
                <main>
                    <!-- Menu para detalhes reserva -->
                    <div style="margin-top:0.5%;" class="container-fluid">
                        <div class="card col d-flex justify-content-center" style="width: 40rem;">
                            <div class="card-body">
                                <h5 class="card-title text-center">PESQUISA DE SATISFAÇÃO - CAFFWORKING</h5>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                Nome do usuário: <?php echo $contato ?> <br>
                                                Espaço: <?php echo $espaco ?> <br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container-fluid px-4">
                                        <table class="table table-bordered dataTable no-footer" id="datatablesSimple">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Texto do enunciado</th>
                                                    <th>Alternativa marcada</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0;

                                                foreach ($resultado_resposta as $resposta) {
                                                    $i++;

                                                ?>
                                                    <tr class="card-header">
                                                        <td>
                                                            <?php echo $resposta['fk_reservas'] ?>
                                                        </td>

                                                        <td>
                                                            <?php echo $resposta['enunciado'] ?>
                                                        </td>

                                                        <td>
                                                            <?php echo $resposta['fk_alternativa'] ?>
                                                        </td>
                                                    </tr>

                                                <?php
                                                }

                                                ?>

                                            </tbody>
                                        </table>
                                        <form action="listarSatisfacao.php" method="POST">

                                            <button id="segundo" type="submit" class="btn btn-primary">Voltar</button>

                                        </form>
                                    </div>
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


        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="js/functions.js"></script>
        <script src="js/jquery.validate.pt-br.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="https://jqueryvalidation.org/files/dist/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    </body>

    </html>
<?php } else {
    echo "<script>
                                                                        
        swal({
            title: 'Sem Detalhes',  
            text: 'Usuário ainda não realizou a pesquisa de satisfação!',
            type: 'info',
            timer: 2000
            },
                function(){
                window.location.href = 'listarSatisfacao.php'
            }) 
                                                                    
        </script>";
}
