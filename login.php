<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="lib/css/styleLogin.css">
        <title>Gena Academia</title>
    </head>

    <body>
        <div id="tudo">
            <div id="login" align="center">
                <div id="logo"><img src="lib/imagens/logo-genacademia.JPG" /></div>
                <form action="cadastro/autentica.php" name="autenticacao" method="post">
                    <fieldset>
                        <legend>Autenticação de Usuário</legend>
                        <br />
                        <table>
                            <tr>
                                <td width="50">Usuário:</td>
                                <td width="100">
                                    <input type="text" name="login" size="25">
                                </td>
                            </tr>
                            <tr>
                                <td width="50">Senha:</td>
                                <td width="100">
                                    <input type="password" name="senha" size="25">
                                </td>
                            </tr>
                        </table>

                        <div id="botaoEntrar"><input type="submit" value="Entrar"></div>
                </form>
                <!--<div id="recuperaSenha"><a href="">Esqueci minha senha</a></div>-->
            </div>

        </fieldset>
    </div>
</body>
</html>