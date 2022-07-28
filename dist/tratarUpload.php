<?php
include "sweetalert.html";

// Numero de campos de upload
$numeroCampos = 5;
// Tamanho máximo do arquivo (em bytes)
$tamanhoMaximo = 10000000;
// Extensões aceitas
$extensoes = array(".png", ".jpg", ".pdf");

// Caminho para onde o arquivo será enviado
if (isset($_FILES['fotosReserva']['name'])) {
    $caminho = "./uploads/Reservas/$id_reservas/";
} else {
    $caminho = "./uploads/Espacos/$id_espacos/";
}
// Se não existir pasta cria para depois 
$checkbox = $array["submitTermosCheck"];

if (!file_exists($caminho)) {
    mkdir($caminho, intval('0777', 8), true);
    chmod($caminho, intval('0777', 8));
}

// Substituir arquivo já existente (true = sim; false = nao)
$substituir = false;
for ($i = 0; $i < $numeroCampos; $i++) {
    // Informações do arquivo enviado
    if ($checkbox != null) {
        $nomeArquivo = $_FILES["fotosEspacos"]["name"][$i];
        $ext = pathinfo($nome, PATHINFO_EXTENSION);
        $nomeArquivo = "termodecompromisso." . $ext;
        $nomeArquivo = "termodecompromisso.pdf";
        $original = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:,\\\'<>°ºª';
        $substituir = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                ';
        $nomeArquivo = strtr(utf8_decode($nomeArquivo), utf8_decode($original), $substituir);
        $nomeArquivo = str_replace(' ', '-', $nomeArquivo);
        $nomeArquivo = strtolower($nomeArquivo);
    } else {
        $nomeArquivo = $_FILES["fotosEspacos"]["name"][$i];
        $original = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:,\\\'<>°ºª';
        $substituir = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                ';
        $nomeArquivo = strtr(utf8_decode($nomeArquivo), utf8_decode($original), $substituir);
        $nomeArquivo = str_replace(' ', '-', $nomeArquivo);
        $nomeArquivo = strtolower($nomeArquivo);
    }

    if (isset($_FILES['fotosReserva']['name'])) {
        $nomeArquivo = $_FILES['fotosReserva']['name'][$i];
        $original = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:,\\\'<>°ºª';
        $substituir = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                ';
        $nomeArquivo = strtr(utf8_decode($nomeArquivo), utf8_decode($original), $substituir);
        $nomeArquivo = str_replace(' ', '-', $nomeArquivo);
        $nomeArquivo = strtolower($nomeArquivo);

        $tamanhoArquivo = $_FILES["fotosReserva"]["size"][$i];
        $nomeTemporario = $_FILES["fotosReserva"]["tmp_name"][$i];
    } else {
        $tamanhoArquivo = $_FILES["fotosEspacos"]["size"][$i];
        $nomeTemporario = $_FILES["fotosEspacos"]["tmp_name"][$i];
    }
    //$path = $_FILES["fotos"]["name"][$i];
    //$ext = pathinfo($path, PATHINFO_EXTENSION);

    // Verifica se o arquivo foi colocado no campo
    if (!empty($nomeArquivo)) {
        $erro = false;

        // Verifica se o tamanho do arquivo é maior que o permitido
        if ($tamanhoArquivo > $tamanhoMaximo) {
            $erroTamanho = "O arquivo " . $nomeArquivo . " não deve ultrapassar " . $tamanhoMaximo . " bytes";
        }
        // Verifica se a extensão está entre as aceitas
        elseif (!in_array(strrchr($nomeArquivo, "."), $extensoes)) {
            $erroExtensao = "A extensão do arquivo <b>" . $nomeArquivo . "</b> não é válida";
        }
        // Verifica se o arquivo existe e se é para substituir

        elseif (file_exists($caminho . $nomeArquivo) and !$substituir) {

            $erroDuplicidade = "O arquivo <b>" . $nomeArquivo . "</b> já existe";
        }

        // Se não houver erro
        if (!isset($erroTamanho) && !isset($erroExtensao) && !isset($erroDuplicidade)) {
            // Move o arquivo para o caminho definido
            move_uploaded_file($nomeTemporario, ($caminho . $nomeArquivo));
            // Mensagem de sucesso
            //echo "O arquivo <b>".$nomeArquivo."</b> foi enviado com sucesso. <br />";
        }
    }
}
