<?php

if(!isset($_SESSION)){
    session_start();
}

function buscaNotificacao1($conexao){

    $parametroChave = parametrosSistemas();
    $notiReservas = "SELECT valor FROM parametros WHERE parametro = '".$parametroChave[0]."'";
    $dadosNotificacao = mysqli_query($conexao, $notiReservas) or die("Error in query: $notiReservas." . mysqli_error($conexao));
    $registro_reserva = mysqli_fetch_assoc($dadosNotificacao);
    return $registro_reserva['valor'];
}


function buscaNotificacao2($conexao){

    $parametroChave = parametrosSistemas();
    $notiReservas = "SELECT valor FROM parametros WHERE parametro = '".$parametroChave[1]."'";
    $dadosNotificacao = mysqli_query($conexao, $notiReservas) or die("Error in query: $notiReservas." . mysqli_error($conexao));
    $registro_reserva = mysqli_fetch_assoc($dadosNotificacao);
    return $registro_reserva['valor'];
}

function parametrosSistemas(){
    $parametroChave = array();
    switch($_SESSION['sistemaGrupoSalas']){
        case '1':
            $parametroChave[] = 'msg_notification_01_CAFF_Working';
            $parametroChave[] = 'msg_notification_02_CAFF_Working';
        break;
        case '2':
            $parametroChave[] = 'msg_notification_01_Reservas';
            $parametroChave[] = 'msg_notification_02_Reservas';
        break;
    }
    return $parametroChave;
}

function atualizaParametroNotificacao($conexao, $texto,$posicao)
{
    $parametro = parametrosSistemas();
    $query = "UPDATE parametros SET valor = '$texto' where parametro = '".$parametro[$posicao]."'";
    $status[] = mysqli_query($conexao, $query) or die("Error in : " . $conexao->error);
    return $status;
}
