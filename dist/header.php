<?php
if (!isset($_SESSION)) {
    session_start();
}
include "verificaLogin.php";
include "funcoesAcessosPermissoes.php";
include_once "chamadasAlertas.php";

//verifica GLPI
if (isset($_SESSION['glpiname']) && isset($_SESSION['glpiID']) && !acionaSOEAUTH()) {
    buscaPermissaoUsuario($conexao, 'fk_glpi_users', $_SESSION['glpiID']);
    $_SESSION['auth'] = 'GLPI';
}
// Verifica SOE
else if (isset($_SESSION['sessaoauth']['name']) && isset($_SESSION['sessaoauth']['soe:matricula']) && acionaSOEAUTH()) {
    buscaPermissaoUsuario($conexao, 'fk_soe_users', $_SESSION['sessaoauth']['soe:matricula']);
    $_SESSION['soeNome']     = $_SESSION['sessaoauth']['soe:organizacao'] . "-" . $_SESSION['sessaoauth']['name'];
    $_SESSION['soeMatricula']     = $_SESSION['sessaoauth']['soe:matricula'];
    $_SESSION['auth'] = 'SOEAUTH';
} else {
    sair();
    echo "Sem Acesso ao sistema";
}

// Trecho que trata grupo de salas escolhido
// 1 CAFF Working
// 2 Demais Espaços do CAFF
if (isset($_REQUEST['GrupoSalas'])) {
    $_SESSION['sistemaGrupoSalas']  = $_REQUEST['GrupoSalas'];
    switch ($_SESSION['sistemaGrupoSalas']) {
        case "1":
            $_SESSION['divColorClass'] = "bg-warning";
            $_SESSION['textColorClass'] = "text-warning";
            $_SESSION['titulo'] = "CAFF Working";
            $_SESSION['text']  = '<a class="navbar-brand ' . $_SESSION['textColorClass'] . '" href="index.php">' . $_SESSION['titulo'] . '</a>';
            break;
        case "2":
            $_SESSION['divColorClass'] = "bg-success";
            $_SESSION['textColorClass'] = "text-success";
            $_SESSION['titulo'] = "Reserva de Espaços";
            $_SESSION['text']  = '<a class="navbar-brand ' . $_SESSION['textColorClass'] . '" href="index.php">' . $_SESSION['titulo'] . '</a>';
            break;
    }
    echo "<script>console.log('" . $_REQUEST['GrupoSalas'] . "');</script>";
}

// Verifica e-mail do soeauth
if (exibeConfirmacao($conexao) == 1) {
    include "verificaEmail.php";
}

?>
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <?php if (isset($_SESSION['text'])) { ?>

        <?= $_SESSION['text'] ?>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
    <?php } ?>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
            <div class="input-group-append">
            </div>
        </div>
    </form>

    <!-- Navbar-->
    <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i><?= isset($_SESSION['glpiname']) ? $_SESSION['glpiname'] : $_SESSION['soeNome']; ?></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">

                <?php if ($_SESSION['auth'] == 'GLPI') : ?>
                    <a class="dropdown-item" href="../../front/intermediaria.php">Serviços do Caff</a>

                <?php endif; ?>

                <a class="dropdown-item" href="index.php">Grupo de Salas</a>
                <?php if ($_SESSION['reservaPermissoaAcesso'] == "1") { ?>
                    <a class="dropdown-item" href="acessos.php">Acessos</a>
                <?php } ?>

                <?php if ($_SESSION['reservaPermissoaAcesso'] == "1") { ?>
                    <a class="dropdown-item" href="configurarEmailEnvio.php">Envio de email</a>
                <?php } ?>
                <?php if ($_SESSION['auth'] == 'GLPI') : ?>

                    <a class="dropdown-item" href="index.php">Grupo de Salas</a>
                    <?php if ($linha_acesso['fk_permissao'] == "1") { ?>
                        <a class="dropdown-item" href="configurarEmailEnvio.php">Envio de email</a>
                    <?php } ?>

                    <a class="dropdown-item" href="../../front/logout.php" .html">Sair</a>
                <?php elseif ($_SESSION['auth'] == 'SOEAUTH') : ?>
                    <a class="dropdown-item" href="../../../oauth2/destruirSession.php">Sair</a>
                <?php endif; ?>
            </div>
        </li>
    </ul>
</nav>