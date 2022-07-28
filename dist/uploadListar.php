<?php
include "sweetalert.html";

if (isset($_GET['id']) == 1) {

  $img = $_GET['caminho'] . $_GET['arquivo'];

  if (file_exists($img)) {
    if (unlink($img)) {
      echo "<script> 
                  swal({
                      title: 'Sucesso!',
                      text: 'Imagem excluída com sucesso!',
                      type: 'success',
                      timer: 2000
                  }, 
                  function(){
                    history.go(-2);
                  })
              </script>";
    }
  } else {
    echo "<script> 
                  swal({
                      title: 'Erro!',
                      text: 'Arquivo inexistente!',
                      type: 'error',
                      timer: 2000
                  }, 
                  function(){
                    history.go(-2);
                  })
            </script>";
  }
}

if (isset($caminho)) {
  $diretorio = dir($caminho);
  if (file_exists($caminho)) {
    if (count(glob($caminho . "/*")) !== 0) {
      echo "<td>Documentos anexados:</td>";
    }
  }

  while ($arquivo = $diretorio->read()) {
    $ext = pathinfo($arquivo, PATHINFO_EXTENSION);
    $getsession = $_SESSION["reservaPermissoaAcesso"] > 0 ? "<td><a href='uploadListar.php?id=1&caminho=$caminho&arquivo=$arquivo' style='margin-left: 1em; cursor: pointer; color: white; background-color: rgb(177,0,0); text-decoration: none; border: 1px solid rgb(177,0,0); border-radius: 7px; border-width: thick;'border=\"0\" width='10' height='10' title=\"Excluir\">Excluir</a><br/>" : "";
    
    if ($arquivo != "." && $arquivo != "..") {
      if ($ext == "pdf" || "png" || "jpg" && empty($_REQUEST['pk_reservas_this'])) {
        echo "<div><tr align='center'>";
        echo  "<td><img style='margin-left:2em;' src='img/pdf.png' target='_blank' width='110' height='110'></td>";
        echo "<td><a style='margin-left:2em; margin-bottom: 5em;' href=" . $caminho . "/" . $arquivo . " target='_blank'>" . $arquivo . "</a></td>  
                " . $getsession . "
                </td>
              </tr>
          </div>";
      } else if (isset($_REQUEST['pk_reservas_this'])) {
        echo "<td><a href=" . $caminho . "/" . $arquivo . " target='_blank'>" . $arquivo . "</a></td>  
                " . $getsession . "
                </td>
              </tr>";
      } else {
        exit();
        echo  "<td><img style='margin-left:2em;' src=" . $caminho . "/" . $arquivo . " target='_blank' width='150' height='150'></td>";
      }
    }
    echo "<br>";
  }


  $diretorio->close();
}
