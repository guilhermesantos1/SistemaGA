<?php
include "lib/classes/DBConexao.class.php";
include "lib/funcoes/strings.php";
require "cadastro/verifica.php";

$num = isset($_GET['id']) ? $_GET['id'] : NULL;

$db = NEW DBConexao();
$db->GetConexao();

$sql = ("SELECT * FROM alunos WHERE id = $num");
$db->Executa($sql);

while ($row = $db->Resultado()) {
    $id = $row['id'];
    $status = $row['status'];
    if ($status == 0) {
        $auxStatus = "<option value=\"0\" selected>Ativo</option>
                      <option value=\"9\">Inativo</option> ";
    } else {
        $auxStatus = "<option value=\"9\"selected>Inativo</option>
                      <option value=\"0\">Ativo</option> ";
    }
    
    $nome = $row['nome'];
    $dtNasc = dbDateToDate($row['dtNasc']);
    $idade = calculaIdade($dtNasc);
    $estadoCivil = $row['estadoCivil'];
    if ($estadoCivil == "Solteiro(a)") {
	$aux = "<option></option>
                <option selected>Solteiro(a)</option>
                <option>Casado(a)</option>
                <option>Viúvo(a)</option>";
    } else if ($estadoCivil == "Casado(a)") {
        $aux = "<option></option>
                <option selected>Casado(a)</option>
                <option>Solteiro(a)</option>
                <option>Viúvo(a)</option>";
    } else if ($estadoCivil == "Viúvo(a)") {
        $aux = "<option></option>
                <option selected>Viúvo(a)</option>
                <option>Solteiro(a)</option>
                <option>Casado(a)</option>";
    } else {
        $aux = "<option selected></option>
                <option>Solteiro(a)</option>
                <option>Casado(a)</option>
                <option>Viúvo(a)</option>";
    }
    
    $sexo = $row['sexo'];
    // tratamento para o caso SEXO
    if ($sexo == "M") {
        $sexo = "Masculino";
    } else {
        $sexo = "Feminino";
    }  
    
    if ($sexo == "Masculino") {
        $auxSexo = "<option value=\"M\" selected>Masculino</option>
                    <option value=\"F\">Feminino</option>";
    } else {
        $auxSexo = "<option value=\"F\" selected>Feminino</option>
                    <option value=\"M\">Masculino</option>";
    }
    
    $rg = $row['rg'];
    $cpf = $row['cpf'];
    $cep = $row['cep'];
    $endereco = $row['endereco'];
    $complemento = $row['complemento'];
    $bairro = $row['bairro'];
    $cidade = $row['cidade'];
    
    $estado = $row['estado'];
    
    if ($estado == "") {
        $auxEst = "<option></option>";
    } else {
        $auxEst = "<option></option>
                   <option selected>$estado</option>";
    }
    $foneRes = $row['foneRes'];
    $celular = $row['celular'];
    
    $operadora = $row['operadora'];
    
    if ($operadora == "Claro") {
        $auxOp = "
                <option></option>
                <option selected>Claro</option>
                <option>Nextel</option>
                <option>Oi</option>
                <option>Tim</option>
                <option>Vivo</option>";
    } else if ($operadora == "Nextel") {
        $auxOp = "
                <option></option>
                <option selected>Nextel</option>
                <option>Claro</option>
                <option>Oi</option>
                <option>Tim</option>
                <option>Vivo</option>";
    } else if ($operadora == "Oi") {
        $auxOp = "
                <option></option>
                <option selected>Oi</option>
                <option>Claro</option>
                <option>Nextel</option>
                <option>Tim</option>
                <option>Vivo</option>";
    } else if ($operadora == "Tim") {
        $auxOp = "
                <option></option>
                <option selected>Tim</option>
                <option>Claro</option>
                <option>Nextel</option>
                <option>Oi</option>
                <option>Vivo</option>";
    } else if ($operadora == "Vivo") {
        $auxOp = "
                <option></option>
                <option selected>Vivo</option>
                <option>Claro</option>
                <option>Nextel</option>
                <option>Oi</option>
                <option>Tim</option>";
    } else {
        $auxOp = "
                <option selected></option>
                <option>Claro</option>
                <option>Nextel</option>
                <option>Oi</option>
                <option>Tim</option>
                <option>Vivo</option>";
    }
    
    $email = $row['email'];
    $pagamento = $row['pagamento'];
    
    // tratamento para o PAGAMENTO
    if ($pagamento == "Pendente") {
        $auxPagto = "<option selected>Pendente</option>
                     <option>Pago</option>";
    } else {
        $auxPagto = "<option selected>Pago</option>
                     <option>Pendente</option>";
    }
    
    $obs = $row['obs'];
    
    $dtPagto = dbDateToDate($row['dataPagamento']);
    $dtVenc = dbDateToDate($row['dataVencimento']);
    if ($dtVenc == "") {
        $auxDtVenc = "--";
    } else {
        $auxDtVenc = $dtVenc;
    }
    
} // fim do while



if ($db->RetornaNumLinhas() > 0) {
    $Conteudo = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
                <link rel=\"stylesheet\" type=\"text/css\" href=\"lib/css/style.css\">
                <link rel=\"stylesheet\" type=\"text/css\" href=\"lib/css/ddmenu.css\">
                <link href=\"lib/_style/jquery.click-calendario-1.0.css\" rel=\"stylesheet\" type=\"text/css\"/>
                <script type=\"text/javascript\" src=\"lib/_scripts/jquery.js\"></script>
                <script type=\"text/javascript\" src=\"lib/_scripts/jquery.click-calendario-1.0-min.js\"></script>		
                <script type=\"text/javascript\" src=\"lib/_scripts/exemplo-calendario.js\"></script>
                <script type=\"text/javascript\" src=\"lib/js/jquery.maskedinput.js\"></script>
            ";
    
    $Conteudo .=  '<script>
                        $(document).ready(function(){
                            $("#dtNasc").mask("99/99/9999");
                            $("#foneRes").mask("(99) 9999-9999");
                            $("#cep").mask("99999-999");
                            $("#rg").mask("99.999.999-*");
                            $("#cpf").mask("999.999.999-99");
                            $("#celular").mask("(99) 99999-9999");
                        });
                    </script>';
    
    $Conteudo .= "<script>
                    $(document).ready(function(){
                        $('#dtPagto').focus(function(){
                            $(this).calendario({
                                target:'#dtPagto'
                            });
                        });
                   });
              </script>";
    
    $Conteudo .= '<script type="text/javascript">
                            function ValidaDados() {
                                var error_string = "";
                                if (confirm("Confirma a alteração?")) {
                                    if (document.formAlteraCadAluno.nome.value == "") {
                                        error_string += "O campo \"Nome\" é obrigatório!"; 
                                    } else if (document.formAlteraCadAluno.dtNasc.value == "") {
                                        error_string += "O campo \"Data de Nascimento\" é obrigatório!";
                                    } else if (document.formAlteraCadAluno.sexo.value == "") {
                                        error_string += "O campo \"Sexo\" é obrigatório!";
                                    }
                                    
                                    if (error_string == "") {
                                        return(true);
                                    } else {
                                        alert(error_string);
                                        return(false);
                                    }
                                }
                            }
			</script>';
    
    $Conteudo .= "
            <div id=\"tudo\">
            <div id=\"topo\">
               <link href=\"../../lib/css/ddmenu.css\" rel=\"stylesheet\" type=\"text/css\" />
                    <nav id=\"menu\">
                    <ul>
                        <li><a href=\"#\">Menu</a>
                            <ul>
                               <li><a href=\"#\">Alunos &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo;</a>
                                    <ul>
                                        <li><a href=\"lib/classes/FollowUp.class.php\">Follow Up</a></li>
                                        <li><a href=\"cadastraAlunoGUI.php\">Cadastro</a></li>
                                        <li><a href=\"lib/classes/Aniversarios.php\">Aniversários</a></li>
                                    </ul>
                                </li>
                            </ul>
                        <li><a href=\"cadastro/logout.php\">Sair</a></li>
                    </ul>
                </nav>
            </div>
            <div id=\"principal\">
           ";
        
    $Conteudo .= "<title>Altera</title>
                <h2>Altera Dados do Aluno</h2>
            <form method=\"post\" name=\"formAlteraCadAluno\">
                <table>
                    <tr>
                        <td>Situação:<i style=\"color: red;\">*</i></td>
                        <td>
                            <select name=\"status\">
                                $auxStatus
                            </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            Próximo Vencimento: <span style=\"color: red;\">$auxDtVenc</span>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Nome:<i style=\"color: red;\">*</i></td>
                        <td><input type=\"text\" name=\"nome\" size=\"62\" value=\"$nome\"></td>
                    </tr>
                    
                    <tr>
                        <td>Data de Nasc.:<i style=\"color: red;\">*</i></td>
                        <td>
                            <input type=\"text\" name=\"dtNasc\" id=\"dtNasc\" size=\"8\" value=\"$dtNasc\">
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            Idade:&nbsp;&nbsp;$idade &nbsp;&nbsp;&nbsp;&nbsp;
                            Sexo: <i style=\"color: red;\">*</i>
                            <select name=\"sexo\">
                                    $auxSexo
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>RG: </td>
                        <td>
                            <input type=\"text\" name=\"rg\" id=\"rg\" size=\"10\" value=\"$rg\">&nbsp;&nbsp;
                            CPF: &nbsp;&nbsp;<input type=\"text\" name=\"cpf\" id=\"cpf\" size=\"12\" value=\"$cpf\">&nbsp;&nbsp;
                            Estado Civil: <select name=\"estadoCivil\">
                                            $aux
                                          </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Endereço:</td>
                        <td>
                            <input type=\"text\" name=\"endereco\" size=\"42\" value=\"$endereco\">&nbsp;&nbsp;
                            CEP:&nbsp;&nbsp;
                            <input type=\"text\" name=\"cep\" id=\"cep\" value=\"$cep\" size=\"6\">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Complemento:</td>
                        <td>
                            <input type=\"text\" name=\"complemento\" value=\"$complemento\">&nbsp;&nbsp;
                            Bairro:&nbsp;&nbsp;
                            <input type=\"text\" name=\"bairro\" size=\"28\" value=\"$bairro\">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Cidade:</td>
                        <td><input type=\"text\" name=\"cidade\" size=\"35\" value=\"$cidade\"></td>
                    </tr>

                    <tr>
                        <td>Estado:</td>
                        <td>
                            <select name=\"estado\">
                                $auxEst
                                ";

                    $sql = ("SELECT * FROM tb_estados
                            ORDER BY nome");
                    $db->Executa($sql) or die("<p style=\"color: red;\"><b>ERRO ao tentar selecionar os valores da tabela de Estados</b></p>" . mysql_error());
                                
                    $i = 1;                                   
                    while ($row = $db->Resultado()) {
                        $nomeEst = utf8_encode($row['nome']);
                        $Conteudo .= "<option>$nomeEst</option>";
                        $i++;
                    }
                                    
                                
                            
$Conteudo .= "</select>
                    <tr>
                        <td>Fone Residencial:</td>
                        <td>
                            <input type=\"text\" name=\"foneRes\" id=\"foneRes\" size=\"12\" value=\"$foneRes\">&nbsp;&nbsp;
                            Celular:&nbsp;&nbsp;
                            <input type=\"text\" name=\"celular\" id=\"celular\" size=\"12\" value=\"$celular\">&nbsp;&nbsp;
                            Op.:&nbsp;&nbsp;
                            <select name=\"operadora\">
                                $auxOp
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Email:</td>
                        <td><input type=\"text\" name=\"email\" size=\"62\" value=\"$email\"></td>
                    </tr>
                    
                    <tr>
                        <td>Situação do Pagamento:</td>
                        <td>
                            <select name=\"pagamento\">
                                $auxPagto
                            </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            Data de Vencimento: <input type=\"text\" name=\"dtPagto\" id=\"dtPagto\" value=\"$dtPagto\" size=\"10\" maxlength=\"10\" />
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Observações:</td>
                        <td><textarea name=\"obs\" id=\"obs\" cols=\"47\" rows=\"8\">$obs</textarea></td>
                    </tr>
                </table>
                <div id=\"DIVBotaoForm\">
                    <input type=\"button\" value=\"Alterar\" onClick=\"if(ValidaDados() == true) { document.formAlteraCadAluno.action = 'alteraCadAluno.php?id=" . $id . "'; document.formAlteraCadAluno.submit();} \" /> 
                    <input type=\"button\" value=\"Excluir\" onClick=\"if (confirm('Confirma a exclusão?')) {document.formAlteraCadAluno.action = 'excluirCadAluno.php?id=" . $id . "'; document.formAlteraCadAluno.submit();} else {return false;} \" />   
                    <input type=\"button\" value=\"Voltar\" onClick=\"self.location = 'lib/classes/FollowUp.class.php'; \" />
                </div>
                <p id=\"aviso\">* Campo de preenchimento obrigatório.</p> 
            </form>
            
            
    ";

    $Conteudo .= "</div>
                          <div id=\"rodape\">
                            <span><b>Usu&aacute;rio: </b>" . $_SESSION['login'] . "</span>
                          </div>
                  </div>";

    echo $Conteudo;
} else {
    die("<b style=\"color: red;\">ATENÇÃO:</b> Não existe dados registrados na tabela");
}

?>
