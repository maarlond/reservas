<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

function buscaEmailModeradorReserva($conexao, $id_reserva)
{
    $query = "SELECT esp.email FROM espaços as esp INNER JOIN reservas  on esp.pk_espacos = fk_espacos where pk_reservas = " . $id_reserva;
    $dados = mysqli_query($conexao, $query);
    $row = mysqli_fetch_row($dados);
    return $row[0];
}

function buscaNameUserReserva($conexao, $id_reserva)
{
    $query = "SELECT name FROM reservas.reservas INNER JOIN sis.glpi_users on id = fk_glpi_users where pk_reservas = " . $id_reserva;
    $dados = mysqli_query($conexao, $query);
    $row = mysqli_fetch_row($dados);
    return $row[0];
}

function buscaParametros($conexao)
{
    $query = "SELECT valor FROM parametros where parametro = 'email_auth' ";
    $dados = mysqli_query($conexao, $query);
    $row = mysqli_fetch_row($dados);
    return $row[0];
}
function buscaParametrosPass($conexao)
{
    $query = "SELECT valor FROM parametros where parametro = 'email_auth_pass' ";
    $dados = mysqli_query($conexao, $query);
    $row = mysqli_fetch_row($dados);
    return base64_decode($row[0]);
}
function atualizaParametroEmail($conexao, $email_auth)
{

    $query = "UPDATE parametros SET valor = '$email_auth' where parametro = 'email_auth' ";
    $status[] = mysqli_query($conexao, $query) or die("Error in : " . $conexao->error);
    return $status;
}

function atualizaParametroEmailPass($conexao, $email_auth_pass)
{
    $email_auth_pass = base64_encode($email_auth_pass);
    $query = "UPDATE parametros SET valor = '$email_auth_pass' where parametro = 'email_auth_pass' ";
    $status[] = mysqli_query($conexao, $query) or die("Error in : " . $conexao->error);
    return $status;
}

function parametrizaçãoEmail($mail, $conexao)
{
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
    $mail->isSMTP();

    $mail->Host       = 'smtp.direto.procergs.rs.gov.br';
    $mail->SMTPAuth   = true;
    $mail->Username   = buscaParametros($conexao);
    $mail->Password   = buscaParametrosPass($conexao);
    // $mail->SMTPSecure = 'tls';
    // $mail->Username = 'spgg.dinfo@yahoo.com';
    // $mail->Password = 'ohgrifxfwspkvngo';
    $mail->Port     = 25;
    $mail->setFrom('no-reply@planejamento.rs.gov.br', 'Sistema de Reservas do CAFF');
    $mail->CharSet = 'UTF-8';
    return $mail;
}
function testeEnvioEmail($mail)
{
    //Content
    $mail->isHTML(true);
    $mail->Subject = 'Teste Reservas';
    $mail->Body    = ('O email está em funcionamento, com as credenciais cadastradas');

    return $mail;
}

function preReservaCadastradaEmail($conexao, $mail, $user, $id_reserva)
{
    //Content
    $mail->isHTML(true);
    //$mail->Subject = 'Nova Pre-Reserva para validar';

    $mail->Subject = (parametrizaEmail(tituloEmailPrereserva($conexao), $user, $id_reserva, "Novo"));
    //$mail->Body    = utf8_decode('A pre reserva do usuario '.$user.' identificador '.$id_reserva.' está esperando sua validação');
    $mail->Body = (parametrizaEmail(textoEmailPrereserva($conexao), $user, $id_reserva, "Novo"));

    return $mail;
}

function parametrizaEmail($texto, $user, $id_reserva, $status)
{
    $texto = str_replace("@user", $user, $texto);
    $texto = str_replace("@id_reserva", $id_reserva, $texto);
    $texto = str_replace("@status", $status, $texto);
    return $texto;
}

function tituloEmailPrereserva($conexao)
{

    $query = "SELECT valor FROM parametros where parametro = 'titulo_email_prereserva'";
    $dados = mysqli_query($conexao, $query);
    $row = mysqli_fetch_row($dados);
    return  $row[0];
}

function textoEmailPrereserva($conexao)
{

    $query = "SELECT valor FROM parametros where parametro = 'texto_email_prereserva'";
    $dados = mysqli_query($conexao, $query);
    $row = mysqli_fetch_row($dados);
    return $row[0];
}

function retornoReservaEmailStatus($conexao, $mail, $user, $id_reserva, $status)
{
    //Content
    $mail->isHTML(true);

    $mail->Subject = (parametrizaEmail(tituloEmailRetornoStatusPrereserva($conexao), $user, $id_reserva, $status));
    $mail->Body = (parametrizaEmail(textoEmailRetornoStatusPrereserva($conexao), $user, $id_reserva, $status));

    return $mail;
}


function tituloEmailRetornoStatusPrereserva($conexao)
{

    $query = "SELECT valor FROM parametros where parametro = 'titulo_email_retorno_prereserva'";
    $dados = mysqli_query($conexao, $query);
    $row = mysqli_fetch_row($dados);
    return  $row[0];
}

function textoEmailRetornoStatusPrereserva($conexao)
{

    $query = "SELECT valor FROM parametros where parametro = 'texto_email_retorno_prereserva'";
    $dados = mysqli_query($conexao, $query);
    $row = mysqli_fetch_row($dados);
    return $row[0];
}

// Autualiza texto de envio de email
function atualizaChaveValor($conexao, $chave, $valor)
{

    $query = "UPDATE parametros SET valor = '$valor' where parametro = '$chave' ";
    $status[] = mysqli_query($conexao, $query) or die("Error in : " . $conexao->error);
    return $status;
}


function trataEmail($email)
{

    if (isset($email)) {

        $emailtratado = explode("-", $email);
        $hifen = isset($emailtratado[2]) ? "-" : "";
        $emailtratadostring = $emailtratado[1] . $hifen . $emailtratado[2];
        $emailTratadoArouba = explode("@", $emailtratadostring);

        $emailSanetizado = $emailTratadoArouba[0] . "@" . $emailtratado[0] . "." . $emailTratadoArouba[1] . "rs.gov.br";

        return $emailSanetizado;
    }
    return "Não tratado";
}


// function buscaEmailUser($conexao)
// {
//     $query = "SELECT glpi_useremails.email FROM reservas.user_permissao 
//                 INNER JOIN sis.glpi_users ON user_permissao.fk_glpi_users = glpi_users.id 
//                 INNER JOIN sis.glpi_useremails ON glpi_users.id = glpi_useremails.users_id 
//                 WHERE user_permissao.fk_soe_users = " . $_SESSION['sessaoauth']['soe:matricula'] . " LIMIT 1";

//     $dados = mysqli_query($conexao, $query);
//     $row = mysqli_fetch_row($dados);
//     return  $row[0];
// }

function buscaEmailResponsavelReserva($conexao, $id_reserva)
{
    $query = "SELECT email FROM reservas where pk_reservas = " . $id_reserva;
    $dados = mysqli_query($conexao, $query);
    $row = mysqli_fetch_row($dados);
    return $row[0];
}

function buscaMatriculaOperadorReserva($conexao, $id_reserva)
{
    $query = "SELECT fk_soe_users FROM reservas where pk_reservas = " . $id_reserva;

    $dados = mysqli_query($conexao, $query);
    $row = mysqli_fetch_row($dados);
    $matricula = $row[0];
    return $matricula;
}

function buscaEmailOperadorReserva($conexao, $id_reserva)
{
    $matricula = buscaMatriculaOperadorReserva($conexao, $id_reserva);

    $query = "SELECT email FROM oauth.usuario where matricula = '" . $matricula . "'";
    $dados = mysqli_query($conexao, $query);
    $row = mysqli_fetch_row($dados);
    return $row[0];
}

function exibeConfirmacao($conexao)
{
    $query = "SELECT confirmar_email FROM oauth.usuario where matricula = '" . $_SESSION['sessaoauth']['soe:matricula'] . "'";
    $dados = mysqli_query($conexao, $query);
    $row = mysqli_fetch_row($dados);
    return $row[0];
}

function exibeEmailSoeAuth($conexao)
{
    $query = "SELECT email FROM oauth.usuario where matricula = '" . $_SESSION['sessaoauth']['soe:matricula'] . "'";
    $dados = mysqli_query($conexao, $query);
    $row = mysqli_fetch_row($dados);
    return $row[0];
}

function sugereEmail($conexao)
{
    $query = "SELECT CONCAT(SUBSTRING_INDEX(usu.nome, ' ', 1),'-', SUBSTRING_INDEX(usu.nome, ' ', -1),'@', org.nome,'.rs.gov.br') as email
                FROM oauth.usuario as usu
                INNER JOIN oauth.organizacao as org ON usu.fk_organizacao = org.cod_organizacao_soe
                WHERE usu.matricula = '" . $_SESSION['sessaoauth']['soe:matricula'] . "'";
    $dados = mysqli_query($conexao, $query);
    $row = mysqli_fetch_row($dados);
    return $row[0];
}
