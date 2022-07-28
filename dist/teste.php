<?php
    include "conexaoDB.php";
    if(!empty($_REQUEST)){
        $query = "SELECT * FROM eventos inner join reservas on pk_eventos = fk_eventos WHERE dt_ini = '".$_REQUEST['data_inicio']."' AND dt_fim <= ".$_REQUEST['data_fim'];
        $dados = mysqli_query($conexao, $query) or die("Error in query: $query." . mysqli_error($conexao));
        echo $query;
        $arraFKEspacos = array();
        while ($linha = mysqli_fetch_assoc($dados)) {
            echo  $linha['fk_espacos'];
            $arraFKEspacos[] = $linha['fk_espacos']; 
        }
        $query_espacos = "SELECT * FROM espaços WHERE pk_espacos NOT IN (" . implode(',', $arraFKEspacos) . ")";
        $dados_espacos = mysqli_query($conexao, $query_espacos) or die("Error in query: $query_espacos." . mysqli_error($conexao));
        echo  $query_espacos;
    }
?>
<html>
    <form action="teste.php">
        <input type="date" name="data_inicio">
        <input type="date" name="data_fim">
        <select name="espacosLivres">
            <?php while ($linha = mysqli_fetch_assoc($dados_espacos)) { ?>
                    <option value="<?=$linha['pk_espacos']?>"><?=$linha['nome']?></option>
            <?php } ?>  
        </select>
        <input type="submit">
    </form>
<html>