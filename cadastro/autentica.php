<?php

//Inclui conexão com o banco de dados
include('../lib/classes/DBConexao.class.php');

// instancia a classe que possui a conexão direta com o banco de dados
$db = NEW DBConexao();
// a variável $db recebe a conexão ativa com o banco de dados
$db->GetConexao();

// Recebemos os dados digitados pelo usuário
$login = $_POST['login'];
$senha = md5($_POST['senha']);

// query que efetua a busca no banco de dados
$sql = ("SELECT id, nome FROM usuarios 
        WHERE login = '$login' 
        AND senha = '$senha'");

// executa a query
$db->Executa($sql);

//Verificams se alguma linha foi afetada, caso sim retornamos suas informações
if ($db->RetornaNumLinhas() > 0) {
    // Retorna os dados do banco
    while ($row = $db->Resultado()) {
        $id = $row['id'];
        $nome = $row['nome'];
    }

    //Inicia a sessão
    session_start();

    //Registra os dados do usuário na sessão
    $_SESSION['LoginFeito'] = TRUE;
    $_SESSION['id'] = $id;
    $_SESSION['nome'] = $nome;
    $_SESSION['login'] = $login;

    //Redireciona para o index
    header("Location: ../index.php");
} else {
    if (($_POST['login'] == "") && ($_POST['senha'] == "")) {
        die("<p style=\"color: red;\"><b>Por favor, informe seu usuário e a sua senha!</b></p>");
    } else if ($_POST['login'] == "") {
        die("<p style=\"color: red;\"><b>O seu login está em branco!</b></p>");
    } else if ($_POST['senha'] == "") {
        die("<p style=\"color: red;\"><b>A sua senha está em branco!</b></p>");    
    }
    //Caso nenhuma linha seja retornada emite o alerta e retorna
    echo "<p style=\"color: red;\"><b>Usuário(a) não cadastrado na base de dados!</b></p>";
    echo "<meta http-equiv='refresh' content='3;URL=../login.php'>";
}

?>