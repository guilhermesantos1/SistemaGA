<?php

$Conteudo = "<script type=\"text/javascript\" src=\"lib/js/jquery-1.8.3.min.js\"></script>
            <script type=\"text/javascript\" src=\"lib/js/jquery.maskedinput.js\"></script>
            <link rel=\"stylesheet\" type=\"text/css\" href=\"lib/css/style.css\">";
        
$Conteudo .= '<script>
                $(document).ready(function(){
                    $("#celular").mask("(99) 99999-9999");
                });
            </script>';

$Conteudo .= "<title>Consultar Alunos</title>
    </head>
    <body>
        <form action=\"consultaAluno.php\" method=\"post\" name=\"form\">
            <table>
                <tr>
                    <td>Nome: </td>
                    <td><input type=\"text\" name=\"nome\"></td>
                </tr>
                
                <tr>
                    <td>Celular: </td>
                    <td><input type=\"text\" name=\"celular\" id=\"celular\"></td>
                </tr>

            </table>
            <input type=\"submit\" value=\"Pesquisar\">
            <input type=\"button\" value=\"Voltar\"
                       onClick=\"self.location = 'index.php'; \">
        </form>";

echo $Conteudo;

?>