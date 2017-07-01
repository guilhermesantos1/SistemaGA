<?php

include "lib/classes/DBConexao.class.php";
include "lib/funcoes/strings.php";

class consultaAluno {

    // variaveis de instância
    var $nome = NULL;
    var $celular = NULL;
    
    var $db = NULL;

    function __construct($nome, $celular) { // assim que a classe for instânciada será executado                                                                                                                                   // esse método, é necessário passar os parâmetros corretos
        
        $this->db = NEW DBConexao(); // instância da classe de banco de dados
        $this->db->GetConexao(); // retorna a conexão com o banco de dados

        // as variaveis de instância da classe, vão ter o valor dos parâmetros passados ao construtor
        $this->nome = $nome;
        $this->celular = $celular;
    }

    function consultaAlunoDB($tabela) { // método para consultar os alunos
        
        $nome = isset($_POST['nome']) ? $_POST['nome'] : NULL;
        $celular = isset($_POST['celular']) ? $_POST['celular'] : NULL;
        
        if ($nome) {
            //die("POSTEI NOME");
            $sql = ("SELECT id, nome, celular, dtNasc, rg
                    FROM $tabela 
                    WHERE nome LIKE '%$this->nome%'
                    ORDER BY nome");
            //die($sql);
            $this->db->Executa($sql) or die("Erro na query. " . mysql_error());
            
            if ($this->db->RetornaNumLinhas() > 0) {
                $Conteudo = "<title>Consulta Alunos</title>
                        <table>
                            <tr>
                                <td bgcolor=\"black\" align=\"center\"><font color=\"white\"><b>Nome</b></td>
                                <td bgcolor=\"black\" align=\"center\"><font color=\"white\"><b>Celular</b></td>
                                <td bgcolor=\"black\" align=\"center\"><font color=\"white\"><b>Data de Nascimento</b></td>
                                <td bgcolor=\"black\" align=\"center\"><font color=\"white\"><b>RG</b></td>
                                <td bgcolor=\"black\" align=\"center\"><font color=\"white\"><b>A&ccedil;&atilde;o</b></td>
                            </tr>";
            
                $i = 1;                                   
                while ($row = $this->db->Resultado()) {
                    if ($i % 2 == 0) {
                        $bgcolor = '#FFFFFF';
                    } else {
                        $bgcolor = '#E8E9E8';
                    }

                    $id = $row['id'];
                    $nome = $row['nome'];
                    $celular = $row['celular'];
                    $dtNasc = dbDateToDate($row['dtNasc']);
                    $rg = $row['rg'];

                    if ($rg == "") {
                        $aux = "-";
                    } else {
                        $aux = "$rg";
                    }
                    
                    $Conteudo .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
                    <tr bgcolor=\"$bgcolor\">
                            <td>$nome</td>
                            <td>$celular</td>
                            <td align=\"center\">$dtNasc</td>
                            <td align=\"center\">$aux</td>
                            <td align=\"center\"><a href=\"alteraCadAlunoGUI.php?&id=$id\"><img src=\"lib/imagens/botao-editar.gif\" /></td>
                    </tr>";
                    $i++;
                }
                $Conteudo .= "</table>";
                echo $Conteudo;
            } else {
                die("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
                    <b style=\"color: red;\">ATENÇÃO:</b> Não existe dados registrados com o nome: <b><i>$this->nome</i></b>");
            }
        } else if ($celular) {
            //die("POSTEI CELULAR");
            $sql = ("SELECT id, nome, celular, dtNasc, rg
                    FROM $tabela 
                    WHERE celular = '$this->celular'
                    ORDER BY nome");
            //die($sql);
            $this->db->Executa($sql) or die("Erro na query. " . mysql_error());
            
            if ($this->db->RetornaNumLinhas() > 0) {
                $Conteudo = "<title>Consulta Alunos</title>
                        <table>
                            <tr>
                                <td bgcolor=\"black\" align=\"center\"><font color=\"white\"><b>Nome</b></td>
                                <td bgcolor=\"black\" align=\"center\"><font color=\"white\"><b>Celular</b></td>
                                <td bgcolor=\"black\" align=\"center\"><font color=\"white\"><b>Data de Nascimento</b></td>
                                <td bgcolor=\"black\" align=\"center\"><font color=\"white\"><b>RG</b></td>
                                <td bgcolor=\"black\" align=\"center\"><font color=\"white\"><b>A&ccedil;&atilde;o</b></td>
                            </tr>";
            
                $i = 1;                                   
                while ($row = $this->db->Resultado()) {
                    if ($i % 2 == 0) {
                        $bgcolor = '#FFFFFF';
                    } else {
                        $bgcolor = '#E8E9E8';
                    }

                    $id = $row['id'];
                    $nome = $row['nome'];
                    $celular = $row['celular'];
                    $dtNasc = dbDateToDate($row['dtNasc']);
                    $rg = $row['rg'];

                    if ($rg == "") {
                        $aux = "-";
                    } else {
                        $aux = "$rg";
                    }
                    
                    $Conteudo .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
                    <tr bgcolor=\"$bgcolor\">
                            <td>$nome</td>
                            <td>$celular</td>
                            <td align=\"center\">$dtNasc</td>
                            <td align=\"center\">$aux</td>    
                            <td align=\"center\"><a href=\"alteraCadAlunoGUI.php?&id=$id\"><img src=\"lib/imagens/botao-editar.gif\" /></td>
                    </tr>";
                    $i++;
                }
                $Conteudo .= "</table>";
                echo $Conteudo;
            } else {
                die("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
                    <b style=\"color: red;\">ATENÇÃO:</b> Não existe dados registrados com o número de celular: <b><i>$this->celular</i></b>");
            }                
        } else {
            //die("OS DOIS CAMPOS ESTAO VAZIOS");
            $sql = ("SELECT id, nome, celular, dtNasc, rg
                    FROM $tabela
                    ORDER BY nome");
            //die($sql);
            $this->db->Executa($sql) or die("Erro na query. " . mysql_error());
            
            if ($this->db->RetornaNumLinhas() > 0) {
                $Conteudo = "<title>Consulta Alunos</title>
                
                        <table>
                            <tr>
                                <td bgcolor=\"black\" align=\"center\"><font color=\"white\"><b>Nome</b></td>
                                <td bgcolor=\"black\" align=\"center\"><font color=\"white\"><b>Celular</b></td>
                                <td bgcolor=\"black\" align=\"center\"><font color=\"white\"><b>Data de Nascimento</b></td>
                                <td bgcolor=\"black\" align=\"center\"><font color=\"white\"><b>RG</b></td>
                                <td bgcolor=\"black\" align=\"center\"><font color=\"white\"><b>A&ccedil;&atilde;o</b></td>
                            </tr>";
            
                $i = 1;                                   
                while ($row = $this->db->Resultado()) {
                    if ($i % 2 == 0) {
                        $bgcolor = '#FFFFFF';
                    } else {
                        $bgcolor = '#E8E9E8';
                    }

                    $id = $row['id'];
                    $nome = $row['nome'];
                    $celular = $row['celular'];
                    $dtNasc = dbDateToDate($row['dtNasc']);
                    $rg = $row['rg'];

                    if ($rg == "") {
                        $aux = "-";
                    } else {
                        $aux = "$rg";
                    }
                    
                    $Conteudo .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
                    <tr bgcolor=\"$bgcolor\">
                            <td>$nome</td>
                            <td>$celular</td>
                            <td align=\"center\">$dtNasc</td>
                            <td align=\"center\">$aux</td>    
                            <td align=\"center\"><a href=\"alteraCadAlunoGUI.php?&id=$id\"><img src=\"lib/imagens/botao-editar.gif\" /></td>
                    </tr>";
                    $i++;
                }
                $Conteudo .= "</table>";
                echo $Conteudo;
            } else {
                die("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
                    <b style=\"color: red;\">ATENÇÃO:</b> Não existe dados registrados na tabela");
            }
        }
        
    } // fim do método (consultaAlunoDB)
        
        /*if ($this->db->RetornaNumLinhas() == 0) {
            echo "N&atilde;o h&aacute; dados registrados";
            exit();
        }*/
        
       /* while ($row = $this->db->Resultado()) {
            
            $nome = $row['nome'];
            $endereco = $row['endereco'];
            $bairro = $row['bairro'];
            $cep = $row['cep'];
            $cidade = $row['cidade'];
            $uf = $row['uf'];
            $email = $row['email'];
            $telefone = $row['telefone'];
            $celular = $row['celular'];
            $rg = $row['rg'];
            $cpf = $row['cpf'];
            
            if ($row['estadoCivil'] == 'Solteiro(a)') {
                if ($row['sexo'] == 'M') {
                    $estadoCivil = 'Solteiro';
                } else if ($row['sexo'] == 'F') {
                    $estadoCivil = 'Solteira';
                }
            } else if($row['estadoCivil'] == 'Casado(a)') {
                if ($row['sexo'] == 'M') {
                    $estadoCivil = 'Casado';
                } else if ($row['sexo'] == 'F') {
                    $estadoCivil = 'Casada';
                }
            } else if ($row['estadoCivil'] == 'Vi&uacute;vo(a)') {
                if ($row['sexo'] == 'M') {
                    $estadoCivil = 'Vi&uacute;vo';
                } else if ($row['sexo'] == 'F') {
                    $estadoCivil = 'Vi&uacute;va';
                }
            }
            
            if ($row['sexo'] == 'M') {
                $sexo = 'Masculino';
            } else if ($row['sexo'] == 'F') {
                $sexo = 'Feminino';
            }
            
            $dtNasc = dbDateToDate($row['dtNasc']);
            
            $Conteudo  = "<title>Consulta Alunos</title>";
            $Conteudo .= "<b>NOME:</b> " . $nome . "&nbsp;|&nbsp; <b>ESTADO CIVIL:</b> " . $estadoCivil . "<br />"; 
            $Conteudo .= "<b>DATA DE NASCIMENTO:</b> " . $dtNasc . "&nbsp;|&nbsp; <b>ENDERE&Ccedil;O:</b> " . $endereco . "<br />";
            $Conteudo .= "<b>BAIRRO:</b> " . $bairro . "&nbsp;|&nbsp; <b>CEP:</b> " . $cep . "<br />";
            $Conteudo .= "<b>CIDADE:</b> " . $cidade . "&nbsp;|&nbsp; <b>UF:</b> " . $uf . "<br />";
            $Conteudo .= "<b>EMAIL: </b>" . $email . "&nbsp;|&nbsp; <b>TELEFONE:</b> " . $telefone. "<br />";
            $Conteudo .= "<b>CELULAR:</b> " . $celular . "&nbsp;|&nbsp; <b>RG:</b> " . $rg . "<br />";
            $Conteudo .= "<b>CPF:</b> " . $cpf . "&nbsp;|&nbsp; <b>SEXO:</b> " . $sexo . "<br />";
            echo $Conteudo;
        }*/
    
} // fim da classe consultaAluno

$consulta = NEW consultaAluno(trim($_POST['nome']), $_POST['celular']);

if ($consulta->db) { //se a conexão estiver ativa
    $consulta->consultaAlunoDB("alunos"); // executa o método para consulta de alunos
}
?>

