<?php
  session_start();
  if(isset($_SESSION['email_user']) || isset($_SESSION['orderNumber'])){
    $title="Tracker Order";
    include "init.php";
    $ordernumber = isset($_GET['tId']) && is_numeric($_GET['tId']) ? intval($_GET['tId']):0;
    ?>
      <div class="container">
      <div class="table-responsive mt-4">
                  <h3 class="text-center mb-3">Food Tracking History</h3>
                            <table class="main-table text-center table table-bordered">

                                    <tr>
                                        <td>#</td>
                                        <td>Remark</td>
                                        <td>Statut</td>
                                        <td>Time</td>
                                    </tr>
       
                        <?php
                              $stmt = $con->prepare("SELECT 
                                            resturant_remark.*,resturant_status.rest_status AS Statut
                                FROM
                                            resturant_remark
                                INNER JOIN
                                            resturant_status
                                ON 
                                            resturant_remark.statut_id  = resturant_status.id
                                WHERE 
                                            resturant_remark.Order_number = '$ordernumber'
                                
                                ");
                         $stmt->execute();
                         $dataRes = $stmt->fetchAll();
                         
                         if(!empty($dataRes)){
                            foreach($dataRes as $st){
                               ?>
                                   <tr>
                                        <td><?php echo $st['id'] ?></td>
                                        <td><?php echo $st['Remark'] ?></td>
                                        <td><?php echo $st['Statut'] ?></td>
                                        <td><?php echo $st['time'] ?></td>
                                    </tr>
                               <?php
                            }
                         }
                        ?>
                        </div>
                        </div>
                        <!---tabel--->
      </div>
<?php 
 include $tp . "/footer.php";
}