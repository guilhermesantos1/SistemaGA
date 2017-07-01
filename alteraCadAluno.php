<?php

include "lib/classes/DBConexao.class.php";
include "lib/funcoes/strings.php";

$db = NEW DBConexao();
$db->GetConexao();

$num = isset($_GET['id']) ? $_GET['id'] : "";

$status = isset($_POST['status']) ? $_POST['status'] : "";
$nome = isset($_POST['nome']) ? trim($_POST['nome']) : "";
$dtNasc = isset($_POST['dtNasc']) ? DateTodbDate($_POST['dtNasc']) : "";
$estadoCivil = isset($_POST['estadoCivil']) ? $_POST['estadoCivil'] : "";
$sexo = isset($_POST['sexo']) ? $_POST['sexo'] : "";
$rg = isset($_POST['rg']) ? $_POST['rg'] : "";
$cpf = isset($_POST['cpf']) ? $_POST['cpf'] : "";
$cep = isset($_POST['cep']) ? $_POST['cep'] : "";
$endereco = isset($_POST['endereco']) ? trim($_POST['endereco']) : "";
$complemento = isset($_POST['complemento']) ? trim($_POST['complemento']) : "";
$bairro = isset($_POST['bairro']) ? trim($_POST['bairro']) : "";
$cidade = isset($_POST['cidade']) ? trim($_POST['cidade']) : "";
$estado = isset($_POST['estado']) ? $_POST['estado'] : "";
$foneRes = isset($_POST['foneRes']) ? $_POST['foneRes'] : "";
$celular = isset($_POST['celular']) ? $_POST['celular'] : "";
$operadora = isset($_POST['operadora']) ? $_POST['operadora'] : "";
$email = isset($_POST['email']) ? trim($_POST['email']) : "";
$pagamento = isset($_POST['pagamento']) ? $_POST['pagamento'] : "";
$obs = isset($_POST['obs']) ? trim($_POST['obs']) : "";

$dtPagto = isset($_POST['dtPagto']) ? $_POST['dtPagto'] : "";

if ($dtPagto == "") {
    $dtPagto = "";
    $dtVenc = "";
} else {
    $dtPagto = DateTodbDate($_POST['dtPagto']);
    $dtVenc = calculaPagto($dtPagto);
}

$sql = ("UPDATE alunos SET status = $status, nome = '$nome', dtNasc = '$dtNasc', estadoCivil = '$estadoCivil', sexo = '$sexo', 
        rg = '$rg', cpf = '$cpf', cep = '$cep', endereco = '$endereco', complemento = '$complemento', bairro = '$bairro', cidade = '$cidade', 
        estado = '$estado', foneRes = '$foneRes', celular = '$celular', operadora = '$operadora', email = '$email', 
        pagamento = '$pagamento', obs = '$obs', dataPagamento = '$dtPagto', dataVencimento = '$dtVenc'
        WHERE id = $num");
//die($sql);
$db->Executa($sql) or die("<p style=\"color: red;\"><b>ERRO ao tentar ALTERAR o cadastro de um aluno!</b></p>" . mysql_error());

echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
    <meta http-equiv=\"refresh\" content=\"3;URL='lib/classes/FollowUp.class.php'\"><b style=\"color: red;\">ALTERAÇÃO REALIZADA COM SUCESSO!</b>";

?>
