<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

include "conexaoDB.php";
include "sweetalert.html";
include "chamadasAlertas.php";
require '../vendor/autoload.php';

session_start();

$status = "";
$id_reserva =  $_REQUEST["pk_reservas"];
$motivo =  $_REQUEST["passaMotivo"];

switch ($_REQUEST['passaStatus']) {
    case 0:
        $status = "Cancelado";
        break;
    case 1:
        $status = "Confirmado";
        break;
}

if ($status == "Cancelado") {
    $update_status_reserva = ("
        UPDATE reservas 
        SET 
        status = '" . $status . "',
        motivo = '" . $motivo . "',
        dt_hr_atualizacao =	NOW()
        where pk_reservas = '" . $_REQUEST["pk_reservas"] . "'
    ");

    $errors[] = mysqli_query($conexao, $update_status_reserva) or die("Error in update_status_reserva:$update_status_reserva " . mysqli_error($conexao));
} elseif ($status == "Confirmado") {
    // print_r($_REQUEST);die();
    $query_info = "SELECT pk_reservas, reservas.status, fk_glpi_users, nome, pk_espacos, secretaria, hr_ini, hr_fim, dt_ini, dt_fim, DATE_FORMAT(dt_hr_atualizacao, '%d/%m/%Y %H:%i:%s ') as dt_hr_atualizacao
                    FROM reservas 
                    inner join espaços 
                    on fk_espacos = pk_espacos
                    inner join eventos
                    on fk_eventos = pk_eventos
                    AND pk_reservas = " . $_REQUEST['pk_reservas'] . "";

    $dados = mysqli_query($conexao, $query_info) or die("Error in query_reservas: $query_info." . mysqli_error($conexao));

    $linha = mysqli_fetch_assoc($dados);

    if (($linha['dt_fim']) == 'NULL') {
        $dateobjectfim = ($linha['dt_ini'] . ' ' . $linha['hr_fim'] . ':00 ');
    } else {
        $dateobjectfim = ($linha['dt_fim'] . ' ' . $linha['hr_ini'] . ':00 ');
    }

    $dateobjectini = ($linha['dt_ini'] . ' ' . $linha['hr_ini'] . ':00 ');

    $buscaEspacos = "SELECT * FROM eventos 
                    INNER JOIN reservas on pk_eventos = fk_eventos
                    INNER JOIN espaços on pk_espacos = fk_espacos
                    WHERE reservas.status = 'Confirmado' AND
                    (((('" . $dateobjectini . "') BETWEEN concat(dt_ini,' ',hr_ini,':00') AND concat(IF(dt_fim = 'NULL',dt_ini,dt_fim),' ',SEC_TO_TIME(MOD(TIME_TO_SEC(hr_fim) + TIME_TO_SEC(intervalo_horarios), 86400)))
                    OR ('" . $dateobjectfim . "') BETWEEN concat(dt_ini,' ',hr_ini,':00') AND concat(IF(dt_fim = 'NULL',dt_ini,dt_fim),' ',SEC_TO_TIME(MOD(TIME_TO_SEC(hr_fim) + TIME_TO_SEC(intervalo_horarios), 86400)))
                    OR concat(dt_ini,' ',hr_ini,':00') BETWEEN ('" . $dateobjectini . "') AND ('" . $dateobjectfim . "') 
                    OR concat(IF(dt_fim = 'NULL',dt_ini,dt_fim),' ',SEC_TO_TIME(MOD(TIME_TO_SEC(hr_fim) + TIME_TO_SEC(intervalo_horarios), 86400))) BETWEEN ('" . $dateobjectini . "') AND ('" . $dateobjectfim . "'))) AND '" . $_REQUEST['pk_reservas'] .  "' != pk_reservas AND '" . $linha['pk_espacos'] . "' = fk_espacos)";
    
                    $dadosEspacos = mysqli_query($conexao, $buscaEspacos) or die("Error in query: $buscaEspacos." . mysqli_error($conexao));

    $dadosExistentes = mysqli_fetch_assoc($dadosEspacos);

    if (isset($dadosExistentes)) {
        echo "<script> 
            swal({
                title: 'Erro!',
                text: 'Essa reserva não pode ser confirmada. A reserva de número " . $dadosExistentes['pk_reservas'] . "  foi aprovada para o mesmo dia, horário e espaço.',
                type: 'error',
                time: 4000
            }, 
            function(){
                window.location.href = 'aprovarReservas.php';
            })
        </script>";
        exit();
    } else {
        $update_status_reserva = ("
        UPDATE reservas 
        SET 
        status = '" . $status . "',
        motivo = NULL,
        dt_hr_atualizacao =	NOW()
        where pk_reservas = '" . $_REQUEST["pk_reservas"] . "'
    ");

        //echo  $update_status_reserva;

        $errors[] = mysqli_query($conexao, $update_status_reserva) or die("Error in update_status_reserva:$update_status_reserva " . mysqli_error($conexao));
    }
} else {
    $update_status_reserva = ("
        UPDATE reservas 
        SET 
        status = '" . $status . "',
        motivo = NULL,
        dt_hr_atualizacao =	NOW()
        where pk_reservas = '" . $_REQUEST["pk_reservas"] . "'
    ");

    //echo  $update_status_reserva;

    $errors[] = mysqli_query($conexao, $update_status_reserva) or die("Error in update_status_reserva:$update_status_reserva " . mysqli_error($conexao));
}

if (in_array(FALSE, $errors)) {
    //$conexao->rollback();
    echo "<script> 
            swal({
                title: 'Erro!',
                text: 'Não foi possível cadastrar esse registro!',
                type: 'error',
                timer: 2000
            }, 
            function(){
                window.location.href = 'index.php';
            })
        </script>";
} else {
    $conexao->commit();

    try {
        $mail = new PHPMailer();
        $mail = parametrizaçãoEmail($mail, $conexao);
        //email cadastrado como parametro  
        // $mail->addAddress(trataEmail(buscaNameUserReserva($conexao, $id_reserva)));
        $emailOperador = buscaEmailOperadorReserva($conexao, $id_reserva);
        $emailResponsavel = buscaEmailResponsavelReserva($conexao, $id_reserva);

        if ($emailOperador != $emailResponsavel) {
            $mail->addAddress($emailOperador);
            $mail->addAddress($emailResponsavel);
        } else {
            $mail->addAddress($emailOperador);
        }

        $mail = retornoReservaEmailStatus($conexao, $mail, $_SESSION['sessaoauth']['name'], $id_reserva, $status);
        $mail->send();
        $mail->ClearAddresses();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    echo "<script> 
                swal({
                    title: 'Alterado!',
                    text: 'Estado da reserva alterada com sucesso!',
                    type: 'success',
                    timer: 2000
                }, 
                function(){
                    window.history.back();
                })
            </script>";
}
