<?php
//iniciando a sessão
session_cache_expire(10);
session_start();
//chamando o arquivo de configuração do mysql
require_once("config.php");

//gerar qrcode pix - Integração PIX
include "vendors/pix/phpqrcode/qrlib.php"; 
include "vendors/pix/phpqrcode/funcoes_pix.php";

//informando nosso fuso horário
setlocale(LC_ALL,'pt_BR' , 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

//informando que não queremos depurar o codigo
ini_set('display_errors',0);
ini_set('display_startup_erros',0);
error_reporting(-E_ALL);

//vamos pegar a data de hoje
$data = date('Y-m-d H:i:s');


//função que verifica se o usuario está autenticado 
function checar_sessao(){
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
return false;
}
return true;
}

//função para capturar IP do usuario ignorando o cloudflare e proxys usado pelo usuario
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

$EnderecoIP = get_client_ip();


//recuperando informações do cliente no mysql
$painel_usuario = $conexao->prepare('SELECT * FROM painel_usuarios WHERE email=:email ');
$painel_usuario->bindParam(':email', $_SESSION['email'], PDO::PARAM_STR);
$painel_usuario->execute();
$u = $painel_usuario->fetch(PDO::FETCH_ASSOC);

$cliente_nome = $u['nome'];
$cliente_id = $u['id'];
$cliente_email = $u['email'];
$cliente_logradouro = $u['logradouro'];
$cliente_cep = $u['cep'];
$cliente_uf = $u['uf'];
$cliente_bairro = $u['bairro'];
$cliente_cidade = $u['cidade'];



//Normalmente faria uma integração com o webservice dos correios mas irei definir um valor fixo para o frente
$frete = "3.55";

//aqui estamos gerando um id unico para nossos pedidos
function id_unico($tamanho=8){
$salt = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$tam = strlen($salt);
$pass = '';
mt_srand(10000000*(double)microtime());
for ($i = 0; $i < $tamanho; $i++)
{
$pass .= $salt[mt_rand(0,$tam - 1)];
}
return $pass;
}

// para não ocorrer erros de calculo, vamos usar as funções abaixo

function conv_soma($valor){
    $soma_total = round($valor, 2); // formatando nossa floatval
    return $soma_total; 
}



//vamos salvar o nosso pedido feito no carrinho
function salvar_pedido($produto,$quantidade,$ordem){
GLOBAL $conexao,$cliente_email,$data,$frete;

//vamos receber os dados do banco
$remedio = $conexao->prepare('SELECT valor FROM painel_remedios WHERE id = :id');
$remedio->bindParam(':id', $produto, PDO::PARAM_STR);
$remedio->execute();
$resultado = $remedio->fetch();

$multiplicando = $resultado['valor'] * $quantidade; // multiplicando valor unitario pela quantidade pedido
$str= str_replace(',', '.', $multiplicando); // troca a vírgula por ponto, caso nao saia no formato decimal

//inserir valor no banco
$novo = $conexao->prepare('INSERT INTO painel_pedidos (produto,quantidade,ordem,email,total,data,frete) VALUES (:produto,:quantidade,:ordem,:email,:total,:data,:frete)');
        $novo->bindParam(':produto', $produto, PDO::PARAM_STR);
        $novo->bindParam(':quantidade', $quantidade, PDO::PARAM_STR);
        $novo->bindParam(':ordem', $ordem, PDO::PARAM_STR);
        $novo->bindParam(':email', $cliente_email, PDO::PARAM_STR);
        $novo->bindParam(':total', $str, PDO::PARAM_STR);
        $novo->bindParam(':data', $data, PDO::PARAM_STR);
        $novo->bindParam(':frete', $frete, PDO::PARAM_STR);  
        $novo->execute();
        return $novo;
}

//função para descobrirmos o valor subtotal do pedido direto no mysql sem o frete
function pedido_subtotal($ordem){
GLOBAL $conexao;
//vamos receber os dados do banco
$sql = "SELECT SUM(total) as soma FROM painel_pedidos WHERE ordem = :ordem";
$sql = $conexao->prepare($sql);
$sql->bindValue(':ordem',$ordem);
$sql->execute();
$row = $sql->fetch(); 
$soma = conv_soma($row['soma']);
return $soma;
}

//função para descobrirmos o valor subtotal do pedido direto no mysql sem o frete
function pedido_total($ordem){
GLOBAL $conexao, $frete;
//vamos receber os dados do banco
$sql = "SELECT SUM(total) as soma FROM painel_pedidos WHERE ordem = :ordem";
$sql = $conexao->prepare($sql);
$sql->bindValue(':ordem',$ordem);
$sql->execute();
$row = $sql->fetch(); 
$soma = conv_soma($row['soma']);
return $soma + $frete;
}



//função para localizar o nome do produto pelo ID
function produto_nome($id){
GLOBAL $conexao;
//vamos receber os dados do banco
$remedio = $conexao->prepare('SELECT nome FROM painel_remedios WHERE id = :id');
$remedio->bindParam(':id', $id, PDO::PARAM_STR);
$remedio->execute();
$resultado = $remedio->fetch(PDO::FETCH_ASSOC);
return $resultado['nome'];
}

//função para localizar a quantidade do produto pelo ID
function produto_quantidade($id){
GLOBAL $conexao;
//vamos receber os dados do banco
$remedio = $conexao->prepare('SELECT quantidade FROM painel_remedios WHERE id = :id');
$remedio->bindParam(':id', $id, PDO::PARAM_STR);
$remedio->execute();
$resultado = $remedio->fetch(PDO::FETCH_ASSOC);
return $resultado['quantidade'];
}

//função para localizar o status do pedido
function produto_status($id){
GLOBAL $conexao;
//vamos receber os dados do banco
$remedio = $conexao->prepare('SELECT pago FROM painel_pedidos WHERE ordem = :id');
$remedio->bindParam(':id', $id, PDO::PARAM_STR);
$remedio->execute();
$resultado = $remedio->fetch(PDO::FETCH_ASSOC);
return $resultado['pago'];
}

//função para localizar a quantidade escolhida no carrinho
function pedido_quantidade($id){
GLOBAL $conexao;
//vamos receber os dados do banco
$remedio = $conexao->prepare('SELECT SUM(quantidade) as soma FROM painel_pedidos WHERE ordem = :ordem');
$remedio->bindParam(':ordem', $id, PDO::PARAM_STR);
$remedio->execute();
$resultado = $remedio->fetch();
return $resultado['soma'];
}

//status do pedido
function status_pedidos($status) {
switch ($status) {
case 0: 
return '<p class="text-warning">Pendente</p>';
break;
case 1:
return '<p class="text-success">Pago</p>';
break;
case 2:
return '<p class="text-danger">Cancelado</p>';
break;
default:
return '<p class="text-danger">Erro</p>';
}
}

//metodo de pagamento
function pedido_metodo($metodo) {
switch ($metodo) {
case 0: 
return '<p class="text-danger">Não Definido</p>';
break;
case 1:
return '<p>PIX</p>';
break;
case 2:
return '<p>Boleto</p>';
break;
case 3:
return '<p>Cartão</p>';
break;
default:
return '<p class="text-danger">Erro</p>';
}
}