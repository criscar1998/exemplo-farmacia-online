<?php
require_once('painel.php');
//verifica a sessão e desloga
if(checar_sessao()) {
$_SESSION['autenticado'] = false;
session_destroy();
echo '<script>window.location.replace("login.php")</script>';
}
?>