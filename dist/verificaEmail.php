<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_REQUEST['inputEmail'])) {
    $emailauth = $_REQUEST['inputEmail'];

    include "conexaoDB.php";
    include "sweetalert.html";

    $query = "UPDATE oauth.usuario SET email = '" . $emailauth . "', confirmar_email = 0 WHERE matricula = '" . $_SESSION['sessaoauth']['soe:matricula'] . "'";
    $errors = mysqli_query($conexao, $query) or die("Error in update_eventos:$query " . mysqli_error($conexao));

    echo "<script> 
        swal({
            title: 'Alterado!',
            text: 'Email alterado com sucesso!',
            type: 'success',
            timer: 2000
        }, 
        function(){
            window.location.href = 'https://sistemas.planejamento.rs.gov.br/reservas/';
        })
        </script>";
}

?>
<style>
    .modal.fade .modal-dialog {
        -webkit-transition: all 0.3s;
        -moz-transition: all 0.3s;
        transition: all 0.5s;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('#exampleModal').modal('show');
    });
</script>

<!-- Modal -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Prezado usuário, favor confirme o seu endereço e-mail</h5>
            </div>
            <form action="verificaEmail.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Endereço de e-mail:<a style="color:red;" title="Campo obrigatório"> * </a></label></label>
                        <input required type="email" class="form-control" name="inputEmail" id="email" value="<?= strtolower(exibeEmailSoeAuth($conexao) !== null ? exibeEmailSoeAuth($conexao) : sugereEmail($conexao)); ?>">
                        <div id="emailHelp" class="form-text small display-6">Nunca compartilharemos seu e-mail com mais ninguém, o e-mail será utilizado para alerta da reserva.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>