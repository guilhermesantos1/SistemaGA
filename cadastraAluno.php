<?php

/**
 * OBS: Colocar um campo Pagamento com as opções:
 * 0 - Pendente;
 * 1 - Pago;
 * 
 * e também um campo de Status com as opções:
 * 0 - Ativo;
 * 9 - Inativo;                                        
 */


include "lib/classes/DBConexao.class.php";
include "lib/funcoes/strings.php";

class cadastraAluno {

    // variaveis de instância
    var $status = NULL;
    var $nome = NULL;
    var $dtNasc = NULL;
    var $estadoCivil = NULL;
    var $sexo = NULL;
    var $rg = NULL;
    var $cpf = NULL;
    var $cep = NULL;
    var $endereco = NULL;
    var $complemento = NULL;
    var $bairro = NULL;
    var $cidade = NULL;
    var $estado = NULL;
    var $foneRes = NULL;
    var $celular = NULL;
    var $operadora = NULL;
    var $email = NULL;
    var $pagamento = NULL;
    var $obs = NULL;
    var $dtPagto = NULL;
    var $dtVenc = NULL;
    
    var $db = NULL;
    
    // assim que a classe for instânciada será executado esse método, é necessário passar os parâmetros corretos
    function __construct($status, $nome, $dtnasc, $estadocivil, $sexo, $rg, $cpf, $cep, $endereco, $complemento, $bairro, $cidade, $estado, 
                        $foneres, $celular, $operadora, $email, $pagamento, $obs, $dtPagto, $dtVenc) { 
        
        // instância da classe de banco de dados
        $this->db = NEW DBConexao(); 
        // retorna a conexão com o banco de dados
        $this->db->GetConexao(); 

        // as variaveis de instância da classe, vão ter o valor dos parâmetros passados ao construtor
        $this->status = $status;
        $this->nome = $nome;
        $this->dtNasc = $dtnasc;
        $this->estadoCivil = $estadocivil;
        $this->sexo = $sexo;
        $this->rg = $rg;
        $this->cpf = $cpf;
        $this->cep = $cep;
        $this->endereco = $endereco;
        $this->complemento = $complemento;
        $this->bairro = $bairro;
        $this->cidade = $cidade;
        $this->estado = $estado;
        $this->foneRes = $foneres;
        $this->celular = $celular;
        $this->operadora = $operadora;
        $this->email = $email;
        $this->pagamento = $pagamento;
        $this->obs = $obs;
        $this->dtPagto = $dtPagto;
        $this->dtVenc = $dtVenc;
        
        
    }

    function cadastraAlunoDB($tabela) { // método para cadastrar os alunos
        $sql = ("INSERT INTO $tabela (id, status, nome, dtNasc, estadoCivil, sexo, rg, cpf, cep, endereco, complemento, bairro, cidade, 
                estado, foneRes, celular, operadora, email, pagamento, obs, dataPagamento, dataVencimento, dataHora)
                VALUES (NULL, $this->status, '$this->nome', '$this->dtNasc', '$this->estadoCivil', '$this->sexo', '$this->rg', '$this->cpf',
                '$this->cep', '$this->endereco', '$this->complemento', '$this->bairro', '$this->cidade', '$this->estado', '$this->foneRes',
                '$this->celular', '$this->operadora', '$this->email', '$this->pagamento', '$this->obs', '$this->dtPagto', '$this->dtVenc', NOW())");
        //die($sql);
        $this->db->Executa($sql) or die("<p style=\"color: red;\"><b>ERRO ao tentar CADASTRAR um novo aluno!</b></p>" . mysql_error());
    }

    public function getNome() { return $this->nome; }
    
    public function setNome($nome) { $this->nome = $nome; }
   
    public function getDtNasc() { return $this->dtNasc; }
    
    public function setDtNasc($dtNasc) { $this->dtNasc = $dtNasc; }
    
    public function getEstadoCivil() { return $this->estadoCivil; }
    
    public function setEstadoCivil($estadoCivil) { $this->estadoCivil = $estadoCivil; }

    public function getSexo() { return $this->sexo; }
    
    public function setSexo($sexo) { $this->sexo = $sexo; }
    
    public function getRg() { return $this->rg; }
    
    public function setRg($rg) { $this->rg = $rg; }
    
    public function getCpf() { return $this->cpf; }
    
    public function setCpf($cpf) { $this->cpf = $cpf; }
    
    public function getCep() { return $this->cep; }
    
    public function setCep($cep) { $this->cep = $cep; }

    public function getEndereco() { return $this->endereco; }
    
    public function setEndereco($endereco) { $this->endereco = $endereco; }
    
    public function getComplemento() { return $this->complemento; }
    
    public function setComplemento($complemento) { $this->complemento = $complemento; }

    public function getBairro() { return $this->bairro; }
    
    public function setBairro($bairro) { $this->bairro = $bairro; }
    
    public function getCidade() { return $this->cidade; }
    
    public function setCidade($cidade) { $this->cidade = $cidade; }
    
    public function getEstado() { return $this->estado; }
    
    public function setEstado($estado) { $this->estado = $estado; }

    public function getFoneRes() { return $this->foneRes; }
    
    public function setFoneRes($foneRes) { $this->foneRes = $foneRes; }
    
    public function getCelular() { return $this->celular; }
    
    public function setCelular($celular) { $this->celular = $celular; }
    
    public function getOperadora() { return $this->operadora; }
    
    public function setOperadora($operadora) { $this->operadora = $operadora; }
    
    public function getEmail() { return $this->email; }
    
    public function setEmail($email) { $this->email = $email; }
    
    public function getPagamento() { return $this->pagamento; }
    
    public function setPagamento($pagamento) { $this->pagamento = $pagamento; }
    
    public function getObs() { return $this->obs; }
    
    public function setObs($obs) { $this->obs = $obs; }
    
    public function getDtPagto() { return $this->dtPagto; }
            
    public function setDtPagto($dtPagto) { $this->dtPagto = $dtPagto; }
    
    public function getDtVenc() { return $this->dtVenc; }
    
    public function setDtVenc($dtVenc) { $this->dtVenc = $dtVenc; }

} // fim da classe cadastraAluno

$dtNasc = isset($_POST['dtNasc']) ? DateTodbDate($_POST['dtNasc']) : NULL;
$dtPagto = isset($_POST['dtPagto']) ? DateTodbDate($_POST['dtPagto']) : NULL;

if ($_POST['pagamento'] == "") {
    $pagamento = "Pendente";
} else {
    $pagamento = $_POST['pagamento'];
}

if ($_POST['dtPagto'] == "") {
    $dtPagto = "";
    $dtVenc = "";
} else {
    $dtPagto = DateTodbDate($_POST['dtPagto']);
    $dtVenc = calculaPagto($dtPagto);
    DateTodbDate($dtVenc);
}


 
// criamos um objeto a partir da classe "cadastraAluno" passando os parâmetros que serão recebidos no construtor
$cad = NEW cadastraAluno($_POST['status'], trim($_POST['nome']), $dtNasc, $_POST['estadoCivil'], $_POST['sexo'], $_POST['rg'], $_POST['cpf'], 
        $_POST['cep'], trim($_POST['endereco']), trim($_POST['complemento']), trim($_POST['bairro']), trim($_POST['cidade']), $_POST['estado'], 
        $_POST['foneRes'], $_POST['celular'], $_POST['operadora'] , trim($_POST['email']), $pagamento, trim($_POST['obs']), $dtPagto, $dtVenc);



if ($cad->db) { // se a conexão estiver ativa
    $cad->cadastraAlunoDB("alunos"); // então cadastra o aluno passando o nome da "TABELA DO BD" como parâmetro
    
    // exibe os dados do aluno cadastrado, utilizando os GET's
    echo "<title>Cadastro de Alunos</title>
        <b style=\"color: red;\">ALUNO CADASTRADO COM SUCESSO!</b><br />";
    /*
        echo "<b>NOME:</b> " . $cad->GetNome() . "&nbsp;|&nbsp; <b>ESTADO CIVIL:</b> " . $cad->GetEstadoCivil() . "<br />"; 
        echo "<b>DATA DE NASCIMENTO:</b> " . $cad->GetDtNasc() . "&nbsp;|&nbsp; <b>ENDERE&Ccedil;O:</b> " . $cad->GetEndereco() . "<br />";
        echo "<b>BAIRRO:</b> " . $cad->GetBairro() . "&nbsp;|&nbsp; <b>CEP:</b> " . $cad->GetCep() . "<br />";
        echo "<b>CIDADE:</b> " . $cad->GetCidade() . "&nbsp;|&nbsp; <b>UF:</b> " . $cad->GetUF() . "<br />";
        echo "<b>EMAIL: </b>" . $cad->GetEmail() . "&nbsp;|&nbsp; <b>TELEFONE:</b> " . $cad->GetTelefone() . "<br />";
        echo "<b>CELULAR:</b> " . $cad->GetCelular() . "&nbsp;|&nbsp; <b>RG:</b> " . $cad->GetRG() . "<br />";
        echo "<b>CPF:</b> " . $cad->GetCPF() . "&nbsp;|&nbsp; <b>SEXO:</b> ";
     */
    
    echo "<meta http-equiv=\"refresh\" content=\"3; url=lib/classes/FollowUp.class.php \">";
    
} else {
    echo "Erro na conexão com o MySQL";
    exit();
}

?>
