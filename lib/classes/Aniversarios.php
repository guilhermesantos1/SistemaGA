<?php

include "DBConexao.class.php";
include "../funcoes/strings.php";
require "../../cadastro/verifica.php";

$db = new DBConexao();
$db->GetConexao();

$sql = ("SELECT nome, dtNasc FROM alunos
        ORDER BY nome");
$db->Executa($sql);

$Conteudo = "
            <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
            <link rel=\"stylesheet\" type=\"text/css\" href=\"../../lib/css/ddmenu.css\" />
            <link rel=\"stylesheet\" type=\"text/css\" href=\"../css/styleNiver.css\" />
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
            </div> <!-- fim da div topo -->
            <div id=\"principal\">
            ";


if ($db->RetornaNumLinhas() > 0) {
    $Conteudo .= "
                    <title>Anivers&aacute;rios</title>
                    <h2>Aniversariantes do M&ecirc;s</h2>
                    <table id=\"tableNiver\" width=\"60%\" height=\"25%\">
                        <tr>
                            <td style=\"color: #006699;\"><b>Data</b></td>
                            <td style=\"color: #006699;\"><b>Nome</b></td>
                        </tr>
                ";

    while ($row = $db->Resultado()) {
        $nome = $row['nome'];
        $dtNasc = dbDateToDate($row['dtNasc']);
        $mesAtual = date("m");
        $mesNiver = substr($dtNasc, 3, 2);
        $diaNiver = substr($dtNasc, 0, 2);

        if ($mesAtual == $mesNiver) {

            $Conteudo .= "
                            <tr onMouseOver=\"this.className='linha_realce'\" onMouseOut=\"this.className=''\">
                                <td>$diaNiver/$mesNiver</td>
                                <td>$nome</td>
                            </tr>
                        ";
        }

    }
    
    $Conteudo .= "
                    </div> <!-- fim da div principal -->
                    </table><br /><br />
                        <div id=\"rodape\">
                            <b>Usu&aacute;rio: </b>" . $_SESSION['login'] . "
                        </div> <!-- fim da div rodape -->
                    </div> <!-- fim da div tudo -->
                    
                ";

    echo $Conteudo;
} else {
    die("A consulta não retornou dados");
}
?>
