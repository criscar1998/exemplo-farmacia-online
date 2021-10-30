<?php 
//chamando as funções
require_once 'painel.php';
//verificando se o cliente está autenticado
if(checar_sessao()){

  //chamando o head do site
 require 'head.php'; 

if (isset($_GET['ordem'])) {
$ordem = $_GET['ordem'];
}
?>
<style type="text/css">

@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap");

body {
    background-color: #eee;
    font-family: "Poppins", sans-serif;
    font-weight: 300
}

.cart {
    height: 100vh
}

.progresses {
    display: flex;
    align-items: center
}

.line {
    width: 76px;
    height: 6px;
    background: #63d19e
}

.steps {
    display: flex;
    background-color: #63d19e;
    color: #fff;
    font-size: 12px;
    width: 30px;
    height: 30px;
    align-items: center;
    justify-content: center;
    border-radius: 50%
}

.check1 {
    display: flex;
    background-color: #63d19e;
    color: #fff;
    font-size: 17px;
    width: 60px;
    height: 60px;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    margin-bottom: 10px
}

.check2 {
    display: flex;
    background-color: #cc0000;
    color: #fff;
    font-size: 17px;
    width: 60px;
    height: 60px;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    margin-bottom: 10px
}

.invoice-link {
    font-size: 15px
}

.order-button {
    height: 50px
}

.background-muted {
    background-color: #fafafc
}
</style>
    <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="row flex-grow">
             <div class="col-12 grid-margin stretch-card">
               <div class="card card-rounded">
                  <div class="card-body">
                <div class="d-flex justify-content-center border-bottom">
                    <div class="p-3">
                        <div class="progresses">
                            <div class="steps"> <span><i class="mdi mdi-check-circle-outline"></i></span> </div> <span class="line"></span>
                            <div class="steps"> <span><i class="mdi mdi-check-circle-outline"></i></i></span> </div> <span class="line"></span>
                            <div class="steps"> <span class="font-weight-bold">3</span> </div>
                        </div>
                    </div>
                </div>
                <?php if (produto_status($ordem) == 0) { ?>

                <div class="row g-0">
                    <div class="col-md-6 border-right p-5">
                        <div class="text-center order-details">
                            <div class="d-flex justify-content-center mb-5 flex-column align-items-center"> <span class="check1"><i class="mdi mdi-check-circle-outline"></i></span> <span class="font-weight-bold">Pedido #<?=$ordem?> foi Confirmado.</span> <small class="mt-2">Agora basta realizar o pagamento:</small> <a class="text-decoration-none invoice-link">Selecione a Forma de Pagamento:</a></div>
                            
                            <form action="pagar-agora.php" method="POST">
          <input type="text" name="ordem" value="<?=$ordem?>" style="display: none;">
  <input type="radio" class="btn-check" name="metodo" value="1" id="option1" autocomplete="off">
<label class="btn btn-secondary" for="option1">PIX</label>

<input type="radio" class="btn-check" name="metodo" value="3" id="option2" autocomplete="off">
<label class="btn btn-secondary" for="option2">Débito/Crédito</label>

<input type="radio" class="btn-check" name="metodo" value="2" id="option3" autocomplete="off">
<label class="btn btn-secondary" for="option3">Boleto</label>
<br>
<br>
 <button type="submit" class="btn btn-success btn-block order-button">Pagar Agora</button>
 </form>
                        </div>
                    </div>
                    <?php } elseif (produto_status($ordem) == 1) { ?>
                
             <div class="row g-0">
                    <div class="col-md-6 border-right p-5">
                        <div class="text-center order-details">
                            <div class="d-flex justify-content-center mb-5 flex-column align-items-center"> <span class="check1"><i class="mdi mdi-check-circle-outline"></i></span> <span class="font-weight-bold">Pedido #<?=$ordem?> já esta Pago.</span> <small class="mt-2">Aguarde a Chegada do produto.</small></div>    
                             <a href="pedidos.php" class="btn btn-success btn-block order-button">Voltar</a>
                        </div>
                    </div>
                   <?php } elseif (produto_status($ordem) == 2) {?>             
             <div class="row g-0">
                    <div class="col-md-6 border-right p-5">
                        <div class="text-center order-details">
                            <div class="d-flex justify-content-center mb-5 flex-column align-items-center"> <span class="check2"><i class="mdi mdi-exclamation"></i></span> <span class="font-weight-bold">Pedido #<?=$ordem?> está Cancelado.</span></div>    
                             <a href="pedidos.php" class="btn btn-success btn-block order-button">Voltar</a>
                        </div>
                    </div>
                   <?php } ?>
                    <div class="col-md-6 background-muted">
                        <div class="p-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-center"> <span>Seu produto será entregue para:</span></div>
                            <div class="mt-3">
                                <h6 class="mb-0"><?=$cliente_nome?></h6> <span class="d-block mb-0">Endereço: <?=$cliente_logradouro?> <br> Bairro: <?=$cliente_bairro?> <br> Cidade: <?=$cliente_cidade .','. $cliente_uf?></span> <small>CEP: <?=$cliente_cep?></small> 
                                <div class="d-flex flex-column mt-3"> <small></div>
                                <div class="d-flex justify-content-between align-items-center"> <span style="color: black;">Seus Produtos:</span></div>
                                <?php 
                                $pedido = $conexao->prepare("SELECT produto,quantidade,total FROM painel_pedidos WHERE ordem=:ordem");
                               $pedido->bindParam(':ordem', $ordem, PDO::PARAM_STR);
                               $pedido->execute();
                               $rwo = $pedido->fetchAll(PDO::FETCH_ASSOC);
                               foreach ($rwo as $go) { ?>
                                <p><?=produto_nome($go['produto'])?> <?=produto_quantidade($go['produto'])?> x <?=$go['quantidade']?> = R$<?=$go['total']?></p>
                               <?php }?>

                            </div>
                        </div>               
                        <div class="row g-0 border-bottom">
                            <div class="col-md-6">
                                <div class="p-3 d-flex justify-content-center align-items-center"> <span>Subtotal</span> </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 d-flex justify-content-center align-items-center"> <span>R$<?=pedido_subtotal($ordem)?></span> </div>
                            </div>
                        </div>
                        <div class="row g-0 border-bottom">
                            <div class="col-md-6">
                                <div class="p-3 d-flex justify-content-center align-items-center"> <span>Valor do Frete</span></div>
                            </div>
                            <div class="col-md-6">
                            
                           <div class="p-3 d-flex justify-content-center align-items-center"> <span>+ R$<?=$frete?></span> </div>
                           </div>
                        </div>
                        <div class="row g-0">
                            <div class="col-md-6">
                                <div class="p-3 d-flex justify-content-center align-items-center"> <span class="font-weight-bold">Total</span> </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 d-flex justify-content-center align-items-center"> <span class="font-weight-bold">R$<?=pedido_total($ordem)?></span> </div>
                            </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
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

</html>                          

<?php }else{

$_SESSION['msg'] = '<div class="alert alert-warning" role="alert">
  Sua sessão expirou!
</div>';
echo '<script>window.location.replace("login.php")</script>';
}