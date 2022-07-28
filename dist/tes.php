<div id='script-warning'>
  <code>../php/get-events.php</code> must be running.
</div>
<?php
                        $dados = mysqli_query($conexao, $query_espacos);                     
                        while ($linha = mysqli_fetch_assoc($dados)) {
                            
                            echo "<span class='bola' style='background-color:".$linha["cor"]."'></span>";
                            echo $linha['nome'];
                        }
                    ?> 
<div id='loading'>loading...</div>
<div id='calendar'></div>
