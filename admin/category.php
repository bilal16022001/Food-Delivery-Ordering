<?php
  session_start();
  if($_SESSION['email']){
    $title="category";
    include "init.php";
    include "SideBar.php";
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    if($do == "Manage"){
?>
   <div class="category">
    <h2 class="text-center mb-4">Manage Food Category</h2>
    <div class="container">
                    <div class="table-responsive">
                        <table class="main-table text-center table table-bordered">
                            <tr>
                                 <td>#</td>
                                 <td>Category Name</td>
                                 <td>Creation Date</td>
                                 <td>Action</td>
                            </tr>
                            <?php
                              $category = getdb("*","category");
                              if(!empty($category)){
                                 foreach($category as $cat){
                                  echo "<tr>";
                                      echo "<td>" . $cat['id'] . "</td>";
                                      echo "<td>" . $cat['category_name'] . "</td>";
                                      echo "<td>" . $cat['Date'] . "</td>";
                                      echo "<td>";
                                          echo "<a href=category.php?do=Edit&id=" . $cat['id'] .">Edit</a> ";
                                      echo "</td>";
                                  echo "</tr>";
                                 }
                              }
                               
                                   
                                 
                            ?>
                        </table>
                        <a class="btn btn-primary" href="category.php?do=Add">Add Category</a>
                    </div>
                </div>
          </div>

     <?php
    }
    if($do == "Add"){
         ?>
         <div class="catEdit">
                <form action="?do=Insert"  method="POST">
                    <h2>Food Category</h2>
                    <input type="text" name="category" placeholder="name of category" /><br/>
                    <input class="btn btn-primary" type="submit" value="Add" />
                    <a class="btn btn-primary" href="category.php">Back</a>
                </form>
            </div>
         <?php
    }

    if($do == "Insert"){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $category = $_POST['category'];
             if(!empty($category)){
                 $stmt = $con->prepare("INSERT INTO `category`(`category_name`,`Date`)VALUES('$category',now())");
                 $stmt->execute();
                 $count = $stmt->rowCount();

                 echo "<div class='alert alert-success'>" . $count  . " Record Inserted</div>";
             }else{
                 echo "you should write";
             }
        }
    }

    if($do == "Edit"){
        $cateId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']):0;
        $catDetail = getdb("*","category","WHERE","id = ",$cateId);
        $_SESSION['catid'] = $cateId;
         ?>
            <div class="catEdit">
                <form action="?do=update"  method="POST">
                    <h2>Food Category</h2>
                    <input type="text" name="category" value="<?php echo $catDetail[0]['category_name'] ?>" /><br/>
                    <input class="btn btn-primary" type="submit" value="update" />
                    <a class="btn btn-primary" href="category.php">Back</a>
                </form>
            </div>
         <?php
    }
    if($do == "update"){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $nameCat = $_POST['category'];
            $catid   =  $_SESSION['catid'];
            
            $stmt = $con->prepare("UPDATE `category` SET `category_name` = '$nameCat' WHERE `category`.`id` = '$catid' ");
            $stmt->execute();
            $count = $stmt->rowCount();

            echo "<div class='alert alert-success'>" . $count  . " Record update</div>";

        }
    }
    include $tp . "/footer.php";
 }
 else{
    header("Location: login.php");
  }