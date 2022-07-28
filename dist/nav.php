<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Menu</div>
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Reservas
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="reservar.php">Reservar</a>
                        <a class="nav-link" href="calendario.php">Calendário</a>
                        <a class="nav-link" href="minhasReservas.php">Minhas reservas</a>
                        <?php if ($_SESSION['reservaPermissoaAcesso'] == 1 || ($_SESSION['reservaPermissoaAcesso'] == 2 && $_SESSION['usuarioGrupoSalas'] == $_SESSION['sistemaGrupoSalas'])) { ?>
                            <a class="nav-link" href="aprovarReservas.php">Aprovar reservas</a>
                            <a class="nav-link" href="listarReservas.php">Todas reservas</a>
                        <?php } ?>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Espaços
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav" id="sidenavAccordionPages">
                        <a class="nav-link" href="listarEspacos.php">Listar</a>
                        <?php if ($_SESSION['reservaPermissoaAcesso'] == "1") { ?>
                            <a class="nav-link" href="espacos.php">Cadastro</a>
                        <?php } ?>
                        <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="401.html">401 Page</a>
                            </nav>
                        </div>
                    </nav>
                </div>

                <?php if ($_SESSION['reservaPermissoaAcesso'] == "1") { ?>
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages2" aria-expanded="false" aria-controls="collapsePages">
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                        Satisfação
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapsePages2" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav" id="sidenavAccordionPages">
                            <a class="nav-link" href="dashboardSatisfacao.php">Dashboard</a>
                            <a class="nav-link" href="listarSatisfacao.php">Todas Pesquisas de Satisfação</a>
                            <a class="nav-link" href="relatoriosSatisfacao.php">Relatórios</a>

                            <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="401.html">401 Page</a>
                                </nav>
                            </div>
                        </nav>
                    </div>
                <?php } ?>

                <?php if ($_SESSION['reservaPermissoaAcesso'] == 1) { ?>
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDashboard" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                        Administração
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseDashboard" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">

                            <a class="nav-link" href="dashboardReservas.php">Dashboard</a>
                            <a class="nav-link" href="relatoriosReserva.php">Relatórios</a>
                            <a class="nav-link" href="acessos.php">Acessos</a>
                            <a class="nav-link" href="mensagensAlertas.php">Notificações em Tela</a>
                        </nav>
                    </div>
                <?php } ?>

            </div>
        </div>
        <div class="<?php echo 'sb-sidenav-footer text-dark ' . $_SESSION['divColorClass']; ?>">
            <div class="small ">Logado no:</div>
            <?php echo $_SESSION['titulo']; ?>
        </div>
    </nav>
</div>