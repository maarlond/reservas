<?php
include "conexaoDB.php";
include "sweetalert.html";
session_start();

$idenunciado = $_REQUEST['pk_enunciado'];
$espaço = $_REQUEST['pk_espacos'];
$status = $_REQUEST['status_enunciado'];
$textoEnunciado = $_REQUEST['inputEnunciado'];
$tituloSatisfacao = $_REQUEST['inputTitulo'];
$textoSatisfacao = $_REQUEST['inputTexto'];

if (isset($status)) {
    $updateStatusEnunciado = "UPDATE satisfacao_parametros SET status_enunciado = $status WHERE fk_espacos = $espaço AND fk_enunciado = $idenunciado";
    $errors[] = mysqli_query($conexao, $updateStatusEnunciado) or die("Error in updateDadosEnunciado:$updateStatusEnunciado " . mysqli_error($conexao));
} else if (isset($textoEnunciado)) {
    // Busca espaços para inserir nos nos parametros com o novo enunciado
    $buscaSalas = "SELECT * FROM espaços";
    $dadosSalas = mysqli_query($conexao, $buscaSalas) or die("Error in query buscaSalas: $buscaSalas." . mysqli_error($conexao));


    /* Start transaction */
    $conexao->begin_transaction();
    try {
        $insertEnunciado = "INSERT INTO enunciado (enunciado) VALUES ('" . $textoEnunciado . "')";
        $errors[] = mysqli_query($conexao, $insertEnunciado) or die("Error in insertEnunciado: $insertEnunciado " . mysqli_error($conexao));

        $id_enunciado = mysqli_insert_id($conexao);

        while ($dados = mysqli_fetch_assoc($dadosSalas)) {

            $insertEnunciadoParametros = "INSERT INTO satisfacao_parametros (fk_espacos, fk_enunciado, status_enunciado) VALUES (" . $dados['pk_espacos'] . " , $id_enunciado, '0');";
            $errors[] = mysqli_query($conexao, $insertEnunciadoParametros) or die("Error in insertEnunciadoParametros: $insertEnunciadoParametros " . mysqli_error($conexao));
        }
        $conexao->commit();
    } catch (mysqli_sql_exception $exception) {
        $conexao->rollback();

        throw $exception;
    }
} else if (isset($tituloSatisfacao) && isset($textoSatisfacao)) {
    $updateSatisfacao = "UPDATE espaços SET texto_satisfacao =  '" . $textoSatisfacao . "', titulo_satisfacao = '" . $tituloSatisfacao . "' WHERE pk_espacos = $espaço";
    $errors[] = mysqli_query($conexao, $updateSatisfacao) or die("Error in updateSatisfacao:$updateSatisfacao " . mysqli_error($conexao));
}

if (in_array(FALSE, $errors)) {
    $conexao->rollback();
    echo "<script> 
                swal({
                    title: 'Erro!',
                    text: 'Não foi possível atualizar esse registro!',
                    type: 'error',
                    timer: 2000
                }, 
                function(){
                  window.location.href = 'espacos.php?pk_espacos=$espaço';
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
                    window.location.href = 'espacos.php?pk_espacos=$espaço';
                })
            </script>";
}
