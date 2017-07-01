<?php

include ("lib/classes/DBConexao.class.php");

$db = NEW DBConexao();
$db->GetConexao();

$sql = ("SELECT * FROM alunos");
$db->Executa($sql);

// se for o primeiro acesso ao sistema depois de criada a tabela do banco de dados
// ele redireciona o usuario para cadastrar um aluno
if ($db->RetornaNumLinhas() > 0) {
    header("Location: lib/classes/FollowUp.class.php");
} else {
    header("Location: cadastraAlunoGUI.php");
}
?>


