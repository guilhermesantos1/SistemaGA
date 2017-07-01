<?php

//Inclui conexão com o banco de dados
include('../lib/classes/DBConexao.class.php');

$db = NEW DBConexao();
$db->GetConexao();

session_start();

$cadastro_concluido = "ok.php";

//As variáveis recebem o valor digitado pelo usuário
$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$login = isset($_POST['login']) ? $_POST['login'] : '';
$senha = isset($_POST['senha']) ? $_POST['senha'] : '';
$senhacriptografada = md5($senha);

//Insere os valores no banco de dados
    $sql = ("
        INSERT INTO usuarios (id, nome, login, senha) 
        VALUES (NULL, '$nome', '$login', '$senhacriptografada')
        ");

    $db->Executa($sql) or die("Falha na inclusao do cadastro do funcionario " . $nome . " -> " . $sql);

header("Location: $cadastro_concluido");
?>