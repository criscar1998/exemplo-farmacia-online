<?php 
//chamando as funções
require_once 'painel.php';
// chamando a função checar_sessao para verificarmos se o usuario está autenticado
if(checar_sessao()){

  //chamando o head do site
 require 'head.php'; 
 
//verificamos se a variavel está definida
if (isset($_GET['produto'])) {

//recebendo o GET
$lista = $_GET['produto'];
$a = "";
foreach ($lista as $produto) {
$a .= $produto .",";
}
//removendo virgula da ultima string da array
$a= rtrim($a, ',');
}
?>
<style type="text/css">
.item {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
}

.btn-pay {
  background-color: #2D54A1;
  border: 0;
  color: #fff;
  font-weight: 600;
}

.fa-ticket {
  color: #0e1fa1;
}

</style>

<div class="main-panel">
        <div class="content-wrapper">                      	
	<div class="container rounded bg-white">
    <div class="row d-flex justify-content-center pb-5">
        <div class="container mt-5 mb-5">
  <div class="row justify-content-center">
    <div class="col-xl-7 col-lg-8 col-md-7">
      <div class="border border-gainsboro p-3">
       <form method="POST">

        <h2 class="h6 text-uppercase mb-0">Seu Carrinho de Compras</h2>
      </div>
            <?php 
            $remedio = $conexao->prepare("SELECT * FROM painel_remedios WHERE id IN ($a)");
            $remedio->execute();
            $rwo = $remedio->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rwo as $go) { 
           //primeiro informamos o valor dos itens de quantidade unica e suas somas, depois quem vai cuidar disso é o JS 
             $valortotal += $go["valor"];
            	?>
      <div class="border border-gainsboro p-3 mt-3 clearfix item">
        <div class="text-lg-left">
          <i class="fa fa-ticket fa-2x text-center" aria-hidden="true"></i>
        </div>
        <div class="col-lg-5 col-5 text-lg-left">
          <h3 class="h6 mb-0"><?=$go['nome']?><br>
            <small>Valor: R$<?=$go['valor']?></small>
          </h3>
        </div>
        <div style="display:none" class="product-price d-none"><?=$go['valor']?></div>
        <div class="pass-quantity col-lg-3 col-md-4 col-sm-3">
          <label for="pass-quantity" class="pass-quantity">Quantidade</label>
          <input class="form-control" name="qtd[]" type="number" value="1" min="1">
          <input class="form-control" name="produtos[]" type="text" style="display: none;" value="<?=$go['id']?>">
        </div>
        <div class="col-lg-2 col-md-1 col-sm-2 product-line-price pt-4">
          <span style="display:none" class="product-line-price"><?=$go['valor']?>
          </span>  
        </div>
      </div>

  <?php  } ?>
  
    </div>
    <div class="col-xl-3 col-lg-4 col-md-5 totals">
      <div class="border border-gainsboro px-3">
        <div class="border-bottom border-gainsboro">
          <p class="text-uppercase mb-0 py-3"><strong>Resumo</strong></p>
        </div>
        <div class="totals-item d-flex align-items-center justify-content-between mt-3">
          <p class="text-uppercase">Subtotal</p>
          <p class="totals-value" id="cart-subtotal"><?=$valortotal?></p>
        </div>
        <div class="d-flex align-items-center justify-content-between mt-3">
          <p class="text-uppercase">Valor do Frete</p>
          <p class="totals-value">+ <?= $frete ?></p>
        </div>
        <div class="d-flex align-items-center justify-content-between mt-3">
          <p class="text-uppercase">Prazo Entrega</p>
          <p class="totals-value">7 Dias Úteis</p>
        </div>       
        <div class="totals-item totals-item-total d-flex align-items-center justify-content-between mt-3 pt-3 border-top border-gainsboro">       	
          <p class="text-uppercase"><strong>Total</strong></p>
          <p class="totals-value font-weight-bold cart-total" id="valortotal"><?=$valortotal + $frete?></p>
        </div>
        <center>    
        </center>
      </div>
      <button type="submit" name="submit" class="mt-3 btn btn-pay w-100 d-flex justify-content-center btn-lg rounded-0">Proximo <i class="mdi mdi-arrow-right-bold-hexagon-outline"></i> </button>
    </div>
    </form>
  </div>
</div><!-- container -->
</div>

<?php
//verificamos se a variavel está definida
if(isset($_POST['submit'])){
    $ordem = id_unico();
    $ct=0;
    foreach( $_POST['produtos'] as $k=> $value ){ // Loop da array
        $quantity     = addslashes($_POST['qtd'][$ct] ); //recebendo valores
        $produtos       = addslashes($_POST['produtos'][$ct] ); //recebendo valoreso 
        $salvando= salvar_pedido($produtos,$quantity,$ordem); //inserindo no BD
        $ct++; // acrescenta +1
           
        if ($salvando) {

        	echo '<script>window.location.replace("pagamento.php?&ordem='.$ordem.'")</script>';

        } else {echo 'mensagem de erro';

       }
    }
}





         ?>   
    </div>
</div>
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript">
$(document).ready(function() {

   /* Set rates */
   var taxRate = 0.00;
   var fadeTime = 300;

   /* Assign actions */
   $('.pass-quantity input').change(function() {
     updateQuantity(this);
   });
   $('.remove-item button').click(function() {
     removeItem(this);
   });


   /* Recalculate cart */
   function recalculateCart() {
     var subtotal = 0;
     var frete = <?= $frete ?>;

     /* Sum up row totals */
     $('.item').each(function() {
       subtotal += parseFloat($(this).children('.product-line-price').text());
     });

     /* Calculate totals */
     var tax = subtotal * taxRate;
     var total = subtotal + tax + frete;

     /* Update totals display */
     $('.totals-value').fadeOut(fadeTime, function() {
       $('#cart-subtotal').html(subtotal.toFixed(2));
       $('#cart-tax').html(tax.toFixed(2));
       $('.cart-total').html(total.toFixed(2));
       if (total == 0) {
         $('.checkout').fadeOut(fadeTime);
       } else {
         $('.checkout').fadeIn(fadeTime);
       }
       $('.totals-value').fadeIn(fadeTime);
     });
   }


   /* Update quantity */
   function updateQuantity(quantityInput) {
     /* Calculate line price */
     var productRow = $(quantityInput).parent().parent();
     var price = parseFloat(productRow.children('.product-price').text());
     var quantity = $(quantityInput).val();
     var linePrice = price * quantity;

     /* Update line price display and recalc cart totals */
     productRow.children('.product-line-price').each(function() {
       $(this).fadeOut(fadeTime, function() {
         $(this).text(linePrice.toFixed(2));
         recalculateCart();
         $(this).fadeIn(fadeTime);
       });
     });
   }

   /* Remove item from cart */
   function removeItem(removeButton) {
     /* Remove row from DOM and recalc cart total */
     var productRow = $(removeButton).parent().parent();
     productRow.slideUp(fadeTime, function() {
       productRow.remove();
       recalculateCart();
     });
   }

 });


</script>
<!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Desafio Eagle care</span>
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
// caso o usuario não esteja devidamente autenticado mandamos ele de volta para o login
}
?>
