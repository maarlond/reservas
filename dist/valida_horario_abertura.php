<?php
session_start();
include "conexaoDB.php";

$idEspaco = $_POST['idEspaco'];
$horaInicial = $_POST['horaInicial'];

if (isset($idEspaco) && isset($horaInicial)) {
    
    $buscarHorario = "SELECT horario_abertura FROM espaços WHERE pk_espacos = $idEspaco";
    $dadosHorario = mysqli_query($conexao, $buscarHorario);
    $registro_horario = mysqli_fetch_assoc($dadosHorario);
    
    $horario_abertura = $registro_horario['horario_abertura'];

    echo $horario_abertura;
} 

