<?php

session_start(); //Inicia a sessão
$_SESSION = array();
session_destroy(); //Encerra a sessão

echo "<p style=\"color: red;\"><b>SESS&Atilde;O ENCERRADA!</b></p>";
echo "<meta http-equiv='refresh' content='3;URL=../login.php'>";
?>