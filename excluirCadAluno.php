<?php

include "lib/classes/DBConexao.class.php";
include "lib/funcoes/strings.php";

$db = NEW DBConexao();
$db->GetConexao();

$num = isset($_GET['id']) ? $_GET['id'] : NULL;

$sql = ("DELETE FROM alunos WHERE id = $num");
$db->Executa($sql) or die("Erro na query. " . mysql_error());

echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
    <meta http-equiv=\"refresh\" content=\"3;URL='lib/classes/FollowUp.class.php'\" /><b style=\"color: red;\">EXCLUSÃO REALIZADA COM SUCESSO!";

?>