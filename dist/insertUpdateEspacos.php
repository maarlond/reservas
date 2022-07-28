<?php
include "conexaoDB.php";
include "sweetalert.html";
session_start();

//Valida o REQUEST
$array = array();
//print_r($_REQUEST);exit();
foreach ($_REQUEST as $key => $value) {
  $array[$key] = $value;
  if (empty($array[$key]) && $array[$key] != 0) {
    $array[$key] = "NULL";
  } else {
    $array[$key] = $value;
    if ($array[$key] == "on") {
      $array[$key] = true;
    }
  }
}

$conexao->begin_transaction();
if ((isset($array["pk_espacos"]) && is_null($array["pk_espacos"]) || $array["pk_espacos"] == "NULL" || $array["pk_espacos"] == "")) {

  $insertEspacos = "INSERT INTO espaços
                (nome,
                localizacao,
                capacidade,
                aprovacao,
                lista_espera,
                foto,
                termo_compromisso,
                status,
                horario_abertura,
                horario_fechamento,
                intervalo_horarios,
                cor,
                email,
                grupo_gestor,
                grupo_salas,
                satisfacao_status,
                calendario_status
                ) 
            VALUES  
                ('" . $array['inputNomeEspacos'] . "',
                '" . $array['inputLocalizacao'] . "',
                '" . $array['inputCapacidade'] . "',
                " . $array['inputAprovacao'] . ",
                " . $array['inputListaEspera'] . ",
                '" . $array['inputFoto'] . "',
                '" . $array['inputTermo'] . "',
                '" . $array['inputStatus'] . "',
                '" . $array['inputHoraAbertura'] . "',
                '" . $array['inputHoraFechamento'] . "',
                '" . $array['inputIntervalo'] . "', 
                '" . $array['inputColor'] . "',
                '" . $array['inputEmail'] . "',
                1,
                '" . $_SESSION['sistemaGrupoSalas']  . "',
                '" . $array['inputStatusSatisfacao'] . "',
                '" . $array['inputStatusCalendario'] . "'
                )";

  // Executa a query e retirar o or die
  $errors[] = mysqli_query($conexao, $insertEspacos) or die("Error in INSERT Espaços: " . $conexao->error);
  $id_espaços = mysqli_insert_id($conexao);
} else {
  $update_espaços = ("
        UPDATE espaços 
        SET  
          nome = '" . $array['inputNomeEspacos'] . "',
          localizacao =  '" . $array['inputLocalizacao'] . "',
          capacidade = " . $array['inputCapacidade'] . ",
          aprovacao =  " . $array['inputAprovacao'] . ",
          lista_espera = " . $array['inputListaEspera'] . ",
          foto = '" . $array['inputFoto'] . "',
          termo_compromisso =  '" . $array['inputTermo'] . "',
          status = " . $array['inputStatus'] . ",
          cor = '" . $array['inputColor'] . "',
          horario_abertura = '" . $array['inputHoraAbertura'] . "',
          horario_fechamento = '" . $array['inputHoraFechamento'] . "',
          intervalo_horarios = '" . $array['inputIntervalo'] . "',
          email = '" . $array['inputEmail'] . "',
          grupo_gestor =  1,
          grupo_salas = '" . $_SESSION['sistemaGrupoSalas']  . "',
          satisfacao_status = '" . $array['inputStatusSatisfacao'] . "',
          calendario_status = '" . $array['inputStatusCalendario'] . "'
          where pk_espacos = " . $array["pk_espacos"] . "
    ");
  $errors[] = mysqli_query($conexao, $update_espaços) or die("Error in update_espaços:$update_espaços " . mysqli_error($conexao));
}
$id_espacos = isset($id_espaços) ? $id_espaços : $array["pk_espacos"];

if ($array['inputStatusSatisfacao'] == 1) {
  $buscaParametrosSatisfacao = "SELECT * FROM satisfacao_parametros WHERE fk_espacos = $id_espacos ";
  $resultParametrosSatisfacao = mysqli_query($conexao, $buscaParametrosSatisfacao) or die("Error in buscaParametrosSatisfacao:$buscaParametrosSatisfacao " . mysqli_error($conexao));

  if (empty(mysqli_num_rows($resultParametrosSatisfacao))) {

    $buscaEnunciados = "SELECT * FROM enunciado";
    $resultEnunciados = mysqli_query($conexao, $buscaEnunciados) or die("Error in buscaEnunciados:$buscaEnunciados " . mysqli_error($conexao));
    while ($row = mysqli_fetch_assoc($resultEnunciados)) {
      $insertParametrosSatisfacao = "INSERT INTO satisfacao_parametros (fk_espacos, fk_enunciado, status_enunciado) VALUES ('" . $id_espacos . "', '" . $row['pk_enunciado'] . "', '" . $array['inputStatusSatisfacao'] . "')";
      $errors[] = mysqli_query($conexao, $insertParametrosSatisfacao) or die("Error in insertParametrosSatisfacao:$insertParametrosSatisfacao " . mysqli_error($conexao));
    }
  }
}

include "tratarUpload.php";

if (in_array(FALSE, $errors)) {
  $conexao->rollback();
  echo "<script> 
              swal({
                  title: 'Erro!',
                  text: 'Não foi possível cadastrar esse registro!',
                  type: 'error',
                  timer: 2000
              }, 
              function(){
                window.location.href = 'listarEspacos.php';
              })
          </script>";
} else {
  $conexao->commit();
  echo "<script> 
              swal({
                  title: 'Alterado!',
                  text: 'Registro alterado com sucesso!',
                  type: 'success',
                  timer: 2000
              }, 
              function(){
                  window.location.href = 'listarEspacos.php';
              })
          </script>";
}
