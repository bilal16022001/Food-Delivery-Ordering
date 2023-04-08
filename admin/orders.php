<?php
  session_start();
  if($_SESSION['email']){
    $title="orders";
    include "init.php";
    include "SideBar.php";
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    if($do == "Manage"){
        
?>
 <div class="users">
    <?php
    $orders = getdb("*","orderplace");

    if(!empty($orders)){
       
    ?>
    <h2 class="text-center mb-4">Orders Received</h2>
    <div class="container">
                    <div class="table-responsive">
                        <table class="main-table text-center table table-bordered">
                            <tr>
                                 <td>#</td>
                                 <td>Order Number</td>
                                 <td>Order Date</td>
                                 <td>Action</td>
                            </tr>
                            <?php
                           foreach($orders as $order){
                                  echo "<tr>";
                                      echo "<td>" . $order['id']  .  "</td>";
                                      echo "<td>" . $order['Order_number']  . "</td>";
                                      echo "<td>" . $order['Order_date']   . "</td>";
                                      echo "<td>";

                                 echo ' <a href="orders.php?do=detail&id='. $order['Order_number'] .'" >Detail</a>';
                                  
                                      echo "</td>";
                                  echo "</tr>";


                                 }
                              }
                               
                                                          
                            ?>
                        </table>
                        <a class="btn btn-primary" href="orders.php?do=notConfirmed">Not Confirmed</a>
                        <a class="btn btn-primary" href="orderConfirmed.php">Order Confirmed</a>
                        <a class="btn btn-primary" href="orderPreparing.php">Food Being Prepared</a>
                        <a class="btn btn-primary" href="FoodPickup.php">Food Pickup</a>
                        <a class="btn btn-primary" href="FoodDelivered.php">Food Delivered</a>
                        <a class="btn btn-primary" href="cancelOrderA.php">Cancelled</a>
                    </div>
                </div>
          </div>

       <?php 

    }
    if($do == "detail"){
        $ordernumber = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']):0;
       ?>
            <div class="foodView">
               <div class="row">
                  <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="main-table text-center table table-bordered">
                                    <tr>
                                        <td>User Details</td>
                                        <td></td>
                                    </tr>
                                    <?php
                                        $stmt = $con->prepare("SELECT
                                         orderplace.*,
                                            users.FirstName,
                                            users.LastName,
                                            users.Email,
                                            users.Phone
                                            FROM
                                                    orderplace
                                                    
                                            INNER JOIN
                                                    users
                                            ON
                                          orderplace.user_id = users.id
                                          WHERE
                                          orderplace.Order_number = '$ordernumber'
                                ");
                                    $stmt->execute();
                                    $data = $stmt->fetchAll();
                               
                                   if(!empty($data)){
                                     foreach($data as $order){
                                        $_SESSION['Name_user'] = $order['FirstName'];
                                          ?>
                                             <tr>
                                                 <td><span>Order Number</span></td>
                                                 <td><?php echo $order['Order_number']; ?></td>
                                             </tr>
                                             <tr>
                                                 <td><span>First Name</span></td>
                                                 <td><?php echo $order['FirstName']; ?></td>
                                             </tr>
                                             <tr>
                                                 <td><span>Last Name</span></td>
                                                 <td><?php echo $order['LastName']; ?></td>
                                             </tr>
                                             <tr>
                                                 <td><span>Email</span></td>
                                                 <td><?php echo $order['Email']; ?></td>
                                             </tr>
                                             <tr>
                                                 <td><span>Mobile Phone</span></td>
                                                 <td><?php echo $order['Phone']; ?></td>
                                             </tr>
                                             <tr>
                                                 <td><span>Flat no / Building no</span></td>
                                                 <td><?php echo $order['Building']; ?></td>
                                             </tr>
                                             <tr>
                                                 <td><span>Street Name</span></td>
                                                 <td><?php echo $order['Street_Name']; ?></td>
                                             </tr>
                                             <tr>
                                                 <td><span>Area</span></td>
                                                 <td><?php echo $order['Area']; ?></td>
                                             </tr>
                                             <tr>
                                                 <td><span>Land Mark</span></td>
                                                 <td><?php echo $order['Land_Mark']; ?></td>
                                             </tr>
                                             <tr>
                                                 <td><span>City</span></td>
                                                 <td><?php echo $order['City']; ?></td>
                                             </tr>
                                             <tr>
                                                 <td><span> Order date</span></td>
                                                 <td><?php echo $order['Order_date']; ?></td>
                                             </tr>
                                             <tr>
                                                 <td><span> Order Final Status</span></td>
                                                 <td>
                                   
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
                                        $status = $stmt->fetchAll();
                        
                                                       
                                        $currSt="";
                                        if(!empty($status)){
                                        foreach($status as $sta){
                                            $currSt = $sta['Statut'];
                                        }
                                        echo "<a href='#'>" .  $currSt . "</a>";
                             
                                        }else{
                                        echo "<a  href='#'>Waiting for Resturant Confirmation</a>";
                                        }
                    
                                             ?>
                                                 </td>
                                             </tr>
                                             
                                          <?php
                                     }
                                   }

                                    ?>
                                 
                            </table>
                        </div>
                       
                  </div>
                  <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="main-table text-center table table-bordered">
                                    <tr>
                                        <td>Order Details</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>#</td>
                                        <td>food</td>
                                        <td>food Name</td>
                                        <td>price</td>
                                    </tr>  
                                    <tr>
                                       <?php
                                    
                                             $stmt2 = $con->prepare("SELECT * FROM `myorder` WHERE `Order_number` = $ordernumber ");
                                             $stmt2->execute();
                                             $orders = $stmt2->fetchAll();

                                             if(!empty($orders)){
                                                foreach($orders as $order){
                                                        ?>
                                                           <tr>
                                                                <td><?php echo $order['id'] ?></td>
                                                                <td><img src="uploads/attach/<?php echo $order['image']; ?>"/></td>
                                                                <td><?php echo $order['title'] ?></td>
                                                                <td><?php echo $order['price'] ?></td>
                                                           </tr>
                                                        <?php
                                                }
                                             }

                                        ?>
                                  </tr>    
                                  <tr>
                                     <td>Total</td>
                                     <td>
                                        <?php
                                              $stmt3 = $con->prepare("SELECT SUM(price) AS Total FROM `myorder` WHERE `Order_number` = $ordernumber");
                                              $stmt3->execute();
                                              $total = $stmt3->fetch();
                                        ?>
                                    
                                     </td>
                                     <td>
              
                                     </td>
                                     <td>
                                         <?php   echo $total['Total']; ?>
                                     </td>
                                  </tr>   
                            </table>
                          </div>
                        </div>
                  </div>
        
          
                <div class="table-responsive">
                  <h3 class="text-center">Food Tracking History</h3>
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
                                        <td>
                                             <?php
                                                     if($st['Role'] == 1){
                                                         echo $st['Statut'] . " (by Resturants)";
                                                     }else{
                                                        echo $st['Statut'] . " (by " . $_SESSION['Name_user'] . ")";
                                                     }
                                             ?>
                                        </td>
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
          

                    </div>
            </div>

       <?php
    }


    include $tp . "/footer.php";
    
}
else {
    header("Location: login.php");
}