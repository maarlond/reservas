<?php
include "conexaoDB.php";
include "sweetalert.html";


if (isset($_REQUEST['pk_espacos'])) {

    $pk_espacos = $_REQUEST['pk_espacos'];

    $query_espacos = "SELECT * FROM espaços where pk_espacos = $pk_espacos";

    $dados = mysqli_query($conexao, $query_espacos) or die("Error in select query_espacos: $query_espacos." . mysqli_error($conexao));

    $linha = mysqli_fetch_array($dados);

    $caminho = "./uploads/Espacos/" . $_REQUEST['pk_espacos'] . "/";

    $query_enunciados = "SELECT * FROM enunciado INNER JOIN satisfacao_parametros ON pk_enunciado = fk_enunciado WHERE fk_espacos = $pk_espacos";
    // echo $query_enunciados;die();
    $dadosEnunciados = mysqli_query($conexao, $query_enunciados) or die("Error in query_reservas: $query_enunciados." . mysqli_error($conexao));

    $linhaEnunciados = mysqli_fetch_assoc($dadosEnunciados);
}

if (!isset($linha['cor'])) {
    $letters = '0123456789ABCDEF';
    $linha['cor'] = '#';
    for ($i = 0; $i < 6; $i++) {
        $index = rand(0, 15);
        $linha['cor'] .= $letters[$index];
    }
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
    <title>Cadastro de Espaços</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <link href='../lib/main.css' rel='stylesheet' />
    <script src='../lib/main.js'>
    </script>

</head>
<style>
    #parametrosSatisfacao {
        display: none;
    }

    .show-menu {
        left: 200px;
        opacity: 1;
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
        <?php include "nav.php"; ?>
        <!-- Incluindo menu esquerdo -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <div id="parametrosEspaco">
                        <form action="insertUpdateEspacos.php" method="post" enctype="multipart/form-data">
                            <br>
                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputNomeEspacos">Nome do espaço</label><a style="color:red;" title="Campo obrigatório"> * </a>
                                        <input required class="form-control py-2" maxlength="45" name="inputNomeEspacos" id="inputNomeEspacos" type="text" placeholder="Nome da sala" value='<?= empty($linha["nome"]) ? "" : $linha["nome"]; ?>' />
                                    </div>
                                </div>
                                <!-- Trecho novo para merge-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputLocalizacao">Email Moderador</label><a style="color:red;" title="Campo obrigatório"> * </a>
                                        <input required class="form-control py-2" maxlength="100" id="inputEmail" name="inputEmail" type="email" placeholder="Email para o envio dos alertas ao moderador" value='<?= empty($linha["email"]) ? "" : $linha["email"]; ?>' />
                                    </div>
                                </div>
                                <!-- End -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputLocalizacao">Localização</label><a style="color:red;" title="Campo obrigatório"> * </a>
                                        <input required class="form-control py-2" maxlength="45" id="inputLocalizacao" name="inputLocalizacao" type="text" placeholder="Localização da sala" value='<?= empty($linha["localizacao"]) ? "" : $linha["localizacao"]; ?>' />
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputHoraAbertura">Horário abertura</label><a style="color:red;" title="Campo obrigatório"> * </a>
                                        <input required class="form-control py-2" id="inputHoraAbertura" name="inputHoraAbertura" type="time" placeholder="Limite de horário inicial" value='<?= empty($linha["horario_abertura"]) ? "" : $linha["horario_abertura"]; ?>' />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputHoraFechamento">Horário fechamento</label><a style="color:red;" title="Campo obrigatório"> * </a>
                                        <input required class="form-control py-2" id="inputHoraFechamento" name="inputHoraFechamento" type="time" placeholder="Limite de horário final" value='<?= empty($linha["horario_fechamento"]) ? "" : $linha["horario_fechamento"]; ?>' />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputIntervalo">Intervalo entre as reservas:</label><a style="color:red;" title="Campo obrigatório"> * </a>
                                        <input required class="form-control py-2" id="inputIntervalo" name="inputIntervalo" type="time" placeholder="Intervalo entre as reservas" value='<?= empty($linha["intervalo_horarios"]) ? "" : $linha["intervalo_horarios"]; ?>' />
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputCapacidade">Capacidade</label><a style="color:red;" title="Campo obrigatório"> * </a>
                                        <input required class="form-control py-2" id="inputCapacidade" name="inputCapacidade" onkeyup="if(parseInt(this.value)>99999999){ this.value =99999999; return false; }" type="number" max="99999999" placeholder="Nº de pessoas" value='<?= empty($linha["capacidade"]) ? "" : $linha["capacidade"]; ?>' />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputAprovacao">Moderar</label><a style="color:red;" title="Campo obrigatório"> * </a>
                                        <select required class="form-control py-2" id="inputAprovacao" name="inputAprovacao" title="Campo para habilitar moderador pra as reservas">
                                            <option value="" selected disabled hidden>Aprovador de reservas?</option>
                                            <option <?php echo isset($linha['aprovacao']) ? ('1' == $linha['aprovacao'] ? 'selected' : '') : ''; ?> value="1">Sim</option>
                                            <option <?php echo isset($linha['aprovacao']) ? ('0' == $linha['aprovacao'] ? 'selected' : '') : ''; ?> value="0">Não</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="small mb-1" for="inputListaEspera">Lista de Espera</label><a style="color:red;" title="Campo obrigatório"> * </a>
                                    <select required class="form-control py-2" id="inputListaEspera" name="inputListaEspera">
                                        <option value="" selected disabled hidden>Permite lista de espera?</option>
                                        <option <?php echo isset($linha['lista_espera']) ? ('1' == $linha['lista_espera'] ? 'selected' : '') : ''; ?> value="1">Sim</option>
                                        <option <?php echo isset($linha['lista_espera']) ? ('0' == $linha['lista_espera'] ? 'selected' : '') : ''; ?> value="0">Não</option>
                                    </select>

                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputStatus">Cor</label><a style="color:red;" title="Campo obrigatório"> * </a>
                                        <input class="form-control py-2" title="Cor que é exibida no Calendario" id="inputColor" name="inputColor" type="color" value="<?= isset($linha['cor']) ? $linha['cor'] : ''; ?>" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputStatus">Disponibilidade</label><a style="color:red;" title="Campo obrigatório"> * </a>
                                        <select required class="form-control py-2" id="inputStatus" name="inputStatus">
                                            <option value="" selected disabled hidden></option>
                                            <option <?php echo isset($linha['status']) ? ('1' == $linha['status'] ? 'selected' : '') : ''; ?> value="1">Disponível</option>
                                            <option <?php echo isset($linha['status']) ? ('0' == $linha['status'] ? 'selected' : '') : ''; ?> value="0">Indisponível</option>
                                            <option <?php echo isset($linha['status']) ? ('2' == $linha['status'] ? 'selected' : '') : ''; ?> value="2">Indisponível Temporariamente</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputTermo">Equipamentos e outros</label><a style="color:red;" title="Campo obrigatório"> * </a>
                                        <textarea required class="form-control py-2" id="inputTermo" name="inputTermo" type="text"><?= empty($linha["termo_compromisso"]) ? "" : $linha["termo_compromisso"]; ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="small mb-1" for="inputTermo">Exibir calendário no portal do caff?</label><a style="color:red;" title="Campo obrigatório"> * </a>
                                    <select required class="form-control py-2" id="inputStatusCalendario" name="inputStatusCalendario" title="Campo para habilitar exibição do calendário com as reservas no portal do caff">
                                        <option value="" selected disabled hidden>Habilitar calendário?</option>
                                        <option <?php echo isset($linha['calendario_status']) ? ('1' == $linha['calendario_status'] ? 'selected' : '') : ''; ?> value="1">Sim</option>
                                        <option <?php echo isset($linha['calendario_status']) ? ('0' == $linha['calendario_status'] ? 'selected' : '') : ''; ?> value="0">Não</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="small mb-1" for="inputTermo">Habilitar pesquisa de satisfação</label><a style="color:red;" title="Campo obrigatório"> * </a>
                                    <select required class="form-control py-2" id="inputStatusSatisfacao" name="inputStatusSatisfacao" title="Campo para habilitar pesquisa de satisfação">
                                        <option value="" selected disabled hidden>Pesquisa de satisfação?</option>
                                        <option <?php echo isset($linha['satisfacao_status']) ? ('1' == $linha['satisfacao_status'] ? 'selected' : '') : ''; ?> value="1">Sim</option>
                                        <option <?php echo isset($linha['satisfacao_status']) ? ('0' == $linha['satisfacao_status'] ? 'selected' : '') : ''; ?> value="0">Não</option>
                                    </select>
                                    <?php if (isset($linha['satisfacao_status'])) {
                                        if ($linha['satisfacao_status'] == 1) {
                                    ?>
                                            <button type="button" class="mt-2 btn btn-sm button-circle btn-info float-right " onclick="exibirOcultarParametros()">Parâmetros satisfação</button>
                                    <?php }
                                    } ?>
                                </div>



                                <div class=" col-md-3">
                                    <div class="form-group">
                                        <?php include "upload.php"; ?>
                                    </div>
                                </div>
                            </div>

                            <?php
                            if ($_SESSION["reservaPermissoaAcesso"] > 0) {
                            ?>
                                <div class="form-group" style="text-align: right;">
                                    <button class="btn btn-success" type="submit" name="pk_espacos" value='<?= isset($linha["pk_espacos"]) ? $linha["pk_espacos"] : ""; ?>'>
                                        <?= isset($linha["pk_espacos"]) ? "Alterar" : "Cadastrar"; ?>
                                    </button>
                                </div>
                            <?php
                            }
                            ?>

                            <div class="form-row">
                                <?php include "uploadListar.php"; ?>
                            </div>
                        </form>
                    </div>

                    <?php if (isset($linha["satisfacao_status"])) {
                        if ($linha["satisfacao_status"] == 1) {

                    ?>
                            <div id="parametrosSatisfacao">
                                <div class="card shadow">
                                    <div class="button mr-2">
                                        <button type="button" class="mt-2 btn btn-sm button-circle btn-info float-right" onclick="exibirOcultarParametros()">Voltar</button>
                                    </div>

                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text">Parâmetros pesquisa de satisfação</h6>
                                    </div>
                                    <div class="col-md-12">
                                        <form action="updateSatisfacao.php" id="updateSatisfacao" method="post">
                                            <input type="hidden" id="<?= $pk_espacos ?>" name="pk_espacos" value="<?= $pk_espacos ?>" />

                                            <label required class="small mb-2" id="labelData" for="inputLogin" style="margin-top: 2%;">Título</label>
                                            <a style="color:red;" title="Campo obrigatório"> * </a>
                                            <textarea required class="form-control py-2 valor" rows="1" name="inputTitulo" type="text" maxlength="500" placeholder="Digite o título da página de satisfação"><?php echo $linha["titulo_satisfacao"] ?></textarea>
                                            <br>
                                            Para inserir um link no texto o mesmo deve ser iniciado por: &lt;a href="https://www.estado.rs.gov.br"&gtex: Texto desejado e finalizados por&lt;/a&gt
                                            <br>
                                            Para fazer uma quebra de linha, favor utilizar &lt;br&gt;
                                            <br>
                                            <label required class="small mb-2" id="labelData" for="inputLogin" style="margin-top: 2%;">Texto</label>
                                            <a style="color:red;" title="Campo obrigatório"> * </a>
                                            <textarea required class="form-control py-2 valor" rows="5" name="inputTexto" type="text" maxlength="1000" placeholder="Digite o texto da página de satisfação"><?php echo $linha["texto_satisfacao"] ?></textarea>
                                            <button type="input" class="mt-3 btn btn-success btn-circle btn-sm float-right" name="incluirTexto" value="1">
                                                Alterar
                                            </button>
                                        </form>
                                    </div>
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text">Pré visualização</h6>
                                    </div>
                                    <div class="card">
                                        <label required class="small mb-1" id="labelData" for="inputLogin" style="margin: 2%;">
                                            <div class="card-body">
                                                <h5 class="card-title text-center text-uppercase"><?php echo $linha["titulo_satisfacao"] ?></h5>
                                                <p class="card-text"><?php echo $linha["texto_satisfacao"] ?></p>
                                            </div>
                                        </label>
                                    </div>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTableSetor" width="100%" cellspacing="0">
                                            <thead class="thead-dark">
                                                <tr align="center">
                                                    <th>ID</th>
                                                    <th>Enunciado</th>
                                                    <th>Ação</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr class="thead-dark" align="center">
                                                    <th>ID</th>
                                                    <th>Enunciado</th>
                                                    <th>Ação</th>
                                                    <th>Status</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php
                                                if (mysqli_num_rows($dadosEnunciados) > 0) {
                                                    do {
                                                ?>
                                                        <tr align="center" class="odd gradeX">
                                                            <td><?= $linhaEnunciados["pk_enunciado"] ?></td>
                                                            <td><?= $linhaEnunciados["enunciado"] ?></td>
                                                            <td align="center">
                                                                <form action="updateSatisfacao.php" id="updateSatisfacao" method="post">
                                                                    <!-- <input type="hidden" id="pk_reservas" name="pk_reservas" value="" />
                                                        <input type="hidden" id="passaStatus" name="passaStatus" value="" />
                                                        <input type="hidden" id="passaMotivo" name="passaMotivo" value="" /> -->
                                                                    <input type="hidden" id="<?= $linhaEnunciados['pk_enunciado'] ?>" name="pk_enunciado" value="<?= $linhaEnunciados['pk_enunciado'] ?>" />
                                                                    <input type="hidden" id="<?= $pk_espacos ?>" name="pk_espacos" value="<?= $pk_espacos ?>" />

                                                                    <button type="submit" class="btn btn-success btn-sm" id="deleteamc" name="status_enunciado" value="1" data-toggle="tooltip" title="Habilitar Enunciado">
                                                                        <i class="fas fa-check teste1"></i>
                                                                    </button>
                                                                    <button type="submit" class="btn btn-danger btn-sm" id="deleteamc" name="status_enunciado" value="0" data-toggle="tooltip" title="Desabilitar Enunciado">
                                                                        <i class="fas fa-times teste2"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                            <td><?php echo ($linhaEnunciados['status_enunciado'] == '1' ? 'Habilitado' : 'Desabilitado'); ?></td>
                                                        </tr>
                                                <?php
                                                    } while ($linhaEnunciados = mysqli_fetch_assoc($dadosEnunciados));
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-body">
                                        <form action="updateSatisfacao.php" method="POST">
                                            <input type="hidden" id="<?= $pk_espacos ?>" name="pk_espacos" value="<?= $pk_espacos ?>" />
                                            <div class="col-md-12">
                                                <label required class="small mb-2" id="labelData" for="inputLogin" style="margin-top: 2%;">Incluir enunciado</label>
                                                <a style="color:red;" title="Campo obrigatório"> * </a>
                                                <textarea required class="form-control py-2 valor" rows="5" name="inputEnunciado" type="text" maxlength="250"></textarea>
                                                <button type="input" class="mt-3 btn btn-success btn-circle btn-sm float-right" name="incluirEnunciado" value="1">
                                                    Incluir
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    <?php }
                    } ?>
                </div>
        </div>
        </main>
    </div>
    <!-- Footer -->
    <?php include "direitos.php"; ?>
    <!-- End of Footer -->
    </div>


    <?php
    if ($_SESSION["reservaPermissoaAcesso"] == 0) {
    ?>
        <style>
            /* pegas os inputs */
            .form-control {
                pointer-events: none;
                background: rgba(200, 200, 200, 0.3);
            }
        </style>
    <?php
    }
    ?>
    <script>
        function toggler(divId, divId2) {
            $("#" + divId).toggle();

            $("#" + divId2).toggle();

        }

        function exibirOcultarParametros() {
            toggler('parametrosSatisfacao');
            toggler('parametrosEspaco');
            // $('#GFG_DOWN').text("DIV Box is toggling.");
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
</body>

</html>