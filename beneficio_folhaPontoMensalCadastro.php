<?php
//Inicializa a página
require_once("inc/init.php");

//Requer a configuração de UI (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('LANCAMENTO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('LANCAMENTO_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('LANCAMENTO_EXCLUIR', $arrayPermissao, true));

if ($condicaoAcessarOK == false) {
    unset($_SESSION['login']);
    header("Location:login.php");
}

$esconderBtnExcluir = "";
if ($condicaoExcluirOK === false) {
    $esconderBtnExcluir = "none";
}
$esconderBtnGravar = "";
if ($condicaoGravarOK === false) {
    $esconderBtnGravar = "none";
}

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Controle de Ponto";
/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["operacao"]["sub"]["controlePonto"]["active"] = true;
include("inc/nav.php");
?>

<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Tabela Básica"] = "";
    include("inc/ribbon.php");
    ?>

    <!-- MAIN CONTENT -->
    <div id="content">

        <!-- widget grid -->
        <section id="widget-grid" class="">
            <div class="row">
                <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable centerBox">
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
                        <header>
                            <span class="widget-icon"><i class="fa fa-cog"></i></span>
                            <h2>Controle de Ponto
                            </h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formFolhaPontoMensalCadastro" method="post">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFolhaPontoMensal" class="collapsed" id="accordionFolhaPontoMensal">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Ponto Mensal
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseFolhaPontoMensal" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>


                                                        <div id="formFolhaPontoMensal" class="col-sm-12">
                                                            <input id="codigo" name="codigo" type="hidden" value="0">

                                                            <div class="form-group">

                                                                <div class="row">

                                                                    <section class="col col-4">
                                                                        <label class="label " for="funcionario">Funcionário</label>
                                                                        <label class="select">
                                                                            <select id="funcionario" name="funcionario" class="readonly" readonly>
                                                                                <option></option>
                                                                                <?php
                                                                                $reposit = new reposit();
                                                                                $sql = "select F.codigo, F.nome from Ntl.funcionario F LEFT JOIN Ntl.usuario U ON F.codigo = U.funcionario where F.dataDemissaoFuncionario IS NULL AND F.ativo = 1 AND U.login != '" . $_SESSION['login'] . "' order by nome";
                                                                                $result = $reposit->RunQuery($sql);
                                                                                foreach ($result as $row) {
                                                                                    $codigo = (int) $row['codigo'];
                                                                                    $nome = $row['nome'];
                                                                                    echo '<option value= ' . $codigo . '>' . $nome . '</option>';
                                                                                }
                                                                                $sql = "select F.codigo, F.nome from Ntl.funcionario F INNER JOIN Ntl.usuario U ON F.codigo = U.funcionario where F.dataDemissaoFuncionario IS NULL AND F.ativo = 1 AND U.login = '" . $_SESSION['login'] . "' AND F.codigo = U.funcionario";

                                                                                $result = $reposit->RunQuery($sql);
                                                                                if ($row = $result) {

                                                                                    $codigo = (int) $row['codigo'];
                                                                                    $nome = $row['nome'];
                                                                                    echo '<option value= ' . $codigo . ' selected>' . $nome . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select>

                                                                        </label>
                                                                    </section>

                                                                    <!-- <section class="col col-4">
                                                                        <label class="label" for="projeto">Projeto</label>
                                                                        <label class="select">
                                                                            <select id="projeto" name="projeto" class="readonly" readonly>
                                                                                <option></option>
                                                                                <?php
                                                                                $reposit = new reposit();
                                                                                $sql = "select codigo, descricao from Ntl.projeto where ativo = 1 order by descricao";
                                                                                $result = $reposit->RunQuery($sql);
                                                                                foreach ($result as $row) {
                                                                                    $codigo = (int) $row['codigo'];
                                                                                    $descricao = $row['descricao'];
                                                                                    echo '<option value=' . $codigo . '>' . $descricao . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </label>
                                                                    </section> -->


                                                                    <?php
                                                                    setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                                                                    date_default_timezone_set('America/Sao_Paulo');
                                                                    $dataAtual = strftime('%m/%Y', strtotime('today'));
                                                                    ?>
                                                                    <section class="col col-2">
                                                                        <label class="label" for="mesAnoFolhaPonto">Mês/Ano</label>
                                                                        <label class="input">
                                                                            <i class="icon-append fa fa-calendar"></i>
                                                                            <input id="mesAnoFolhaPonto" name="mesAnoFolhaPonto" style="text-align: center;" autocomplete="off" type="text" class="readonly" readonly value="<?= $dataAtual  ?>">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-md-1">
                                                                        <label class="label">&nbsp;</label>
                                                                        <label id="labelCheckAlmoco" class="checkbox hidden">
                                                                            <input id="checkAlmoco" name="checkAlmoco" type="checkbox" value="true">
                                                                            Habilitar Almoço
                                                                        </label>
                                                                    </section>

                                                                    <section class="col col-2">
                                                                        <label class="select">
                                                                            <select id="ativo" name="ativo" class="hidden" required>
                                                                                <option value='1' selected>Sim</option>
                                                                            </select>
                                                                        </label>
                                                                    </section>



                                                                </div>


                                                                <div class="row">
                                                                    <section class="col col-12">
                                                                        <legend><strong></strong></legend>
                                                                    </section>
                                                                </div>
                                                                <div class="row">
                                                                    <section class="col col-md-4">
                                                                        <label class="label"> </label>
                                                                        <input id="horaAtual" name="horaAtual" type="text" class="text-center form-control hidden" hidden data-autoclose="true" value="">

                                                                    </section>

                                                                </div>
                                                                <div class="row">
                                                                    <section class="col col-2">
                                                                        <label class="label" for="expediente">Expediente</label>
                                                                        <label class="select">
                                                                            <select id="expediente" name="expediente" class="readonly" readonly>
                                                                                <option>08:00 às 17:00</option>
                                                                                <option>10:00 às 16:00</option>

                                                                            </select>
                                                                        </label>
                                                                    </section>

                                                                    <section class="col col-2">
                                                                        <label class="label" for="almoco">Almoço</label>
                                                                        <label class="select">
                                                                            <select id="almoco" name="almoco" class="readonly" readonly>
                                                                                <option>01:00:00</option>
                                                                                <option>00:15:00</option>
                                                                            </select>
                                                                        </label>
                                                                    </section>
                                                                </div>

                                                                <div class="row">

                                                                    <section class="col col-1">
                                                                        <div class="form-group">
                                                                            <label class="label">Dia</label>
                                                                            <div class="input-group" data-align="top" data-autoclose="true">
                                                                                <input id="inputDia" name="inputDia" type="text" class="text-center form-control " data-autoclose="true" value="">
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class="col col-2">
                                                                        <div class="form-group">
                                                                            <label id="labelHora" class="label">Entrada</label>
                                                                            <div class="input-group" data-align="top" data-autoclose="true">
                                                                                <input id="inputHoraEntrada" name="inputHoraEntrada" type="text" class="text-center form-control" placeholder="  00:00:00" data-autoclose="true" value="">
                                                                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class="col col-1 sectionAlmoco" style="display: block">
                                                                        <div class="form-group">
                                                                            <label class="label">Inicio/Almoço</label>
                                                                            <div class="input-group" data-align="top" data-autoclose="true">
                                                                                <input id="inputInicioAlmoco" name="inputInicioAlmoco" type="text" class="text-center form-control" placeholder="  00:00" data-autoclose="true" value="">
                                                                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class="col col-1 sectionAlmoco" style="display: block">
                                                                        <div class="form-group">
                                                                            <label class="label">Fim/Almoço</label>
                                                                            <div class="input-group" data-align="top" data-autoclose="true">
                                                                                <input id="inputFimAlmoco" name="inputFimAlmoco" type="text" class="text-center form-control" placeholder="  00:00" data-autoclose="true" value="">
                                                                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class="col col-2">
                                                                        <div class="form-group">
                                                                            <label id="labelHora" class="label">Saída</label>
                                                                            <div class="input-group" data-align="top" data-autoclose="true">
                                                                                <input id="inputHoraSaida" name="inputHoraSaida" type="text" class="text-center form-control" placeholder="  00:00:00" data-autoclose="true" value="">
                                                                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class="col col-1">
                                                                        <div class="form-group">
                                                                            <label id="labelHora" class="label">H.Extra</label>
                                                                            <div class="input-group" data-align="top" data-autoclose="true">
                                                                                <input id="inputHoraExtra" name="inputHoraExtra" type="text" class="text-center form-control" placeholder="  00:00" data-autoclose="true" value="">
                                                                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class="col col-1">
                                                                        <div class="form-group">
                                                                            <label id="labelHora" class="label">Atraso</label>
                                                                            <div class="input-group" data-align="top" data-autoclose="true">
                                                                                <input id="inputAtraso" name="inputAtraso" type="text" class="text-center form-control" placeholder="  00:00" data-autoclose="true" value="">
                                                                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class="col col-2">
                                                                        <label class="label" for="lancamento">Lançamento/Ocorrência</label>
                                                                        <label class="select">
                                                                            <select id="inputLancamento" name="inputLancamento">
                                                                                <option value="0"></option>
                                                                                <?php
                                                                                $reposit = new reposit();
                                                                                $sql = "select codigo, descricao from Ntl.lancamento where ativo = 1 order by descricao";
                                                                                $result = $reposit->RunQuery($sql);
                                                                                foreach ($result as $row) {
                                                                                    $codigo = (int) $row['codigo'];
                                                                                    $descricao = $row['descricao'];
                                                                                    echo '<option value=' . $codigo . '>' . $descricao . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </label>
                                                                    </section>


                                                                </div>
                                                                <div class="row">
                                                                    <section class="col col-md-2">
                                                                        <label class="label"> </label>
                                                                        <button id="btnAddPonto" type="button" class="btn btn-primary">
                                                                            <i class="">Lançar Ponto</i>
                                                                        </button>
                                                                    </section>
                                                                    <section class="col col-md-2">
                                                                        <label class="label"> </label>
                                                                        <button id="btnGravar" type="button" class="btn btn-success">
                                                                            <i class="">Confirmar Alterações</i>
                                                                        </button>
                                                                    </section>

                                                                </div>

                                                                <hr><br><br>

                                                                <?php
                                                                $i = 0;
                                                                $days = date("t");
                                                                while ($i  < $days) {
                                                                    $i = $i + 1;
                                                                    echo "<div class=\"row\">

                                                                    <section class=\"col col-1\">
                                                                        <div class=\"form-group\">
                                                                            <label class=\"label\">Dia</label>
                                                                            <div class=\"input-group\" data-align=\"top\" data-autoclose=\"true\">
                                                                                <input id=\"dia-$i\" name=\"dia\" type=\"text\" class=\"text-center form-control readonly\" readonly data-autoclose=\"true\" value=\"" . $i . "\">
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class=\"col col-2\">
                                                                        <div class=\"form-group\">
                                                                            <label id=\"labelHora\" class=\"label\">Entrada</label>
                                                                            <div class=\"input-group\" data-align=\"top\" data-autoclose=\"true\">
                                                                                <input id=\"horaEntrada-$i\" name=\"horaEntrada\" type=\"text\" class=\"text-center form-control readonly\" readonly desabled placeholder=\"  00:00:00\" data-autoclose=\"true\" value=\"\">
                                                                                <span class=\"input-group-addon\"><i class=\"fa fa-clock-o\"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class=\"col col-1 sectionAlmoco\" style=\" display:block\">
                                                                        <div class=\"form-group\">
                                                                            <label class=\"label\">Inicio/Almoço</label>
                                                                            <div class=\"input-group\" data-align=\"top\" data-autoclose=\"true\">
                                                                                <input id=\"inicioAlmoco-$i\" name=\"inicioAlmoco\" type=\"text\" class=\"text-center form-control readonly\" readonly desabled placeholder=\"  00:00\" data-autoclose=\"true\" value=\"\">
                                                                                <span class=\"input-group-addon\"><i class=\"fa fa-clock-o\"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class=\"col col-1 sectionAlmoco\" style=\"display:block\">
                                                                        <div class=\"form-group\">
                                                                            <label class=\"label\">Fim/Almoço</label>
                                                                            <div class=\"input-group\" data-align=\"top\" data-autoclose=\"true\">
                                                                                <input id=\"fimAlmoco-$i\" name=\"fimAlmoco\" type=\"text\" class=\"text-center form-control readonly\" readonly desabled placeholder=\"  00:00\" data-autoclose=\"true\" value=\"\">
                                                                                <span class=\"input-group-addon\"><i class=\"fa fa-clock-o\"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class=\"col col-2\">
                                                                        <div class=\"form-group\">
                                                                            <label id=\"labelHora\" class=\"label\">Saída</label>
                                                                            <div class=\"input-group\" data-align=\"top\" data-autoclose=\"true\">
                                                                                <input id=\"horaSaida-$i\" name=\"horaSaida\" type=\"text\" class=\"text-center form-control readonly\" readonly desabled placeholder=\"  00:00:00\" data-autoclose=\"true\" value=\"\">
                                                                                <span class=\"input-group-addon\"><i class=\"fa fa-clock-o\"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class=\"col col-1\">
                                                                        <div class=\"form-group\">
                                                                            <label id=\"labelHora\" class=\"label\">H.Extra</label>
                                                                            <div class=\"input-group\" data-align=\"top\" data-autoclose=\"true\">
                                                                                <input id=\"horaExtra-$i\" name=\"horaExtra\" type=\"text\" class=\"text-center form-control readonly\" readonly desabled placeholder=\"  00:00\" data-autoclose=\"true\" value=\"\">
                                                                                <span class=\"input-group-addon\"><i class=\"fa fa-clock-o\"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class=\"col col-1\">
                                                                        <div class=\"form-group\">
                                                                            <label id=\"labelHora\" class=\"label\">Atraso</label>
                                                                            <div class=\"input-group\" data-align=\"top\" data-autoclose=\"true\">
                                                                                <input id=\"atraso-$i\" name=\"atraso\" type=\"text\" class=\"text-center form-control readonly\" readonly desabled placeholder=\"  00:00\" data-autoclose=\"true\" value=\"\">
                                                                                <span class=\"input-group-addon\"><i class=\"fa fa-clock-o\"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class=\"col col-2\">
                                                                        <label class=\"label\" for=\"lancamento\">Lançamento/Ocorrência</label>
                                                                        <label class=\"select\">
                                                                            <select id=\"lancamento-$i\" name=\"lancamento\" class=\" readonly\" readonly style= \"pointer-events: none; touch-action: none\" tabindex=\"-1\">
                                                                                <option value=\"0\"></option>";

                                                                    $reposit = new reposit();
                                                                    $sql = "select codigo, sigla, descricao from Ntl.lancamento where ativo = 1 order by descricao";
                                                                    $result = $reposit->RunQuery($sql);
                                                                    foreach ($result as $row) {
                                                                        $codigo = (int) $row['codigo'];
                                                                        $descricao = $row['descricao'];
                                                                        echo "<option value='$codigo'>$descricao</option>";
                                                                    }
                                                                    echo " </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                </div>
                                                                ";
                                                                }
                                                                ?>

                                                                <div class="row">
                                                                    <section class="col col-12">
                                                                        <label class="label">Observações</label>
                                                                        <textarea maxlength="500" id="observacaoFolhaPontoMensal" name="observacaoFolhaPontoMensal" class="form-control" rows="3" value="" style="resize:vertical"></textarea>
                                                                    </section>
                                                                </div>
                                                            </div>
                                                    </fieldset>
                                                </div>

                                            </div>
                                        </div>
                                        <footer>
                                            <button type="button" id="btnExcluir" class="btn btn-danger" aria-hidden="true" title="Excluir" style="display:<?php echo $esconderBtnExcluir ?>">
                                                <span class="fa fa-trash"></span>
                                            </button>
                                            <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="dlgSimpleExcluir" aria-labelledby="ui-id-1" style="height: auto; width: 600px; top: 220px; left: 262px; display: none;">
                                                <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                                                    <span id="ui-id-2" class="ui-dialog-title">
                                                    </span>
                                                </div>
                                                <div id="dlgSimpleExcluir" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; max-height: none; height: auto;">
                                                    <p>CONFIRMA A EXCLUSÃO ? </p>
                                                </div>
                                                <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
                                                    <div class="ui-dialog-buttonset">
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="button" id="btnNovo" class="btn btn-primary" aria-hidden="true" title="Novo" style="display:<?php echo $esconderBtnGravar ?>">
                                                <span class="fa fa-file-o"></span>
                                            </button>

                                            <button type="button" id="btnVoltar" class="btn btn-default" aria-hidden="true" title="Voltar">
                                                <span class="fa fa-backward"></span>
                                            </button>

                                        </footer>
                                </form>
                            </div>

                        </div>
                    </div>
                </article>
            </div>
        </section>
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
<script src="<?php echo ASSETS_URL; ?>/js/business_beneficioFolhaPontoMensal.js" type="text/javascript"></script>
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

<!--<script src="/js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>-->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/fullcalendar.js"></script>
<!--<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/locale-all.js"></script>-->

<!-- Form to json -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/form2js.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/jquery.toObject.js"></script>

<script src="js/plugin/clockpicker/clockpicker.min.js"></script>


<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {

        $("#inputHoraEntrada").mask("99:99:99");


        $('#inputHoraEntrada').clockpicker({
            donetext: 'Done',
            default: 'now',
            use24hours: true,
        }).val(moment().format('HH:mm:ss'));

        $("#inputHoraSaida").mask("99:99:99");

        $('#inputHoraSaida').clockpicker({
            donetext: 'Done',
            default: 'now',
            use24hours: true,
        }).val(moment().format('HH:mm:ss'));

        $("#inputInicioAlmoco").mask("99:99");

        $('#inputInicioAlmoco').clockpicker({
            donetext: 'Done',
            default: 'now',
            use24hours: true,
        }).val(moment().format('HH:mm'));

        $("#inputFimAlmoco").mask("99:99");

        $('#inputFimAlmoco').clockpicker({
            donetext: 'Done',
            default: 'now',
            use24hours: true,
        }).val(moment().format('HH:mm'));

        $("#inputHoraExtra").mask("99:99");

        $('#inputHoraExtra').clockpicker({
            donetext: 'Done',
            default: 'now',
            use24hours: true,
        }).val(moment().format('HH:mm'));

        $("#inputAtraso").mask("99:99");

        $('#inputAtraso').clockpicker({
            donetext: 'Done',
            default: 'now',
            use24hours: true,
        }).val(moment().format('HH:mm'));



        $("#btnAddPonto").on("click", function() {

            var dia = $("#inputDia").val()

            var entrada = $("#horaEntrada-" + dia)
            var inputEntrada = $("#inputHoraEntrada").val()

            var inicioAlmoco = $("#inicioAlmoco-" + dia)
            var inputInicioAlmoco = $("#inputInicioAlmoco").val()

            var fimAlmoco = $("#fimAlmoco-" + dia)
            var inputFimAlmoco = $("#inputFimAlmoco").val()

            var saida = $("#horaSaida-" + dia)
            var inputSaida = $("#inputHoraSaida").val()

            var extra = $("#horaExtra-" + dia)
            var inputExtra = $("#inputHoraExtra").val()

            var atraso = $("#atraso-" + dia)
            var inputAtraso = $("#inputAtraso").val()

            var lancamento = $("#lancamento-" + dia)
            var inputLancamento = $("#inputLancamento").val()

            entrada.val(inputEntrada)
            inicioAlmoco.val(inputInicioAlmoco)
            fimAlmoco.val(inputFimAlmoco)
            saida.val(inputSaida)
            extra.val(inputExtra)
            atraso.val(inputAtraso)
            lancamento.val(inputLancamento)

        });


        $('#btnNovo').on("click", function() {
            novo()
        });
        $("#btnGravar").on("click", function() {
            gravar();
        });
        $("#btnVoltar").on("click", function() {
            voltar();
        });
        $("#btnExcluir").on("click", function() {
            excluir();
        });
        $("#checkAlmoco").on("click", function() {
            var check = $(".sectionAlmoco")
            check.each((index, el) => {
                console.log(typeof el)
                console.log($(el))

                if ($(el).css('display') != 'block') {

                    $(el).css('display', 'block')
                } else {
                    $(el).css('display', 'none')
                }
            })
        });

        carregaFolhaPontoMensal();


    });

    function voltar() {
        $(location).attr('href', 'beneficio_folhaPontoMensalFiltro.php');

    }

    function novo() {
        $(location).attr('href', 'beneficio_folhaPontoCadastro.php');

    }

    function gravar() {

        //Botão que desabilita a gravação até que ocorra uma mensagem de erro ou sucesso.
        $("#btnGravar").prop('disabled', true);

        var arrayFolha = $("input[name='dia']").serializeArray()

        var arrayDia = arrayFolha.map(folha => {
            return {
                dia: folha.value
            }
        })

        arrayFolha = $("input[name='horaEntrada']").serializeArray()
        var arrayHoraEntrada = arrayFolha.map(folha => {
            return {
                horaEntrada: folha.value
            }
        })

        arrayFolha = $("input[name='inicioAlmoco']").serializeArray()
        var arrayInicioAlmoco = arrayFolha.map(folha => {
            return {
                inicioAlmoco: folha.value
            }
        })

        arrayFolha = $("input[name='fimAlmoco']").serializeArray()
        var arrayFimAlmoco = arrayFolha.map(folha => {
            return {
                fimAlmoco: folha.value
            }
        })

        arrayFolha = $("input[name='horaSaida']").serializeArray()
        var arrayHoraSaida = arrayFolha.map(folha => {
            return {
                horaSaida: folha.value
            }
        })

        arrayFolha = $("input[name='horaExtra']").serializeArray()
        var arrayHoraExtra = arrayFolha.map(folha => {
            return {
                horaExtra: folha.value
            }
        })

        arrayFolha = $("input[name='atraso']").serializeArray()
        var arrayAtraso = arrayFolha.map(folha => {
            return {
                atraso: folha.value
            }
        })

        arrayFolha = $("select[name='lancamento'] option:selected")
        var arrayLancamento = new Array()
        arrayFolha.each((index, el) => {
            let value = $(el).val()
            arrayLancamento.push({
                lancamento: value
            })
        })

        var codigo = parseInt($("#codigo").val())
        var ativo = parseInt($("#ativo").val())
        var funcionario = $("#funcionario").val();
        var mesAnoFolhaPonto = $("#mesAnoFolhaPonto").val().split('/')
        var mes = mesAnoFolhaPonto[0]
        var ano = mesAnoFolhaPonto[1]
        var observacaoFolhaPontoMensal = $("#observacaoFolhaPontoMensal").val();

        var data = new Date().getMonth()


        // Mensagens de aviso caso o usuário deixe de digitar algum campo obrigatório:
        var folhaPontoMensalTabela = arrayDia.map((array, index) => {
            return {
                dia: array.dia,
                horaEntrada: arrayHoraEntrada[index].horaEntrada,
                horaSaida: arrayHoraSaida[index].horaSaida,
                inicioAlmoco: arrayInicioAlmoco[index].inicioAlmoco,
                fimAlmoco: arrayFimAlmoco[index].fimAlmoco,
                horaExtra: arrayHoraExtra[index].horaExtra,
                atraso: arrayAtraso[index].atraso,
                lancamento: arrayLancamento[index].lancamento,
                mes: mes,
                ano: ano

            }

        })

        var folhaPontoInfo = {
            codigo: codigo,
            ativo: ativo,   
            funcionario: funcionario,
            observacao: observacaoFolhaPontoMensal
        }

        gravaFolhaPontoMensal(folhaPontoInfo, folhaPontoMensalTabela,
            function(data) {

                if (data.indexOf('sucess') < 0) {
                    var piece = data.split("#");
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                        $("#btnGravar").prop('disabled', false);
                        return false;
                    } else {
                        smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR !", "error");
                        $("#btnGravar").prop('disabled', false);
                        return false;
                    }
                } else {
                    var piece = data.split("#");
                    smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                    novo();
                }
            }
        );
    }


    function excluir() {
        debugger;
        var id = +$("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirFolhaPontoMensal(id, function(data) {
            if (data.indexOf('failed') > -1) {
                var piece = data.split("#");
                var mensagem = piece[1];

                if (mensagem !== "") {
                    smartAlert("Atenção", mensagem, "error");
                } else {
                    smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
                }
            } else {
                smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                voltar();
            }
        });
    }


    function carregaFolhaPontoMensal() {
        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        if (params.length === 2) {
            var id = params[1];
            var idx = id.split("=");
            var idd = idx[1];
            if (idd !== "") {
                recuperaFolhaPontoMensal(idd,
                    function(data) {
                        data = data.replace(/failed/g, '');
                        var piece = data.split("#");

                        //Atributos de Cliente
                        var mensagem = piece[0];
                        var out = piece[1];

                        piece = out.split("^");
                        console.table(piece);
                        //Atributos de cliente 
                        var codigo = +piece[0];
                        var funcionario = piece[1];
                        var projeto = piece[2];
                        var mesAnoFolhaPonto = piece[3];



                        //Atributos de cliente        
                        $("#codigo").val(codigo);
                        $("#funcionario").val(funcionario);
                        $("#projeto").val(projeto);
                        $("#mesAnoFolhaPonto").val(mesAnoFolhaPonto);





                    }
                );
            }
        }
    }
</script>