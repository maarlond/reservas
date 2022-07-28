<?php
if (isset($_SESSION['titulo'])) {
} else {
    echo "<script>window.location.href='http://sis.caff.rs.gov.br/reservas/dist/index.php';</script>";
}
