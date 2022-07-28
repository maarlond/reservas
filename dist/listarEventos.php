<?php
session_start();
include "conexaoDB.php";

if (!isset($_REQUEST['grupoSalas'])) {
	$grupoSalas = $_SESSION['sistemaGrupoSalas'];
} else {
	$grupoSalas = $_REQUEST['grupoSalas'];
}

$where = $_REQUEST['espaco'] == "0" ? "" : "and pk_espacos = " . $_REQUEST['espaco'];
$validaPortalCaff = empty($_REQUEST['portalCaff']) ? "" : " and calendario_status = 1";

$sql = "SELECT pk_eventos as id, IF (div_publico = 0, concat(hr_ini, ' | ', hr_fim, ' - ','Reservado'),
		concat(hr_ini,'|', hr_fim,' - ',  titulo)) as title, dt_ini as start, date_add(dt_fim, interval 1 day) as end, cor as color
		FROM eventos
		left JOIN reservas
		ON pk_eventos = fk_eventos
		left JOIN espaços
		ON  pk_espacos = fk_espacos
		where reservas.status = 'Confirmado' AND grupo_salas = " . $grupoSalas . " " . $where . $validaPortalCaff;
$dados = mysqli_query($conexao, $sql) or die("Error in $sql: $sql." . mysqli_error($conexao));

$array = [];

foreach ($dados as $key => $value) {
	$array[$key] = $value;
}
echo json_encode($array);
