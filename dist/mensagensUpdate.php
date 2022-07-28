<?php
session_start();

include "sweetalert.html";
include "conexaoDB.php";
include "funcoesNotificacoes.php";

    //print_r($_REQUEST);exit;

    if(isset($_REQUEST['AtualizarNotificacoes'])){

        $retorno = atualizaParametroNotificacao($conexao,$_REQUEST['inputTextoNotificacao1'],0);
        $retorno = atualizaParametroNotificacao($conexao,$_REQUEST['inputTextoNotificacao2'],1);

        echo "<script>
            swal({
                title: 'Notificações Alteradas',
                text: 'Ajustes feito!',
                type: 'success',
                timer: 2000
            },
            function(){
                window.location.href = 'mensagensAlertas.php';
            })
            </script>";

    }
    else{

        echo "<script>
            swal({
                title: 'Erro',
                text: 'Notificação não Alterada!',
                type: 'error',
                timer: 2000
            },
            function(){
                window.location.href = 'mensagensAlertas.php';
            })
            </script>";

    }
?>