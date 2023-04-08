<?php
  session_start();
  if(isset($_SESSION['email_user'])){
    $title="category";
    include "init.php";
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
          
                        $email= $_SESSION['email_user'];
                        $user = getdb("id","users","where","Email='$email'");
                        $user_id="";
                         if(!empty($user)){
                            $_SESSION['user_id']=$user[0]['id'];
                            $user_id= $_SESSION['user_id'];
                         }
   
                            $cartItems = getdb("*","cart","where","user_id=","$user_id");
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
                <div class="shopping">
                <h4>Your shopping Cart</h4>
              <div class="container">
         <form action="" method="POST">
              <input type="text" name="Building" placeholder="Flat or Building Number" required />
                <input type="text" name="Street" placeholder="Street Name" required />
                <input type="text" name="Area" placeholder="Area" required />
                <input type="text" name="Mark" placeholder="Land Mark if any" required />
                <input type="text" name="City" placeholder="City" required />
                <span>Total</span>
                <?php
                  $userid=$_SESSION['user_id'];
                  $stmt = $con->prepare("SELECT SUM(price) FROM `cart` WHERE user_id = $userid ");
                  $stmt->execute();
                  $total = $stmt->fetch();
                ?>
                <h3 class="price">$<?php echo $total[0] ?></h3>
                <span>Free Shipping</span>
                <input type="submit" value="place order "/>
         </form>
              </div>
            </div>
            </div>
        </div>
          </div>
    <?php

if($_SERVER['REQUEST_METHOD']=="POST"){

      $Building = $_POST['Building'];
      $Street = $_POST['Street'];
      $Area = $_POST['Area'];
      $Mark = $_POST['Mark'];
      $City = $_POST['City'];
      $randomNum = rand(0,1000000000);
      $userid =  $_SESSION['user_id'];
     
      $cartItems = getdb("*","cart","where","user_id=","$user_id");

      foreach($cartItems as $cart){
         $image = $cart['image'];
         $title = $cart['title'];
         $description = $cart['description'];
         $price = $cart['price'];

         $stmt = $con->prepare("INSERT INTO `myorder`(`image`,`title`,`description`,`price`,`user_id`,`Order_number`)VALUES('$image','$title','$description','$price','$user_id','$randomNum') ");
         $stmt->execute();
      }

      $stmt2 = $con->prepare("INSERT INTO `orderplace`(`Order_date`,`Building`,`Street_Name`,`Area`,`Land_Mark`,`City`,`Order_number`,`user_id`)VALUES(now(),'$Building','$Street','$Area','$Mark','$City','$randomNum','$userid') ");
      $stmt2->execute();

    

         $stmt3 = $con->prepare("UPDATE `cart` SET `order_number` = '$randomNum' WHERE `cart`.`user_id` = '$userid' ");
         $stmt3->execute();

         $delet = deleteItem("cart","user_id",$userid);
    

 
}





       include $tp . "/footer.php";
       include "footer.php";
  } 
  
  else{
    header("Location: home.php");
  }

  