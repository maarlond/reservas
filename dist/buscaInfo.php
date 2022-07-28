<?php
session_start();
include "conexaoDB.php";

$pk_reservas = $_POST['pk_reservas'];

$caminho = "./uploads/Reservas/" . $_REQUEST['pk_reservas'] . "/";

if (isset($pk_reservas)) {
    $resultado = '';

    $query_info = "SELECT pk_reservas, reservas.status, motivo, titulo, fk_glpi_users, nome, secretaria, DATE_FORMAT(dt_hr_atualizacao, '%d/%m/%Y %H:%i:%s ') as dt_hr_atualizacao,
        IF((SELECT sis.glpi_users.name FROM sis.glpi_users WHERE fk_glpi_users = sis.glpi_users.id) IS NOT NULL,
        (SELECT sis.glpi_users.name FROM sis.glpi_users WHERE fk_glpi_users = sis.glpi_users.id),
        (SELECT nome FROM oauth.usuario WHERE matricula = fk_soe_users)) AS name
        FROM reservas
        inner join espaços
        on fk_espacos = pk_espacos
        inner join eventos
        on fk_eventos = pk_eventos
        AND pk_reservas = " . $_REQUEST['pk_reservas'] . "";



    $dadosInfo = mysqli_query($conexao, $query_info) or die("Error in query_reservas: $query_info." . mysqli_error($conexao));

    $linhaInfo = mysqli_fetch_assoc($dadosInfo);

    if ($linhaInfo['name'] == "" or $linhaInfo['name'] == null) {
        $linhaInfo['name'] = "Usuário inexistente!";
    }

    $resultado .= '<dl class="row">';

    $resultado .= '<dt class="col-sm-6">ID da reserva:</dt>';
    $resultado .= '<dd class="col-sm-6">' . $linhaInfo["pk_reservas"] . '</dd>';

    $resultado .= '<dt class="col-sm-6">Nome do espaço:</dt>';
    $resultado .= '<dd class="col-sm-6">' . $linhaInfo["nome"] . '</dd>';

    $resultado .= '<dt class="col-sm-6">Objetivo:</dt>';
    $resultado .= '<dd class="col-sm-6">' . $linhaInfo["titulo"] . '</dd>';

    $resultado .= '<dt class="col-sm-6">Status da reserva:</dt>';
    $resultado .= '<dd class="col-sm-6">' . $linhaInfo["status"] . '</dd>';

    $resultado .= '<dt class="col-sm-6">Operador da reserva:</dt>';
    $resultado .= '<dd class="col-sm-6">' . $linhaInfo['name'] . '</dd>';

    $resultado .= '<dt class="col-sm-6">Secretaria:</dt>';
    $resultado .= '<dd class="col-sm-6">' . $linhaInfo['secretaria'] . '</dd>';

    $resultado .= '<dt class="col-sm-6">Data do cadastro:</dt>';
    $resultado .= '<dd class="col-sm-6">' . $linhaInfo['dt_hr_atualizacao'] . '</dd>';

    if (isset($linhaInfo['motivo'])) {
        $resultado .= '<dt class="col-sm-12">Motivo do cancelamento:</dt>';

        $resultado .= '<dd class="col-sm-12">' . $linhaInfo['motivo'] . '</dd>';
    }

    if (isset($caminho)) {
        $diretorio = dir($caminho);
        if (file_exists($caminho)) {
            if (isset($diretorio)) {
                if (count(glob($caminho . "/*")) !== 0) {
                    $resultado .= '<dt class="col-sm-12">Documentos em anexo:</dt>';
                    while ($arquivo = $diretorio->read()) {
                        $ext = pathinfo($arquivo, PATHINFO_EXTENSION);
                        if ($arquivo != "." && $arquivo != "..") {
                            $resultado .=  "<dd class='col-sm-12'><a href=" . $caminho . "/" . $arquivo . " target='_blank'>" . $arquivo . "</a></dd>";
                        }
                    }
                }
            }
        }
    }
    $resultado .= '</dl>';

    echo $resultado;
}
