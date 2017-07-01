<?php

include "DBConexao.class.php";
include "../funcoes/strings.php";
require "../../cadastro/verifica.php";

class FollowUp {

    var $id = null;
    var $db = null;
    var $usuario = null;

    function __construct() {
        $this->db = new DBConexao(); // instância da classe de banco de dados
        $this->db->GetConexao(); // retorna a conexão com o banco de dados
        $this->usuario = $_SESSION['login'];
    }

    function GetConteudo($tabela) {

        $Registros['PorPagina'] = 20; // Número de registros por página
        // Monta a consulta MySQL para saber quantos registros serão encontrados
        $sql = "SELECT COUNT(*) AS total FROM alunos WHERE status = 0";
        // Executa a consulta
        //die($sql);
        $query = $this->db->Executa($sql) or die("Erro na query. " . mysql_error());
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
        //$fim = ceil($total / $Registros['PorPagina']);
        // ============================================


        $x = min($total, ($inicio + 1));
        $y = min($total, ($inicio + $Registros['PorPagina']));

        $sql = ("SELECT id, nome, foneRes, celular, status, pagamento, dataVencimento
                    FROM $tabela
                    WHERE status = 0
                    ORDER BY nome ASC LIMIT $inicio, " . $Registros['PorPagina'] . "");
        //die($sql);
        $this->db->Executa($sql) or die("Erro na query. " . mysql_error());

        $Conteudo = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
                     <link rel=\"stylesheet\" type=\"text/css\" href=\"../css/styleFollow.css\" />
                     <link rel=\"stylesheet\" type=\"text/css\" href=\"../../lib/css/ddmenu.css\" />
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
                    <table width=\"133%\" height=\"1%\">
                        <tr>
                            <td>
                                <input type=\"button\" value=\"Cadastrar Novo Aluno\" onClick=\"self.location='../../cadastraAlunoGUI.php'; \" />
                                <div id=\"busca\"> <!-- inicio da DIV busca -->
                            </td>
                            
                            <td>
                                    <form method=\"GET\" action=\"buscaRapida.php\">
                                        <input type=\"text\" id=\"consulta\" name=\"consulta\" size=\"30\" maxlength=\"255\" />
                                        <input type=\"submit\" value=\"Buscar\" />
                                    </form>
                                </div> <!-- fim da DIV busca -->
                            </td>
                        </tr>
                     </table>";

        if ($this->db->RetornaNumLinhas() > 0) {
            $Conteudo .= "
                    <title>Consulta de Alunos</title>
                        <table id=\"followTable\" width=\"130%\" height=\"30%\">
                            <tr>
                                <td style=\"color: #006699;\"><b>Nome</b></td>
                                <td style=\"color: #006699;\"><b>Fone Res.</b></td>
                                <td style=\"color: #006699;\"><b>Celular</b></td>
                                <td style=\"color: #006699;\" align=\"center\"><b>Situa&ccedil;&atilde;o</b></td>
                                <td style=\"color: #006699;\" align=\"center\"><b>Pagamento</b></td>
                                <td style=\"color: #006699;\" align=\"center\"><b>Pr&oacute;x. Venc.</b></td>
                            </tr>
                            ";

            while ($row = $this->db->Resultado()) {

                $id = $row['id'];
                $nome = $row['nome'];
                $foneRes = $row['foneRes'];
                $celular = $row['celular'];
                $situacao = $row['status'];
                $pagamento = $row['pagamento'];
                $dtVenc = $row['dataVencimento'];

                if ($situacao == 0) {
                    $auxSituacao = "Ativo";
                } else {
                    $auxSituacao = "Inativo";
                }

                if ($foneRes == "") {
                    $foneRes = "-";
                }

                if ($celular == "") {
                    $celular = "-";
                }

                if ($dtVenc == "") {
                    $dtVenc = "-";
                } else {
                    $dtVenc = dbDateToDate($dtVenc);
                }
                
                $dtVencCompara = DateTodbDate($dtVenc);
                $dtVencNum = dbDateToNumber($dtVencCompara);
                //die("ddd " . $dtVencNum);
                
                $dtAtual = date("Ymd");
                
                if ($dtAtual > $dtVencNum) {
                    $auxPagto = "<b style=\"color: red;\">Pendente</b>";
                } else {
                    $auxPagto = $pagamento;
                }
                


                $Conteudo .= "
                    <tr onMouseOver=\"this.className='linha_realce'\" onMouseOut=\"this.className=''\" onClick=\"location.href='../../alteraCadAlunoGUI.php?id=$id'\">
                            <td>$nome</td>
                            <td>$foneRes</td>
                            <td>$celular</td>
                            <td align=\"center\">$auxSituacao</td>  
                            <td align=\"center\">$auxPagto</td>  
                            <td align=\"center\"><b style=\"color: red;\">$dtVenc</b></td>  
                    </tr>";
            }

            $Conteudo .= "</table><br />";
            
            $Conteudo .= "<b style=\"font-family: Calibri; font-weight: bold;\">Total de P&aacute;ginas: $paginas</b>";

            // pagina anterior
            if ($paginas > 0) {
                $Conteudo .= '<span id="paginacao"><a href="?pagina=' . ($pagina - 1) . '"><b>&laquo; Anterior</b></a>&nbsp;&nbsp;&nbsp;&nbsp;';
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
                $Conteudo .= '&nbsp;&nbsp;&nbsp;&nbsp;<a href="?pagina=' . ($pagina + 1) . '"><b>Pr&oacute;xima &raquo;</b></a>&nbsp;&nbsp;</span>';
            }

            $Conteudo .= "<span id=\"resultados\">Exibindo resultados de $x a $y de $total</span><br />";

            $Conteudo .= "</div>
                          <div id=\"rodape\">
                            <span><b>Usu&aacute;rio: </b>$this->usuario</span>
                          </div>
                  </div>";
            echo $Conteudo;
        } else {
            die("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
                    <b style=\"color: red;\">ATENÇÃO:</b> Não existe dados registrados na tabela");
        }
    }

}

// fim da classe

$Conteudo = new FollowUp();

if ($Conteudo->db) { // se a conexão estiver ativa
    $Conteudo->GetConteudo("alunos");
}
?>
