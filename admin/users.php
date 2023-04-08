<?php
  session_start();
  if(isset($_SESSION['email'])){
    $title="users";
    include "init.php";
    include "SideBar.php";
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    if($do == "Manage"){
?>

 <div class="users">
    <h2 class="text-center mb-4">User Details</h2>
    <div class="container">
                    <div class="table-responsive">
                        <table class="main-table text-center table table-bordered">
                            <tr>
                                 <td>#</td>
                                 <td>First Name</td>
                                 <td>Last Name</td>
                                 <td>Mobile Phone</td>
                                 <td>Email</td>
                                 <td>Action</td>
                            </tr>
                            <?php
                              $users = getdb("*","users","WHERE","Role = ",0);
                              if(!empty($users)){
                                 foreach($users as $user){
                                  echo "<tr>";
                                      echo "<td>" . $user['id'] . "</td>";
                                      echo "<td>" . $user['FirstName'] . "</td>";
                                      echo "<td>" . $user['LastName'] . "</td>";
                                      echo "<td>" . $user['Phone'] . "</td>";
                                      echo "<td>" . $user['Email'] . "</td>";
                                      echo "<td>";
                                          echo "<a href=users.php?do=Edit&id=" . $user['id'] .">Edit</a> ";
                                          echo "<a href=users.php?do=Detail&id=" . $user['id'] .">Detail</a> ";
                                      echo "</td>";
                                  echo "</tr>";
                                 }
                              }
                               
                                   
                                 
                            ?>
                        </table>
                    </div>
                </div>
          </div>

         <?php

   }

   if($do == "Edit"){
        $userId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']):0;
        $EditUser = getdb("*","users","WHERE","id = ",$userId);
        $_SESSION['userId'] = $userId;
        $_SESSION['Email'] = $EditUser[0]['Email'];
    ?>
        <!-----start content---->
        <div class="content">
            <div class="container">
            <h1 class="text-center mb-2">Edit User</h1>

                <form class="m-auto formUsers" method="POST" action="?do=update" enctype="multipart/form-data">     
                      <!----start firstName---->
                      <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">First Name</label>
                        <div class="col-sm-10 col-lg-12 pa_In">
                        <input type="text" name="firstName" placeholder="first Name" value="<?php echo $EditUser[0]['FirstName'] ?>"    class="form-control" required="required"  />
                    </div>
                 </div>
                  <!----end firstName---->
                    <!----start LastName---->
                     <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Last Name</label>
                        <div class="col-sm-10 col-lg-12 pa_In">
                        <input type="text" name="lastName" placeholder="Last Name" value="<?php echo $EditUser[0]['LastName'] ?>"   class="form-control" required="required"  />
                    </div>
                 </div>
                  <!----end LastName---->
                   <!----start Phone---->
                   <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Number Phone</label>
                        <div class="col-sm-10 col-lg-12 pa_In">
                        <input type="text" name="Phone" placeholder="Number Phone" value="<?php echo $EditUser[0]['Phone'] ?>"     class="form-control" required="required"  />
                    </div>
                 </div>
                  <!----end Phone---->
                     <!----start Email---->
                     <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10 col-lg-12 pa_In">
                        <input type="text" name="Email" placeholder="Email" value="<?php echo $EditUser[0]['Email'] ?>"     class="form-control" required="required"  />
                    </div>
                 </div>
                  <!----end Email---->
                      <!----start submit---->
                      <div class="form-group form-group-lg">
                    <div class="col-sm-offset-10 col-lg-12">
                       <input type="submit" value="Save User" class="btn btn-primary" />
                    </div>
                   </div>
              <!----end submit---->
                </div>
          
            </form>

            </div>
        <!-----end content---->
    <?php 
   }
   
   if($do == "update"){

      $id  = $_SESSION['userId'];

      if($_SERVER['REQUEST_METHOD'] == 'POST'){

           $firstName = $_POST['firstName'];
           $lastName  = $_POST['lastName'];
           $Phone     = $_POST['Phone'];
           $Email     = $_POST['Email'];

           $check = checkitem("*","users","WHERE","Email = '$Email' AND id != '$id' ");
       
           if($check > 0){
              echo "<div class='alert alert-danger'>this is already exit</div>";
           }else{
              $stmt = $con->prepare("UPDATE `users` SET `FirstName` = '$firstName' , `LastName` = '$lastName' , `Phone` = '$Phone' , `Email` = '$Email' WHERE `users`.`id` = '$id' ");
              $stmt->execute();
              $count = $stmt->rowCount();

                echo "<div class='alert alert-success'>" . $count  . " Record update</div>";
         

           }
      }
   }
   if($do == "Detail"){
       $detailId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
       $DetailUser = getdb("*","users","WHERE","id = ",$detailId);
       ?>
         <div class="detailuser">
             <ul>
                <?php
                  if(!empty($DetailUser)){
                     foreach($DetailUser as $user){
                          ?>
                           <li>First Name : <?php echo $user['FirstName'] ?> </li>
                           <li>Last Name : <?php echo $user['LastName'] ?></li>
                           <li>Mobile Phone : <?php echo $user['Phone'] ?></li>
                           <li>Email : <?php echo $user['Email'] ?></li>
                          <?php
                     }
                  }
                ?>
             </ul>
         </div>
       <?php

   }

   include $tp . "/footer.php";

 }
  
  else{
    header("Location: login.php");
  }