<?php
  session_start();
  if(isset($_SESSION['email_user'])){
    $title="orders";
    include "init.php";
    ?>
        <div class="myOr_image">
           <img src="admin/uploads/attach/bax.jpg"/>
        </div>
        <div class="container myorders">
            <div class="row">
                <div class="col-md-4">
                    <?php
                       $category = getdb("*","category");
                       echo "<h3>Food Category</h3>";
                       if(!empty($category)){
                          echo "<ul>";
                          foreach($category as $cat){ 
                                 echo "<li>" . $cat['category_name'] . "</li>";
                          }
                          echo "</ul>";
                       }
                    ?>
                </div>
                <div class="col-md-8">
                    <div class="row mb-3">
                        <?php
                          $email= $_SESSION['email_user'];
                          $user = getdb("id","users","where","Email='$email'");
                          $user_id="";

                           if(!empty($user)){
                              $_SESSION['user_id']=$user[0]['id'];
                              $user_id= $_SESSION['user_id'];
                           }
        
                            $placeOrder = getdb("*","orderplace","where","user_id=","$user_id");

                            if(!empty($placeOrder)){ 
                                foreach($placeOrder as $order){
                                    $orderNumber = $order['Order_number'];
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
                           WHERE resturant_remark.Order_number = '$orderNumber'
                           
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
                             <a href="<?php echo "TrackerOrder.php?tId=" . $order['Order_number'] ?>">Tracker order</a>
                         </div>
                         <div class="col-md-5">
                            <?php
                            echo '<a href="orderDetail.php?orderId=' . $order['Order_number'] .'">View Details</a>';
                            ?>
                         </div>
                        </div>
                          <?php
                                   }
                                }
                                else{
                                    echo "<div>there is not order</div>";
                                }

                       ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
       include $tp . "/footer.php";
  }  else{
    header("Location: home.php");
  }