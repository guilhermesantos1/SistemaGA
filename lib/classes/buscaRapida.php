<?php

include ("DBConexao.class.php");
include ("../funcoes/strings.php");
require ("../../cadastro/verifica.php");

$db = NEW DBConexao();
$db->GetConexao();

// Configuração do script
// ========================
$Registros['PorPagina'] = 20; // Número de registros por página
// Verifica se foi feita alguma busca
// Caso contrario, redireciona o visitante
if (!isset($_GET['consulta'])) {
    header("Location: FollowUp.class.php");
    exit;
}
// Se houve busca, continue o script:
// Salva o que foi buscado em uma variável
$busca = $_GET['consulta'];
// Usa a função mysql_real_escape_string() para evitar erros no MySQL
$busca = mysql_real_escape_string($busca);

// ============================================
// Monta a consulta MySQL para saber quantos registros serão encontrados
$sql = "SELECT COUNT(*) AS total FROM `alunos` 
        WHERE ((`nome` LIKE '%" . $busca . "%') OR ('%" . $busca . "%'))";
// Executa a consulta
//die($sql);
$query = $db->Executa($sql);
// Salva o valor da coluna 'total', do primeiro registro encontrado pela consulta
$total = mysql_result($query, 0, 'total');
// Calcula o máximo de paginas
$paginas = (($total % $Registros['PorPagina']) > 0) ? (int) ($total / $Registros['PorPagina']) + 1 : ($total / $Registros['PorPagina']);

// ============================================
// Sistema simples de paginação, verifica se há algum argumento 'pagina' na URL
if (isset($_GET['pagina'])) {
    $pagina = (int) $_GET['pagina'];
} else {
    $pagina = 1;
}
$pagina = max(min($paginas, $pagina), 1);
$inicio = ($pagina - 1) * $Registros['PorPagina'];

// ============================================
// Monta outra consulta MySQL, agora a que fará a busca com paginação
$sql = "SELECT * FROM `alunos` 
        WHERE ((`nome` LIKE '%" . $busca . "%') OR ('%" . $busca . "%')) ORDER BY `nome` ASC LIMIT " . $inicio . ", " . $Registros['PorPagina'];
// Executa a consulta
$db->Executa($sql);

$x = min($total, ($inicio + 1));
$y = min($total, ($inicio + $Registros['PorPagina']));

// ============================================


$Conteudo = "
            <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
            <link href=\"../../lib/css/ddmenu.css\" rel=\"stylesheet\" type=\"text/css\" />
            <link href=\"../css/styleFollow.css\" rel=\"stylesheet\" type=\"text/css\" />
            <div id=\"tudo\">
                <div id=\"topo\">
                    
                    <nav id=\"menu\">
                    <ul>
                        <li><a href=\"#\">Menu</a>
                            <ul>
                                <li><a href=\"#\">Alunos &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo;</a>
                                    <ul>
                                        <li><a href=\"FollowUp.class.php\">Follow Up</a></li>
                                        <li><a href=\"../../cadastraAlunoGUI.php\">Cadastro</a></li>
                                        <li><a href=\"Aniversarios.php\">Aniversários</a></li>
                                    </ul>
                                </li>
                            </ul>
                        <li><a href=\"../../cadastro/logout.php\">Sair</a></li>
                    </ul>
                </nav>
            </div>
            <div id=\"principal\">
           ";

if ($db->RetornaNumLinhas() > 0) {
    $Conteudo .= "
                    <title>Consulta de Alunos</title>
                    <h2>Consulta Aluno</h2>
                        <table id=\"followTable\" width=\"130%\" height=\"32%\">
                            <tr>
                                <td style=\"color: #006699;\"><b>Nome</b></td>
                                <td style=\"color: #006699;\"><b>Fone Res.</b></td>
                                <td style=\"color: #006699;\"><b>Celular</b></td>
                                <td style=\"color: #006699;\" align=\"center\"><b>Situação</b></td>
                                <td style=\"color: #006699;\" align=\"center\"><b>Pagamento</b></td>
                                <td style=\"color: #006699;\" align=\"center\"><b>Pr&oacute;x. Venc.</b></td>
                            </tr>
                            ";

    $i = 1;
    while ($row = $db->Resultado()) {

        $id = $row['id'];
        $nome = $row['nome'];
        $foneRes = $row['foneRes'];
        $celular = $row['celular'];
        $situacao = $row['status'];
        $pagamento = $row['pagamento'];

        if ($situacao == 0) {
            $auxSituacao = "Ativo";
        } else {
            $auxSituacao = "<span style=\"color: red;\">Inativo</span>";
        }

        if ($foneRes == "") {
            $foneRes = "-";
        }

        if ($celular == "") {
            $celular = "-";
        }

        $dtVenc = $row['dataVencimento'];

        if ($dtVenc == "") {
            $dtVenc = "-";
        } else {
            $dtVenc = dbDateToDate($dtVenc);
        }


        $Conteudo .= "
                    <tr onMouseOver=\"this.className='linha_realce'\" onMouseOut=\"this.className=''\" onClick=\"location.href='../../alteraCadAlunoGUI.php?id=$id'\">
                            <td>$nome</td>
                            <td>$foneRes</td>
                            <td>$celular</td>
                            <td align=\"center\">$auxSituacao</td>  
                            <td align=\"center\">$pagamento</td>  
                            <td align=\"center\"><b style=\"color: red;\">$dtVenc</b></td>  
                    </tr>";
        $i++;
    }
    $Conteudo .= "</table><br />";
} else {
    die("<b style=\"color: red;\">ATENÇÃO:</b> Não existe dados registrados com o nome: <b><i>$busca</i></b>");
}

$Conteudo .= "<b style=\"font-family: Calibri; font-weight: bold;\">Total de P&aacute;ginas: $paginas</b>";

// pagina anterior
if ($paginas > 0) {
    $Conteudo .= '<span id="paginacao"><a href="?consulta=' . $_GET['consulta'] . '&pagina=' . ($pagina - 1) . '"><b>&laquo; Anterior</b></a>&nbsp;&nbsp;&nbsp;&nbsp;';
}

// Começa a exibição dos paginadores
if ($paginas > 0) {
    for ($i = 1; $i <= $paginas; $i++) {
        if ($i == $pagina) {
            $Conteudo .= " <strong style='color: blue;'>" . $i . "</strong>&nbsp;&nbsp;&nbsp; ";
        }
    }
}

// proxima pagina
if ($paginas > 0) {
    $Conteudo .= '&nbsp;&nbsp;&nbsp;&nbsp;<a href="?consulta=' . $_GET['consulta'] . '&pagina=' . ($pagina + 1) . '"><b>Próxima &raquo;</b></a>&nbsp;&nbsp;</span>';
}

$Conteudo .= "<span id=\"resultados\">Exibindo resultados de $x a $y de $total</span><br />";

$Conteudo .= "</div>
                          <div id=\"rodape\">
                            <span><b>Usu&aacute;rio: </b>" . $_SESSION['login'] . "</span>
                          </div>
                  </div>";
echo $Conteudo;
?>