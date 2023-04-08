
<div id="foodMenu" class="foodMenu">
   <div class="container">
    <h2 class="text-center mb-4">Food Menu</h2>
    <div class="foods">
        <?php
            $items = getdb("*","food_items");
            if(!empty($items)){
                foreach($items as $item){
                    ?>
                        <div class="food">
                            <img src="admin/uploads/attach/<?php echo $item['image'] ?>"/>
                            <h3><?php echo $item['name']; ?></h3>
                            <p><?php echo $item['description']; ?></p>
                            <div class="info">
                                <span><?php echo $item['price']; ?></span>
                                <?php
                                   echo "<a class='order btn btn-primary' href=home.php?id=" . $item['id'] .">order now</a> ";
                                ?>
                            </div>
                            </div>
                    <?php
                }
            }
        ?>
        
    </div>
</div>
</div>

<?php

  if(isset($_GET['id']) && isset($_SESSION['email_user'])){
      $id = intval($_GET['id']);
      $user_id = $_SESSION['user_id'];

     $foodItems = getdb("*","food_items","WHERE","id=",$id);
     $image = $foodItems[0]['image'];
     $food_category = $foodItems[0]['food_category'];
     $name = $foodItems[0]['name'];
     $description = $foodItems[0]['description'];
     $price = $foodItems[0]['price'];

     $check = checkitem("*","cart","Where","title='$name'");
      if($check==0){

      $stmt = $con->prepare("INSERT INTO `cart`(`image`,`title`,`description`,`price`,`user_id`)VALUES('$image','$name','$description','$price','$user_id')");
      $stmt->execute();
      }
  } else{
    // header("Location: login.php");
  }

?>

