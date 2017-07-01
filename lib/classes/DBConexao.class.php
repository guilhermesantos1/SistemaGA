<?php

class DBConexao {

    var $host = "localhost";
    var $usuario = "root";
    var $senha = "";
    var $database = "genacademia";
    var $conexao = NULL;
    var $sql = "";

    function GetConexao() {
        $this->conexao = mysql_connect($this->host, $this->usuario, $this->senha);
        $status = mysql_select_db($this->database, $this->conexao);
        return $status;
    }

    function Executa($sql) {
        $this->query = mysql_query($sql);
        return $this->query;
    }

    function RetornaNumLinhas() {
        return mysql_num_rows($this->query);
    }

    function Resultado() {
        return mysql_fetch_assoc($this->query);
    }

}

?>