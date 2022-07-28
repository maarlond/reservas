<div class="control-group">
  <label class="control-label">Adicionar Fotos dos Espaços ou Termo de Compromisso (Arquivo(.png, .jpg, .pdf))<br>Tamanho máximo do arquivo: 10MB</label>
  <div class="controls">
    <div id="anexoVariavel">
      <input id="anexo" type="file" multiple name="fotosEspacos[]" data-max-size="10" onchange="exibirCheckboxTermos(); validarArquivo();" />
    </div>
    <br>
    <div id="termos" style="margin-left: 1.5em" hidden="true">
      <input class="form-check-input fechar" id="submitTermosCheck" type="checkbox" name="submitTermosCheck">
      <label class="form-check-label" for="submitTermosCheck"><b>O arquivo inserido é um termo de compromisso?</b>
    </div>
  </div>
</div>

<script>
  function exibirCheckboxTermos() {
    var val = $('#anexo').val().toLowerCase(),
      regexPdf = new RegExp("(.*?)\.(pdf)$");

    if ((regexPdf.test(val))) {
      document.getElementById("termos").hidden = false;
    } else {
      document.getElementById("termos").hidden = true;
    }
  }

  function validarArquivo() {
    var val = $('#anexo').val().toLowerCase(),
      regexArquivos = new RegExp("(.*?)\.(png|pdf|jpg)$");

    var arquivoInput = document.getElementById('#anexo');
   
    if (!(regexArquivos.test(val))) {
      document.getElementById('anexo').value = ''; // Limpa o campo
      swal({
        title: 'Erro!',
        text: 'Arquivo incorreto!',
        type: 'error',
        timer: 2000
      }, );
    }
  }
</script>