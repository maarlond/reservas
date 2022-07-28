<?php
//session_start();
include "conexaoDB.php";
include "sweetalert.html";

$array = array();

foreach ($_REQUEST as $key => $value) {
    $array[$key] = $value;
}

$i = 1;
if (is_array($array)) {
    foreach ($array as $key => $dados) {
        $enunciado = $array['enunciado' . $i];
        $alternativa = $array['resposta' . $i];
        $pk_satisfacao = $array['pk_satisfacao'];

        if (!empty($enunciado) && !empty($alternativa)) {
            $resposta_satisfacao = "INSERT INTO resposta(fK_alternativa, fk_enunciado, fk_satisfacao) VALUES ($alternativa, $enunciado, $pk_satisfacao)";
            // $resultado_resposta[] = mysqli_query($conexao, $resposta_satisfacao);
            $errors[] = mysqli_query($conexao, $resposta_satisfacao) or die("Error in INSERT resposta_satisfacao: " . $conexao->error);
            $i++;
        }
    }
}

if (in_array(FALSE, $errors)) {
    $conexao->rollback();
    echo "<script> 
                swal({
                    title: 'Erro!',
                    text: 'Não foi possível salvar esse registro!',
                    type: 'error',
                    timer: 2000
                }, 
                function(){
                  window.location.href = 'reservar.php';
                })
            </script>";
} else {
    $conexao->commit();

    echo "<script> 
                swal({
                    title: 'Salvo!',
                    text: 'Respostas salvas sucesso!',
                    type: 'success',
                    timer: 2000
                }, 
                function(){
                    window.location.href = 'reservar.php';
                })
            </script>";
}
