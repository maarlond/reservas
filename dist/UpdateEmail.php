<?php
session_start();
//ini_set('display_errors',1);
//ini_set('display_startup_erros',1);
//error_reporting(E_ALL);
// definições de host, database, usuário e senha
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require '../vendor/autoload.php';
include "sweetalert.html";
include "conexaoDB.php";
include "chamadasAlertas.php";
    if(isset($_REQUEST['salvar'])){
        atualizaParametroEmail($conexao,$_REQUEST['inputLogin']);
        atualizaParametroEmailPass($conexao,$_REQUEST['inputPass']);
        echo "<script> 
        swal({
            title: 'Alterado!',
            text: 'Email alterado com sucesso!',
            type: 'success',
            timer: 2000
        }, 
        function(){
            window.location.href = 'configurarEmailEnvio.php';
        })
        </script>";
    }
    else if(isset($_REQUEST['testeEnvio'])){
        try {
            //Server settings
            $mail = new PHPMailer();		
			$mail = parametrizaçãoEmail($mail,$conexao);
			$mail->addAddress(exibeEmailSoeAuth($conexao));
			$mail = testeEnvioEmail($mail);
            $mail->send();
            $mail->ClearAddresses();
            echo "<script> 
            swal({
                title: 'Email Enviado!',
                text: 'Enviado para ".(exibeEmailSoeAuth($conexao))."',
                type: 'success',
                timer: 2000
            }, 
            function(){
                window.location.href = 'configurarEmailEnvio.php';
            })
            </script>";

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    else if(isset($_REQUEST['AtualizarEmailPrereserva'])){
        $retorno = atualizaChaveValor($conexao,'titulo_email_prereserva' ,$_REQUEST['inputTituloEmailPrereserva']);
        $retorno = atualizaChaveValor($conexao,'texto_email_prereserva' ,$_REQUEST['inputTextoEmailPrereserva']);

        echo "<script> 
            swal({
                title: 'Email Modelo Pré-reserva',
                text: 'Email Modelo Pré-reserva Alterado!',
                type: 'success',
                timer: 2000
            }, 
            function(){
                window.location.href = 'configurarEmailEnvio.php';
            })
            </script>";

    }
    else if(isset($_REQUEST['AtualizarEmailRetornoPrereserva'])){
        $retorno = atualizaChaveValor($conexao,'titulo_email_retorno_prereserva' ,$_REQUEST['inputTituloEmailRetornoPrereserva']);
        $retorno = atualizaChaveValor($conexao,'texto_email_retorno_prereserva' ,$_REQUEST['inputTextoEmailRetornoPrereserva']);

        echo "<script> 
            swal({
                title: 'Email Modelo Retorno ao Usuario!',
                text: 'Email Modelo Retorno ao Usuario Alterado!',
                type: 'success',
                timer: 2000
            }, 
            function(){
                window.location.href = 'configurarEmailEnvio.php';
            })
            </script>";
        
    }
?>