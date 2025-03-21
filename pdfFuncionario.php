<?php

include "repositorio.php";

//initilize the page
require_once("inc/init.php");
//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

require('./fpdf/mc_table.php');
// $codigoLogin = $_SESSION['codigo'];

// if ((empty($_GET["id"])) || (!isset($_GET["id"])) || (is_null($_GET[""]))) {
//     $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
//     echo "failed#" . $mensagem . ' ';
//     return;
// }

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

require_once('fpdf/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        global $codigo;
        $sqlLogo = "SELECT nome  FROM dbo.funcionario";
        $reposit = new reposit();
        $result = $reposit->RunQuery($sqlLogo);
        $rowLogo = $result[0];
        $logo = $rowLogo['parametroLogoRelatorio'];
        if ($logo != "") {
            $img = explode('/', $logo);
            $img = $img[1] . "/" . $img[2] . "/" . $img[3];
            $img = str_replace('"', "'", $img);


            list($x1, $y1) = getimagesize($img);
            $x2 = 15;
            $y2 = 10;
            if (($x1 / $x2) < ($y1 / $y2)) {
                $y2 = 5;
            } else {
                $x2 = 5;
            }
            $this->Cell(116, 1, "", 0, 1, 'C', $this->Image($img, $x2, $y2, 0, 15));
        }
        $sqlMarca = "SELECT parametroMarca 
        FROM Ntl.parametro ";
        $reposit = new reposit();
        $result = $reposit->RunQuery($sqlMarca);
        $rowMarca = $result[0];
        $logoMarca = $rowMarca['parametroMarca'];
        if ($logoMarca != "") {
            $img1 = explode('/', $logoMarca);
            $img1 = $img1[1] . "/" . $img1[2] . "/" . $img1[3];
            $img1 = str_replace('"', "'", $img1);
            list($x3, $y3) = getimagesize($img1);
            $x4 = 1;
            $y4 = 100;
            if (($x3 / $x4) < ($y3 / $y4)) {
                $y4 = 5;
            } else {
                $x4 = 50;
            }
            $this->Image($img1, $x4, $y4, 105, 105);
        }
        //        if ($nomeLogoRelatorio != "")
        //        $this->SetFont('Arial', '', 8); #Seta a Fonte
        //        $dataAux = new DateTime();
        //        $dataAux->setTimezone(new DateTimeZone("GMT-3"));
        //        $dataAtualizada = $dataAux->format('d/m/Y H:i:s');
        //        $this->Cell(288, 0, $dataAtualizada, 0, 0, 'R', 0); #Título do Relatório
        // $this->Cell(116, 1, "", 0, 1, 'C', 0); #Título do Relatório
        // $this->Image($img, 7, 5, 13, 13); #logo da empresa
        $this->SetXY(190, 5);
        $this->SetFont('Arial', 'B', 8); #Seta a Fonte

        $this->Cell(20, 7.5, 'Pagina ' . $this->pageno()); #Imprime o Número das Páginas

        $this->Ln(24); #Quebra de Linhas

        $this->SetTextColor(255, 192, 203);
        $this->Image('C:\inetpub\wwwroot\Cadastro\img\marcaDagua.png', 35, 45, 135, 145, 'PNG');
    }
    function Footer()
    {
        $this->SetY(202);
    }
}


$pdf = new PDF('P', 'mm', 'A4'); #Crio o PDF padrão RETRATO, Medida em Milímetro e papel A$
$pdf->SetFillColor(238, 238, 238);
$pdf->SetMargins(0, 0, 0); #Seta a Margin Esquerda com 20 milímetro, superrior com 20 milímetro e esquerda com 20 milímetros
$pdf->SetDisplayMode('default', 'continuous'); #Digo que o PDF abrirá em tamanho PADRÃO e as páginas na exibição serão contínuas
$pdf->AddPage();

$tamanhoFonte = 10;
$tamanhoFonteMenor = 8;
$tipoDeFonte = 'Courier';
$fontWeight = 'B';





$pdf->setY(9);
$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
$pdf->setX(85);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'RELATÓRIO INDIVIDUAL DO FUNCIONÁRIO'), 0, 0, "C", 0);
$pdf->SetFont($tipoDeFonte, '', 20);



$pdf->setY(16);
$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
$pdf->setX(85);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'DADOS DO FUNCIONÁRIO'), 0, 0, "C", 0);
$pdf->SetFont($tipoDeFonte, '', 2);

$pdf->Line(5, 19, 205, 19); //menor
$pdf->Line(5, 19, 205, 19); //menor
$pdf->Line(5, 19, 205, 19); //menor


$pdf->Line(5, 5, 205, 5); //horizontal 1
$pdf->Line(5, 12, 205, 12); //horizontal abaixo
$pdf->Line(5, 5, 5, 290); //vertical 1
$pdf->Line(205, 5, 205, 290); //vertical 2
$pdf->Line(5, 290, 205, 290); //horizontal 2



$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);

$pdf->setY(28);
$pdf->setX(12);
$pdf->Cell(25, -1, iconv('UTF-8', 'windows-1252', 'NOME:'), 0, 0, "L", 0);

$pdf->setY(28);
$pdf->setX(78);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'DATA DE NASC.:'), 0, 0, "L", 0); ////

$pdf->setY(35);
$pdf->setX(12);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'CPF:'), 0, 0, "L", 0);

$pdf->setY(35);
$pdf->setX(78);
$pdf->Cell(25, -1, iconv('UTF-8', 'windows-1252', 'ESTADO CIVIL:'), 0, 0, "L", 0); ////


$pdf->setY(42);
$pdf->setX(12);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'RG:'), 0, 0, "L", 0);

$pdf->setY(42);
$pdf->setX(78);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'PRIMEIRO EMPREGO:'), 0, 0, "L", 0); ////


$pdf->setY(28);
$pdf->setX(154);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'GÊNERO:'), 0, 0, "L", 0);

$pdf->setY(35);
$pdf->setX(154.5);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'ATIVO:'), 0, 0, "L", 0);


$pdf->setY(42);
$pdf->setX(154);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'PIS:'), 0, 0, "L", 0);
// $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'PIS/PASEP:'), 0, 0, "L", 0);



$id = $_GET["id"];

$sql = " SELECT FU.codigo, FU.ativo, FU.cpf, FU.rg, FU.dataNascimento, FU.estadoCivil, FU.nome, FU.cep, FU.logradouro, FU.uf, FU.bairro, FU.cidade, FU.numero, FU.complemento, FU.primeiroEmprego, FU.pisPasep, G.descricao as genero 
                from dbo.funcionario FU 
                FULL JOIN dbo.genero G on G.codigo = FU.genero WHERE FU.codigo = " . $id;






$sqlTelefone = " SELECT telefone, principal, whatsapp FROM dbo.telefoneFuncionario WHERE funcionarioId = $id";
$sqlEmail = "SELECT email, principal FROM dbo.emailFuncionario WHERE funcionarioId = $id";

$sqlDependente = "SELECT nome, cpf, dataNascimento, tipo FROM dbo.dependentesListaFuncionario WHERE funcionarioId = $id";


$reposit = new reposit();
$resultQuery = $reposit->RunQuery($sql);
$resultQueryTelefone = $reposit->RunQuery($sqlTelefone);
$resultQueryEmail = $reposit->RunQuery($sqlEmail);
$resultQueryDependente = $reposit->RunQuery($sqlDependente);


$margem = 5;

foreach ($resultQuery as $row) {
    $nome = $row['nome'];
    $cpf = $row['cpf'];
    $rg = $row['rg'];
    $dataNascimento = $row['dataNascimento'];
    $dataNascimento = explode(" ", $dataNascimento);
    $dataNascimento = explode("-", $dataNascimento[0]);
    $dataNascimento =  $dataNascimento[2] . "/" . $dataNascimento[1] . "/" . $dataNascimento[0];
    $genero = $row['genero'];
    $pispasep = $row['pisPasep'];
    $primeiroEmprego = $row['primeiroEmprego'];
    $estadoCivil = (int)$row['estadoCivil'];

    $ativo = +$row['ativo'];
    $primeiroEmprego = (int) $row['primeiroEmprego'];

    $valor_de_retorno = match ($estadoCivil) {
        1 => 'Solteiro',
        2 => 'Casado',
        3 => 'Separado',
        4 => 'Divorciado',
        5 => 'Viúvo'
    };

    $estadoCivil = $valor_de_retorno;
    if ($ativo == 1) {
        $ativo = 'Sim';
    } else {
        $ativo = 'Não';
    }

    if ($primeiroEmpreg == 1) {
        $primeiroEmprego = "Sim";
    } else {
        $primeiroEmprego = "Não";
    }
    if ($pispasep == "") {
        $pispasep = "Nenhum";
    }

    //como os nomes são separados por espaço em branco então vamos criar o array a partir dos espaços
    $split_nome = explode(" ", trim($nome)); ////pesquisar dps
    //so vamos abreviar o nome se ele tiver pelo menos 2 sobrenomes
    if (count($split_nome) > 2) {
        //esse for inicia a partir da segunda posição do array para o primeiro nome ser desconsiderado
        for ($i = 1; (count($split_nome) - 1) > $i; $i++) {
            //claro que como existem dos|de|da|das
            // (Cristina DOS Santos) podemos omitir ou exibir sem abrevirar essas preposições, aqui no caso eu as mantenho sem alteração
            if (strlen($split_nome[$i]) > 3) {
                //aqui será feito a abreviação com apenas a inicial da palavra a ser abreviada seguida de ponto
                $split_nome[$i] = substr($split_nome[$i], 0, 1) . ".";
            }
        }
    }
    //aqui será impresso o nome resultante com a junção do array em favor de se obter uma string colando as posições do array com espaços em branco!
    $split_nome = implode(" ", $split_nome);
    $split_nome = mb_strimwidth($split_nome, 0, 23, "...");

    // $comum = new comum();
    // $split_nome = $comum->formatarString($split_nome);

    $pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);

    $pdf->setY(28);
    $pdf->setX(25);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $split_nome), 0, 0, "L", 0);

    $pdf->setY(35);
    $pdf->setX(24);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $cpf), 0, 0, "L", 0);

    $pdf->setY(42);
    $pdf->setX(23);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $rg), 0, 0, "L", 0);

    $pdf->setY(28);
    $pdf->setX(110);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $dataNascimento), 0, 0, "L", 0);

    $pdf->setY(35);
    $pdf->setX(110);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $estadoCivil), 0, 0, "L", 0);

    $pdf->setY(42);
    $pdf->setX(120);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $primeiroEmprego), 0, 0, "L", 0);

    $pdf->setY(28);
    $pdf->setX(175);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $genero), 0, 0, "L", 0);



    $pdf->setY(35);
    $pdf->setX(175);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $ativo), 0, 0, "L", 0);

    $pdf->setY(42);
    $pdf->setX(166);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $pispasep), 0, 0, "L", 0);

    // $pdf->Line(25,200, 185, 50); //menor
    // $pdf->Line(25,200, 185, 50); //menor
    // $pdf->Line(25,200, 185, 50); //menor

}

if ($i > 240) {
    $pdf->AddPage();
    // $pdf->Line(5, 5, 205, 5); //horizontal 1
    $pdf->Line(5, 12, 205, 12); //horizontal abaixo
    // $pdf->Header();
    // $pdf->Footer();
    $i = 15;
}
$pdf->setY(60);
$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
$pdf->setX(85);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'DADOS DE CONTATO'), 0, 0, "C", 0);
$pdf->SetFont($tipoDeFonte, '', 2);

$pdf->Line(5, 63, 205, 63); //menor
$pdf->Line(5, 63, 205, 63); //menor
$pdf->Line(5, 63, 205, 63); //menor

$j = 72;


$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
$pdf->setY($j);
$pdf->setX(15);
$pdf->SetFillColor(255, 160, 122);
$pdf->Cell(30, 5, iconv('UTF-8', 'windows-1252', 'TELEFONE'), 1, 0, "C", 1);
$pdf->SetFillColor(238, 232, 170);
$pdf->Cell(23, 5, iconv('UTF-8', 'windows-1252', 'PRINCIPAL'), 1, 0, "C", 1);
$pdf->SetFillColor(144, 238, 144);
$pdf->Cell(23, 5, iconv('UTF-8', 'windows-1252', 'WHATSAPP'), 1, 0, "C", 1);

$pdf->setY($j);
$pdf->setX(100);
$pdf->SetFillColor(255, 160, 122);
$pdf->Cell(68, 5, iconv('UTF-8', 'windows-1252', 'EMAIL'), 1, 0, "C", 1);
$pdf->SetFillColor(238, 232, 170);
$pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', 'PRINCIPAL'), 1, 0, "C", 1);

$pdf->SetFillColor(238, 238, 238);
$pdf->SetTextColor(0, 0, 0);

$j = 72;


foreach ($resultQueryTelefone as $row) {

    $telefone = $row['telefone'];
    $principal = $row['principal'];
    $whatsapp = $row['whatsapp'];

    if ($principal == 1) {
        $principal = 'Sim';
    } else {
        $principal = 'Não';
    }
    if ($whatsapp == 1) {
        $whatsapp = 'Sim';
    } else {
        $whatsapp = 'Não';
    }

    $j += 5;
    $pdf->setY($j);
    $pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
    $pdf->setX(15);
    $pdf->SetFont($tipoDeFonte, '', 8);
    $pdf->Cell(30, 5, iconv('UTF-8', 'windows-1252', $telefone), 1, 0, "C", 0);
    $pdf->Cell(23, 5, iconv('UTF-8', 'windows-1252', $principal), 1, 0, "C", 0);
    $pdf->Cell(23, 5, iconv('UTF-8', 'windows-1252', $whatsapp), 1, 0, "C", 0);
    if ($j > 240) {
        $pdf->AddPage();
        // $pdf->Line(5, 5, 205, 5); //horizontal 1
        $pdf->Line(5, 12, 205, 12); //horizontal abaixo
        // $pdf->Header();
        // $pdf->Footer();
        $i = 15;
    }
}


$i = 72;

foreach ($resultQueryEmail as $row) {
    $email = mb_strimwidth($row['email'], 0, 35, "...");
    // $email =  substr_replace($email, '*****', 2, strpos($email, '@') - 4);
    $principal = $row['principal'];

    if ($principal == 1) {
        $principal = 'Sim';
    } else {
        $principal = 'Não';
    }



    $i += 5;
    $pdf->setY($i);
    $pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
    $pdf->setX(100);
    $pdf->SetFont($tipoDeFonte, '', 8);
    $pdf->Cell(68, 5, iconv('UTF-8', 'windows-1252', $email), 1, 0, "C", 0);
    $pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', $principal), 1, 0, "C", 0);


    if ($i > 240) {
        $pdf->AddPage();
        // $pdf->Line(5, 5, 205, 5); //horizontal 1
        $pdf->Line(5, 12, 205, 12); //horizontal abaixo
        // $pdf->Header();
        // $pdf->Footer();
        $i = 15;
    }
}

$i = $i + 25;

if ($i > 200 || $j>200) {
    $pdf->AddPage();
    // $pdf->Line(5, 5, 205, 5); //horizontal 1
    $pdf->Line(5, 12, 205, 12); //horizontal abaixo
    // $pdf->Header();
    // $pdf->Footer();
    $i = 15;
}


$quantidadeDepedentes = (int)$resultQueryDependente;
if ($quantidadeDepedentes >= 1) {



    foreach ($resultQueryDependente as $row) {
        


        if ($titulo < 1) {



            $pdf->setY($i);
            $pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
            $pdf->setX(85);
            $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'LISTA DE DEPENDENTES'), 0, 0, "C", 0);
            $pdf->SetFont($tipoDeFonte, '', 20);

            $pdf->Line(5, $i + 5, 205, $i + 5); //menor
            $pdf->Line(5, $i + 5, 205, $i + 5); //menor
            $pdf->Line(5, $i + 5, 205, $i + 5); //menor


            $pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);


            $i = $i + 9;
            $pdf->setY($i);
            $pdf->setX(28.5);
            $pdf->SetFillColor(173, 216, 230);

            $pdf->Cell(40, 5, iconv('UTF-8', 'windows-1252', 'NOME'), 1, 0, "C", 1);
            $pdf->Cell(40, 5, iconv('UTF-8', 'windows-1252', 'CPF'), 1, 0, "C", 1);
            $pdf->Cell(48, 5, iconv('UTF-8', 'windows-1252', 'DATA DE NASCIMENTO'), 1, 0, "C", 1);
            $pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', 'TIPO'), 1, 0, "C", 1);
            $pdf->SetFillColor(255, 255, 255);
        }
        $titulo = 1;
        $nome = $row['nome'];

        $cpf = $row['cpf'];
        $dataNascimento = $row['dataNascimento'];
        $tipo = $row['tipo'];

        if ($tipo == "") {
            $tipo = "---";
        }

        $split_nome = explode(" ", trim($nome));
        if (count($split_nome) > 2) {
            for ($contador = 1; (count($split_nome) - 1) > $contador; $contador++) {
                if (strlen($split_nome[$contador]) > 3) {
                    $split_nome[$contador] = substr($split_nome[$contador], 0, 1) . ".";
                }
            }
        }
        $split_nome = implode(" ", $split_nome);


        $i += 5;

        $pdf->setY($i);
        $pdf->setX(28.5);
        $pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
        $pdf->SetFont($tipoDeFonte, '', 8);
        $pdf->Cell(40, 5, iconv('UTF-8', 'windows-1252', $split_nome), 1, 0, "C", 1);
        $pdf->Cell(40, 5, iconv('UTF-8', 'windows-1252', $cpf), 1, 0, "C", 1);
        $pdf->Cell(48, 5, iconv('UTF-8', 'windows-1252', $dataNascimento), 1, 0, "C", 1);
        $pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', $tipo), 1, 0, "C", 1);
        
        if ($i > 240) {
            $pdf->AddPage();
            // $pdf->Line(5, 5, 205, 5); //horizontal 1
            $pdf->Line(5, 12, 205, 12); //horizontal abaixo
            // $pdf->Header();
            // $pdf->Footer();
            $i = 15;
        }

    }
}






$i = $i + 25;
$pdf->setY($i);
$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
$pdf->setX(85);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'ENDEREÇO'), 0, 0, "C", 0);
$pdf->Line(5, $i + 3, 205, $i + 3); //menor
$pdf->Line(5, $i + 3, 205, $i + 3); //menor
$pdf->Line(5, $i + 3, 205, $i + 3); //menor



$i = $i + 9;

$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
$pdf->setY($i);
$pdf->setX(20);
$pdf->Cell(25, -1, iconv('UTF-8', 'windows-1252', 'RUA:'), 0, 0, "L", 0);
$pdf->setX(128);
$pdf->Cell(83, -1, iconv('UTF-8', 'windows-1252', 'BAIRRO:'), 0, 0, "L", 0);
$pdf->setY($i + 7);
$pdf->setX(20);
$pdf->Cell(25, -1, iconv('UTF-8', 'windows-1252', 'CEP:'), 0, 0, "L", 0);
$pdf->setX(60);
$pdf->Cell(25, -1, iconv('UTF-8', 'windows-1252', 'CIDADE:'), 0, 0, "L", 0);
$pdf->setX(128.5);
$pdf->Cell(25, -1, iconv('UTF-8', 'windows-1252', 'UF:'), 0, 0, "L", 0);
$pdf->setY($i + 14);
$pdf->setX(20);
$pdf->Cell(25, -1, iconv('UTF-8', 'windows-1252', 'COMPLEMENTO:'), 0, 0, "L", 0);

$pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);



foreach ($resultQuery as $row) {
    if ($i > 240) {
        $pdf->AddPage();
        // $pdf->Line(5, 5, 205, 5); //horizontal 1
        $pdf->Line(5, 12, 205, 12); //horizontal abaixo
        // $pdf->Header();
        // $pdf->Footer();
        $i = 15;
    }

    $cep = $row['cep'];
    $logradouro = mb_strimwidth($row['logradouro'], 0, 35, "...");
    $uf = $row['uf'];
    $bairro = mb_strimwidth($row['bairro'], 0, 20, "...");
    $cidade = mb_strimwidth($row['cidade'], 0, 20, "...");
    $numero = $row['numero'];
    $complemento = mb_strimwidth(trim($row['complemento']), 0, 20, "...");
    if ($complemento == "") {
        $complemento = 'Nenhum';
    }



    $ruaEnumero = $logradouro . ', ' . $numero;
    $pdf->setY($i);
    $pdf->setX(32);
    $pdf->Cell(25, -1, iconv('UTF-8', 'windows-1252', $ruaEnumero), 0, 0, "L", 0);
    $pdf->setX(148.5);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $bairro), 0, 0, "L", 0);
    $pdf->setY($i + 7);
    $pdf->setX(32);
    $pdf->Cell(25, -1, iconv('UTF-8', 'windows-1252', $cep), 0, 0, "L", 0);
    $pdf->setX(80);
    $pdf->Cell(102, -1, iconv('UTF-8', 'windows-1252', $cidade), 0, 0, "L", 0);
    $pdf->setX(142);;
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $uf), 0, 0, "L", 0);
    $pdf->setY($i + 14);
    $pdf->setX(53);
    $pdf->Cell(25, -1, iconv('UTF-8', 'windows-1252', $complemento), 0, 0, "L", 0);
}


$pdf->Ln(8);
$pdf->Output();
