<?php

//flag que aciona o SOEAUTH
function acionaSOEAUTH(){

    $conexao = conexaoBanco();
    $query_acesso = "SELECT valor FROM parametros where parametro = 'flag_aciona_soeauth' ";
    $dados_acesso = $conexao->query($query_acesso) or die("Error in select query_acesso: $query_acesso." . mysqli_error($conexao));
    $linha_acesso = mysqli_fetch_array($dados_acesso);

    $flag = $linha_acesso['valor'] === 'true';
    return $flag;
}

function sair(){
    unset($_SESSION);

    session_destroy();

    switch($_SERVER["HTTP_HOST"]){
        case  "localhost:8080":
            echo "<script>window.location.href='http://localhost:8080/oauth2/auth.php?sistema=reservas'</script>";
        break;
        case "reservas.caff.rs.gov.br":
            echo "<script>window.location.href='https://sis.caff.rs.gov.br/'</script>";
        break;
        case "sistemas.planejamento.rs.gov.br":
            echo "<script>window.location.href='https://sistemas.planejamento.rs.gov.br/oauth2/auth.php?sistema=reservas'</script>";
        break;
    }
}
function parametros(){

    $parametros = array(
        "nome" => "",
        "tabela" => "",
        "on1" => "",
        "on2" => "",

    );
    if($_SESSION['auth'] === "SOEAUTH"){
        $parametros['nome'] = "nome";
        $parametros['tabela'] = "oauth.usuario";
        $parametros['on1'] = "matricula";
        $parametros['on2'] = "fk_soe_users";

    }
    else{
        $parametros['nome'] = "name";
        $parametros['tabela'] = "sis.glpi_users";
        $parametros['on1'] = "id";
        $parametros['on2'] = "fk_glpi_users";
    }

    return $parametros;
}

function verificaUsuarioSessaoLogado()
{
    if ($_SESSION['auth'] == "SOEAUTH" && acionaSOEAUTH() ) {
        return $_SESSION["soeNome"];
    } else if ($_SESSION['auth'] == "GLPI") {
        return $_SESSION["glpiname"];
    }
}

function tratarUsuario()
{
    if ($_SESSION['auth'] == "SOEAUTH" && acionaSOEAUTH()) {
        return "fk_soe_users";
    } else if ($_SESSION['auth'] == "GLPI") {
        return "fk_glpi_users";
    }
}

function verificaIDSessaoLogado()
{
    if ($_SESSION['auth'] == "SOEAUTH" & acionaSOEAUTH()) {
        return $_SESSION["soeMatricula"];
    } else if ($_SESSION['auth'] == "GLPI") {
        return $_SESSION["glpiID"];
    }
}

function buscaPermissaoUsuario($conexao, $parametro, $userID)
{
    //Se tiver alguma permissão insere na sessão o tipo de permissão
    // 0 basico  // 1 administrador // 2 aprovador
    $query_acesso = "SELECT * FROM user_permissao where $parametro = " . $userID;
    $dados_acesso = $conexao->query($query_acesso) or die("Error in select query_acesso: $query_acesso." . mysqli_error($conexao));
    $linha_acesso = mysqli_fetch_array($dados_acesso);

    $_SESSION['reservaPermissoaAcesso'] = 0;
    if (isset($linha_acesso['fk_permissao'])) {
        $_SESSION['reservaPermissoaAcesso'] = $linha_acesso['fk_permissao'];
        $_SESSION['usuarioGrupoSalas'] = $linha_acesso['grupo_salas'];
    }
}

function validaUsersGLPI()
{
    return isset($_SESSION['glpiID']) ? $_SESSION['glpiID'] : "NULL";
}

function validaUsersSOE()
{
    return isset($_SESSION['soeMatricula']) ? $_SESSION['soeMatricula'] : "NULL";
}
