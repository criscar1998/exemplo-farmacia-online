<?php 
//chamando as funções
require_once 'painel.php';
//verificando se o cliente está autenticado
if(checar_sessao()){

  //chamando o head do site
 require 'head.php'; 

if (isset($_POST['ordem'])) {

$ordem = $_POST['ordem'];
$metodo = $_POST['metodo'];
$marcar = $conexao->prepare("UPDATE painel_pedidos SET metodo=:metodo WHERE ordem=:id"); 
          $marcar->bindParam(':metodo', $metodo, PDO::PARAM_STR);
          $marcar->bindParam(':id', $ordem, PDO::PARAM_STR);    
          $marcar->execute();
}
?>
<style type="text/css">
.dummy-positioning {
  -webkit-box-align: center;
          align-items: center;
  -webkit-box-pack: center;
          justify-content: center;
}

.success-icon {
  display: inline-block;
  width:4em;
  height:4em;
  font-size: 20px;
  border-radius: 50%;
  border: 4px solid #96df8f;
  background-color: #fff;
  position: relative;
  overflow: hidden;
  -webkit-transform-origin: center;
          transform-origin: center;
  -webkit-animation: showSuccess 180ms ease-in-out;
          animation: showSuccess 180ms ease-in-out;
  -webkit-transform: scale(1);
          transform: scale(1);
}

.success-icon__tip, .success-icon__long {
  display: block;
  position: absolute;
  height: 4px;
  background-color: #96df8f;
  border-radius: 10px;
}
.success-icon__tip {
  width: 2.4em;
  top:2.15em;
  left: 1.4em;
  -webkit-transform: rotate(45deg);
          transform: rotate(45deg);
  -webkit-animation: tipInPlace 300ms ease-in-out;
          animation: tipInPlace 300ms ease-in-out;
  -webkit-animation-fill-mode: forwards;
          animation-fill-mode: forwards;
  -webkit-animation-delay: 180ms;
          animation-delay: 180ms;
  visibility: hidden;
}
.success-icon__long {
  width: 4em;
  -webkit-transform: rotate(-45deg);
          transform: rotate(-45deg);
  top: 1.85em;
  left: 2.75em;
  -webkit-animation: longInPlace 140ms ease-in-out;
          animation: longInPlace 140ms ease-in-out;
  -webkit-animation-fill-mode: forwards;
          animation-fill-mode: forwards;
  visibility: hidden;
  -webkit-animation-delay: 440ms;
          animation-delay: 440ms;
}

@-webkit-keyframes showSuccess {
  from {
    -webkit-transform: scale(0);
            transform: scale(0);
  }
  to {
    -webkit-transform: scale(1);
            transform: scale(1);
  }
}

@keyframes showSuccess {
  from {
    -webkit-transform: scale(0);
            transform: scale(0);
  }
  to {
    -webkit-transform: scale(1);
            transform: scale(1);
  }
}
@-webkit-keyframes tipInPlace {
  from {
    width: 0em;
    top: 0em;
    left: -0.8em;
  }
  to {
    width:1.2em;
    top: 2.15em;
    left: 0.7em;
    visibility: visible;
  }
}
@keyframes tipInPlace {
  from {
    width: 0em;
    top: 0em;
    left: -0.8em;
  }
  to {
    width:1.2em;
    top: 2.15em;
    left:0.7em;
    visibility: visible;
  }
}
@-webkit-keyframes longInPlace {
  from {
    width: 0em;
    top: 2.55em;
    left:1.6em;
  }
  to {
    width: 2em;
    top: 1.85em;
    left: 1.375em;
    visibility: visible;
  }
}
@keyframes longInPlace {
  from {
    width: 0em;
    top: 2.55em;
    left: 1.6em;
  }
  to {
    width: 2em;
    top: 1.85em;
    left: 1.375em;
    visibility: visible;
  }
}
</style>
<div class="main-panel">
        <div class="content-wrapper">
        <div class="container rounded bg-white">
    <div class="row d-flex justify-content-center pb-5">

<?php 
if ($metodo == "1") { 

//integração do PIX
 $px[00]="01"; //não alterar
$px[01]="12"; //não alterar
$px[26][00]="BR.GOV.BCB.PIX"; //não alterar
$px[26][01]="ac6d2a5e-3aab-4791-a5fe-b0a75d18e1fb"; //chave pix
$px[52]="0000"; //não alterar
$px[53]="986"; //não alterar
$px[54]= pedido_total($ordem); // Valor
$px[58]="BR"; // Informando o Pais
$px[59]="Aegle Care"; // Nome do beneficiario
$px[60]="Porto Alegre"; //cidade do PIX
$px[62][05]=$ordem; //identificador
$pix=montaPix($px);
$pix.="6304";
$pix.=crcChecksum($pix);
ob_start(); QRCode::png($pix, null,'M',5);
$imageString = base64_encode( ob_get_contents() );
ob_end_clean();
if ($imageString) {
 echo '</div><center><h4 style="color:black;">Escaneie seu QRCode Abaixo</h4><img src="data:image/png;base64,' . $imageString . '" width="180" height="180"></center><br>
<div class="col-md-6 offset-md-3">
              <input type="text" style="display:none;" id="Key" value="'.$pix.'" />
              <center>
                  <button onclick="mycopy()" class="btn btn-success btn-block">Pix Copia e Cola</button>
                  </center>
              </div>
              <br>
              <center><h4 style="color:black;">Não sabe como Pagar com o Pix ? Assista:</h4>
               <iframe width="350" height="250" src="https://www.youtube.com/embed/I2wvEAwLu90" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
              </center>'; } else {
    echo '<div class="alert alert-danger">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <i class="material-icons">close</i>
                    </button>
                    <span>
                      <b> Ops,não conseguimos gerar seu pix, entre em contato conosco!</b></span>
                  </div>';
  }
 } elseif ($metodo == "2") {

//aqui rodaria a integração, conforme fiz no PIX.

   echo '<div class="dummy-positioning d-flex"> 
          <div class="success-icon">
     <div class="success-icon__tip"></div>
    <div class="success-icon__long"></div>
      </div> 
      </div>
      <br>
      <center><h4 style="color:black;">Seu Boleto foi Gerado com Sucesso!</h4></center>
      <div class="container">
      <div class="row">
      <div class="col align-self-center">
      <center>
      <button class="btn btn-success btn-block">Baixar Boleto</button>
      </center>
      </div>';


} elseif ($metodo == "3") {
    //aqui rodaria a integração, conforme fiz no PIX.
?>
<div class="wrapper">
    <h4 class="text-uppercase">Detalhes do Cartão</h4>
    <form class="form mt-4" method="POST">
        <div class="form-group"> <label for="name" class="text-uppercase">Titular do Cartão</label> <input type="text" class="form-control" placeholder="João da Silva"> </div>
        <div class="form-group"> <label for="card" class="text-uppercase">Número do Cartão</label>
            <div class="card-number"> <input type="text" class="card-no" step="4" placeholder="1234 4567 5869 1234" pattern="^[0-9].{15,}"> <span class=""> <img src="https://www.freepnglogos.com/uploads/mastercard-png/mastercard-marcus-samuelsson-group-2.png" alt="" width="30" height="30"> </span> </div>
        </div>
        <div class="d-flex w-100">
            <div class="d-flex w-50 pr-sm-4">
                <div class="form-group"> <label for="expiry" class="text-uppercase">Vencimento</label> <input type="text" class="form-control" placeholder="03/2020"> </div>
            </div>
            <div class="d-flex w-50 pl-sm-5 pl-3">
                <div class="form-group"> <label for="cvv">CVV</label>
                <input type="password" class="form-control pr-5" maxlength="3" placeholder="123"> </div>
            </div>
        </div>
        <div class="my-3"> <input type="submit" name="submit" value="Pagar Agora" class="text-uppercase btn btn-primary btn-block p-3"> </div>
    </form>
</div>
<style type="text/css">

@import url('https://fonts.googleapis.com/css2?family=Ubuntu&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box
}

body {
    background: #9ab3f5;
    font-family: 'Ubuntu', sans-serif
}

.wrapper {
    background-color: #f4f2f7;
    margin: 20px auto;
    max-width: 400px;
    padding: 15px 20px;
    border-radius: 10px
}

h4 {
    font-weight: 800;
    color: #888
}

label {
    font-weight: 700;
    color: #888;
    font-size: 12px
}

.card-no {
    border: none;
    outline: none;
    width: 90%;
    padding-left: 8px
}

.form-control {
    outline: none;
    border: none;
    box-shadow: none
}

.card-number {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 5px 8px 2px
}

a {
    font-size: 12px;
    font-weight: 900;
    margin-left: 30%
}

a {
    text-decoration: none
}

.form-inline label {
    font-size: 1rem
}

.focused {
    border: 2px solid #9ab3f5
}

#form-footer a {
    margin: 0
}

#form-footer p {
    margin: 0;
    text-align: center;
    font-size: 14px;
    font-weight: 500;
    color: #777
}

@media(max-width:395px) {
    .form-inline label {
        font-size: 12px
    }

    #form-footer p {
        font-size: 11px
    }

    .card-no {
        width: 85%
    }
}

</style>


<?php } ?>
    </div> 
        
           </div>
           </div>
          </div>
        </div>

<!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Desafio Eagle care.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2021. All rights reserved.</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="vendors/chart.js/Chart.min.js"></script>
  <script src="vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script src="vendors/progressbar.js/progressbar.min.js"></script>

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <script src="js/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->
</body>
<script>
  function mycopy() {
    var hidden = document.getElementById("Key");
    hidden.style.display = 'block';
    hidden.select();
    hidden.setSelectionRange(0, 99999)
    document.execCommand("copy");
    alert("Linha Digitável Copiada: " + hidden.value);
    hidden.style.display = 'none';
  }
</script>

</html>                          

<?php }else{

$_SESSION['msg'] = '<div class="alert alert-warning" role="alert">
  Sua sessão expirou!
</div>';
echo '<script>window.location.replace("login.php")</script>';
}