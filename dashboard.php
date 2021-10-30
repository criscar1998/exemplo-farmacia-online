 <?php 
 //chamando as funções
 require_once 'painel.php';
// chamando a função checar_sessao para verificarmos se o usuario está autenticado
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
                                <h4 class="card-title card-title-dash">Nossa Lista de Medicamentos</h4>
                                   <p class="card-subtitle card-subtitle-dash">Adquira seus Medicamentos</p>
                                  </div>                                  
                                </div>
                                <div class="table-responsive  mt-1">
                                  <table class="table select-table">
                                    <thead>
                                      <tr>
                                        <th>
                                          <div class="form-check form-check-flat mt-0">
                                            <label class="form-check-label">
                                              </label>
                                          </div>
                                        </th>
                                        <th>Nome</th>
                                        <th>Quantidade(mg)</th>
                                        <th>Laboratório</th>
                                        <th>Valor</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                  //consultando todos os produtos cadastrados
                               $remedio = $conexao->prepare("SELECT * FROM painel_remedios ORDER BY id DESC");
                               $remedio->execute();
                               $rwo = $remedio->fetchAll(PDO::FETCH_ASSOC);
                               foreach ($rwo as $go) { ?>
                                      <tr> 
                                      <form action="carrinho.php" method="GET">  
                                        <td>
                                          <div class="form-check form-check-flat mt-0">
                                            <label class="form-check-label">
                                            <input type="checkbox" name="produto[]" value="<?=$go['id']?>" class="form-check-input" aria-checked="false"><i class="input-helper"></i></label>
                                          </div>
                                        </td>
                                        <td>
                                          <div class="d-flex ">
                                            <img src="<?=$go['img']?>" alt="">
                                            <div>
                                              <h6><?=$go['nome']?></h6>
                                              <p><?=$go['tipo']?></p>
                                            </div>
                                          </div>
                                        </td>
                                        <td>
                                          <h6><?=$go['quantidade']?></h6>
                                        </td>
                                        <td>
                                          <div>                                    
                                              <p class="text-success"><?=$go['laboratorio']?></p>
                                        </td>
                                        <td><?=$go['valor']?></td>
                                      </tr>
                                    <?php } ?>
                                    </tbody>
                                  </table>
                                </div>
                                <center>
                                <button type="submit" class="btn btn-primary me-2">Adicionar ao Carrinho</button>
                                </center>
                               </form>
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