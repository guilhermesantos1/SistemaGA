    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="../lib/css/styleLogin.css">
        <script type="text/javascript">
            function ValidaDados() {
                var error_string = "";
                if (document.form.login.value == "") {
                    error_string += "O campo \"Login\" é obrigatório!";
                } else if (document.form.senha.value == "") {
                    error_string += "O campo \"Senha\" é obrigatório!";
                }

                if (error_string == "") {
                    return(true);
                } else {
                    alert(error_string);
                    return(false);
                }
            }
        </script>
        <title>Cadastro de Usuários</title>
    </head>
    <body>
        <h1 align="center">Cadastro de Usuários</h1>
            <form name="form" method="POST" action="cadastraUsuarioProcessa.php">
                <table align="center">
                <tr>
                    <td>
                        <table width="200" border="0" align="center">
                            <tr>
                                <td>Nome:</td>
                                <td><input type="text" name="nome" id="nome"></td>
                            </tr>
                            <tr>
                                <td>Login:</td>
                                <td><input type="text" name="login" id="login"></td>
                            </tr>
                            <tr>
                                <td>Senha:</td>
                                <td><input type="password" name="senha" maxlength="24" id="senha"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                    <?php
                    //Verifica se a página recebeu alguma mensagem de erro
                    if (isset($_GET['Erro']))
                        echo '<tr><td><br><br><font
                                    color="red">' . $_GET['Erro'] . '</font><br></td></tr>';
                    ?>
                </table>
                <div align="center">
                    <input type="button" value="Cadastrar" onClick="if(ValidaDados() == true) { document.form.submit(); } " />
                </div>
            </form>
    </body>
</html>
