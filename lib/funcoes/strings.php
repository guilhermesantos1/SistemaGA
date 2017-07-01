<?php

// Fun��o que prepara uma data no formato 'dd/mm/aaaa' para ser gravada no banco de dados.
function DateTodbDate($data) {
    if (($data == NULL) or ($data == '') or ($data == ' '))
        return "NULL";
    $ano = substr($data, 6, 4);
    $mes = substr($data, 3, 2);
    $dia = substr($data, 0, 2);
    $dt = $ano . '-' . $mes . '-' . $dia;
    return ($dt);
}

function dbDateToNumber($data) {
    if (($data == NULL) or ($data == '') or ($data == ' '))
        return NULL;
    $ano = substr($data, 0, 4);
    $mes = substr($data, 5, 2);
    $dia = substr($data, 8, 2);
    $dt = $ano . $mes . $dia;
    if ($dt < 19000101)
        return NULL;
    return ($dt);
}

function dbDateToDate($data) {
    if (($data == NULL) or ($data == '') or ($data == ' '))
        return NULL;
    $ano = substr($data, 0, 4);
    $mes = substr($data, 5, 2);
    $dia = substr($data, 8, 2);
    $dt = $dia . '/' . $mes . '/' . $ano;
    return ($dt);
}

function DateToNumber($data) {
    if (($data == NULL) or ($data == '') or ($data == ' '))
        return NULL;
    $ano = substr($data, 6, 4);
    $mes = substr($data, 3, 2);
    $dia = substr($data, 0, 2);
    $dt = $ano . $mes . $dia;
    if ($dt < 19000101)
        return NULL;
    return ($dt);
}

// Fun��o que transforma uma data no formato 'aaaammdd' para o formato 'dd/mm/aaaa'.
function NumberToDate($data) {
    if (($data == NULL) or ($data == '') or ($data == ' '))
        return NULL;
    $ano = substr($data, 0, 4);
    $mes = substr($data, 4, 2);
    $dia = substr($data, 6, 2);
    $dt = $dia . '/' . $mes . '/' . $ano;
    return ($dt);
}

// Fun��o que transforma uma data no formato 'aaaammdd' para ser gravada no banco de dados.
function NumberTodbDate($data) {
    if (($data == NULL) or ($data == '') or ($data == ' '))
        return "NULL";
    $ano = substr($data, 0, 4);
    $mes = substr($data, 4, 2);
    $dia = substr($data, 6, 2);
    $dt = "'" . $ano . '-' . $mes . '-' . $dia . "'";
    return ($dt);
}

// fun��o que retorna o 1� nome de uma string que devolve o nome completo
function PrimeiroNome($nome) {
    return(substr($nome, 0, strpos($nome, " ")));
}

// fun��o para quebrar texto em v�rias linhas sem quebrar palavra ao final da linha
function QuebraTexto($texto = "", $tamanho_celula = "") {
//elimina sujeiras na vari�vel de sa�da
    unset($texto_saida);
    $cont = 0;
//se o texto n�o couber todo em uma c�lula, faz a divis�o respeitando palavras inteiras no final das c�lulas
    if (strlen($texto) > $tamanho_celula) {
        while (strlen($texto) > 0) {
//verifica a posi��o do �ltimo espa�o em branco na substring
            $pos = strrpos(substr($texto, 0, $tamanho_celula), " ");
//se n�o existir espa�o em branco ou o texto couber na c�lula
            if (($pos == 0) or (strlen($texto) < $tamanho_celula)) {
                $pos = $tamanho_celula;
            }
//cria o array do texto, desde o in�cio at� o �ltimo espa�o em branco
            $texto_saida[$cont] = substr($texto, 0, $pos);
//reseta o texto, iniciando a partir do caracter seguinte � substring colocada no array
            $texto = substr($texto, $pos + 1, strlen($texto));
            $cont += 1;
        } //fim do while
    } else { //se o texto couber inteiro na c�lula
        $texto_saida[$cont] = $texto;
    }
    return $texto_saida;
}

// fun��o de consist�ncia usa dentro da fun��o AlternaCaps
function TestaNome(&$strProxNome) {
    $strProxNome = trim($strProxNome);
    if (Strlen($strProxNome)) {
        if (($strProxNome != "e") AND ($strProxNome != "da") AND ($strProxNome != "das") AND ($strProxNome != "de") AND ($strProxNome != "do") AND ($strProxNome != "dos")) {
            $strProxNome = ucfirst($strProxNome) . ' ';
        } else {
            $strProxNome = $strProxNome . ' ';
        }
    }
}


function calculaIdade($data) {
    
    // Separa em dia, mês e ano
    list($dia, $mes, $ano) = explode('/', $data);
    
    // Descobre que dia é hoje e retorna a unix timestamp
    $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
    // Descobre a unix timestamp da data de nascimento do fulano
    $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);
    
    // Depois apenas fazemos o cálculo já citado :)
    $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
    
    return($idade);
}

function calculaPagto($dt) {
    /*$Y = substr($dt, 6, 8);
    $m = substr($dt, 3, 2);
    $d = substr($dt, 0, 2);
    $dt = $Y . '-' . $m . '-' . $d;*/
    $data['pg'] = $dt;
    $tipopg = 1;
    list($ano, $mes, $dia) = explode('-', $data['pg'], '3');
    $datav = mktime(0, 0, 0, $mes, $dia, $ano); 
    $proximovenc = mktime(0, 0, 0, ($mes + $tipopg), $dia, $ano);
    
    return(date('Y-m-d',$proximovenc));
}


?>