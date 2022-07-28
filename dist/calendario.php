<?php
include "conexaoDB.php";
session_start();

if (!empty($_GET['grupo'])) {
  $grupoPortalCaff = $_GET['grupo'];
}
$validaCalendar = false;

if (!empty($grupoPortalCaff)) {
  $_SESSION['sistemaGrupoSalas'] = $grupoPortalCaff;
  $validaCalendar = true;
}

$validaPortalCaff = $validaCalendar == '' ? "" : " and calendario_status = 1";

$query_espacos = "SELECT pk_espacos, nome, cor FROM espaços WHERE grupo_salas = " . $_SESSION['sistemaGrupoSalas'] . $validaPortalCaff . " ORDER BY nome desc";
$dados = mysqli_query($conexao, $query_espacos) or die("Error in query_espacos: $query_espacos." . mysqli_error($conexao));

$espaco = 0;

if (isset($_REQUEST["inputEspacos"])) {
  $espaco = $_REQUEST["inputEspacos"];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Calendário</title>
  <link href="css/styles.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
  <link href='../lib/main.css' rel='stylesheet' />
  <script src='../lib/main.js'></script>
  <script src="../lib/locales-all.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');

      var calendar = new FullCalendar.Calendar(calendarEl, {

        locale: 'pt-br',
        dayMaxEvents: 3,
        selectable: true,
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth listWeek dayGridWeek'
        },
        eventClick: function(info) {
          info.jsEvent.preventDefault();
          eventId = info.event.id;
          info.el.style.backgroundColor = 'gray';
          info.el.style.borderColor = 'gray';

          buscaInfoCalendar(eventId);
        },
        events: {
          url: './listarEventos.php?espaco=<?php echo $espaco ?>&grupoSalas=<?php echo $_SESSION['sistemaGrupoSalas'] ?>&portalCaff=<?php echo $validaCalendar ?>',
          extraParams: function() {
            return {
              cachebuster: new Date().valueOf()
            };
          }
        }
      });

      calendar.render();
    });
  </script>
  <style>
    body {
      margin: 0;
      padding: 0;
    }

    #script-warning {
      display: none;
      background: #eee;
      border-bottom: 1px solid #ddd;
      padding: 0 10px;
      line-height: 40px;
      text-align: center;
      font-weight: bold;
      font-size: 12px;
      color: red;
    }

    #loading {
      display: none;
      position: absolute;
      top: 10px;
      right: 10px;
    }

    #calendar {
      max-width: 1100px;
      margin: 40px auto;
      padding: 0 10px;
    }

    .bola {
      margin-left: 10px;
      margin-right: 3px;
      border-radius: 50%;
      display: inline-block;
      height: 12px;
      width: 12px;
    }
  </style>
</head>

<body class="sb-nav-fixed">
  <!-- Incluindo menu header -->
  <?php if (empty($grupoPortalCaff)) {
    include "header.php";
    require "verificarAcesso.php";
  ?>
    <!-- Incluindo menu header -->
    <div id="layoutSidenav">
      <!-- Incluindo menu esquerdo -->
      <?php include "nav.php"; ?>
    <?php } ?>
    <!-- Incluindo menu esquerdo -->
    <div id="layoutSidenav_content">

      <main>
        <div class="container-fluid">
          <form action="calendario.php" method="get">
            <div class="form-row">

              <div class="col-md-3">
                <div class="form-group">
                  <label class="small mb-1" for="inputEspacos">Espaços</label>

                  <select required class="form-control py-2" name="inputEspacos" id="inputEspacos" type="sala" placeholder="Escolha a sala<">
                    <option value="0">Todos</option>
                    <?php
                    while ($linha = mysqli_fetch_assoc($dados)) {
                      $select = $espaco == $linha['pk_espacos'] ? "selected" : "";
                      echo '<option style="background-color:' . $linha["cor"] . '"' . $select . ' value="' . $linha['pk_espacos'] . '">' . $linha['nome'] . '</option>';
                    }
                    ?>
                  </select>

                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <br>
                  <input type="hidden" id="grupo" name="grupo" value="<?= !empty($grupoPortalCaff) ? $grupoPortalCaff : "" ?>">

                  <button type="submit" class="btn btn-info btn-circle">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>
            </div>
          </form>
          <?php include "detalhesReserva.php" ?>
          <!-- Incluindo Calendário -->
          <?php include "tes.php"; ?>
        </div>
      </main>
      <?php if (empty($grupoPortalCaff)) { ?>

        <?php include "direitos.php"; ?>
      <?php } ?>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/functions.js"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

</body>

</html>