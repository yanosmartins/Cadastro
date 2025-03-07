<?php
error_get_last();
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Ponto Eletrônico Diário";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
$page_css[] = "style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['funcionario']['sub']['ponto']['sub']["controlePontoDiario"]["active"] = true;

include("inc/nav.php");
?>
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Área do Funcionário"] = "";
    $breadcrumbs["Ponto"] = "";
    include("inc/ribbon.php");
    ?>

    <!-- MAIN CONTENT -->
    <div id="content">

        <!-- widget grid -->
        <section id="widget-grid" class="">
            <!-- <div class="row" style="margin: 0 0 13px 0;">
                <?php if ($condicaoGravarOK) { ?>
                    <a class="btn btn-primary fa fa-file-o" aria-hidden="true" title="Novo" href="<?php echo APP_URL; ?>/cadastroLocalizacao.php" style="float:right"></a>
                <?php } ?>
            </div> -->

            <div class="">
                <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable centerBox">
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
                        <header>
                            <span class="widget-icon"><i class="fa fa-cog"></i></span>
                            <h2>Funcionário
                            </h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formLocalizacao" method="post">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseCadastro" class="">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Ponto Eletrônico
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseCadastro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <input id="codigo" name="codigo" type="text" class="hidden">
                                                        <input id="idFolha" name="idFolha" type="text" class="hidden">
                                                        <input id="ip" name="ip" type="text" class="hidden">

                                                        <div class="row ">
                                                            <div class=" row text-center" style="margin-bottom: 10px;">
                                                                <h2 style="font-weight:bold;">Ponto Eletrônico</h2>
                                                                <h5>
                                                                    <div id="diaAtual" name="diaAtual" style="font-size: 17px;">
                                                                    </div>
                                                                    <script>
                                                                        dataAtual()

                                                                        function dataAtual() {
                                                                            meses = new Array("Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
                                                                            semana = new Array("Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado");

                                                                            var dataAtual = new Date(),
                                                                                diaext;
                                                                            var dia = dataAtual.getDate();
                                                                            var dias = dataAtual.getDay();
                                                                            var mes = dataAtual.getMonth();
                                                                            var ano = dataAtual.getFullYear();

                                                                            $("#dia").val(dia);

                                                                            diaext = semana[dias] + ", " + dia + " de " + meses[mes] + " de " + ano;
                                                                            document.getElementById("diaAtual").innerHTML = diaext;
                                                                        }
                                                                    </script>
                                                                </h5>
                                                                <!-- <script>
                                                                    var myVar = setInterval(myTimer, 1000);

                                                                    function myTimer() {
                                                                        var d = new Date(),
                                                                            displayDate;
                                                                        if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
                                                                            displayDate = d.toLocaleTimeString('pt-BR');
                                                                        } else {
                                                                            displayDate = d.toLocaleTimeString('pt-BR', {
                                                                                timeZone: 'America/Sao_Paulo'
                                                                            });
                                                                        }
                                                                        document.getElementById("hora").innerHTML = displayDate;
                                                                        $("#horaAtual").val(displayDate);
                                                                    }
                                                                </script> -->
                                                                <div id="hora" style="font-size: 17px;">
                                                                </div>
                                                                <div class="#"><br>
                                                                    <h4>Funcionário: <span id="#">
                                                                            <?php
                                                                            $reposit = new reposit();
                                                                            $url = explode("=", $_SERVER["REQUEST_URI"]); ////essas linhas fazem a leitura do codigo "id" na url
                                                                            $codigo = ($url[1]);
                                                                            $codigo = (int)$codigo;
                                                                            $sql = "SELECT codigo, nome, escala FROM dbo.funcionario WHERE codigo = $codigo";
                                                                            $result = $reposit->RunQuery($sql);
                                                                            ?></span>
                                                                        <?php
                                                                        if ($row = $result[0]) {
                                                                            $nome = $row['nome'];
                                                                            $escala = $row['escala'];
                                                                            // echo '<option id="funcionario" name="funcionario" value= ' . $codigo . ' selected>' . $nome . '</option>';
                                                                            $nome = mb_strtoupper($nome);
                                                                            echo "<input type='hidden' name='funcionario' id='funcionario' value='$codigo'";
                                                                            echo "<br>";
                                                                            echo "<p>$nome</p>";
                                                                        }
                                                                        ?>
                                                                    </h4>
                                                                </div>
                                                                <div class="row" style="display: inline-flex;">
                                                                    <div class="col col-2" style="width:150px;">
                                                                        <h4>Expediente: <span id="#">
                                                                                <?php
                                                                                $hoje = getdate();
                                                                                $diaSemana = $hoje["wday"];

                                                                                $diaSemanaExtenso = $hoje["wday"];
                                                                                $valor_de_retorno = match ($diaSemanaExtenso) {
                                                                                    1 => 'segunda',
                                                                                    2 => 'terca',
                                                                                    3 => 'quarta',
                                                                                    4 => 'quinta',
                                                                                    5 => 'sexta',
                                                                                    6 => 'sabado',
                                                                                    7 => 'domingo',
                                                                                };

                                                                                $diaSemanaExtenso = $valor_de_retorno;

                                                                                $reposit = new reposit();
                                                                                $sqlExpediente = "SELECT horaEntrada, inicioIntervalo, fimIntervalo, horaSaida, $diaSemanaExtenso FROM dbo.escala where codigo = $escala"; //  AND funcionario = " . $_SESSION['funcionario'];
                                                                                $resultExpediente = $reposit->RunQuery($sqlExpediente);

                                                                                foreach ($resultExpediente as $row) {
                                                                                    $diaSemanaValor = $row[$diaSemanaExtenso];
                                                                                }
                                                                                // $diaSemanaValor =0;
                                                                                if ($diaSemanaValor == 1) {
                                                                                    $avisoFolga = '0';
                                                                                    foreach ($resultExpediente as $row) {
                                                                                        $codigo = (int) $row['codigo'];
                                                                                        $horaEntrada = $row['horaEntrada'];
                                                                                        $horaSaida = $row['horaSaida'];
                                                                                        $inicioIntervalo = $row['inicioIntervalo'];
                                                                                        $fimIntervalo = $row['fimIntervalo'];

                                                                                        $horaEntradaPartida = explode(":", $horaEntrada);
                                                                                        $horaEntrada = $horaEntradaPartida[0] . ":" .  $horaEntradaPartida[1];

                                                                                        $horaSaidaPartida = explode(":", $horaSaida);
                                                                                        $horaSaida = $horaSaidaPartida[0] . ":" .  $horaSaidaPartida[1];

                                                                                        $inicioIntervaloPartido = explode(":", $inicioIntervalo);
                                                                                        $inicioIntervalo = $inicioIntervaloPartido[0] . ":" .  $inicioIntervaloPartido[1];

                                                                                        $fimIntervaloPartido = explode(":", $fimIntervalo);
                                                                                        $fimIntervalo = $fimIntervaloPartido[0] . ":" .  $fimIntervaloPartido[1];
                                                                                    }
                                                                                } else {
                                                                                    if ($codigo) {
                                                                                        $avisoFolga = '1';
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </span>
                                                                            <?php
                                                                            if ($funcionario == $_SESSION['funcionario']) {
                                                                                echo "<p id='expediente' name='expediente' data-funcionario='$funcionario' value='$codigo'>$horaEntrada-$horaSaida</p>";
                                                                            }
                                                                            ?>
                                                                        </h4>
                                                                    </div>
                                                                    <div class="col col-2" style="width:150px;">
                                                                        <h4>Intervalo: <span id="#">

                                                                            </span>
                                                                            <?php
                                                                            if ($funcionario == $_SESSION['funcionario']) {
                                                                                echo "<p id='intervalo' name='intervalo' data-funcionario='$funcionario' value='$codigo'>$inicioIntervalo-$fimIntervalo</p>";
                                                                            }
                                                                            ?>
                                                                        </h4>
                                                                    </div>
                                                                </div>
                                                                <h4 id="horarioPausa" class="hidden">Horários Previstos para Pausa: <span id="#">
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, inicioPrimeiraPausa, fimPrimeiraPausa, inicioSegundaPausa, fimSegundaPausa
                                                                                FROM Ntl.beneficioProjeto
                                                                                WHERE ativo = 1 AND funcionario = " . $_SESSION['funcionario'];
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = (int) $row['codigo'];
                                                                            $inicioPrimeiraPausa = $row['inicioPrimeiraPausa'];
                                                                            $fimPrimeiraPausa = $row['fimPrimeiraPausa'];
                                                                            $inicioSegundaPausa = $row['inicioSegundaPausa'];
                                                                            $fimSegundaPausa = $row['fimSegundaPausa'];
                                                                            $funcionario = $row['funcionario'];
                                                                        }

                                                                        // echo '<option id="horarioPausa" name="horarioPausa" data-funcionario="' . $funcionario . '" value="' . $codigo . '" selected>' . $inicioPrimeiraPausa . " - " . $fimPrimeiraPausa . ' | ' . $inicioSegundaPausa . " - " . $fimSegundaPausa . '</option>';

                                                                        echo "<input type='hidden' name='horarioPausa' id='horarioPausa' data-funcionario='$funcionario' value='$codigo'";
                                                                        echo "<br>";
                                                                        echo "<p id='pausa'>$inicioPrimeiraPausa - $fimPrimeiraPausa | $inicioSegundaPausa - $fimSegundaPausa</p>";
                                                                        ?>
                                                                    </span>
                                                                </h4>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <center>
                                                                O horário será registrado de acordo com o horário do servidor <br> (UTC/GMT -03:00) - Horario de Brasília
                                                            </center>
                                                        </div>
                                                        <div class="col col-xs-12 hidden" style="margin-top: 15px;" id="btnPausas">
                                                            <div class="col col-md-1"></div>
                                                            <div class="col col-md-5">
                                                                <h4 style="text-align: center;"> Primeira Pausa </h4>
                                                                <div style="display: flex;justify-content: space-evenly;align-items: center;">
                                                                    <div class="col col-md-2">
                                                                        <button type="button" class="btn  btn-block btnEntrada" name="btnInicioPrimeiraPausa" id="btnInicioPrimeiraPausa" style="background-color: #546e7a;width: 115px;height: 60px;margin: 0 0 20px;">
                                                                            <span class="fa fa-pause"></span><br>Inicio Pausa
                                                                        </button>
                                                                    </div>
                                                                    <div class="col col-md-2">
                                                                        <button type="button" class="btn  btn-block btnEntrada" name="btnFimPrimeiraPausa" id="btnFimPrimeiraPausa" style="background-color: #546e7a;width: 110px;height: 60px;margin: 0 0 20px;">
                                                                            <span class="fa fa-play"></span><br>Fim Pausa
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col col-md-5">
                                                                <h4 style="text-align: center;"> Segunda Pausa </h4>
                                                                <div style="display: flex;justify-content: space-evenly;align-items: center;">
                                                                    <div class="col col-md-2">
                                                                        <button type="button" class="btn  btn-block btnEntrada" name="btnInicioSegundaPausa" id="btnInicioSegundaPausa" style="background-color: #546e7a;width: 115px;height: 60px;margin: 0 0 20px;">
                                                                            <span class="fa fa-pause"></span><br>Inicio Pausa
                                                                        </button>
                                                                    </div>
                                                                    <div class="col col-md-2">
                                                                        <button type="button" class="btn  btn-block btnEntrada" name="btnFimSegundaPausa" id="btnFimSegundaPausa" style="background-color: #546e7a;width: 110px;height: 60px;margin: 0 0 20px;">
                                                                            <span class="fa fa-play"></span><br>Fim Pausa
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- <div class="col col-1"></div> -->
                                                        </div>
                                                        <div class="col col-xs-12" style="margin-top: 15px;">
                                                            <div class="col col-xs-3">

                                                                <button type="button" class="btn  btn-block btnEntrada" name="btnEntrada" id="btnEntrada" style="height: 100px; background-color:#05ad4f;" disabled>
                                                                    <span class="fa fa-sign-in"></span><br>Entrada<br><label style="font-weight: bold;" id="labelEntrada"></label>
                                                                </button>
                                                            </div>
                                                            <div class="col col-xs-3">
                                                                <button type="button" class="btn  btn-block btnInicioAlmoco" id="btnInicioAlmoco" style=" background: #29c4e3; height:100px;" disabled>
                                                                    <span class="fa fa-cutlery "></span><br> Inicio Intervalo<br><label style="font-weight: bold;" id="labelInicioAlmoco"></label>
                                                                </button>
                                                            </div>
                                                            <div class="col col-xs-3">
                                                                <button type="button" class="btn  btn-block btnFimAlmoco" id="btnFimAlmoco" style="background: #d9d216; height:100px; " disabled>
                                                                    <span class="fa fa-cutlery"></span><br> Fim Intervalo<br><label style="font-weight: bold;" id="labelFimAlmoco"></label>
                                                                </button>
                                                            </div>
                                                            <div class="col col-xs-3">
                                                                <button type="button" class="btn  btn-block btnSaida" id="btnSaida" style="height: 100px;  background-color:#c42121;" disabled>
                                                                    <span class="fa fa-sign-out"></span><br>Saida<br><label style="font-weight: bold;" id="labelSaida"></label>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <div class="col col-xs-10">
                                                            <div class="col col-md-2"><br>
                                                                <div class="form-group">
                                                                    <div class="input-group" data-align="top" data-autoclose="true">
                                                                        <input id="xx" name="xx" type="text" class="hidden" style="height: 40px; border-radius: 0px !important;" data-autoclose="true" value="" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col col-md-2"><br>
                                                                <div class="form-group">
                                                                    <label id="labelHora" class="label">Atraso</label>
                                                                    <div class="input-group" data-align="top" data-autoclose="true">
                                                                        <input id="atraso" name="atraso" type="text" class="text-center form-control" placeholder="00:00:00" style="height: 40px; border-radius: 0px !important;" data-autoclose="true" data-mask="99:99:99" value="" readonly>
                                                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col col-md-2"><br>
                                                                <div class="form-group">
                                                                    <label id="labelHora" class="label">Hora Extra</label>
                                                                    <div class="input-group" data-align="top" data-autoclose="true">
                                                                        <input id="horaExtra" name="horaExtra" type="text" class="text-center form-control" placeholder="00:00:00" style="height: 40px; border-radius: 0px !important;" data-autoclose="true" data-mask="99:99:99" value="" readonly>
                                                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col col-md-3"><br>
                                                                <label class="label" for="lancamento">Ocorrência/Lançamento</label>
                                                                <label class="select">
                                                                    <select id="lancamento" name="lancamento" style="height: 40px; border-radius: 0px !important;">
                                                                        <!-- <option selected value=""></option> -->
                                                                        <?php

                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, descricao FROM dbo.lancamento where ativo = 1 ORDER BY codigo";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            // $codigo = $row['codigo'];
                                                                            $codigo = $row['codigo'];
                                                                            $descricao = $row['descricao'];
                                                                            echo '<option value=' . $codigo . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </div>
                                                            <div class="col col-3"> 
                                                                <label class="label" for="lancamento"></label>
                                                                <button type="button" class="btn  btn-block btnLancamento" id="btnLancamento" style="height: 50px;  background-color:#FF8C00;">
                                                                    <span class="">Lançar Ocorrência</span><br>
                                                                </button><br>
                                                            </div>
                                                        </div>

                                                        <input id="mesAno" name="mesAno" type="text" class="hidden">
                                                        <input id="horaAtual" name="horaAtual" type="text" class="hidden">
                                                        <input id="horaEntrada" name="horaEntrada" type="text" class="hidden">
                                                        <input id="horaSaida" name="horaSaida" type="text" class="hidden">
                                                        <input id="inicioAlmoco" name="inicioAlmoco" type="text" class="hidden">
                                                        <input id="fimAlmoco" name="fimAlmoco" type="text" class="hidden">
                                                        <input id="horarioAlmocoTolerado" name="horarioAlmocoTolerado" type="text" class="hidden">
                                                        <input id="status" name="status" type="text" class="hidden">
                                                        <input id="registraAlmoco" name="registraAlmoco" type="text" class="hidden">
                                                        <input id="tipoEscala" name="tipoEscala" type="text" class="hidden">
                                                        <input id="escalaDia" name="escalaDia" type="text" class="hidden">
                                                        <input id="layoutFolhaPonto" name="layoutFolhaPonto" type="text" class="hidden">
                                                        <input id="registraPausa" name="registraPausa" type="text" class="hidden">
                                                        <input id="inicioPrimeiraPausa" name="inicioPrimeiraPausa" type="text" class="hidden">
                                                        <input id="fimPrimeiraPausa" name="fimPrimeiraPausa" type="text" class="hidden">
                                                        <input id="inicioSegundaPausa" name="inicioSegundaPausa" type="text" class="hidden">
                                                        <input id="fimSegundaPausa" name="fimSegundaPausa" type="text" class="hidden">
                                                        <input id="horaEntradaEscala" type="text" class="hidden">
                                                        <input id="expedienteEscala" type="text" class="hidden">
                                                        <input id="horaSaidaEscala" type="text" class="hidden">
                                                        <input id="margemTolerancia" type="text" class="hidden">
                                                        <input id="IntervaloEscala" type="text" class="hidden">
                                                        <input id="atrasoAlmoco" type="text" class="hidden">
                                                        <input id="observacaoAtraso" type="text" class="hidden">
                                                        <input id="observacaoExtra" type="text" class="hidden">
                                                        <input id="horaTotalDia" type="text" class="hidden">
                                                        <input id="horasPositivasDia" type="text" class="hidden">
                                                        <input id="horasNegativasDia" type="text" class="hidden">


                                                        <input id="feriado" name="feriado" type="text" class="hidden">

                                                        <div class="row hidden">
                                                            <section class="col col-12">
                                                                <label class="label">Observações</label>
                                                                <textarea maxlength="500" id="observacao" name="observacao" class="form-control" rows="3" value="" style="resize:vertical"></textarea>
                                                            </section>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <footer>
                                        <button id="btnPdf" type="button" class="btn btn-primary" title="Gerar Pdf">
                                            <span class="fa fa-file-pdf-o"></span>
                                        </button>
                                        <!-- <a href="https://meuip.com.br" target="_blank"> <button id="btnVerificarIp" type="button" class="btn btn-success" title="Verificar Ip">
                                                Verificar meu Ip
                                            </button></a> -->
                                        <!-- Modal para quando der erro por não ter carregado a pagina por completo -->
                                        <div class="modal fade" id="modalErro" tabindex="-1" role="dialog" aria-labelledby="modalErro" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" align="center" id="modalErro"><i class='fa fa-warning'></i> Atenção
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <center>
                                                            <h5>Ponto não registrado! <br> Por favor tente novamente.</h5>
                                                        </center>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- MODAL FERIADO -->
                                        <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="dlgSimpleFeriado" aria-labelledby="ui-id-1" style="height: auto; width: 600px; top: 220px; left: 262px; display: none;">
                                            <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                                                <span id="ui-id-1" class="ui-dialog-title">
                                                </span>
                                            </div>
                                            <div id="dlgSimpleFeriado" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; max-height: none; height: auto;">
                                                <center>
                                                    <p>Hoje é feriado. <br> Deseja confirmar o registro do ponto?</p>
                                                </center>
                                            </div>
                                            <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
                                                <div class="ui-dialog-buttonset">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- MODAL REGISTRAR PONTO -->
                                        <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="dlgSimplePonto" aria-labelledby="ui-id-1" style="height: auto; width: 600px; top: 220px; left: 262px; display: none;">
                                            <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                                                <span id="ui-id-1" class="ui-dialog-title">
                                                </span>
                                            </div>
                                            <div id="dlgSimplePonto" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; max-height: none; height: auto;">
                                                <center>
                                                    <p id="alerta"></p>
                                                    <p>Deseja registrar ponto?</p>
                                                </center>
                                            </div>
                                            <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
                                                <div class="ui-dialog-buttonset">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal para aviso de hora extra sem autorização -->
                                        <div class="modal fade" id="modalAutorizacao" tabindex="-1" role="dialog" aria-labelledby="modalAutorizacao" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" align="center" id="modalAutorizacao"><i class='fa fa-warning'></i> Atenção
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <center>
                                                            <h5>Hora extra sem autorização</h5>
                                                        </center>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal comprovante registro de ponto -->
                                        <div class="modal fade" id="comprovanteRegistro" tabindex="-1" role="dialog" aria-labelledby="comprovanteRegistro" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" align="center" id="comprovanteRegistro">Comprovante de Registro de Ponto do Trabalhador
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <center>
                                                            <h5 id='dataComprovante'></h5>
                                                            <br>
                                                            <h5 id='horaComprovante'></h5>
                                                        </center>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- MODAL JUSTIFICATIVA ATRASO -->
                                        <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="dlgSimpleJustificativa" aria-labelledby="ui-id-1" style="height: auto; width: 600px; top: 220px; left: 262px; display: none;">
                                            <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                                                <span id="ui-id-1" class="ui-dialog-title">
                                                </span>
                                            </div>
                                            <div id="dlgSimpleJustificativa" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; max-height: none; height: auto;">
                                                <center>
                                                    <p id="titulo">Justificativa de Atraso</p>
                                                    <textarea maxlength="500" id="justificativa" name="justificativa" class="form-control" rows="3" value="" style="resize:vertical" required></textarea>
                                                </center>
                                            </div>
                                            <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
                                                <div class="ui-dialog-buttonset">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- MODAL JUSTIFICATIVA PAUSA FORA DO LIMITE -->
                                        <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="dlgSimpleJustificativaPausa" aria-labelledby="ui-id-1" style="height: auto; width: 600px; top: 220px; left: 262px; display: none;">
                                            <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                                                <span id="ui-id-1" class="ui-dialog-title">
                                                </span>
                                            </div>
                                            <div id="dlgSimpleJustificativaPausa" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; max-height: none; height: auto;">
                                                <center>
                                                    <p id="tituloPausa"></p>
                                                    <textarea maxlength="500" id="justificativaPausa" name="justificativaPausa" class="form-control" rows="3" value="" style="resize:vertical" required></textarea>
                                                </center>
                                            </div>
                                            <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
                                                <div class="ui-dialog-buttonset">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- MODAL REGISTRAR PAUSA -->
                                        <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="dlgSimplePausa" aria-labelledby="ui-id-1" style="height: auto; width: 600px; top: 220px; left: 262px; display: none;">
                                            <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                                                <span id="ui-id-1" class="ui-dialog-title">
                                                </span>
                                            </div>
                                            <div id="dlgSimplePausa" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; max-height: none; height: auto;">
                                                <center>
                                                    <p id="alertaPausa"></p>
                                                    <p>Deseja registrar pausa?</p>
                                                </center>
                                            </div>
                                            <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
                                                <div class="ui-dialog-buttonset">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal IP -->
                                        <div class="modal fade bd-example-modal-sm" id="modalIp" tabindex="-1" role="dialog" aria-labelledby="modalIp" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" align="center" id="modalIp"><i class='fa fa-warning'></i> Atenção
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <center>
                                                            <h5 id="ipInvalido"></h5>
                                                        </center>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </footer>
                                </form>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </section>
    </div>
    <!-- end widget grid -->
</div>
<!-- END MAIN CONTENT -->
</div>
<!-- END MAIN PANEL -->

<!-- ==========================CONTENT ENDS HERE ========================== -->

<!-- PAGE FOOTER -->
<?php
include("inc/footer.php");
?>
<!-- END PAGE FOOTER -->

<?php
//include required scripts
include("inc/scripts.php");
?>

<script src="<?php echo ASSETS_URL; ?>/js/business_pontoEletronicoDiario.js" type="text/javascript"></script>

<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->
<!-- Flot Chart Plugin: Flot Engine, Flot Resizer, Flot Tooltip -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.cust.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.resize.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.time.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.tooltip.min.js"></script>

<!-- Vector Maps Plugin: Vectormap engine, Vectormap language -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- Full Calendar -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/moment/moment.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/moment/momentjs-business.js"></script>

<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/fullcalendar.js"></script>

<!-- Form to json -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/form2js.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/jquery.toObject.js"></script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script language="JavaScript" type="text/javascript">
    var tolerancia = $("#margemTolerancia").val();
    // var toleranciaExtra = "00:10:00";
    // var toleranciaAtraso = "00:10:00";
    var toleranciaDia = "";
    var btnClicado = "";
    var horaRetorno = "";
    var folgaCobertura = "";
    var modalHoraExtra = "";
    var verificaIp = "";
    var autorizacaoExtra = '';


    var arrDiasAlterados = [];
    $(document).ready(function() {
        resetaTempo();
        getHoraServidor();

        setInterval(() => {
            horaDisplay = moment(horaDisplay).add(1, 'seconds');
            document.getElementById("hora").innerHTML = moment(horaDisplay).format('HH:mm:ss');
        }, 1000);




        carregaPonto()


        $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
            _title: function(title) {
                if (!this.options.title) {
                    title.html("&#160;");
                } else {
                    title.html(this.options.title);
                }
            }
        }));


        $("#btnEntrada").on("click", function() {
            resetaTempo();
            var campo = 'Entrada';
            btnClicado = 'entrada';
            getHora(campo);

        });

        $("#btnSaida").on("click", function() {
            var inicioAlmoco = $("#inicioAlmoco").val();
            var fimAlmoco = $("#fimAlmoco").val();
            btnClicado = 'saida';
            resetaTempo();
            if (($("#btnInicioAlmoco").prop('disabled')) == false) {
                inicioAlmoco = "00:00:00";
                fimAlmoco = "00:00:00";
                $("#inicioAlmoco").val('00:00:00');
                $("#fimAlmoco").val('00:00:00');
            }
            if ((inicioAlmoco != "00:00:00") && (fimAlmoco == "00:00:00")) {
                $("#horaSaida").val('00:00:00');
                smartAlert("Atenção", "Registre primeiro o fim do Intervalo!", "error");
                return false;
            }



            var campo = 'Saida';
            getHora(campo);
        });

        $("#btnInicioAlmoco").on("click", function() {
            resetaTempo();
            var entrada = $("#horaEntrada").val();
            if (entrada == "00:00:00") {
                $("#inicioAlmoco").val('00:00:00');
                smartAlert("Atenção", "Registre primeiro a hora de entrada!", "error");
                return false;
            }
            var campo = 'Inicio Almoço';
            btnClicado = 'inicioAlmoco';
            getHora(campo);
        });

        $("#btnFimAlmoco").on("click", function() {
            resetaTempo();
            var inicioAlmoco = $("#inicioAlmoco").val();
            if (inicioAlmoco == "00:00:00") {
                $("#fimAlmoco").val('00:00:00');
                smartAlert("Atenção", "Registre primeiro o inicio do Intervalo!", "error");
                return false;
            }
            var campo = 'Fim Almoço';
            btnClicado = 'fimAlmoco';
            getHora(campo);
        });

        $("#btnLancamento").on("click", function() {
            resetaTempo();
            var lancamento = $("#lancamento").val()
            var dataAtual = new Date();
            var dia = dataAtual.getDate();
            var horaEntrada = $("#horaEntrada").val();
            var horaSaida = $("#horaSaida").val();
            var atraso = $("#atraso").val();
            var extra = $("#horaExtra").val();
            btnClicado = 'lancamento';

            if (lancamento == "") {
                smartAlert("Atenção", "Selecione um lançamento!", "error");
                return;
            } else {
                gravarLancamento()
            }
        });


        $('#btnPdf').on("click", function() {
            // resetaTempo();
            imprimir();
        });

        var avisaFolga = <?php echo $avisoFolga ?>

        if (avisaFolga == 1) {
            avisoDaFolga()
        }

        $('#dlgSimpleFeriado').dialog({
            autoOpen: false,
            width: 400,
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4><i class='fa fa-warning'></i> Atenção</h4></div>",
            buttons: [{
                html: "Confirmar",
                "class": "btn btn-success",
                click: function() {
                    $(this).dialog("close");
                    $('#dlgSimpleFeriado').css('display', 'none');
                    $("#feriado").val(1);
                    // gravar();
                    enviarEmail();
                }
            }, {
                html: "<i class='fa fa-times'></i>&nbsp; Cancelar",
                "class": "btn btn-default",
                click: function() {
                    $(this).dialog("close");
                    return;
                }
            }]
        });

        $('#dlgSimplePonto').dialog({
            autoOpen: false,
            width: 400,
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4><i class='fa fa-warning'></i> Atenção</h4></div>",
            buttons: [{
                html: "Confirmar",
                "class": "btn btn-success",
                click: function() {
                    $(this).dialog("close");
                    $('#dlgSimplePonto').css('display', 'none');
                    let expediente = $("#expediente").text();
                    if (!expediente) {
                        expediente = '00:00 - 00:00';
                    }
                    expediente = expediente.split("-");
                    inicioExpediente = parse(expediente[0].trim());
                    fimExpediente = parse(expediente[1].trim());

                    var entrada = parse($("#horaEntrada").val());
                    var saida = parse($("#horaSaida").val());
                    var tolerancia = $("#margemTolerancia").val();
                    toleranciaEntrada = inicioExpediente + parse(tolerancia);
                    toleranciaSaida = fimExpediente + parse(tolerancia);
                    if ((btnClicado == 'entrada') && (entrada > toleranciaEntrada)) {
                        justificar(btnClicado);
                    } else if ((btnClicado == 'saida') && (saida > toleranciaSaida)) {
                        justificar(btnClicado);
                    } else {
                        gravar();
                        enviarEmail();
                    }
                }
            }, {
                html: "<i class='fa fa-times'></i>&nbsp; Cancelar",
                "class": "btn btn-default",
                click: function() {
                    $(this).dialog("close");
                    // location.reload();
                }
            }]
        });

        $("#dlgSimplePonto").dialog("widget").find(".ui-dialog-titlebar-close").hide();


        $('#dlgSimplePausa').dialog({
            autoOpen: false,
            width: 400,
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4><i class='fa fa-warning'></i> Atenção</h4></div>",
            buttons: [{
                html: "Confirmar",
                "class": "btn btn-success",
                click: function() {
                    $(this).dialog("close");
                    $('#dlgSimplePausa').css('display', 'none');
                    registraPausa(btnClicado);
                }
            }, {
                html: "<i class='fa fa-times'></i>&nbsp; Cancelar",
                "class": "btn btn-default",
                click: function() {
                    $(this).dialog("close");
                    location.reload();
                }
            }]
        });

        $("#dlgSimplePausa").dialog("widget").find(".ui-dialog-titlebar-close").hide();

        $('#comprovanteRegistro').on('hide.bs.modal', (e) => {
            // e.preventDefault();
            e.stopPropagation();

            if (modalHoraExtra != 1) {
                voltar();
            }
        });

        $('#modalAutorizacao').on('hide.bs.modal', (e) => {
            e.stopPropagation();
            voltar();
        });

        $('#modalIp').on('hide.bs.modal', (e) => {
            e.stopPropagation();
            $("#ipInvalido").val('');
            // voltar();
        });

        $('#modalAutorizacao').on('show.bs.modal', (e) => {
            modalHoraExtra = 1;
        });

        $("#btnInicioPrimeiraPausa").on("click", function() {
            resetaTempo();
            var horaEntrada = $("#horaEntrada").val();
            var saida = $("#horaSaida").val();
            if (horaEntrada == '00:00:00') {
                $("#inicioPrimeiraPausa").val('')
                smartAlert("Atenção", "Registre primeiro a hora de entrada!", "error");
                return;
            }
            if (saida != '00:00:00') {
                $("#inicioPrimeiraPausa").val('')
                smartAlert("Atenção", "Não é possivel registrar pausa após a saida!", "error");
                return;
            }

            btnClicado = 'inicioPrimeiraPausa';
            getHora(btnClicado);
        });

        $("#btnFimPrimeiraPausa").on('click', function() {
            resetaTempo();
            var inicioPrimeiraPausa = $("#inicioPrimeiraPausa").val();
            var saida = $("#horaSaida").val();
            if (!inicioPrimeiraPausa) {
                $("#fimPrimeiraPausa").val('');
                smartAlert("Atenção", "Registre primeiro o inicio da pausa!", "error");
                return;
            }

            if (saida != '00:00:00') {
                $("#fimPrimeiraPausa").val('');
                smartAlert("Atenção", "Não é possivel registrar pausa após a saida!", "error");
                return;
            }

            btnClicado = 'fimPrimeiraPausa';
            getHora(btnClicado);
        });

        $("#btnInicioSegundaPausa").on("click", function() {
            resetaTempo();
            var inicioPrimeiraPausa = $("#inicioPrimeiraPausa").val();
            var fimPrimeiraPausa = $("#fimPrimeiraPausa").val();
            var inicioAlmoco = $("#inicioAlmoco").val();
            var fimAlmoco = $("#fimAlmoco").val();
            var saida = $("#horaSaida").val();

            if (saida != '00:00:00') {
                $("#inicioSegundaPausa").val('');
                smartAlert("Atenção", "Não é possivel registrar pausa após a saida!", "error");
                return;
            }

            btnClicado = 'inicioSegundaPausa';
            getHora(btnClicado);
        });

        $("#btnFimSegundaPausa").on('click', function() {
            resetaTempo();
            var inicioSegundaPausa = $("#inicioSegundaPausa").val();
            var saida = $("#horaSaida").val();
            if (!inicioSegundaPausa) {
                $("#fimSegundaPausa").val('');
                smartAlert("Atenção", "Registre primeiro o inicio da pausa!", "error");
                return;
            }

            if (saida != '00:00:00') {
                $("#fimSegundaPausa").val('');
                smartAlert("Atenção", "Não é possivel registrar pausa após a saida!", "error");
                return;
            }

            btnClicado = 'fimSegundaPausa';
            getHora(btnClicado);
        });

        $('#dlgSimpleJustificativa').dialog({
            autoOpen: false,
            width: 400,
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4><i class='fa fa-warning'></i> Atenção</h4></div>",
            buttons: [{
                html: "Gravar",
                "class": "btn btn-success",
                click: function() {
                    var justificativa = $("#justificativa").val();
                    $("#observacao").val(justificativa);
                    $(this).dialog("close");
                    $('#dlgSimpleJustificativa').css('display', 'none');
                    gravar();
                    enviarEmail();
                }
            }, {
                html: "<i class='fa fa-times'></i>&nbsp; Cancelar",
                "class": "btn btn-default",
                click: function() {
                    $(this).dialog("close");
                    location.reload();
                }
            }]
        });
        $("#dlgSimpleJustificativa").dialog("widget").find(".ui-dialog-titlebar-close").hide();

        $('#dlgSimpleJustificativaPausa').dialog({
            autoOpen: false,
            width: 400,
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4><i class='fa fa-warning'></i> Atenção</h4></div>",
            buttons: [{
                html: "Gravar",
                "class": "btn btn-success",
                click: function() {
                    $(this).dialog("close");
                    $('#dlgSimpleJustificativaPausa').css('display', 'none');
                    registraPausa(btnClicado);
                }
            }, {
                html: "<i class='fa fa-times'></i>&nbsp; Cancelar",
                "class": "btn btn-default",
                click: function() {
                    $(this).dialog("close");
                    location.reload();
                }
            }]
        });
        $("#dlgSimpleJustificativaPausa").dialog("widget").find(".ui-dialog-titlebar-close").hide();

        // getIpClient();
        // carregaPonto();
        recuperaDados();
    });

    function gravar() {
        var dataAtual = new Date();
        var dia = dataAtual.getDate();
        var mes = dataAtual.getMonth();


        mes += 1;

        //Botão que desabilita a gravação até que ocorra uma mensagem de erro ou sucesso.
        $("#btnEntrada").prop('disabled', true);
        $("#btnSaida").prop('disabled', true);
        $("#btnInicioAlmoco").prop('disabled', true);
        $("#btnFimAlmoco").prop('disabled', true);

        var codigo = $("#codigo").val();
        var idFolha = $("#idFolha").val();
        var horaEntrada = $("#horaEntrada").val();
        var inicioAlmoco = $("#inicioAlmoco").val();
        var fimAlmoco = $("#fimAlmoco").val();
        var tolerancia = $("#margemTolerancia").val();
        var intervalo = $("#IntervaloEscala").val();
        var horaSaida = $("#horaSaida").val();
        var justificativaAtraso = $("#observacaoAtraso").val();
        var justificativaExtra = $("#observacaoExtra").val();
        var lancamento = $("#lancamento").val();


        //HORA ENTRADA SETADA NA ESCALA
        var horaEntradaEscala = $("#horaEntradaEscala").val();
        var horaEntradaEscalaPartida = horaEntradaEscala.split(":");
        var hhEntradaEscala = Number(horaEntradaEscalaPartida[0]);
        var mmEntradaEscala = Number(horaEntradaEscalaPartida[1]);
        var ssEntradaEscala = Number(horaEntradaEscalaPartida[2]);

        //MARGEM DE TOLERANCIA
        var toleranciaPartida = tolerancia.split(":");
        var hhTolerancia = Number(toleranciaPartida[0]);
        var mmTolerancia = Number(toleranciaPartida[1]);
        var ssTolerancia = Number(toleranciaPartida[2]);

        //HORARIO TOLERADO ENTRADA (SOMA DA ESCALA COM A MARGEM DE TOLERANCIA)
        var hhEntradaTolerado = Number(hhEntradaEscala) + Number(hhTolerancia);
        var mmEntradaTolerado = Number(mmEntradaEscala) + Number(mmTolerancia);
        var ssEntradaTolerado = Number(ssEntradaEscala) + Number(ssTolerancia);
        var horarioEntradaTolerado = hhEntradaTolerado + ":" + mmEntradaTolerado + ":" + ssEntradaTolerado;

        //HORARIO DE ENTRADA DO FUNCIONARIO DIVIDIDO
        var horaEntradaPartida = horaEntrada.split(":");
        var hhEntrada = Number(horaEntradaPartida[0]);
        var mmEntrada = Number(horaEntradaPartida[1]);
        var ssEntrada = Number(horaEntradaPartida[2]);

        //CALCULO DE ATRASO
        var hhAtraso = hhEntrada - hhEntradaEscala;
        var mmAtraso = mmEntrada - mmEntradaEscala;
        var ssAtraso = ssEntrada - ssEntradaEscala;

        if (ssAtraso > 60) {
            ssAtraso = ssAtraso - 60;
            mmAtraso += 1;
        }
        if (mmAtraso > 60) {
            mmAtraso = mmAtraso - 60;
            hhAtraso += 1;
        }
        //formatacão das horas
        if (hhAtraso.toString().length == 1) {
            hhAtraso = "0" + hhAtraso;
        }
        if (mmAtraso.toString().length == 1) {
            mmAtraso = "0" + mmAtraso;
        }
        if (ssAtraso.toString().length == 1) {
            ssAtraso = "0" + ssAtraso;
        }
        //validacao da tolerancia
        if (hhAtraso >= hhTolerancia && mmAtraso >= mmTolerancia && ssAtraso > hhTolerancia) {
            var atraso = hhAtraso + ":" + mmAtraso + ":" + ssAtraso;
        } else {
            atraso = "00:00:00";
            hhAtraso = "00";
            mmAtraso = "00";
            ssAtraso = "00";
        }

        if (horaEntrada == "00:00:00") {
            atraso = "00:00:00";

        }

        //==========================================================================================================

        //INTERVALO
        var intervaloPartido = intervalo.split(":");
        var hhIntervalo = Number(intervaloPartido[0]);
        var mmIntervalo = Number(intervaloPartido[1]);
        var ssIntervalo = Number(intervaloPartido[2]);

        //HORARIO DO INICIO DO INTERVALO DO FUNCIONARIO DIVIDIDO
        var inicioAlmocoPartido = inicioAlmoco.split(":");
        var hhInicioAlmoco = Number(inicioAlmocoPartido[0]);
        var mmInicioAlmoco = Number(inicioAlmocoPartido[1]);
        var ssInicioAlmoco = Number(inicioAlmocoPartido[2]);

        var hhAlmocoTolerado = Number(hhInicioAlmoco) + Number(hhIntervalo);
        var mmAlmocoTolerado = Number(mmInicioAlmoco) + Number(mmIntervalo);
        var ssAlmocoTolerado = Number(ssInicioAlmoco) + Number(ssIntervalo);

        //FORMATACAO DE HORARIO TOLERADO
        if (ssAlmocoTolerado > 60) {
            ssAlmocoTolerado = ssAlmocoTolerado - 60;
            mmAlmocoTolerado += 1;
        }
        if (mmAlmocoTolerado > 60) {
            mmAlmocoTolerado = mmAlmocoTolerado - 60;
            hhAlmocoTolerado += 1;
        }
        if (hhAlmocoTolerado.toString().length == 1) {
            hhAlmocoTolerado = "0" + hhAlmocoTolerado;
        }
        if (mmAlmocoTolerado.toString().length == 1) {
            mmAlmocoTolerado = "0" + mmAlmocoTolerado;
        }
        if (ssAlmocoTolerado.toString().length == 1) {
            ssAlmocoTolerado = "0" + ssAlmocoTolerado;
        }

        var horarioAlmocoTolerado = hhAlmocoTolerado + ":" + mmAlmocoTolerado + ":" + ssAlmocoTolerado;


        //HORARIO DO FIM DO INTERVALO DO FUNCIONARIO DIVIDIDO
        //  fimAlmoco = "14:09:05";//aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
        var fimAlmocoPartido = fimAlmoco.split(":");
        var hhFimAlmoco = Number(fimAlmocoPartido[0]);
        var mmFimAlmoco = Number(fimAlmocoPartido[1]);
        var ssFimAlmoco = Number(fimAlmocoPartido[2]);



        //ATRASO DE INTERVALO
        if (fimAlmoco != "00:00:00") {
            var hhAtrasoIntervalo = hhFimAlmoco - hhAlmocoTolerado;
            var mmAtrasoIntervalo = mmFimAlmoco - mmAlmocoTolerado;
            var ssAtrasoIntervalo = ssFimAlmoco - ssAlmocoTolerado;
        } else {
            var hhAtrasoIntervalo = 0;
            var mmAtrasoIntervalo = 0;
            var ssAtrasoIntervalo = 0;
        }

        if (Number(ssAtrasoIntervalo) < 0 || Number(mmAtrasoIntervalo) < 0 || Number(hhAtrasoIntervalo) < 0) {
            atrasoAlmoco = "00:00:00";
        } else {
            if (ssAtrasoIntervalo > 60) {
                ssAtrasoIntervalo = ssAtrasoIntervalo - 60;
                mmAtrasoIntervalo += 1;
            }
            if (mmAtrasoIntervalo > 60) {
                mmAtrasoIntervalo = mmAtrasoIntervalo - 60;
                hhAtrasoIntervalo += 1;
            }
            //formatacão das horas
            if (hhAtrasoIntervalo.toString().length == 1) {
                hhAtrasoIntervalo = "0" + hhAtrasoIntervalo;
            }
            if (mmAtrasoIntervalo.toString().length == 1) {
                mmAtrasoIntervalo = "0" + mmAtrasoIntervalo;
            }
            if (ssAtrasoIntervalo.toString().length == 1) {
                ssAtrasoIntervalo = "0" + ssAtrasoIntervalo;
            }

            //validacao da tolerancia
            if (hhAtrasoIntervalo >= hhIntervalo || mmAtrasoIntervalo >= mmIntervalo && ssAtrasoIntervalo > ssIntervalo) {
                var atrasoAlmoco = hhAtrasoIntervalo + ":" + mmAtrasoIntervalo + ":" + ssAtrasoIntervalo;
            } else {
                atrasoAlmoco = "00:00:00";
            }
        }


        $("#atrasoAlmoco").val(atrasoAlmoco);
        //======================================================================================================================

        //HORA SAIDA SETADA NA ESCALA
        var horaSaidaEscala = $("#horaSaidaEscala").val();
        var horaSaidaEscalaPartida = horaSaidaEscala.split(":");
        var hhSaidaEscala = Number(horaSaidaEscalaPartida[0]);
        var mmSaidaEscala = Number(horaSaidaEscalaPartida[1]);
        var ssSaidaEscala = Number(horaSaidaEscalaPartida[2]);

        //MARGEM DE TOLERANCIA
        var toleranciaPartida = tolerancia.split(":");
        var hhTolerancia = Number(toleranciaPartida[0]);
        var mmTolerancia = Number(toleranciaPartida[1]);
        var ssTolerancia = Number(toleranciaPartida[2]);

        //HORARIO TOLERADO SAIDA (SOMA DA ESCALA COM A MARGEM DE TOLERANCIA)
        var hhSaidaTolerado = Number(hhSaidaEscala) + Number(hhTolerancia);
        var mmSaidaTolerado = Number(mmSaidaEscala) + Number(mmTolerancia);
        var ssSaidaTolerado = Number(ssSaidaEscala) + Number(ssTolerancia);
        var horarioSaidaTolerado = hhSaidaTolerado + ":" + mmSaidaTolerado + ":" + ssSaidaTolerado;

        //HORARIO DE SAIDA DO FUNCIONARIO DIVIDIDO
        var horaSaidaPartida = horaSaida.split(":");
        var hhSaida = Number(horaSaidaPartida[0]);
        var mmSaida = Number(horaSaidaPartida[1]);
        var ssSaida = Number(horaSaidaPartida[2]);

        if (hhSaida >= hhSaidaTolerado && mmSaida <= mmSaidaTolerado && ssSaida <= ssSaidaTolerado) {
            //CALCULO DE EXTRA por saida
            var hhExtra = hhSaida - hhSaidaEscala;
            var mmExtra = mmSaida - mmSaidaEscala;
            var ssExtra = ssSaida - ssSaidaEscala;

        } else {
            hhExtra = "00";
            mmExtra = "00";
            ssExtra = "00";
        }


        //////////////////////////////////////


        var hhEntradaPermitida = hhEntradaEscala + hhTolerancia;
        var mmEntradaPermitida = mmEntradaEscala + mmTolerancia;
        var ssEntradaPermitida = ssEntradaEscala + ssTolerancia;


        if (hhEntrada <= hhEntradaPermitida || mmEntrada <= mmEntradaPermitida || ssEntrada <= ssEntradaPermitida) {
            //calculo de hora extra por entrada
            var hhExtraEntrada = hhEntradaEscala - hhEntrada;
            var mmExtraEntrada = mmEntradaEscala - mmEntrada;
            var ssExtraEntrada = ssEntradaEscala - ssEntrada;
        } else {
            hhExtraEntrada = "00";
            mmExtraEntrada = "00";
            ssExtraEntrada = "00";
        }


        if (Number(hhExtraEntrada) < 0) {
            hhExtraEntrada = hhExtraEntrada * -1;
        }
        if (Number(mmExtraEntrada) < 0) {
            mmExtraEntrada = mmExtraEntrada * -1;
        }
        if (Number(ssExtraEntrada) < 0) {
            ssExtraEntrada = ssExtraEntrada * -1;
        }




        if (ssExtra >= 60) {
            ssExtra = ssExtra - 60;
            mmExtra += 1;
        }
        if (mmExtra >= 60) {
            mmExtra = mmExtra - 60;
            hhExtra += 1;
        }
        //formatacão das horas
        if (hhExtra.toString().length == 1) {
            hhExtra = "0" + hhExtra;
        }
        if (mmExtra.toString().length == 1) {
            mmExtra = "0" + mmExtra;
        }
        if (ssExtra.toString().length == 1) {
            ssExtra = "0" + ssExtra;
        }
        //validacao da tolerancia
        horaExtra = hhExtra + ":" + mmExtra + ":" + ssExtra;
        if (horaExtra != "00:00:00") {
            smartAlert("Erro", "O funcionário possui horas extras", "erro");
        } else {
            horaExtra = "00:00:00";
        }



        //hora de saida permitida
        var hhSaidaPermitida = hhSaidaEscala - hhTolerancia;
        var mmSaidaPermitida = mmSaidaEscala - mmTolerancia;
        var ssSaidaPermitida = ssSaidaEscala - ssTolerancia;
        if (Number(hhSaidaPermitida) < 0) {
            hhSaidaPermitida = hhSaidaPermitida * -1;
        }
        if (Number(mmSaidaPermitida) < 0) {
            mmSaidaPermitida = 60 + mmSaidaPermitida;
            hhSaidaPermitida -= 1;
        }
        if (Number(ssSaidaPermitida) < 0) {
            ssSaidaPermitida = 60 + ssSaidaPermitida;
            mmSaidaPermitida -= 1;
        }


        var hhSaidaAdiantada = hhSaidaPermitida - hhSaida;
        var mmSaidaAdiantada = mmSaidaPermitida - mmSaida;
        var ssSaidaAdiantada = ssSaidaPermitida - ssSaida;

        if (Number(hhSaidaAdiantada) < 0) {
            hhSaidaAdiantada = hhSaidaAdiantada * -1;
        }
        if (Number(mmSaidaAdiantada) < 0) {
            mmSaidaAdiantada = mmSaidaAdiantada * -1;
        }
        if (Number(ssSaidaAdiantada) < 0) {
            ssSaidaAdiantada = ssSaidaAdiantada * -1;
        }

        if (hhSaidaAdiantada.toString().length == 1) {
            hhSaidaAdiantada = "0" + hhSaidaAdiantada;
        }
        if (mmSaidaAdiantada.toString().length == 1) {
            mmSaidaAdiantada = "0" + mmSaidaAdiantada;
        }
        if (ssSaidaAdiantada.toString().length == 1) {
            ssSaidaAdiantada = "0" + ssSaidaAdiantada;
        }

        var horaSaidaAdiantada = hhSaidaAdiantada + ":" + mmSaidaAdiantada + ":" + ssSaidaAdiantada;


        if (horaSaidaAdiantada != "00:00:00") {
            //calculo de hora extra por Saida
            var hhSaidaAdiantada = hhSaidaEscala - hhSaida;
            var mmSaidaAdiantada = mmSaidaEscala - mmSaida;
            var ssSaidaAdiantada = ssSaidaEscala - ssSaida;
            if (Number(hhSaidaAdiantada) < 0) {
                hhSaidaAdiantada = hhSaidaAdiantada * -1;
            }
            if (Number(mmSaidaAdiantada) < 0) {
                mmSaidaAdiantada = mmSaidaAdiantada * -1;
            }
            if (Number(ssSaidaAdiantada) < 0) {
                ssSaidaAdiantada = ssSaidaAdiantada * -1;
            }

            if (hhSaidaAdiantada.toString().length == 1) {
                hhSaidaAdiantada = "0" + hhSaidaAdiantada;
            }
            if (mmSaidaAdiantada.toString().length == 1) {
                mmSaidaAdiantada = "0" + mmSaidaAdiantada;
            }
            if (ssSaidaAdiantada.toString().length == 1) {
                ssSaidaAdiantada = "0" + ssSaidaAdiantada;
            }
        } else {
            hhSaidaAdiantada = "00";
            mmSaidaAdiantada = "00";
            ssSaidaAdiantada = "00";
        }


        //total de horas NEGATIVAS
        var hhNegativas = Number(hhAtraso) + Number(hhAtrasoIntervalo) + Number(hhSaidaAdiantada);
        var mmNegativas = Number(mmAtraso) + Number(mmAtrasoIntervalo) + Number(mmSaidaAdiantada);
        var ssNegativas = Number(ssAtraso) + Number(ssAtrasoIntervalo) + Number(ssSaidaAdiantada);
        if (Number(hhNegativas) < 0) {
            hhNegativas = hhNegativas * -1;
        }
        if (Number(mmNegativas) < 0) {
            mmNegativas = mmNegativas * -1;
        }
        if (Number(ssNegativas) < 0) {
            ssNegativas = ssNegativas * -1;
        }

        if (hhNegativas.toString().length == 1) {
            hhNegativas = "0" + hhNegativas;
        }
        if (mmNegativas.toString().length == 1) {
            mmNegativas = "0" + mmNegativas;
        }
        if (ssNegativas.toString().length == 1) {
            ssNegativas = "0" + ssNegativas;
        }


        //total de horas POSITIVAS
        var hhPositivas = Number(hhExtra) + Number(hhExtraEntrada);
        var mmPositivas = Number(mmExtra) + Number(mmExtraEntrada);
        var ssPositivas = Number(ssExtra) + Number(ssExtraEntrada);



        if (ssPositivas >= 60) {
            ssPositivas = ssPositivas - 60;
            mmPositivas += 1;
        }
        if (mmPositivas >= 60) {
            mmPositivas = mmPositivas - 60;
            hhPositivas += 1;
        }
        if (hhPositivas.toString().length == 1) {
            hhPositivas = "0" + hhPositivas;
        }
        if (mmPositivas.toString().length == 1) {
            mmPositivas = "0" + mmPositivas;
        }
        if (ssPositivas.toString().length == 1) {
            ssPositivas = "0" + ssPositivas;
        }




        //VALOR DO EXPEDIENTE TOTAL DO FUNCIONARIOlet horaPartida =  hora.split(' ');

        var expedienteEscala = $("#expedienteEscala").val();
        var expedienteEscalaPartida = expedienteEscala.split(":");
        var hhExpedienteEscala = Number(expedienteEscalaPartida[0]);
        var mmExpedienteEscala = Number(expedienteEscalaPartida[1]);
        var ssExpedienteEscala = Number(expedienteEscalaPartida[2]);

        if (hhExpedienteEscala.toString().length == 1) {
            hhExpedienteEscala = "0" + hhExpedienteEscala;
        }
        if (mmExpedienteEscala.toString().length == 1) {
            mmExpedienteEscala = "0" + mmExpedienteEscala;
        }
        if (ssExpedienteEscala.toString().length == 1) {
            ssExpedienteEscala = "0" + ssExpedienteEscala;
        }

        var hhTotalDia = Number(hhExpedienteEscala) + Number(hhPositivas) - Number(hhNegativas);
        var mmTotalDia = Number(mmExpedienteEscala) + Number(mmPositivas) - Number(mmNegativas);
        var ssTotalDia = Number(ssExpedienteEscala) + Number(ssPositivas) - Number(ssNegativas);

        var hhTotalDia = hhSaida - hhEntrada;
        var mmTotalDia = mmSaida - mmEntrada;
        var ssTotalDia = ssSaida - ssEntrada;

        if (ssTotalDia < 0) {
            ssTotalDia = 60 + ssTotalDia; // SOMANDO POIS O VALOR PASSA COMO NEGATIVO E "(+)+(-)" = "-"
            mmTotalDia -= 1;
        }
        if (mmTotalDia < 0) {
            mmTotalDia = 60 + mmTotalDia;
            hhTotalDia -= 1;
        }



        if (hhTotalDia.toString().length == 1) {
            hhTotalDia = "0" + hhTotalDia;
        }
        if (mmTotalDia.toString().length == 1) {
            mmTotalDia = "0" + mmTotalDia;
        }
        if (ssTotalDia.toString().length == 1) {
            ssTotalDia = "0" + ssTotalDia;
        }

        //////////aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
        var hhPositivas = hhTotalDia - hhExpedienteEscala;
        var mmPositivas = mmTotalDia - mmExpedienteEscala;
        var ssPositivas = ssTotalDia - ssExpedienteEscala;

        if (ssPositivas < 0) {
            ssPositivas = 60 + ssPositivas; // SOMANDO POIS O VALOR PASSA COMO NEGATIVO E "(+)+(-)" = "-"
            mmPositivas -= 1;
        }
        if (mmPositivas < 0) {
            mmPositivas = 60 + mmPositivas;
            hhPositivas -= 1;
        }
        if (hhPositivas.toString().length == 1) {
            hhPositivas = "0" + hhPositivas;
        }
        if (mmPositivas.toString().length == 1) {
            mmPositivas = "0" + mmPositivas;
        }
        if (ssPositivas.toString().length == 1) {
            ssPositivas = "0" + ssPositivas;
        }

        var hhNegativas = hhExpedienteEscala - hhTotalDia;
        var mmNegativas = mmExpedienteEscala - mmTotalDia;
        var ssNegativas = ssExpedienteEscala - ssTotalDia;

        if (ssNegativas < 0) {
            ssNegativas = 60 + ssNegativas; // SOMANDO POIS O VALOR PASSA COMO NEGATIVO E "(+)+(-)" = "-"
            mmNegativas -= 1;
        }
        if (mmNegativas < 0) {
            mmNegativas = 60 + mmNegativas;
            hhNegativas -= 1;
        }

        if (hhNegativas.toString().length == 1) {
            hhNegativas = "0" + hhNegativas;
        }
        if (mmNegativas.toString().length == 1) {
            mmNegativas = "0" + mmNegativas;
        }
        if (ssNegativas.toString().length == 1) {
            ssNegativas = "0" + ssNegativas;
        }



        //controle da horas positivas
        if (hhTotalDia >= hhExpedienteEscala && mmTotalDia >= mmExpedienteEscala && ssTotalDia >= ssExpedienteEscala) {
            var horasPositivasDiaOK = 1;
        } else {
            var horasPositivasDiaOK = 0;
        }
        if (hhTotalDia <= hhExpedienteEscala && mmTotalDia <= mmExpedienteEscala && ssTotalDia <= ssExpedienteEscala) {
            var horasNegativasDiaOK = 1;
        } else {
            var horasNegativasDiaOK = 0;
        }


        var horaTotalDia = hhTotalDia + ":" + mmTotalDia + ":" + ssTotalDia;
        if (horaSaida != "00:00:00") {
            if (horasPositivasDiaOK = 1) {
                var horasPositivasDia = hhPositivas + ":" + mmPositivas + ":" + ssPositivas;
            }
            if (horasNegativasDiaOK = 1) {
                var horasNegativasDia = hhNegativas + ":" + mmNegativas + ":" + ssNegativas;
            }
        }


        if (hhPositivas < 0 || mmPositivas < 0 || ssPositivas < 0) {
            horasPositivasDia = "00:00:00";
        }
        if (hhNegativas < 0 || mmNegativas < 0 || ssNegativas < 0) {
            horasNegativasDia = "00:00:00";
        }
        if (hhTotalDia < 0 || mmTotalDia < 0 || ssTotalDia < 0) {
            horaTotalDia = "00:00:00";
        }


        //seletor de justificativa (de atraso na entrada ou na saida)
        if (horaSaida != "00:00:00") {
            var justificativaAtraso = $("#observacaoAtraso").val();
            var justificativaExtra = $("#justificativa").val();

        } else {
            var justificativaAtraso = $("#justificativa").val();
        }
        if (horasPositivasDia != "00:00:00") {
            horaExtra = horasPositivasDia;
        }

        //ALERTA DE ATRASO DE ENTRADA E DE SAIDA
        if (horaSaida == "00:00:00") {
            if (inicioAlmoco == "00:00:00") {
                if (fimAlmoco == "00:00:00") {

                    if (atraso != "00:00:00") {
                        smartAlert("Erro", "Você possui atraso!", "error");
                    }
                    
                    if (horaExtra != "00:00:00") {
                        smartAlert("Erro", "Você possui hora extra!", "primary");
                    }
                }
            }
        }






        $("#horarioAlmocoTolerado").val(horarioAlmocoTolerado);
        setTimeout(function() {
            gravarPonto(codigo, idFolha, dia, horaEntrada, inicioAlmoco, fimAlmoco, horaSaida, horaExtra, atraso, justificativaAtraso, justificativaExtra, atrasoAlmoco, horaTotalDia, horasPositivasDia, horasNegativasDia,
                function(data) {
                    if (data.indexOf('sucess') < 0) {
                        var piece = data.split("#");
                        var mensagem = piece[0];
                        if (mensagem == "success") {
                            smartAlert("Sucesso", "Ponto marcado com sucesso!", "success");
                            // return false;
                        } else {
                            smartAlert("Atenção", mensagem, "error");
                            // smartAlert("Atenção", "Operação não realizada - entre em contato com o suporte!", "error");
                            return false;
                        }
                    } else {
                        var piece = data.split("#");
                        var mensagem = piece[2];
                        if (!mensagem) {
                            smartAlert("Sucesso", "Ponto marcado com sucesso!", "success");

                        } else {
                            out = mensagem.split("#");
                            mensagem = out[0];
                            autorizacaoExtra = out[1];

                            smartAlert("Sucesso", "Ponto marcado com sucesso!", "success");

                            // smartAlert("Aviso", mensagem, "info");

                        }
                    }
                    location.reload();

                });
        }, 500)

    }

    function gravarLancamento() {
        const dataAtual = new Date();
        const dia = dataAtual.getDate();
        var codigo = $("#codigo").val();
        var idFolha = $("#idFolha").val();
        var lancamento = $("#lancamento").val();
        gravaLancamento(codigo, idFolha, dia, lancamento,
            function(data) {
                if (data.indexOf('sucess') < 0) {
                    var piece = data.split("#");
                    var mensagem = piece[0];
                    if (mensagem == "success") {
                        smartAlert("Sucesso", "Ocorrência lançada com sucesso!", "success");
                        // return false;
                    } else {
                        smartAlert("Atenção", mensagem, "error");
                        // smartAlert("Atenção", "Operação não realizada - entre em contato com o suporte!", "error");
                        return false;
                    }
                } else {
                    var piece = data.split("#");
                    var mensagem = piece[2];
                    if (!mensagem) {
                        smartAlert("Sucesso", "Ocorrência lançada com sucesso!", "success");

                    } else {
                        out = mensagem.split("#");
                        mensagem = out[0];
                        autorizacaoExtra = out[1];

                        smartAlert("Sucesso", "Ocorrência lançada com sucesso!", "success");
                        // smartAlert("Aviso", mensagem, "info");
                    }
                }
                location.reload();
            });
    }

    function voltar() {
        $(location).attr('href', 'funcionario_pontoEletronicoDiario.php');
    }


    function parse(horario) {
        // divide a string em duas partes, separado por dois-pontos, e transforma em número
        let [hora, minuto, segundos] = horario.split(':').map(v => parseInt(v));
        if (!minuto) { // para o caso de não ter os minutos
            minuto = 00;
        }

        if (!segundos) { // para o caso de não ter os segundos
            segundos = 0;
        }
        return segundos + (minuto * 60) + (hora * Math.pow(60, 2));
    }

    function duracao(inicioExpediente, fimExpediente) {
        return (parse(fimExpediente) - parse(inicioExpediente));
    }

    function carregaPonto() {
        var mesAno = moment().format('YYYY-MM');
        var dataAtual = new Date();
        var dia = dataAtual.getDate();


        var funcionario = $("#funcionario").val();

        $('#mesAno').val(mesAno);
        recuperaPonto(funcionario, mesAno, dia,
            function(data) {
                data = data.replace(/failed/g, '');
                var piece = data.split("#");

                var mensagem = piece[0];
                var out = piece[1];

                piece = out.split("^");

                //Atributos do funcionário
                var idFolha = piece[0];
                var codigo = piece[1];
                var funcionario = piece[2];
                var horaEntrada = piece[3] || '00:00:00';
                var inicioAlmoco = piece[4] || '00:00:00';
                var fimAlmoco = piece[5] || '00:00:00';
                var horaSaida = piece[6] || '00:00:00';
                var horaExtra = piece[7] || '00:00:00';
                var atraso = piece[8] || '00:00:00';
                var horaEntradaEscala = piece[9] || '00:00:00';
                var inicioIntervaloEscala = piece[10] || '00:00:00';
                var fimIntervaloEscala = piece[11] || '00:00:00';
                var horaSaidaEscala = piece[12] || '00:00:00';
                var expedienteEscala = piece[13] || '00:00:00';
                var intervaloEscala = piece[14] || '00:00:00';
                var segundaEscala = piece[15];
                var tercaEscala = piece[16];
                var quartaEscala = piece[17];
                var quintaEscala = piece[18];
                var sextaEscala = piece[19];
                var sabadoEscala = piece[20];
                var toleranciaEscala = piece[21] || '00:00:00';
                var justificativaAtraso = piece[22];
                var justificativaExtra = piece[23];
                var lancamento = piece[24];
                var atrasoAlmoco = piece[25] || '00:00:00';
                var horaTotalDia = piece[26] || '00:00:00';
                var horasPositivasDia = piece[27] || '00:00:00';
                var horasNegativasDia = piece[28] || '00:00:00';

                if (atraso != "00:00:00") {
                    // smartAlert("Atenção", "O funcionário possui atraso", "error")
                    $("#labelEntrada").css('font-weight', 'bold').css('color', 'red');
                    // $("#labelEntrada").css('color', 'red');
                }
                // if (horaExtra != "00:00:00") {
                // smartAlert("Atenção", "O funcionário possui horas extras", "erro");
                // $("#labelSaida").css('font-weight', 'bold').css('color', 'Cyan');
                // }



                $(`#labelEntrada`).text(horaEntrada);
                $(`#labelInicioAlmoco`).text(inicioAlmoco);
                $(`#labelFimAlmoco`).text(fimAlmoco);
                $(`#labelSaida`).text(horaSaida);
                $("#codigo").val(codigo);
                $("#idFolha").val(idFolha);
                $("#horaEntrada").val(horaEntrada);
                $("#inicioAlmoco").val(inicioAlmoco);
                $("#fimAlmoco").val(fimAlmoco);
                $("#horaSaida").val(horaSaida);
                $("#atraso").val(atraso);
                $("#horaExtra").val(horaExtra);
                $("#observacaoAtraso").val(justificativaAtraso);
                $("#observacaoExtra").val(justificativaExtra);
                $("#margemTolerancia").val(toleranciaEscala);
                $(`#horaEntradaEscala`).val(horaEntradaEscala);
                $(`#horaSaidaEscala`).val(horaSaidaEscala);
                $(`#expedienteEscala`).val(expedienteEscala);
                $(`#IntervaloEscala`).val(intervaloEscala);
                $(`#lancamento`).val(lancamento);
                $(`#atrasoAlmoco`).val(atrasoAlmoco);
                $(`#horaTotalDia`).val(horaTotalDia);
                $(`#horasPositivasDia`).val(horasPositivasDia);
                $(`#horasNegativasDia`).val(horasNegativasDia);
                $(`#horarioAlmocoTolerado`).val(horarioAlmocoTolerado);

                if (atrasoAlmoco !== "00:00:00") {
                    $("#labelFimAlmoco").css('font-weight', 'bold').css('color', 'red');
                }
                if (($("#labelEntrada").text()) == "00:00:00") {
                    $("#labelEntrada").text("");
                }
                if (($("#labelSaida").text()) == "00:00:00") {
                    $("#labelSaida").text("");
                }
                if (($("#labelInicioAlmoco").text()) == "00:00:00") {
                    $("#labelInicioAlmoco").text("");
                }
                if (($("#labelFimAlmoco").text()) == "00:00:00") {
                    $("#labelFimAlmoco").text("");
                }


                habilitaBotões();
                if (horaEntrada == "00:00:00") {
                    $("#btnSaida").prop('disabled', true);
                } else {
                    $("#btnEntrada").prop('disabled', true);
                }

                if (inicioAlmoco != "00:00:00") {
                    $("#btnInicioAlmoco").prop('disabled', true);
                }

                if (fimAlmoco != "00:00:00") {
                    $("#btnFimAlmoco").prop('disabled', true);
                }

                if (horaSaida != "00:00:00") {
                    $("#btnEntrada").prop('disabled', true);
                    $("#btnInicioAlmoco").prop('disabled', true);
                    $("#btnFimAlmoco").prop('disabled', true);
                    $("#btnSaida").prop('disabled', true);
                }

                var weekday = dataAtual.getDay();

            }
        );
    }


    function imprimir() {
        const idFolha = $('#idFolha').val();
        $(location).attr('href', 'prototipo_folhaDePontoPdfPontoEletronicoPDF.php?idFolha=' + idFolha);
    }





    function validaHoraAtual(horaAtual) {
        if ((horaAtual == "") || (horaAtual == " ") || (!horaAtual) || (horaAtual == '00:00:00')) {
            return false;
        }
        return true;
    }

    function validarIp(ip) {

        // var ip = $("#ip").val();
        var projeto = <?php echo $_SESSION['projeto']; ?>

        validaIp(ip, projeto,
            function(data) {
                if (data.indexOf('sucess') < 0) {
                    var piece = data.split("#");
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                        $("#ipInvalido").html("O IP " + ip + " não é permitido para registro de ponto!");
                        $("#modalIp").modal('show');
                        return false;
                    } else {
                        smartAlert("Atenção", "Operação não realizada - entre em contato com o suporte!", "error");
                        return false;
                    }
                } else {
                    carregaPonto()

                }
            }
        );
    }




    function desabilitaBotões() {
        $("#btnEntrada").prop('disabled', true);
        $("#btnSaida").prop('disabled', true);
        $("#btnInicioAlmoco").prop('disabled', true);
        $("#btnFimAlmoco").prop('disabled', true);
        $("#lancamento").prop('disabled', true);
        $("#btnLancamento").prop('disabled', true);

        $("#btnInicioPrimeiraPausa").prop('disabled', true);
        $("#btnFimPrimeiraPausa").prop('disabled', true);
        $("#btnInicioSegundaPausa").prop('disabled', true);
        $("#btnFimSegundaPausa").prop('disabled', true);

    }

    function habilitaBotões() {
        $("#btnEntrada").prop('disabled', false);
        $("#btnSaida").prop('disabled', false);
        $("#btnInicioAlmoco").prop('disabled', false);
        $("#btnFimAlmoco").prop('disabled', false);
        $("#lancamento").prop('disabled', false);
        $("#btnLancamento").prop('disabled', false);

        $("#btnInicioPrimeiraPausa").prop('disabled', false);
        $("#btnFimPrimeiraPausa").prop('disabled', false);
        $("#btnInicioSegundaPausa").prop('disabled', false);
        $("#btnFimSegundaPausa").prop('disabled', false);
    }


    function getHora(campo) {
        var campo = campo;
        var inicioAlmoco = $('#inicioAlmoco').val();
        var fimAlmoco = $('#fimAlmoco').val();
        var horarioAlmocoTolerado = $('#horarioAlmocoTolerado').val();

        selecionarHora(function(data) {

            if (data.indexOf('sucess') > -1) {
                var piece = data.split("#");
                var hora = piece[1];
                // var verificaIp = $("#verificaIp").val();
                var tipoEscala = $("#tipoEscala").val();

                let expediente = $("#expediente").text();
                if (!expediente) {
                    expediente = '00:00 - 00:00';
                }
                expediente = expediente.split("-");
                inicioExpediente = parse(expediente[0].trim());
                fimExpediente = parse(expediente[1].trim());

                let intervalo = $("#intervalo").text();
                if (!intervalo) {
                    intervalo = '00:00 - 00:00';
                }
                intervalo = intervalo.split("-");
                inicioIntervalo = parse(intervalo[0].trim());
                fimIntervalo = parse(intervalo[1].trim());

                let horarioPausa = $("#pausa").text();
                if (!horarioPausa) {
                    horarioPausa = '00:00 - 00:00';
                }
                horarioPausa = horarioPausa.split("|");
                horarioPrimeiraPausa = horarioPausa[0].split("-");
                horarioSegundaPausa = horarioPausa[1].split("-");

                inicioPrimeiraPausa = parse(horarioPrimeiraPausa[0].trim());
                fimPrimeiraPausa = parse(horarioPrimeiraPausa[1].trim());
                inicioSegundaPausa = parse(horarioSegundaPausa[0].trim());
                fimSegundaPausa = parse(horarioSegundaPausa[1].trim());

                totalHorasIntervalo = fimIntervalo - inicioIntervalo;
                totalHorasPrimeiraPausa = fimPrimeiraPausa - inicioPrimeiraPausa;
                totalHorasSegundaPausa = fimSegundaPausa - inicioSegundaPausa;

                if (campo == 'Entrada') {
                    if (validaHoraAtual(horaAtual) == false) {
                        $('#modalErro').modal('show');
                        return;
                    }
                    let horaPartida = hora.split(' ');
                    var hora = horaPartida[1];
                    var horaNova = hora.substring(0, 8);
                    let separador = horaNova.split(':');
                    let h = separador[0];
                    let m = separador[1];
                    let s = separador[2];

                    var hora = `${h}:${m}:${s}`;
                    $("#horaEntrada").val(hora)
                    campo = 'horaEntrada';

                    // var inicioIntervalo = $("#inicioAlmoco").val()
                    // horaRetorno = converteHora(parse(inicioIntervalo) + totalHorasIntervalo);

                }
                if (campo == 'Saida') {
                    if (validaHoraAtual(horaAtual) == false) {
                        $('#modalErro').modal('show');
                        return;
                    }
                    let horaPartida = hora.split(' ');
                    var hora = horaPartida[1];
                    var horaNova = hora.substring(0, 8);
                    let separador = horaNova.split(':');
                    let h = separador[0];
                    let m = separador[1];
                    let s = separador[2];

                    var hora = `${h}:${m}:${s}`;
                    $("#horaSaida").val(hora)
                    campo = 'horaSaida';

                    var inicioIntervalo = $("#inicioAlmoco").val()
                    horaRetorno = converteHora(parse(inicioIntervalo) + totalHorasIntervalo);

                }
                if (campo == 'Inicio Almoço') {
                    if (validaHoraAtual(hora) == false) {
                        $('#modalErro').modal('show');
                        return;
                    }
                    let horaPartida = hora.split(' ');
                    var hora = horaPartida[1];
                    var horaNova = hora.substring(0, 8);
                    let separador = horaNova.split(':');
                    let h = separador[0];
                    let m = separador[1];
                    let s = separador[2];

                    var hora = `${h}:${m}:${s}`;
                    $("#inicioAlmoco").val(hora)

                    campo = 'inicioAlmoco';
                }
                if (campo == 'Fim Almoço') {
                    if (validaHoraAtual(horaAtual) == false) {
                        $('#modalErro').modal('show');
                        return;
                    }
                    let horaPartida = hora.split(' ');
                    var hora = horaPartida[1];
                    var horaNova = hora.substring(0, 8);
                    let separador = horaNova.split(':');
                    let h = separador[0];
                    let m = separador[1];
                    let s = separador[2];

                    var hora = `${h}:${m}:${s}`;
                    $("#fimAlmoco").val(hora)
                    campo = 'fimAlmoco';

                    var inicioIntervalo = $("#inicioAlmoco").val()
                    horaRetorno = converteHora(parse(inicioIntervalo) + totalHorasIntervalo);

                }

                ///////////////////////////////////////////////////////////

                if (campo == 'inicioPrimeiraPausa') {
                    if (validaHoraAtual(hora) == false) {
                        $('#modalErro').modal('show');
                        return;
                    }
                    $("#inicioPrimeiraPausa").val(hora)

                    var horaEntrada = $("#horaEntrada").val();
                    if (parse(hora) < (parse(horaEntrada) + parse('01:00:00'))) {
                        $("#inicioPrimeiraPausa").val('')
                        smartAlert("Atenção", "A pausa não pode ser registrada com menos de 1h da entrada!", "error");
                        return;
                    }

                    if (inicioExpediente < fimExpediente) {
                        if (parse(hora) > (fimExpediente - parse('01:00:00'))) {
                            $("#inicioPrimeiraPausa").val('')
                            smartAlert("Atenção", "A pausa não pode ser registrada com menos de 1h para o fim do expediente!", "error");
                            return;
                        }
                    } else {
                        if (horaEntrada == '00:00:00' && parse(hora) > (fimExpediente - parse('01:00:00'))) {
                            $("#inicioPrimeiraPausa").val('')
                            smartAlert("Atenção", "A pausa não pode ser registrada com menos de 1h para o fim do expediente!", "error");
                            return;
                        }
                    }

                    $('#dlgSimplePausa').dialog('open');

                    return;
                }
                if (campo == 'fimPrimeiraPausa') {
                    if (validaHoraAtual(hora) == false) {
                        $('#modalErro').modal('show');
                        return;
                    }
                    $("#fimPrimeiraPausa").val(hora)

                    $('#dlgSimplePausa').dialog('open');

                    var inicioPausa = $("#inicioPrimeiraPausa").val()
                    horaRetorno = converteHora(parse(inicioPausa) + totalHorasPrimeiraPausa);

                    if (horaRetorno) {
                        $("#alertaPausa").html("O retorno da sua pausa é as " + horaRetorno).css('color', 'red');
                    }
                    return;
                }
                if (campo == 'inicioSegundaPausa') {
                    if (validaHoraAtual(hora) == false) {
                        $('#modalErro').modal('show');
                        return;
                    }
                    $("#inicioSegundaPausa").val(hora)

                    var horaEntrada = $("#horaEntrada").val();

                    if (horaEntrada != '00:00:00' && (parse(hora) < (parse(horaEntrada) + parse('01:00:00')))) {
                        $("#inicioSegundaPausa").val('')
                        smartAlert("Atenção", "A pausa não pode ser registrada com menos de 1h da entrada!", "error");
                        return;
                    }

                    if (inicioExpediente < fimExpediente) {
                        if (parse(hora) > (fimExpediente - parse('01:00:00'))) {
                            $("#inicioPrimeiraPausa").val('')
                            smartAlert("Atenção", "A pausa não pode ser registrada com menos de 1h para o fim do expediente!", "error");
                            return;
                        }
                    } else {
                        if (horaEntrada == '00:00:00' && parse(hora) > (fimExpediente - parse('01:00:00'))) {
                            $("#inicioPrimeiraPausa").val('')
                            smartAlert("Atenção", "A pausa não pode ser registrada com menos de 1h para o fim do expediente!", "error");
                            return;
                        }
                    }
                    $('#dlgSimplePausa').dialog('open');

                    // registraPausa(btnClicado);

                    return;
                }
                if (campo == 'fimSegundaPausa') {
                    if (validaHoraAtual(hora) == false) {
                        $('#modalErro').modal('show');
                        return;
                    }
                    $("#fimSegundaPausa").val(hora)

                    $('#dlgSimplePausa').dialog('open');

                    var inicioPausa = $("#inicioSegundaPausa").val()
                    horaRetorno = converteHora(parse(inicioPausa) + totalHorasSegundaPausa);

                    if (horaRetorno) {
                        $("#alertaPausa").html("O retorno da sua pausa é as " + horaRetorno).css('color', 'red');
                    }

                    return;
                }

                if (verificaIp == 1) {
                    var ip = $("#ip").val();

                    if (ip) {
                        validarIp();
                    } else {
                        campo = '#' + campo;
                        $(campo).val("");
                        smartAlert("Atenção", "Não foi possivel verificar o IP!", "error");
                        return;
                    }
                } else {
                    if (tipoEscala == 1) {
                        verificarFeriado();
                    } else {
                        $('#dlgSimplePonto').dialog('open');

                        // if (inicioAlmoco != "00:00:00" && fimAlmoco == "00:00:00") {
                        //     $("#alerta").html("O retorno do seu intervalo é às " + horarioAlmocoTolerado).css('color', 'red');
                        // }
                    }
                }
            }
        });
    }

    function justificar(btnClicado) {

        $('#dlgSimpleJustificativa').dialog('open');
        if (btnClicado == 'entrada') {
            $("#titulo").html("Justificativa de Atraso");
        } else if (btnClicado == 'saida') {
            $("#titulo").html("Justificativa de Hora Extra");
        }
    }

    function avisoDaFolga() {
        smartAlert("Atenção", "Dia de Folga!", "error");
        return;
    }

    function converteHora(segundos) {
        let horas = Math.floor(segundos / Math.pow(60, 2));
        segundos = segundos - (horas * 3600);
        let minutos = Math.floor(segundos / 60);
        segundos = segundos - (minutos * 60);

        if (horas.toString().length < 2) horas = `0${horas}`;
        if (minutos.toString().length < 2) minutos = `0${minutos}`;
        if (segundos.toString().length < 2) segundos = `0${segundos}`;

        return `${horas}:${minutos}:${segundos}`;
    }

    function resetaTempo() {
        var intervalo = 0;
        clearInterval(intervalo);
        tempo = 300000;
        intervalo = setInterval(() => {
            $(location).attr('href', 'index.php');
        }, (tempo));
    }


    function horaAgoraClick(botao) {
        const agora = new Date()
        const dia = agora.getDate().toString().padStart(2, '0')
        const mes = String(agora.getMonth() + 1).padStart(2, '0')
        const ano = agora.getFullYear()
        const horas = agora.getHours();
        const minutos = agora.getMinutes();
        const segundos = agora.getSeconds();
        const dataAtualClick = `${dia} / ${mes} / ${ano}`;
        const horaAtualClick = `${horas} : ${minutos} : ${segundos}`;

        const horaBotao = horaAtualClick;

        mudaHoraClick(botao, horaBotao)
        return
    }

    function getHoraServidor() {
        $.ajax({
            url: 'js/sqlscope_pontoEletronicoDiario.php',
            dataType: 'html', //tipo do retorno
            type: 'post', //metodo de envio
            async: false,
            data: {
                funcao: 'selecionaHora',
            },

            success: function(data) {
                data = data.replace(/failed/gi, '');
                var piece = data.split("#");

                var mensagem = piece[0];
                var out = piece[1];
                piece = out.split("^");

                horaServidor = piece[0];
                horaDisplay = piece[1];


                return;
            },


            error: function(xhr, er) {
                console.log(xhr, er);
            }
        });
    }
</script>