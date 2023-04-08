<?php
  session_start();
  if(isset($_SESSION['email_user']) || isset($_SESSION['orderNumber'])){
    $title="category";
    include "init.php";
    $orderNumber = isset($_GET['orderId']) && is_numeric($_GET['orderId']) ? intval($_GET['orderId']):0;
    ?>
    <div class="allCart">
        <div class="container myorders">
            <div class="cont">
                <div class="">
                    <?php
                       $category = getdb("*","category");
                       echo "<h3 class='cateF'>Food Category</h3>";
                       if(!empty($category)){
                          echo "<ul>";
                          foreach($category as $cat){ 
                                 echo "<li>" . $cat['category_name'] . "</li>";
                          }
                          echo "</ul>";
                       }
                    ?>
                </div>
                <div class="cartOrder">
                    <div class="order_cart">
                        <h4 class="titleor mb-3">your orders Delicious hot food !</h4>
                     <div class="cartOr">
                        <?php
          
                        // $email= $_SESSION['email_user'];
                        // $user = getdb("id","users","where","Email='$email'");
                        // $user_id="";
                        // // echo $email;
                        //  if(!empty($user)){
                        //     $_SESSION['user_id']=$user[0]['id'];
                        //     $user_id= $_SESSION['user_id'];
                        //  }
   
                            $cartItems = getdb("*","myorder","where","Order_number=","$orderNumber");
                            if(!empty($cartItems)){
                                foreach($cartItems as $cart){
                            ?>
                            <div class="row mb-3">
                               <div class="col-md-4">
                                 <img src="admin/uploads/attach/<?php echo $cart['image']; ?>"/>
                              </div>
                              <div class="col-md-4">
                                 <h4><?php echo $cart['title']; ?></h4>
                                 <p><?php echo $cart['description']; ?></p>
                              </div>
                              <div class="col-md-4">
            
                                 <p>$<?php echo $cart['price']; ?></p>
                              </div>
                            </div>
                           <?php
                                }
                            } else{
                                echo "<div>your cart is empty</div>";
                            }
                        ?>
                     </div>
                    </div>
                </div>
                <div class="ordering">
    
                <h4>Order # <?php echo $orderNumber; ?></h4>
              <div class="container">
               <div class="p-4 orderCont">
                <?php
                   $myOdrer = getdb("*","orderplace","where","Order_number=","$orderNumber");
                   $cid="";
                     if(!empty($myOdrer)){
                        foreach($myOdrer as $order){
                            $cid=$order['Order_number'];
                  
                   ?>
                    <div>
                      <span>Order Date : </span>
                      <?php echo $order['Order_date'] ?>
                    </div>
                    <div>
                      <span>Flat No / Building No : </span>
                      <?php echo $order['Building'] ?>
                    </div>
                    <div>
                      <span>Street Name : </span>
                      <?php echo $order['Street_Name'] ?>
                    </div>
                    <div>
                      <span>Area : </span>
                      <?php echo $order['Area'] ?>
                    </div>
                    <div>
                      <span>Street Name : </span>
                      <?php echo $order['Order_date'] ?>
                    </div>
                    <div>
                      <span>LandMark : </span>
                      <?php echo $order['Land_Mark'] ?>
                    </div>
                    <div>
                      <span>City : </span>
                      <?php echo $order['City'] ?>
                    </div>
                   <?php
                            
                           }
                        }
                ?>
                <div class="total  text-center">
                  <a class="mb-2 d-block" href="<?php echo "cancelledOrder.php?cid=$cid" ?>">Cancel this Order</a>
                  <p>Total</p>
                  <?php
                    // $userid=$_SESSION['user_id'];
                    $stmt = $con->prepare("SELECT SUM(price) FROM `myorder` WHERE Order_number = $orderNumber ");
                    $stmt->execute();
                    $total = $stmt->fetch();
                 ?>
                <h3 class="price">$<?php echo $total[0] ?></h3>
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
                      echo "<a href='TrackerOrder.php?tId=$orderNumber'>" .  $currSt . "</a>";
                    }else{
                      echo "<a  href='#'>Waiting for Resturant Confirmation</a>";
                    }
                    
                ?>
  
                </div>

              </div>
              </div>
            </div>
            </div>
        </div>
          </div>
    <?php




       include $tp . "/footer.php";
       include "footer.php";
  } 
  
  else{
    header("Location: home.php");
  }

  