<?php
//Inicializado primeira a sessão para posteriormente recuperar valores das variáveis globais. 
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Cadastrar </title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../../vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
  <!--Importando Script Jquery-->
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="../../images/logo.png" alt="logo">
              </div>
              <h4>Estamos Felizes em te ver por aqui!</h4>
              <h6 class="fw-light">Faça seu Cadastro.</h6>
              <?php
 if (isset($_POST['cadastrar'])) {
                         
require_once 'config.php';

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = MD5($_POST['senha']);
$endereco = $_POST['endereco'] .','. $_POST['numero'];
$bairro = $_POST['bairro'];
$cep = $_POST['cep'];
$uf = $_POST['uf'];
$cidade = $_POST['cidade'];

$cad = $conexao->prepare('SELECT * FROM painel_usuarios WHERE email=:email');
      $cad->bindParam(':email', $email, PDO::PARAM_STR);
      $cad->execute();

  if($email == "" || $email == null){
    echo'<div class="alert alert-danger" role="alert">
  Você deve Informar seu Email!
</div>';

    }else{
      if($cad->rowCount() == 1){
         echo'<div class="alert alert-danger" role="alert">Já existe um cadastro com esse email!</div>';

      }else{
        $novo = $conexao->prepare('INSERT INTO painel_usuarios (nome,email,senha,logradouro,cep,bairro,uf,cidade) VALUES (:nome,:email,:senha,:endereco,:cep,:bairro,:uf,:cd)');
        $novo->bindParam(':nome', $nome, PDO::PARAM_STR);
        $novo->bindParam(':email', $email, PDO::PARAM_STR);
        $novo->bindParam(':senha', $senha, PDO::PARAM_STR);
        $novo->bindParam(':endereco', $endereco, PDO::PARAM_STR);
        $novo->bindParam(':cep', $cep, PDO::PARAM_STR);
        $novo->bindParam(':bairro', $bairro, PDO::PARAM_STR);
        $novo->bindParam(':uf', $uf, PDO::PARAM_STR);
        $novo->bindParam(':cd', $cidade, PDO::PARAM_STR);
        $novo->execute();

        if($novo){
          echo'<div class="alert alert-success" role="alert">Cadastrado com Sucesso!</div>';
        }else{
          echo'<div class="alert alert-danger" role="alert">Erro Interno!</div>';
        }
      }
    }
  }  
?>
              <form class="pt-3" method="POST" action="">
                <div class="form-group">
                  <input type="text" name="nome" class="form-control form-control-lg"  placeholder="Seu nome e sobrenome" required>
                </div>
                <div class="form-group">
                  <input type="email" name="email" class="form-control form-control-lg"  placeholder="Seu Email" required>
                </div>
                <div class="form-group">
                  <input type="password" name="senha" class="form-control form-control-lg" placeholder="Senha" required>
                </div>
                <div class="form-group">
                  <input type="text" name="cep" id="cep" class="form-control form-control-lg" placeholder="CEP" required>
                </div>
                <div class="form-group">
                  <input type="text" name="endereco" id="logradouro" class="form-control form-control-lg" placeholder="Endereço">
                </div>
                <div class="form-group">
                  <input type="text" name="numero" id="numero" class="form-control form-control-lg" placeholder="Número da casa">
                </div>
                <div class="form-group">
                  <input type="text" name="bairro" id="bairro" class="form-control form-control-lg" placeholder="Bairro">
                </div>
                <div class="form-group">
                  <input type="text" name="cidade" id="cidade" class="form-control form-control-lg" placeholder="Cidade">
                </div>
                <div class="form-group">
                  <input type="text" name="uf" id="uf" class="form-control form-control-lg" style="display: none;">
                </div>
                <div class="mt-3">
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit" name="cadastrar">Cadastrar</button>
                </div>      
                <div class="text-center mt-4 fw-light">
                  Você já tem cadastro? <a href="login.php" class="text-primary">Login</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../../vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/viacep.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <script src="../../js/settings.js"></script>
  <script src="../../js/todolist.js"></script>
  <!-- endinject -->
</body>

</html>
