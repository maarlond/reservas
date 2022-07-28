<?php
// session_start();
include "conexaoDB.php";
include "sweetalert.html";
include "funcoesNotificacoes.php";

$hash = $_GET['valor'];

if (isset($hash)) {
    $buscaDadosReserva = "SELECT *, res.email FROM satisfacao 
    INNER JOIN reservas as res on pk_reservas = fk_reservas 
    INNER JOIN eventos as ev on pk_eventos = fk_eventos 
    INNER JOIN espaços on pk_espacos = res.fk_espacos  WHERE hash = '$hash'";
    $dadosReserva = mysqli_query($conexao, $buscaDadosReserva) or die("Error in query: $buscaDadosReserva." . mysqli_error($conexao));
    $dados = mysqli_fetch_assoc($dadosReserva);


    $buscaRespostas  = "SELECT * FROM satisfacao INNER JOIN resposta ON pk_satisfacao = fk_satisfacao WHERE hash = '$hash'";
    $resultRespostas = mysqli_query($conexao, $buscaRespostas) or die("Error in query: $buscaRespostas." . mysqli_error($conexao));
    $dadosRespostas = mysqli_fetch_assoc($resultRespostas);

    $buscaPerguntas = "SELECT * FROM satisfacao_parametros INNER JOIN enunciado ON fk_enunciado = pk_enunciado WHERE fk_espacos = '" . $dados["fk_espacos"] . "' AND status_enunciado = '1'";
    $resultPerguntas = mysqli_query($conexao, $buscaPerguntas) or die("Error in query: $buscaPerguntas." . mysqli_error($conexao));
    $rowPerguntas = mysqli_num_rows($resultPerguntas);
    $paginas = $rowPerguntas % 2 == 0 ? $rowPerguntas / 2 : ($rowPerguntas + 1) / 2;
}

if (isset($dados) && (empty($dadosRespostas))) {
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

    <style>
        #satisfacao fieldset:not(:first-of-type) {
            display: none;
        }
    </style>

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
                    <!-- Menu para solicitar reserva -->
                    <div style="margin-top:0.5%;" class="container-fluid d-flex justify-content-center">
                        <form id="satisfacao" action="insertSatisfacao.php" method="post">
                            <div class="card col justify-content-center" style="width: 40rem;">
                                <div class="card-body">
                                    <h5 class="card-title text-center text-uppercase"><?php echo $dados["titulo_satisfacao"] ?></h5>
                                    <p class="card-text"><?php echo $dados["texto_satisfacao"] ?></p>
                                </div>
                                <br>
                                <fieldset>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Email <a style="color: red;">*</a></label>
                                        <input disabled type="email" class="form-control" name="inputEmail" aria-describedby="emailHelp" placeholder="Email" value="<?php echo $dados['email'] ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nome <a style="color: red;">*</a></label>
                                        <input disabled type="text" class="form-control" id="inputNome" name="inputNome" placeholder="Nome completo" value="<?php echo $dados['contato'] ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Espaço/Sala <a style="color: red;">*</a></label>
                                        <input disabled type="text" class="form-control" id="inputEspaco" name="inputEspaco" value="<?php echo $dados["nome"] ?>" placeholder="Nome completo">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Órgão: <a style="color: red;">*</a></label>
                                        <select disabled class="form-control" name="inputOrgao" placeholder="Órgão">
                                            <option selected value="<?php echo $dados['secretaria'] ?>"><?php echo strtoupper($dados['secretaria']) ?></option>
                                        </select>
                                    </div>
                                    <input style="float:right; margin-top: 2em;" type="button" class="next-step btn btn-primary" name="nextstep1" value="Próximo">
                                    <p>Página 1 de 3</p>

                                </fieldset>

                                <fieldset>
                                    <?php
                                    $i = 0;
                                    $numero = 0;
                                    $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

                                    //inicio visualização:
                                    $inicio = ($paginas * $pagina) - $paginas;

                                    //Busca Enunnciados no db:
                                    $busca_enunciado = "SELECT * FROM satisfacao_parametros INNER JOIN enunciado ON fk_enunciado = pk_enunciado WHERE fk_espacos = '" . $dados["fk_espacos"] . "' AND status_enunciado = '1' LIMIT $inicio, $paginas";

                                    $enunciado_formulario = mysqli_query($conexao, $busca_enunciado);

                                    while ($linha_enunciado = mysqli_fetch_assoc($enunciado_formulario)) {
                                        $i++;
                                        $numero++;
                                        echo $numero . ".&nbsp; ";
                                        echo $linha_enunciado['enunciado'] . " <a style='color: red;'>*</a></label><br><br>";

                                    ?>
                                        <div class="table justify-content-center">
                                            <div class="table table-borderless">
                                                <table class="table border-light table-hover" id="dataTableFormulario" cellspacing="0">
                                                    <thead class="thead-light">
                                                        <tr align="center">
                                                            <th></th>
                                                            <th>1</th>
                                                            <th>2</th>
                                                            <th>3</th>
                                                            <th>4</th>
                                                            <th>5</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr class="thead-light" align="center">
                                                            <label style="display: block;text-align: center;" id="resposta<?= $i ?>-error" class="error" for="resposta<?= $i ?>"></label>

                                                            <th> Muito Insatisfeito </th>
                                                            <th>
                                                                <input type="radio" name="resposta<?= $i ?>" required value="1">
                                                                <input type="hidden" name="enunciado<?= $i ?>" value="<?php echo $linha_enunciado['pk_enunciado']; ?>">
                                                            </th>
                                                            <th>
                                                                <input type="radio" name="resposta<?= $i ?>" value="2">
                                                                <input type="hidden" name="enunciado<?= $i ?>" value="<?php echo $linha_enunciado['pk_enunciado']; ?>">
                                                            </th>
                                                            <th>
                                                                <input type="radio" name="resposta<?= $i ?>" value="3">
                                                                <input type="hidden" name="enunciado<?= $i ?>" value="<?php echo $linha_enunciado['pk_enunciado']; ?>">
                                                            </th>
                                                            <th>
                                                                <input type="radio" name="resposta<?= $i ?>" value="4">
                                                                <input type="hidden" name="enunciado<?= $i ?>" value="<?php echo $linha_enunciado['pk_enunciado']; ?>">
                                                            </th>
                                                            <th>
                                                                <input type="radio" name="resposta<?= $i ?>" value="5">
                                                                <input type="hidden" name="enunciado<?= $i ?>" value="<?php echo $linha_enunciado['pk_enunciado']; ?>">
                                                            </th>
                                                            <th> Muito Satisfeito </th>
                                                        </tr>
                                                    </tfoot>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>

                                        <br><br>
                                    <?php
                                    } ?>
                                    <input style="float:right; margin-top: 2em;" type="button" class="next-step btn btn-primary ml-2" name="nextstep2" value="Próximo">
                                    <input style="float:right; margin-top: 2em;" type="button" class="previous-step btn btn-primary" name="previous-step" value="Anterior">
                                    <p>Página 2 de 3</p>
                                </fieldset>

                                <fieldset>
                                    <?php
                                    $pagina = 2;

                                    //início visualização:
                                    $inicio = ($paginas * $pagina) - $paginas;

                                    //Busca Enunciados no db:
                                    $busca_enunciado = "SELECT * FROM satisfacao_parametros INNER JOIN enunciado ON fk_enunciado = pk_enunciado WHERE fk_espacos = '" . $dados["fk_espacos"] . "' AND status_enunciado = '1' LIMIT $inicio, $paginas";
                                    $enunciado_formulario = mysqli_query($conexao, $busca_enunciado);

                                    while ($linha_enunciado = mysqli_fetch_assoc($enunciado_formulario)) {
                                        $i++;
                                        $numero++;
                                        echo $numero . ".&nbsp; ";
                                        echo $linha_enunciado['enunciado'] . " <a style='color: red;'>*</a></label><br><br>";

                                    ?>
                                        <div class="table justify-content-center">
                                            <div class="table table-borderless">
                                                <table class="table border- table-hover" id="dataTableFormulario" cellspacing="0">
                                                    <thead class="thead-light">
                                                        <tr align="center">
                                                            <th></th>
                                                            <th>1</th>
                                                            <th>2</th>
                                                            <th>3</th>
                                                            <th>4</th>
                                                            <th>5</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr class="thead-light" align="center">
                                                            <label style="display: block;text-align: center;" id="resposta<?= $i ?>-error" class="error" for="resposta<?= $i ?>"></label>

                                                            <th> Muito Insatisfeito </th>
                                                            <th>
                                                                <input type="radio" name="resposta<?= $i ?>" required value="1">
                                                                <input type="hidden" name="enunciado<?= $i ?>" value="<?php echo $linha_enunciado['pk_enunciado']; ?>">
                                                            </th>
                                                            <th>
                                                                <input type="radio" name="resposta<?= $i ?>" value="2">
                                                                <input type="hidden" name="enunciado<?= $i ?>" value="<?php echo $linha_enunciado['pk_enunciado']; ?>">
                                                            </th>
                                                            <th>
                                                                <input type="radio" name="resposta<?= $i ?>" value="3">
                                                                <input type="hidden" name="enunciado<?= $i ?>" value="<?php echo $linha_enunciado['pk_enunciado']; ?>">
                                                            </th>
                                                            <th>
                                                                <input type="radio" name="resposta<?= $i ?>" value="4">
                                                                <input type="hidden" name="enunciado<?= $i ?>" value="<?php echo $linha_enunciado['pk_enunciado']; ?>">
                                                            </th>
                                                            <th>
                                                                <input type="radio" name="resposta<?= $i ?>" value="5">
                                                                <input type="hidden" name="enunciado<?= $i ?>" value="<?php echo $linha_enunciado['pk_enunciado']; ?>">
                                                            </th>
                                                            <th> Muito Satisfeito </th>
                                                        </tr>
                                                    </tfoot>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    <?php } ?>
                                    <input type="hidden" name="pk_satisfacao" value="<?php echo $dados["pk_satisfacao"] ?>">

                                    <input style="float:right; margin-top: 2em;" type="button" class="btn btn-primary ml-2 finish" name="finalizar" value="Finalizar">

                                    <input style="float:right; margin-top: 2em;" type="button" class="previous-step btn btn-primary" name="previous-step" value="Anterior">
                                    <p>Página 3 de 3</p>
                                </fieldset>
                        </form>
                        <div class="mb-2 mt-2 progress">
                            <div class="progress-bar progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    </form>

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
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="https://jqueryvalidation.org/files/dist/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    </body>

    </html>

<?php } else {
    echo "<script> 
    swal({
        title: 'Aviso!',
        text: 'Formulário já preenchido ou acesso não permitido!',
        type: 'info'
    }, 
    function(){
      window.location.href = 'https://sistemas.planejamento.rs.gov.br/reservas/';
    })
</script>";
} ?>