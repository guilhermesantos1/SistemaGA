<?php

include "lib/classes/DBConexao.class.php";
require "cadastro/verifica.php";

$db = NEW DBConexao();
$db->GetConexao();

$Conteudo = "
                <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
                <link rel=\"stylesheet\" type=\"text/css\" href=\"lib/css/style.css\" />
                <link rel=\"stylesheet\" type=\"text/css\" href=\"lib/css/ddmenu.css\" />
                <link rel=\"stylesheet\" type=\"text/css\" href=\"lib/_style/jquery.click-calendario-1.0.css\" />
                <script type=\"text/javascript\" src=\"lib/_scripts/jquery.js\"></script>
                <script type=\"text/javascript\" src=\"lib/_scripts/jquery.click-calendario-1.0-min.js\"></script>		
                <script type=\"text/javascript\" src=\"lib/_scripts/exemplo-calendario.js\"></script>
                <script type=\"text/javascript\" src=\"lib/js/jquery.maskedinput.js\"></script>
            ";

$Conteudo .=  '
                <script>
                    $(document).ready(function(){
                        $("#dtNasc").mask("99/99/9999");
                        $("#foneRes").mask("(99) 9999-9999");
                        $("#celular").mask("(99) 99999-9999");
                        $("#rg").mask("99.999.999-*");
                        $("#cpf").mask("999.999.999-99");
                        $("#cep").mask("99999-999");
                    });
                </script>';

$Conteudo .= "
                <script>
                    $(document).ready(function(){
                        $('#dtPagto').focus(function(){
                            $(this).calendario({
                                target:'#dtPagto'
                            });
                        });
                    });
                </script>
            ";

$Conteudo .= '
                <script type="text/javascript">
                    function ValidaDados() {
                        var error_string = "";
                        if (document.form.nome.value == "") {
                            error_string += "O campo \"Nome\" é obrigatório!"; 
                        } else if (document.form.dtNasc.value == "") {
                            error_string += "O campo \"Data de Nascimento\" é obrigatório!";
                        } else if (document.form.sexo.value == "") {
                            error_string += "O campo \"Sexo\" é obrigatório!";
                        }

                        if (error_string == "") {
                            return(true);
                        } else {
                            alert(error_string);
                            return(false);
                        }
                    }
                </script>
            ';

$Conteudo .= "
            <div id=\"tudo\">
            <div id=\"topo\">
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
        
$Conteudo .= "
                <title>Cadastra</title>
                <h2>Cadastra Aluno</h2>
                <form method=\"post\" name=\"form\">
                    <table>
                        <tr>
                            <td>Situação:<i style=\"color: red;\">*</i></td>
                            <td>
                                <select name=\"status\">
                                    <option value=\"0\">Ativo</option>
                                    <option value=\"9\">Inativo</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td>Nome:<i style=\"color: red;\">*</i></td>
                            <td><input type=\"text\" name=\"nome\" size=\"62\"></td>
                        </tr>

                        <tr>
                            <td>Data de Nasc.:<i style=\"color: red;\">*</i></td>
                            <td>
                                <input type=\"text\" name=\"dtNasc\" id=\"dtNasc\" size=\"8\">
                                &nbsp;
                                Estado Civil:
                                <select name=\"estadoCivil\">
                                    <option value=\"\"></option>
                                    <option>Solteiro(a)</option>
                                    <option>Casado(a)</option>
                                    <option>Viúvo(a)</option>
                                </select>
                                &nbsp;
                                Sexo:<i style=\"color: red;\">*</i>&nbsp;&nbsp;
                                <select name=\"sexo\">
                                    <option value=\"\"></option>
                                    <option value=\"F\">Feminino</option>
                                    <option value=\"M\">Masculino</option>
                                </select>
                            </td>
                        </tr>

                        <tr>

                        </tr>

                        <tr>
                            <td>RG: </td>
                            <td>
                                <input type=\"text\" name=\"rg\" id=\"rg\" size=\"10\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;
                                CPF:&nbsp;&nbsp; <input type=\"text\" name=\"cpf\" id=\"cpf\" size=\"12\">
                            </td>
                        </tr>

                        <tr> 
                            <td>Endereço:</td>
                            <td>
                                <input type=\"text\" name=\"endereco\" size=\"42\">&nbsp;&nbsp;
                                CEP:&nbsp;&nbsp;
                                <input type=\"text\" name=\"cep\" id=\"cep\" size=\"6\">
                            </td>
                        </tr>

                        <tr>
                            <td>Complemento:</td>
                            <td>
                                <input type=\"text\" name=\"complemento\">&nbsp;&nbsp;
                                Bairro:&nbsp;&nbsp;
                                <input type=\"text\" name=\"bairro\" size=\"28\">
                            </td>
                        </tr>

                        <tr>
                            <td>Cidade:</td>
                            <td><input type=\"text\" name=\"cidade\" size=\"35\"></td>
                        </tr>

                        <tr>
                            <td>Estado:</td>
                            <td>
                                <select name=\"estado\">
                                    <option value=\"\"></option>
                                    ";

                        $sql = ("SELECT * FROM tb_estados
                                ORDER BY nome");
                        $db->Executa($sql) or die("<p style=\"color: red;\"><b>ERRO ao tentar selecionar os valores da tabela de Estados</b></p>" . mysql_error());

                        $i = 1;                                   
                        while ($row = $db->Resultado()) {
                            $nome = utf8_encode($row['nome']);
                            $Conteudo .= "<option>$nome</option>";
                            $i++;
                        }
                                    
                                
                            
$Conteudo .= "
                </select>
                    <tr>
                        <td>Fone Residencial:</td>
                        <td>
                            <input type=\"text\" name=\"foneRes\" id=\"foneRes\" size=\"12\">&nbsp;&nbsp;
                            Celular:&nbsp;&nbsp;
                            <input type=\"text\" name=\"celular\" id=\"celular\" size=\"12\">&nbsp;&nbsp;
                            Op.:&nbsp;&nbsp;
                            <select name=\"operadora\">
                                <option></option>
                                <option>Claro</option>
                                <option>Nextel</option>
                                <option>Oi</option>
                                <option>Tim</option>
                                <option>Vivo</option>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Email:</td>
                        <td><input type=\"text\" name=\"email\" size=\"62\"></td>
                    </tr>
                    
                    <div id=\"pag\">
                    <tr>
                        <td>Situação do Pagamento:</td>
                        <td>
                            <select name=\"pagamento\">
                                <option value=\"\"></option>
                                <option>Pendente</option>
                                <option>Pago</option>
                            </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            Data de Vencimento: <input type=\"text\" name=\"dtPagto\" id=\"dtPagto\" size=\"10\" maxlength=\"10\" />
                        </td>
                    </tr>
                    </div>
                    
                    <tr>
                        <td>Observações:</td>
                        <td><textarea name=\"obs\" id=\"obs\" cols=\"47\" rows=\"8\"></textarea></td>
                    </tr>
            </table>
            
            <div id=\"DIVbotaoForm\">
                <input type=\"button\" value=\"Cadastrar\" onClick=\"if(ValidaDados() == true) { document.form.action = 'cadastraAluno.php'; document.form.submit();} \">
                <input type=\"button\" value=\"Voltar\"
                       onClick=\"self.location = 'lib/classes/FollowUp.class.php'; \">
            </div>
                       <p id=\"aviso\">* Campo de preenchimento obrigatório.</p> 
        </form>";

        $Conteudo .= "</div>
                          <div id=\"rodape\">
                            <span><b>Usu&aacute;rio: </b>" . $_SESSION['login'] . "</span>
                          </div>
                  </div>";

echo $Conteudo;

?>