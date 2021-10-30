<?php

$MySQL_Host = "localhost"; // IP ou Dominio em que está hospedado o servidor mysql
$MySQL_Usuario = "farmacia_painel"; // Usuario mysql
$MySQL_Senha = "zQfQ~T_qf[eE"; // Senha mysql
$MySQL_Banco = "farmacia_painel"; // Nome do Banco de dados
$MySQL_Porta = 3306; // Porta de comunicação com o MYSQL, Padrão: 3306



//Estabelecendo conexão com o MYSQL
try {
$conexao = new PDO('mysql:host='.$MySQL_Host.';port='.$MySQL_Porta.';dbname='.$MySQL_Banco.'', $MySQL_Usuario, $MySQL_Senha);
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conexao->exec("set names utf8");
} catch(PDOException $e) {
echo '
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Indisponível</title>
<link rel="shortcut icon" href="img/favicon.ico">
</head>
<style>
body {
font-size:25px;
text-align:center;
margin-top:50px;
}
</style>
<body>
<p><h1>Ops, Parece que está ocorrendo um erro em nosso Site.</h1></p>';
echo '<font color="red"><b>'.$e->getMessage().'
</b><font>
</body>
</html>';
die();
}
