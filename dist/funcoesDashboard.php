<?php

/* -------------- Funções para buscar dados do dashboard satisfação -------------- */

// Busca alternativas selecionas da pesquisa de satisfação
function buscaRespostas($grupo, $tipo)
{
    $conexao = conexaoBanco();

    $queryRespostas = "SELECT (SELECT COUNT(*) FROM espaços as esp INNER JOIN reservas as res ON esp.pk_espacos = res.fk_espacos INNER JOIN satisfacao as sat ON res.pk_reservas = sat.fk_reservas INNER JOIN resposta as resp ON sat.pk_satisfacao = resp.fk_satisfacao INNER JOIN alternativa as alt ON resp.fk_alternativa = alt.pk_alternativa
    WHERE esp.grupo_salas = " . $grupo . " AND alt.texto = 'Muito Satisfeito') as MuitoSatisfeito,
        (SELECT COUNT(*) FROM espaços as esp INNER JOIN reservas as res ON esp.pk_espacos = res.fk_espacos INNER JOIN satisfacao as sat ON res.pk_reservas = sat.fk_reservas INNER JOIN resposta as resp ON sat.pk_satisfacao = resp.fk_satisfacao INNER JOIN alternativa as alt ON resp.fk_alternativa = alt.pk_alternativa
    WHERE esp.grupo_salas = " . $grupo . " AND alt.texto = 'Satisfeito') as Satisfeito,
        (SELECT COUNT(*) FROM espaços as esp INNER JOIN reservas as res ON esp.pk_espacos = res.fk_espacos INNER JOIN satisfacao as sat ON res.pk_reservas = sat.fk_reservas INNER JOIN resposta as resp ON sat.pk_satisfacao = resp.fk_satisfacao INNER JOIN alternativa as alt ON resp.fk_alternativa = alt.pk_alternativa
    WHERE esp.grupo_salas = " . $grupo . " AND alt.texto = 'Neutro') as Neutro,
        (SELECT COUNT(*) FROM espaços as esp INNER JOIN reservas as res ON esp.pk_espacos = res.fk_espacos INNER JOIN satisfacao as sat ON res.pk_reservas = sat.fk_reservas INNER JOIN resposta as resp ON sat.pk_satisfacao = resp.fk_satisfacao INNER JOIN alternativa as alt ON resp.fk_alternativa = alt.pk_alternativa
    WHERE esp.grupo_salas = " . $grupo . " AND alt.texto = 'Insatisfeito') as Insatisfeito,
        (SELECT COUNT(*) FROM espaços as esp INNER JOIN reservas as res ON esp.pk_espacos = res.fk_espacos INNER JOIN satisfacao as sat ON res.pk_reservas = sat.fk_reservas INNER JOIN resposta as resp ON sat.pk_satisfacao = resp.fk_satisfacao INNER JOIN alternativa as alt ON resp.fk_alternativa = alt.pk_alternativa
    WHERE esp.grupo_salas = " . $grupo . " AND alt.texto = 'Muito Insatisfeito') as MuitoInsatisfeito";

    $dadosSatisfacao = mysqli_query($conexao, $queryRespostas) or die("Error in query: $queryRespostas." . mysqli_error($conexao));
    $countRespostas = mysqli_fetch_assoc($dadosSatisfacao);

    if ($tipo == "MuitoSatisfeito") {
        $ContadorMuitoSatisfeito = $countRespostas['MuitoSatisfeito'];
        return $ContadorMuitoSatisfeito;
    } else if ($tipo == "Satisfeito") {
        $ContadorSatisfeito = $countRespostas['Satisfeito'];
        return $ContadorSatisfeito;
    } else if ($tipo == "Neutro") {
        $ContadorNeutro = $countRespostas['Neutro'];
        return $ContadorNeutro;
    } else if ($tipo == "Insatisfeito") {
        $ContadorInsatisfeito = $countRespostas['Insatisfeito'];
        return $ContadorInsatisfeito;
    } else {
        $ContadorMuitoInsatisfeito = $countRespostas['MuitoInsatisfeito'];
        return $ContadorMuitoInsatisfeito;
    }
}

// Busca a nota total dos últimos 6 meses conforme a data de hoje
function buscaDatas($grupo, $tipo)
{
    $conexao = conexaoBanco();

    if ($tipo == "LabelDias") {
        for ($i = 6; $i > 0; $i--) {
            $nowDay[] = (strftime('%b' . " " . '%d', strtotime(-$i . 'month')));
        }
        return $nowDay;
    } else if ($tipo == "DataDados") {
        $querySelectDatas = "SELECT (SELECT round(sum(alt.pontuacao), 2) FROM espaços AS esp
                                INNER JOIN reservas as res ON esp.pk_espacos = res.fk_espacos
                                INNER JOIN eventos AS ev ON res.fk_eventos = ev.pk_eventos 
                                INNER JOIN satisfacao AS sat ON res.pk_reservas = sat.fk_reservas 
                                INNER JOIN resposta AS resp ON sat.pk_satisfacao = resp.fk_satisfacao
                                INNER JOIN alternativa AS alt ON resp.fk_alternativa = alt.pk_alternativa
                                WHERE DATE(ev.dt_ini) = CURRENT_DATE() - INTERVAL 6 MONTH AND esp.grupo_salas = '"  . $grupo  .  "') as 'Mês 6',";
        $varDay = 5;
        while ($varDay > 0) {
            $querySelectDatas .= "(SELECT round(sum(alt.pontuacao), 2) FROM espaços AS esp
                                    INNER JOIN reservas as res ON esp.pk_espacos = res.fk_espacos
                                    INNER JOIN eventos AS ev ON res.fk_eventos = ev.pk_eventos 
                                    INNER JOIN satisfacao AS sat ON res.pk_reservas = sat.fk_reservas 
                                    INNER JOIN resposta AS resp ON sat.pk_satisfacao = resp.fk_satisfacao
                                    INNER JOIN alternativa AS alt ON resp.fk_alternativa = alt.pk_alternativa
                                    WHERE DATE(ev.dt_ini) = CURRENT_DATE() - INTERVAL " . $varDay . " MONTH AND esp.grupo_salas = '"  . $grupo  .  "') as 'Mês " . $varDay . "',";
            if ($varDay == 1) {
                $querySelectDatas .= "round(sum(alt.pontuacao), 2) AS soma FROM espaços AS esp
                INNER JOIN reservas as res ON esp.pk_espacos = res.fk_espacos
                INNER JOIN eventos AS ev ON res.fk_eventos = ev.pk_eventos 
                INNER JOIN satisfacao AS sat ON res.pk_reservas = sat.fk_reservas 
                INNER JOIN resposta AS resp ON sat.pk_satisfacao = resp.fk_satisfacao
                INNER JOIN alternativa AS alt ON resp.fk_alternativa = alt.pk_alternativa
                WHERE DATE(ev.dt_ini) = CURRENT_DATE() AND esp.grupo_salas = '"  . $grupo  .  "'";
            }
            $varDay--;
        }

        $dadosSelectDatas = mysqli_query($conexao, $querySelectDatas) or die("Error in query: $querySelectDatas." . mysqli_error($conexao));

        $row = mysqli_fetch_array($dadosSelectDatas);

        for ($i = 6; $i > 0; $i--) {
            $datasValor[] = $row["Mês " . $i];
        }

        $datasValor[] = $row["soma"];
        return $datasValor;
    }
}

// Busca as salas melhores avaliadas no total
function buscaMelhoresSalas($grupo, $tipo)
{
    $conexao = conexaoBanco();

    $queryTopEspacos = "SELECT esp.nome as nome, round(sum(alt.pontuacao), 2), esp.cor FROM espaços AS esp
                            INNER JOIN reservas as res ON esp.pk_espacos = res.fk_espacos
                            INNER JOIN eventos AS ev ON res.fk_eventos = ev.pk_eventos 
                            INNER JOIN satisfacao AS sat ON res.pk_reservas = sat.fk_reservas 
                            INNER JOIN resposta AS resp ON sat.pk_satisfacao = resp.fk_satisfacao
                            INNER JOIN alternativa AS alt ON resp.fk_alternativa = alt.pk_alternativa
                            WHERE esp.grupo_salas = '"  . $grupo  .  "'
                            GROUP BY esp.pk_espacos
                            ORDER BY round(sum(alt.pontuacao)) DESC
                            LIMIT 5";

    $dadosTopEspacos = mysqli_query($conexao, $queryTopEspacos) or die("Error in query: $queryTopEspacos." . mysqli_error($conexao));

    while ($row = mysqli_fetch_array($dadosTopEspacos)) {
        $EspacoNome[] = $row[0];
        $EspacoValor[] = $row[1];
        $EspacoCor[] = $row[2];
    }

    if ($tipo == "BuscaNome") {
        return $EspacoNome;
    } else if ($tipo == "BuscaCor") {
        return $EspacoCor;
    } else if ($tipo == "BuscaValor") {
        return $EspacoValor;
    }
}

// Busca as salas piores avaliadas no total
function buscaPioresSalas($grupo, $tipo)
{
    $conexao = conexaoBanco();

    $queryTopSecretarias = "SELECT esp.nome as nome, round(sum(alt.pontuacao), 2), esp.cor FROM espaços AS esp
                                INNER JOIN reservas as res ON esp.pk_espacos = res.fk_espacos
                                INNER JOIN eventos AS ev ON res.fk_eventos = ev.pk_eventos 
                                INNER JOIN satisfacao AS sat ON res.pk_reservas = sat.fk_reservas 
                                INNER JOIN resposta AS resp ON sat.pk_satisfacao = resp.fk_satisfacao
                                INNER JOIN alternativa AS alt ON resp.fk_alternativa = alt.pk_alternativa
                                WHERE esp.grupo_salas = '"  . $grupo  .  "'
                                GROUP BY esp.pk_espacos, esp.cor
                                ORDER BY round(sum(alt.pontuacao)) ASC
                                LIMIT 5";

    $dadosTopSecretarias = mysqli_query($conexao, $queryTopSecretarias) or die("Error in query: $queryTopSecretarias." . mysqli_error($conexao));

    while ($row = mysqli_fetch_array($dadosTopSecretarias)) {
        $SecretariaNome[] = $row[0];
        $SecretariaValor[] = $row[1];
        $SecretariaCor[] = $row[2];
    }
    if ($tipo == "BuscaNome") {
        return $SecretariaNome;
    } else if ($tipo == "BuscaCor") {
        return $SecretariaCor;
    } else if ($tipo == "BuscaValor") {
        return $SecretariaValor;
    }
}


/* -------------- Funções para buscar dados do dashboard reservas -------------- */
function buscaReservas($grupo, $tipo)
{
    $conexao = conexaoBanco();

    if ($tipo == "TotalReservas") {
        $queryTotalReservas = "SELECT COUNT(*) as total FROM reservas INNER JOIN espaços as esp ON reservas.fk_espacos = esp.pk_espacos WHERE esp.grupo_salas = "  . $grupo  .  " ";
        $dadosContador = mysqli_query($conexao, $queryTotalReservas) or die("Error in query: $queryTotalReservas." . mysqli_error($conexao));
        $contadorReservas = mysqli_fetch_assoc($dadosContador);
        return $contadorReservas["total"];
    } else if ($tipo == "TotalReservasConfirmadas") {
        $queryTotalReservas = "SELECT COUNT(*) as total FROM reservas as res INNER JOIN espaços as esp ON res.fk_espacos = esp.pk_espacos WHERE esp.grupo_salas = "  . $grupo  .  " AND res.status = 'Confirmado'";
        $dadosConfirm = mysqli_query($conexao, $queryTotalReservas) or die("Error in query: $queryTotalReservas." . mysqli_error($conexao));
        $countReservasConfirmadas = mysqli_fetch_assoc($dadosConfirm);

        return $countReservasConfirmadas["total"];
    }
}

function buscaReservasStatus($grupo, $tipo)
{
    $conexao = conexaoBanco();

    $queryStatus = "SELECT (SELECT COUNT(*) FROM reservas as res INNER JOIN espaços as esp ON res.fk_espacos = esp.pk_espacos WHERE esp.grupo_salas = "  . $grupo  .  " AND res.status = 'Confirmado') as Confirmado, 
    (SELECT COUNT(*) FROM reservas as res  INNER JOIN espaços as esp ON res.fk_espacos = esp.pk_espacos WHERE esp.grupo_salas = "  . $grupo  .  " AND res.status = 'Cancelado') as Cancelado,
    (SELECT COUNT(*) FROM reservas as res INNER JOIN espaços as esp ON res.fk_espacos = esp.pk_espacos WHERE esp.grupo_salas = "  . $grupo  .  " AND res.status = 'Editado') as Editado,
    (SELECT COUNT(*) FROM reservas as res INNER JOIN espaços as esp ON res.fk_espacos = esp.pk_espacos WHERE esp.grupo_salas = "  . $grupo  .  " AND res.status = 'Novo') as Novo";

    $dadosStatus = mysqli_query($conexao, $queryStatus) or die("Error in query: $queryStatus." . mysqli_error($conexao));
    $countStatus = mysqli_fetch_assoc($dadosStatus);

    if ($tipo == "StatusConfirmado") {
        $ContadorConfirm = $countStatus['Confirmado'];
        return $ContadorConfirm;
    } else if ($tipo == "StatusCancelado") {
        $ContadorCancel = $countStatus['Cancelado'];
        return $ContadorCancel;
    } else if ($tipo == "StatusEditado") {
        $ContadorEdit = $countStatus['Editado'];
        return $ContadorEdit;
    } else if ($tipo == "StatusNovo") {
        $ContadorNovo = $countStatus['Novo'];
        return $ContadorNovo;
    }
}

function buscaReservasMes($grupo, $tipo)
{
    $conexao = conexaoBanco();

    if ($tipo == "LabelDias") {
        for ($i = 30; $i >= 0; $i--) {
            $nowDay[] = (strftime('%b' . " " . '%d', strtotime(-$i . 'days')));
        }
        return $nowDay;
    } else if ($tipo == "DataDados") {

        $querySelectDatas = "SELECT (SELECT COUNT(*) FROM reservas AS res INNER JOIN eventos AS ev ON res.fk_eventos = ev.pk_eventos INNER JOIN espaços as esp ON res.fk_espacos = esp.pk_espacos WHERE DATE(ev.dt_ini) = CURRENT_DATE() - INTERVAL 30 DAY AND esp.grupo_salas = '"  . $grupo  .  "') as 'Data Anterior 30',";

        $varDay = 29;

        while ($varDay > 0) {
            $querySelectDatas .= "(SELECT COUNT(*) FROM reservas AS res INNER JOIN eventos AS ev ON res.fk_eventos = ev.pk_eventos INNER JOIN espaços as esp ON res.fk_espacos = esp.pk_espacos WHERE DATE(ev.dt_ini) = CURRENT_DATE() - INTERVAL " . $varDay . " DAY AND esp.grupo_salas = '" . $grupo . "') as 'Data Anterior " . $varDay . "',";
            if ($varDay == 1) {
                $querySelectDatas .= "COUNT(*) as 'Data atual' FROM reservas AS res INNER JOIN eventos AS ev ON res.fk_eventos = ev.pk_eventos INNER JOIN espaços as esp ON res.fk_espacos = esp.pk_espacos WHERE DATE(ev.dt_ini) = CURRENT_DATE() AND (esp.grupo_salas = '"  . $grupo  .  "') ORDER BY COUNT(*) ASC";
            }
            $varDay--;
        }

        $dadosSelectDatas = mysqli_query($conexao, $querySelectDatas) or die("Error in query: $querySelectDatas." . mysqli_error($conexao));

        $row = mysqli_fetch_array($dadosSelectDatas);

        for ($i = 30; $i > 0; $i--) {
            $datasValor[] = $row["Data Anterior " . $i];
        }
        $datasValor[] = $row["Data atual"];
        return $datasValor;
    }
}

function buscaEspacos($grupo, $tipo)
{
    $conexao = conexaoBanco();

    $queryTopEspacos = "SELECT esp.nome as nome, COUNT(*) as 'Quantidade de reservas', cor FROM espaços AS esp 
                    INNER JOIN reservas AS r ON esp.pk_espacos = r.fk_espacos INNER JOIN eventos AS ev ON r.fk_eventos = ev.pk_eventos
                    WHERE esp.grupo_salas = "  . $grupo  . "
                    GROUP BY esp.pk_espacos
                    ORDER BY COUNT(r.pk_reservas) DESC
                    LIMIT 5";
    $dadosTopEspacos = mysqli_query($conexao, $queryTopEspacos) or die("Error in query: $queryTopEspacos." . mysqli_error($conexao));

    while ($row = mysqli_fetch_array($dadosTopEspacos)) {
        $EspacoNome[] = $row[0];
        $EspacoValor[] = $row[1];
        $EspacoCor[] = $row[2];
    }
    if ($tipo == "EspacoNome") {
        return $EspacoNome;
    } else if ($tipo == "EspacoCor") {
        return $EspacoCor;
    } else if ($tipo == "EspacoValor") {
        return $EspacoValor;
    }
}

function buscaSecretarias($grupo, $tipo)
{
    $conexao = conexaoBanco();

    $queryTopSecretarias = "SELECT DISTINCT(UPPER(secretaria)) AS nomeSecretaria, COUNT(pk_reservas) as 'Quantidade de reservas' FROM reservas as res
                        INNER JOIN espaços as esp ON res.fk_espacos = esp.pk_espacos
                        WHERE esp.grupo_salas = "  . $grupo  . "
                        GROUP BY nomeSecretaria
                        ORDER BY COUNT(res.pk_reservas) DESC
                        LIMIT 5";

    $dadosTopSecretarias = mysqli_query($conexao, $queryTopSecretarias) or die("Error in query: $queryTopSecretarias." . mysqli_error($conexao));

    while ($row = mysqli_fetch_array($dadosTopSecretarias)) {
        $SecretariaNome[] = $row[0];
        $SecretariaValor[] = $row[1];
    }

    if ($tipo == "SecretariaNome") {
        return $SecretariaNome;
    } else if ($tipo == "SecretariaValor") {
        return $SecretariaValor;
    }
}
