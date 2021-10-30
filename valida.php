<?php
session_start();
require_once("config.php");
date_default_timezone_set('America/Sao_Paulo');
$data = date('Y/m/d H:i');
//inicio
if (isset($_POST['submit'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

if (!empty($_POST['email']) OR !empty($_POST['senha'])){
$login = $conexao->prepare('SELECT * FROM painel_usuarios WHERE email=:email');
$login->bindParam(':email', $email, PDO::PARAM_STR);
$login->execute();
if($login->rowCount() == 1){
    $info = $login->fetch();
    $senha = md5($senha);
    if($senha == $info['senha']){
                $_SESSION['id'] = $info['id'];
                $_SESSION['nome'] = $info['nome'];
                $_SESSION['email'] = $info['email'];
                $_SESSION['autenticado'] = true;
                header("Location: dashboard.php");
            }else{
                $_SESSION['msg'] = '<div class="alert alert-danger" role="alert">
  Login ou Senha Incorreto!
</div>';        
                header("Location: login.php");
            }

} else { $_SESSION['msg'] = '<div class="alert alert-danger" role="alert">
  Nenhum Usuario Existente com esse Login!
</div>';
                header("Location: login.php");
}

} else{
        $_SESSION['msg'] = '<div class="alert alert-danger" role="alert">
  Os campos não podem ficar vazios!
</div>';
        header("Location: login.php");
    } 


} else {
    $_SESSION['msg'] = '<div class="alert alert-danger" role="alert">
  Informe os dados de Acesso!
</div>';
     header("Location: login.php");
}

