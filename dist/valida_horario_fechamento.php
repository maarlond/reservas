<?php
session_start();
include "conexaoDB.php";

$idEspaco = $_POST['idEspaco'];
$horaFinal = $_POST['horaFinal'];

if (isset($idEspaco) && isset($horaFinal)) {
    
    $buscarHorario = "SELECT horario_fechamento FROM espaços WHERE pk_espacos = $idEspaco";
    $dadosHorario = mysqli_query($conexao, $buscarHorario);
    $registro_horario = mysqli_fetch_assoc($dadosHorario);
    
    $horario_fechamento = $registro_horario['horario_fechamento'];

    echo $horario_fechamento;
} 

