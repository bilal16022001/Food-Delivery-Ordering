<?php
  session_start();
  if($_SESSION['email']){
    $title="users";
    include "init.php";
    include "SideBar.php";
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    if($do == "Manage"){
        
?>
 <div class="menu">
    <h2 class="text-center mb-4">Manage Food Items</h2>
    <div class="container">
                    <div class="table-responsive">
                        <table class="main-table text-center table table-bordered">
                            <tr>
                                 <td>#</td>
                                 <td>image</td>
                                 <td>Category Name</td>
                                 <td>Creation Date</td>
                                 <td>Action</td>
            
                            </tr>
                            <?php
                              $stmt = $con->prepare("SELECT 
                              food_items.*,category.category_name
                       FROM
                              food_items
                       INNER JOIN 
                              category
                       ON
                              food_items.food_category = category.id");
                               $stmt->execute();
                               $items = $stmt->fetchAll();

                              if(!empty($items)){
                                 foreach($items as $item){
                                     $_SESSION['item_id'] = $item['id'];
                                  echo "<tr>";
                                      echo "<td>" . $item['id'] . "</td>";
                                      echo "<td>";
                                         if(!empty($item['image'])){
                                             ?>
                                                <img src="uploads/attach/<?php echo $item['image']; ?>"  />
                                             <?php
                                         }else{
                                            echo "no image";
                                         }
                                      echo "</td>";
                                      echo "<td>" . $item['category_name'] . "</td>";
                                      echo "<td>" . $item['name'] . "</td>";
                                      echo "<td>";
                                          echo "<a href=menu.php?do=Edit&id=" . $item['id'] .">Edit</a> ";
                                      echo "</td>";
                                  echo "</tr>";
                                 }
                              }else{
                                 echo "there is not items";
                              }
                               
                                   
                                 
                            ?>
                        </table>
                        <a class="btn btn-primary" href="menu.php?do=Add">Add New Food</a>
                    </div>
                </div>
          </div>


<?php

}
if($do == "Add"){

   ?>
     <div class="menuForm">
        <form action="?do=Insert" method="POST" enctype="multipart/form-data">
            <label>Food Category :</label>
            <?php
                  $category = getdb("*","category");
                  echo "<select name='name_category'>";
                        foreach($category as $cat){
                           ?>
                                    <option value="<?php echo $cat['id'] ?>"><?php echo $cat['category_name'] ?></option>
                           <?php
                        }
                  echo "</select>";
            ?>
            <br/>
            <label>Item Name :</label>
            <input type="text" name="item" required /><br/>
            <label>Description :</label>
            <textarea name="Description" required></textarea><br/>
            <label>image</label>
            <input type="file" name="file" required /><br/>
            <label>Price :</label>
            <input type="text" name="price" required />
            <input type="submit" value="submit" />
        </form>
     </div>
   <?php 

}

if($do == "Insert"){
   if($_SERVER['REQUEST_METHOD'] == "POST"){
        $name_category=$_POST['name_category'];
        $item = $_POST['item'];
        $Description = $_POST['Description'];

        $fileName =  $_FILES['file']['name'];
        $fileSize =  $_FILES['file']['size'];
        $fileTmp  =  $_FILES['file']['tmp_name'];
      //   $fileType =  $_FILES['file']['Type'];

        $attachArr = explode(".",$fileName);
        $file_ext  = strtolower(end($attachArr));
        $attachAll = array("jpeg","png","jpg","gif","jfif");

        $price = $_POST['price'];
 
        $arrErour=array();
        if(!empty($fileName)){
          $arrErour[]="<div class='container alert alert-danger'>image is required</div>"; 
        }
        if(!in_array($file_ext,$attachAll)){
           $arrErour[]="<div class='container alert alert-danger'>not allowed this exetntion</div>"; 
        }
        if($fileSize > 4194304){     
         $arrErour[] = "<div class='container alert alert-danger'>image can't be larger <strong>4MB</strong></div>";
        }

       if(!empty($arrErour)){
           $attach = rand(0,1000000) . "_" . $fileName;
           move_uploaded_file($fileTmp,"uploads\attach\\" . $attach);

           $stmt = $con->prepare("INSERT INTO `food_items`(`image`,`food_category`,`name`,`description`,`price`)VALUES('$attach','$name_category','$item','$Description','$price')");
           $stmt->execute();
       }



   }
}
if($do == "Edit"){
     $userId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']):0;
     $_SESSION['item_id'] = $userId;
     $stmt = $con->prepare("SELECT 
     food_items.*,category.category_name
      FROM
         food_items
      INNER JOIN 
         category
      ON
         food_items.food_category = category.id
      WHERE
       food_items.id = '$userId'
     ");
              $stmt->execute();
              $items = $stmt->fetchAll();
      
     ?>
      <div class="menuForm">
        <form action="?do=update" method="POST" enctype="multipart/form-data">
            <label>Food Category :</label>
            <?php
                  $category = getdb("*","category");
                  echo "<select name='name_category'>";
                        foreach($category as $cat){
                         
                           ?>
                           <option value="<?php echo $cat['id'] ?>" <?php if($cat['id']==$items[0]['food_category']){echo "selected";} ?>> <?php echo $cat['category_name'] ?></option>
                           <?php
                        }
                  echo "</select>";
            ?>
            <br/>
            <label>Item Name :</label>
            <input type="text" name="item" value="<?php echo $items[0]['name'] ?>" required /><br/>
            <label>Description :</label>
            <textarea name="Description" required><?php echo $items[0]['description'] ?></textarea><br/>
            <label>image</label>
            <input type="file" name="file" /><br/>
            <label>Price :</label>
            <input type="text" name="price" value="<?php echo $items[0]['price'] ?>" required />
            <input type="submit" value="submit" />
        </form>
     </div>
     <?php
}
if($do == "update"){
   $itemid =  $_SESSION['item_id'];
   $name_category=$_POST['name_category'];
   $item = $_POST['item'];
   $Description = $_POST['Description'];

   $fileName =  $_FILES['file']['name'];
   $fileSize =  $_FILES['file']['size'];
   $fileTmp  =  $_FILES['file']['tmp_name'];
 //   $fileType =  $_FILES['file']['Type'];

   $attachArr = explode(".",$fileName);
   $file_ext  = strtolower(end($attachArr));
   $attachAll = array("jpeg","png","jpg","gif","jfif");
   $attach = rand(0,1000000) . "_" . $fileName;
   move_uploaded_file($fileTmp,"uploads\attach\\" . $attach);

   $price = $_POST['price'];

   $food_img = getdb("image","food_items","WHERE","id =",$itemid);

   $img="";
   if(!empty($fileName)){
      $img = $attach;
   }else{
      $img = $food_img[0]['image'];
   }

   $stmt = $con->prepare("UPDATE `food_items` SET `image` = '$img' , `food_category` = '$name_category' , `name` = '$item' , `description` = '$Description' , `price` = '$price' WHERE `food_items`.`id` = '$itemid' ");
   $stmt->execute();

       echo "<div class='alert alert-success'>" . $stmt->rowCount()  . " Record updated</div>";
}


   include $tp . "/footer.php";
}

  else{
    header("Location: login.php");
  }