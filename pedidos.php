 <?php 
 //chamando as funções
 require_once 'painel.php';

 if(checar_sessao()){

  //chamando o head do site
 require 'head.php'; 
 ?>

     <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="row flex-grow">
             <div class="col-12 grid-margin stretch-card">
               <div class="card card-rounded">
                  <div class="card-body">
                     <div class="d-sm-flex justify-content-between align-items-start">
                           <div>
                                <h4 class="card-title card-title-dash">Sua Lista de Pedidos</h4>
                                   <p class="card-subtitle card-subtitle-dash">Sua Lista de Pedidos Pagos ou Pendentes</p>
                                  </div>                                  
                                </div>
                                <div class="table-responsive  mt-1">
                                  <table class="table select-table">
                                    <thead>
                                      <tr>
                                        <th></th>
                                        <th>Quantidade</th>
                                        <th>Status</th>
                                        <th>Valor</th>
                                        <th>Meio de Pagamento</th>
                                        <th></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                               $pedido = $conexao->prepare("SELECT DISTINCT pago, metodo, ordem, data FROM `painel_pedidos` a GROUP BY id ORDER by data ASC");
                               $pedido->bindParam(':email', $cliente_email, PDO::PARAM_STR);
                               $pedido->execute();
                               $rwo = $pedido->fetchAll(PDO::FETCH_ASSOC);
                               foreach ($rwo as $go) { ?>
                                      <tr> 
                                        <td>
                                          <h6><a href="pagamento.php?&ordem=<?=$go['ordem']?>" class="btn btn-success btn-block order-button">Ver Pedido</a></h6>
                                        </td>                                       
                                        <td>
                                          <h6><?=pedido_quantidade($go['ordem'])?> Produto</h6>
                                        </td>
                                        <td>
                                          <h6><?=status_pedidos($go['pago'])?></h6>
                                        </td>
                                        <td>
                                          <h6>R$<?=pedido_total($go['ordem'])?></h6>
                                        </td>
                                        <td>                                   
                                        <h6><?=pedido_metodo($go['metodo'])?></h6>
                                        </td>                                     
                                      </tr>
                                    <?php }?>
                                    </tbody>
                                  </table>
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