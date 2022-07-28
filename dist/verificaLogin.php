<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Verifica se sessão está ativa para utilizar nos sitema
if(empty($_SESSION['sessaoauth']) || !isset($_SESSION['sessaoauth'])){
    //destruir sessão
    unset($_SESSION);
    session_destroy();
    //redirecioanmento pra pagina de não autorizado
    header("Location: http://".$_SERVER['HTTP_HOST']."/reservas/restrito.php");
}
else {
    //include()

}
