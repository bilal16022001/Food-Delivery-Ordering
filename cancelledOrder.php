<?php
  session_start();
  if(isset($_SESSION['email_user']) || isset($_SESSION['orderNumber'])){
    $title="Order Cancelled";
    include "init.php";

    $ordernumber = isset($_GET['cid']) && is_numeric($_GET['cid']) ? intval($_GET['cid']):0;
    ?>
      <div class="container">
      <div class="table-responsive mt-4">
                  <h3 class="text-center mb-3">Cancel Order</h3>
                            <table class="main-table text-center table table-bordered">

                                    <tr>
                                        <td>Order Number</td>
                                        <td>Statut</td>
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

                        $statut="waiting Resturant for confirmation";
   
                         if(!empty($dataRes)){
                            foreach($dataRes as $st){
                              $statut = $st['Statut'];
  
                            }
                         ?>
                                <tr>
                                        <td><?php echo $ordernumber ?></td>
                                        <td><?php echo $statut?></td>
                                    </tr>
                         <?php
                     

                         }else{
                          ?>
                          <tr>
                                  <td><?php echo $ordernumber ?></td>
                                  <td><?php echo $statut?></td>
                              </tr>
                           <?php


                         }
     
                        ?>
                        </table>
                        <?php
          
                               if($statut == "Order Confirmed" || $statut == "waiting Resturant for confirmation"){
                               
                                ?>
                                  <form action="<?php echo $_SERVER['PHP_SELF'] . "?cid=$ordernumber" ?>" method="POST">
                                        <h2>Reason For Cancel</h2>
                                        <textarea name="remark" class='w-100 cancelText mb-2' required></textarea>
                                        <input class="btn btn-primary" type="submit" value="update Order" />
                                  </form>
                                <?php
                               }
                              else if($statut == 'Order Cancelled'){
                                echo "<h2 class='text-center' style='color:red'>your order is cancelled</h2>";
                               } 
                               else{
                                  echo "<h2 class='text-center' style='color:red'>you can't cancel this Order pickup for deliver or delivred </h2>";
                               }
                         ?>
                        </div>
                        </div>
                        <!---tabel--->
                 </div>
      <?php 
    
    if($_SERVER['REQUEST_METHOD']=="POST"){
           $remark = $_POST['remark'];

           $checkRemark = checkitem("Remark","resturant_remark","WHERE","Remark='$remark' ");
           if($checkRemark == 0){

           $stmt = $con->prepare("INSERT INTO `resturant_remark`(`Remark`,`time`,`statut_id`,`Order_number`,`Role`) VALUES('$remark',now(), 2,'$ordernumber', 0)");
           $stmt->execute();
           
           }

           $checkCurr = checkitem("Remark","current_remark","WHERE","Order_number='$ordernumber' ");

           if($checkCurr == 0){

               $stmt2 = $con->prepare("INSERT INTO `current_remark`(`Remark`,`time`,`statut_id`,`Order_number`) VALUES('$remark',now(), 2 ,'$ordernumber')");
               $stmt2->execute();
                 
           } else{
               $stmt3 = $con->prepare("UPDATE `current_remark` SET `Remark` = '$remark' , `time` = now() , `statut_id` = 2 , `Order_number` = '$ordernumber' WHERE `current_remark`.`Order_number` = '$ordernumber' ");
               $stmt3->execute();
           }

    }
    
    include $tp . "/footer.php";
    }