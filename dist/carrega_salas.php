<?php
session_start();
include "conexaoDB.php";
$espaco = 0;
$query_espacos_disp = "";

$dataInicial = $_POST['dataInicial'];
$dataFinal   = $_POST['dataFinal'];
$horaInicial = $_POST['horaInicial'];
$horaFinal = $_POST['horaFinal'];
$requestEspacos = $_POST['requestEspacos'];

$query_espacos = "SELECT pk_espacos, nome, cor FROM espaços WHERE status = 1  AND  grupo_salas = " . $_SESSION['sistemaGrupoSalas']  . " ORDER BY nome asc";

$dados = mysqli_query($conexao, $query_espacos) or die("Error in query_espacos: $query_espacos." . mysqli_error($conexao));

if (!empty($requestEspacos)) {
    $query_reserva = "SELECT * FROM reservas INNER JOIN eventos on pk_eventos = fk_eventos WHERE pk_reservas = " . $requestEspacos;
    $dados_reserva = mysqli_query($conexao, $query_reserva) or die("Error in query_reserva: $query_reserva." . mysqli_error($conexao));
    $registro_reserva = mysqli_fetch_assoc($dados_reserva);
}

if (!empty($dataInicial) and !empty($horaInicial) and !empty($horaFinal) or !empty($requestEspacos)) {

    if (empty($dataFinal)) { // Consulta ao banco caso não tiver a data fim
        $dateobjectfim = ($dataInicial . ' ' . $horaFinal . ':00 ');
    } else {
        $dateobjectfim = ($dataFinal . ' ' . $horaFinal . ':00 ');
    }

    $dateobjectini = ($dataInicial . ' ' . $horaInicial . ':00 ');
    $idEspaco = !empty($requestEspacos) ? ' AND ' .  $requestEspacos . ' != pk_reservas ' : '';

    $buscaEspacos = "SELECT *, SEC_TO_TIME(MOD(TIME_TO_SEC(hr_fim) + TIME_TO_SEC(intervalo_horarios), 86400)) as horaFimIntervalo FROM eventos 
        INNER JOIN reservas on pk_eventos = fk_eventos
        INNER JOIN espaços on pk_espacos = fk_espacos
        WHERE reservas.status = 'Confirmado' AND
        (((('" . $dateobjectini . "') BETWEEN concat(dt_ini,' ',hr_ini,':00') AND concat(IF(dt_fim = 'NULL',dt_ini,dt_fim),' ',SEC_TO_TIME(MOD(TIME_TO_SEC(hr_fim) + TIME_TO_SEC(intervalo_horarios), 86400)))
        OR ('" . $dateobjectfim . "') BETWEEN concat(dt_ini,' ',hr_ini,':00') AND concat(IF(dt_fim = 'NULL',dt_ini,dt_fim),' ',SEC_TO_TIME(MOD(TIME_TO_SEC(hr_fim) + TIME_TO_SEC(intervalo_horarios), 86400)))) 
        OR concat(dt_ini,' ',hr_ini,':00') BETWEEN ('" . $dateobjectini . "') AND ('" . $dateobjectfim . "') 
        OR concat(IF(dt_fim = 'NULL',dt_ini,dt_fim),' ',SEC_TO_TIME(MOD(TIME_TO_SEC(hr_fim) + TIME_TO_SEC(intervalo_horarios), 86400))) BETWEEN ('" . $dateobjectini . "') AND ('" . $dateobjectfim . "')))" . $idEspaco; //. $idEspaco;
    $dados = mysqli_query($conexao, $buscaEspacos) or die("Error in query: $buscaEspacos." . mysqli_error($conexao));

    //Arrays para guardar os dados da consulta
    $arraFKEspacos = array();
    $arraFKReservas = array();

    //Enquanto existir dados, guarda o id do espaço e da reserva em um array
    while ($linha = mysqli_fetch_assoc($dados)) {
        $arraFKEspacos[] = $linha['fk_espacos'];
        $arraFKReservas[] = $linha['pk_reservas'];
    }

    if (!empty($arraFKEspacos)) {

        $implode = implode(",", $arraFKEspacos);
        // Se o array for diferente de vazio, seleciona os dados que não possuem o mesmo pk_espacos
        $query_espacos_disp = "SELECT * FROM espaços WHERE status = 1 AND grupo_salas = " . $_SESSION['sistemaGrupoSalas']  . " AND pk_espacos NOT IN ( $implode  )";
    } else {

        $query_espacos_disp = "SELECT * FROM espaços WHERE status = 1 AND grupo_salas = " . $_SESSION['sistemaGrupoSalas']  . "";
    }

    $dados = mysqli_query($conexao, $query_espacos_disp);

    if (empty($requestEspacos)) {
        if (mysqli_num_rows($dados) > 0) {
            while ($linha = mysqli_fetch_assoc($dados)) {
                echo '<option value="" selected disabled hidden>Favor, escolha a sala</option>';
                echo '<option value="' . $linha['pk_espacos'] . '">' . $linha['nome'] . '</option>';
            }
        } else {
            echo '<option value="" selected disabled hidden>Nenhuma sala disponível :(</option>';
        }
    } else {
        while ($linha = mysqli_fetch_assoc($dados)) {
            $selected = $registro_reserva["fk_espacos"] == $linha["pk_espacos"] ? "selected" : "";
            echo '<option ' . $selected . ' value="' . $linha['pk_espacos'] . '">' . $linha['nome'] . '</option>';
        }
    }
}
