<?php
include "conexaoDB.php";
include "chamadasAlertas.php";
require "../vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;

date_default_timezone_set('America/Sao_Paulo');
$date = date('Y-m-d');

// $horaInicial = date('H:i', strtotime('-12 hours'));

$horaInicial = date('H:i', strtotime('-12 hours'));

$horaAtual = date('H:i');


// Consulta reservas encerradas no horário informado com status confirmado no banco de dados
$buscaDadosEspacos = "SELECT *, res.email FROM eventos
                INNER JOIN reservas as res on pk_eventos = fk_eventos 
                INNER JOIN espaços as esp ON pk_espacos = fk_espacos
                WHERE res.status = 'Confirmado' 
                AND esp.satisfacao_status = 1 
                AND (((('$date') = IF(dt_fim = 'NULL', dt_ini, dt_fim)) AND hr_fim BETWEEN '" . $horaInicial . "' AND  '" . $horaAtual . "'))";
$dadosEspacos = mysqli_query($conexao, $buscaDadosEspacos) or die("Error in query: $buscaDadosEspacos." . mysqli_error($conexao));
// Enquanto existir dados na consulta anterior, os dados serão salvos em 2 arrays, hash para salvar no banco e utilizar via get no link de satisfação
while ($linha = mysqli_fetch_assoc($dadosEspacos)) {
  $dados[] =  $linha;
  $hash[] = md5($linha['pk_reservas']);
}

// Caso existir dados no array
if (is_array($dados)) {
  foreach ($dados as $key => $valor) {

    // Consulta para validar se o hash já existe
    $buscaDadosSatisfacao = "SELECT * FROM `satisfacao` WHERE hash = '$hash[$key]'";
    $resultSatisfacao = mysqli_query($conexao, $buscaDadosSatisfacao) or die("Error in query: $buscaDadosSatisfacao." . mysqli_error($conexao));
    $dadosSatisfacao = mysqli_fetch_assoc($resultSatisfacao);

    // Se o hash não existe no banco, insere ele
    if (empty($dadosSatisfacao)) {

      $insereDadosSatisfacao = "INSERT INTO `satisfacao` (`fk_reservas`, `hash`) VALUES ('" . $dados[$key]["pk_reservas"] . "', '" . $hash[$key] . "')";
      $errors[] = mysqli_query($conexao, $insereDadosSatisfacao) or die("Error in INSERT Satisfacao: " . $conexao->error);

      try {
        $id_reserva = $dados[$key]['pk_reservas'];
        $tituloReserva = $dados[$key]['titulo'];
        $nomeEspaco = $dados[$key]['nome'];
        $emailResponsavel = $dados[$key]['email'];

        $link = 'https://sistemas.planejamento.rs.gov.br/reservas/dist/satisfacao.php?valor=' . $hash[$key];
        $mail = new PHPMailer();
        $mail = parametrizaçãoEmail($mail, $conexao);
        $mail->addAddress($emailResponsavel);
        $mail->isHTML(true);

        // $mail = testeEnvioEmail($mail);
        $mail->Subject = 'Pesquisa de satisfação!';

        $mail->Body = 'Prezado (a) Usuário (a) <br> Convidamo-os a participar da pesquisa de satisfação da sua experiência com o espaço ' . $nomeEspaco . ' referente á 
      reserva de número: ' . $id_reserva . " e nome: " . $tituloReserva . '<br> Segue abaixo o link para realização da pesquisa:<br> Link: ' . $link;
        $mail->send();
        $mail->ClearAddresses();
      } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
    }
  }
}
