<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];


if ($funcao == 'validaSenha') {
    call_user_func($funcao);
}
return;

function validaSenha()
{
    $login = $_POST["login"];
    $senha = $_POST["senha"];
    $comum = new comum();
    $senhaCript = $comum->criptografia($senha);
    $reposit = new reposit();
    $result = $reposit->SelectCondTrue("usuario| login='" . $login . "' AND CAST(login as varbinary(100)) = CAST('" . $login . "' as varbinary(100)) and ativo = 1");

    if ($row = $result[0]) {
        $codigo = $row['codigo'];
        if ($codigo) {
            $sql = " SELECT restaurarSenha FROM ntl.usuario where codigo = $codigo";
            $resultRestaura = $reposit->RunQuery($sql);
            if ($rowRestaura = $resultRestaura[0]) {
                $restauraSenha = $rowRestaura['restaurarSenha'];
            }
        }
        $funcionario = $row['funcionario'];
        $grupo = $row['grupo'];
        $nome = $row['nome'];
        $senhaBanco = $row['senha'];
        $candidato = $row['candidato'];
        $tipoUsuario = $row['tipoUsuario'];
        $reposit->FechaConexao();
        if ($funcionario) {
            $sql = " SELECT BP.codigo, BP.funcionario, BP.projeto
            FROM Ntl.beneficioProjeto BP WHERE BP.funcionario = $funcionario AND BP.ativo = 1 AND BP.dataDemissaoFuncionario IS NULL";
            $result = $reposit->RunQuery($sql);

            if ($row = $result[0]) {
                $projeto = $row['projeto'];
            }
        }
        $sqlSamu = "SELECT codigo FROM Ntl.projeto WHERE apelido = 'SAMU'";
        $resultSamu = $reposit->RunQuery($sqlSamu);
        $projetoSamu = $resultSamu[0]['codigo'];

        if ($senhaCript == $senhaBanco) {
            session_start();
            $_SESSION['login'] = $login;
            $_SESSION['codigo'] = $codigo;
            $_SESSION['funcionario'] = $funcionario;
            $_SESSION['projeto'] = $projeto;
            $_SESSION['grupo'] = $grupo;
            $_SESSION['candidato'] = $candidato;
            $_SESSION['tipoUsuario'] = $tipoUsuario;

            define("login", $login);
            session_write_close();
            echo ('sucess#' . $nome . '#' . $login . '#' . $restauraSenha . '#' . $projetoSamu);
        } else {
            echo ('failed ') . $senha;
        }
    } else {
        echo ('failed ') . $senha;
    }
}
