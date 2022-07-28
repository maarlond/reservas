<?php
//ini_set('display_errors',1);
//ini_set('display_startup_erros',1);
//error_reporting(E_ALL);
use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;

session_start();
include "conexaoDB.php";
include "sweetalert.html";
include "chamadasAlertas.php";
require "../vendor/autoload.php";
include "funcoesAcessosPermissoes.php";

$idEspaco = $_REQUEST['inputEspacos'];
$horaFim = $_REQUEST['inputHoraFim'];

//Tratamento do intervalo das salas
if (isset($horaFim)) {
  $buscarEspacamento = "SELECT intervalo_horarios FROM espaços WHERE pk_espacos = $idEspaco ";
  $dadosEspacamento = mysqli_query($conexao, $buscarEspacamento);
  $registro_espacamento = mysqli_fetch_assoc($dadosEspacamento);

  $explodeH = explode(":", $registro_espacamento['intervalo_horarios']);
  $horasminutos = date("H:i", strtotime("+" . $explodeH[1] . " minute", strtotime($horaFim)));
  $horaFimEspacamento = date("H:i", strtotime("+" . $explodeH[0] . " hour", strtotime($horasminutos)));
}

$secretaria = explode("-", verificaUsuarioSessaoLogado());
//Valida o REQUEST
$array = array();
$array['submitPublicoCheck'] = 0;
foreach ($_REQUEST as $key => $value) {
  $array[$key] = $value;
  if (empty($array[$key])) {
    $array[$key] = "NULL";
  } else {
    $array[$key] = $value;
    if ($array[$key] == "on") {
      $array[$key] = true;
    }
  }
}
$datasConflitantes = 0;
$id_reserva = 0;
if (!isset($_REQUEST['pk_reservas_this']) && $datasConflitantes <= 0) {
  $insertEvento = "INSERT INTO eventos
              (titulo,
              descricao,
              hr_ini,
              hr_fim,
              hr_fim_espacamento,
              dt_ini,
              dt_fim,
              select_webex,
              div_publico
              )
          VALUES
              ('" . $array['inputObjetivo'] . "',
              '',
              '" . $array['inputHora'] . "',
              '" . $array['inputHoraFim'] . "',
              '" . $horaFimEspacamento . "',
              '" . $array['inputData'] . "',
              '" . $array['inputDataFim'] . "',
              '" . $array['inputWebex'] . "',
              " . $array['submitPublicoCheck'] . "
              )";


  // Executa a query e retirar o or die
  $errors[] = mysqli_query($conexao, $insertEvento) or die("Error in INSERT Eventos: " . $conexao->error);
  $id_evento = mysqli_insert_id($conexao);
  $insertReserva = ("
          INSERT INTO reservas
              (status,
              dt_hr_atualizacao,
              contato,
              secretaria,
              ramal,
              fk_espacos,
              fk_eventos,
              email,
              fk_glpi_users,
              fk_soe_users
              )
          VALUES
              ('Novo',
                NOW(),
                '" . $array['inputContato'] . "',
                '" . $secretaria[0] . "',
                '" . $array['inputTelefoneRamal'] . "',
                '" . $array['inputEspacos'] . "',
                $id_evento,
                '" . $array['inputEmail'] . "',
                " . validaUsersGLPI() . ",
                " . validaUsersSOE() . " )");
  // Executa a query e retirar o or die
  $errors[] = mysqli_query($conexao, $insertReserva) or die("Error in INSERT Reservas: " . $conexao->error);
  $id_reserva = mysqli_insert_id($conexao);
} else if (isset($_REQUEST['pk_reservas_this']) &&  $datasConflitantes <= 0) {

  $update_eventos = ("
        UPDATE eventos
        SET
        titulo =	'" . $array['inputObjetivo'] . "',
        descricao =	'',
        hr_ini =	'" . $array['inputHora'] . "',
        hr_fim =	'" . $array['inputHoraFim'] . "',
        hr_fim_espacamento =	'" . $horaFimEspacamento . "',
        dt_ini =	'" . $array['inputData'] . "',
        dt_fim =	'" . $array['inputDataFim'] . "',
        select_webex =	'" . $array['inputWebex'] . "',
        div_publico =	" . $array['submitPublicoCheck'] . "
        where pk_eventos = " . $_REQUEST['fk_eventos'] . "
    ");

  $errors[] = mysqli_query($conexao, $update_eventos) or die("Error in update_eventos:$update_eventos " . mysqli_error($conexao));

  $update_reserva = ("
        UPDATE reservas
        SET
			status = 		'Editado',
			dt_hr_atualizacao =	NOW(),
			contato =		'" . $array['inputContato'] . "',
			secretaria =	 '" . $secretaria[0] . "',
			ramal =			'" . $array['inputTelefoneRamal'] . "',
			fk_espacos =	" . $array['inputEspacos'] . "
          where pk_reservas = '" . $_REQUEST["pk_reservas_this"] . "'
    ");

  $errors[] = mysqli_query($conexao, $update_reserva) or die("Error in update_reserva:$update_reserva " . mysqli_error($conexao));
}
if ($_FILES['fotosReserva']['size'][0] > 0) {
  if (isset($_REQUEST['pk_reservas_this'])) {
    $id_reservas = $array["pk_reservas_this"];
  } else {
    $id_reservas = isset($id_reserva) ? $id_reserva : $array["pk_reservas"];
  }

  include "tratarUpload.php";
}

if ($datasConflitantes > 0) {
  $conexao->rollback();
  echo "<script>
              swal({
                  title: 'Erro!',
                  text: 'As datas escolhidas tem conflito com alguma reserva já existente nesse espaço!',
                  type: 'error',
                  timer: 2000,
                  showCancelButton: false,
                  showConfirmButton: false
              },
              function(){
                window.location.href = history.go(-1);
              })
          </script>";
} else if (in_array(FALSE, $errors)) {
  $conexao->rollback();
  echo "<script>
              swal({
                  title: 'Erro!',
                  text: 'Não foi possível cadastrar esse registro!',
                  type: 'error',
                  timer: 2000
              },
              function(){
                window.location.href = 'minhasReservas.php';
              })
          </script>";
} else {
  $conexao->commit();
  try {
    $id_reserva = isset($_REQUEST['pk_reservas_this']) ? $_REQUEST['pk_reservas_this'] : $id_reserva;
    $mail = new PHPMailer();
    $mail = parametrizaçãoEmail($mail, $conexao);
    $mail->addAddress(buscaEmailModeradorReserva($conexao, $id_reserva));
    $mail = preReservaCadastradaEmail($conexao, $mail, exibeEmailSoeAuth($conexao), $id_reserva);
    $mail->send();
    $mail->ClearAddresses();
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }

  echo "<script>
                  swal({
                      title:'Reserva à confirmar!',
                      text: 'Sua reserva foi cadastrada, agora cabe ao moderador confirmar!',
                      type: 'success'

                  },
                  function(){
                      window.location.href = 'minhasReservas.php';
                  })
            </script>";
}
