<?php
require_once('painel.php');
if(checar_sessao()){

header("Location: dashboard.php");

}else{

header("Location: login.php");

}

?>