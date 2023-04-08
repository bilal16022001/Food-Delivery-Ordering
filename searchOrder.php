<?php
  session_start();
  // if(isset($_SESSION['email_user'])){
    $title="Search Order";
    include "init.php";
    // include "SideBar.php";
   
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $OrderNumber = $_POST['OrderNumber'];
        $_SESSION['orderNumber'] = $OrderNumber;
        $orders = getdb("*","orderplace","WHERE","Order_number = '$OrderNumber'");
        $str="";
      if(empty($orders)){
        $str = "there is not order";
      }
    }

    ?>
    <div class="users search">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <label>Search by order number</label>
            <input type="text" name="OrderNumber" class="mb-2" required /><br/>
            <input class="btn btn-primary" type="submit" value="search" />
        </form>
        <?php
         if(!empty($orders)){
            foreach($orders as $order){
        ?>
              <div class="row mb-3">
                           <div class="col-md-2">
                            order
                          </div>
                         <div class="col-md-5">
                             <h4>order # <?php echo $order['Order_number'] ?></h4>
                             <span class="or_d">Order Date : </span><?php echo $order['Order_date'] ?><br/>
                             <a href="#"> </a>
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
                                       resturant_remark.Order_number = '$OrderNumber'
                           
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
                             <a href="<?php echo "orderDetail.php?orderId=" . $order['Order_number'] ?>">Tracker order</a>
                         </div>
                         <div class="col-md-5">
                            <?php
                            echo '<a href="orderDetail.php?orderId=' . $order['Order_number'] .'">View Details</a>';
                            ?>
                         </div>
                        </div>

             <?php }
                 
                             
                           }
                             if(isset($str)){
                                echo $str;
                              }
                           
                                                          
                            ?>
                        </table>
                    </div>
                </div>
          </div>

    </div>
    
    <?php

     include $tp . "/footer.php";
  // }   else{
  //   header("Location: login.php");
  // }