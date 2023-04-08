<?php
  session_start();
  if(isset($_SESSION['email_user'])){
    $title="user Profile";
    include "init.php";
    $email = $_SESSION['email_user'];
    // include "SideBar.php";
     ?>
      <div class="users profile">
          <h2 class="text-center mb-4">User Profile</h2>

          <ul>
              <?php
                 $admin = getdb("*","users","WHERE","Email = '$email'");
                  foreach($admin as $info){
                    $_SESSION['userid'] = $info['id'];
                     ?>
                      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <li><span>First Name</span>:  <input type="text" name="firstName" value="<?php echo $info['FirstName'] ?>" /></li>
                            <li><span>last Name</span>: <input type="text" name="lastName" value="<?php echo $info['LastName'] ?>" /></li>
                            <input type="hidden" name="pass" value="<?php echo $info['password'] ?>" />
                            <li><span>password</span>: <input type="text" name="password" value=""  /></li>
                            <li><span>Phone</span>:  <input type="text" name="phone" value="<?php echo $info['Phone'] ?>" /></li>
                            <li><span>Email</span>: <input type="text" name="email" value="<?php echo $info['Email'] ?>" /></li>
                            <input class="btn btn-primary d-block m-auto" type="submit" value="update" />
                      </form>
                     <?php
                  }
              ?>
          </ul>
      </div>
     <?php
       
     if($_SERVER['REQUEST_METHOD'] == "POST"){
            $firstName = $_POST['firstName'];
            $lastName  = $_POST['lastName'];
            $phone     = $_POST['phone'];
            $password  = $_POST['password'];
            $email     = $_POST['email'];
            $oldPss    = $_POST['pass'];
            $id =  $_SESSION['userid'];
            $sqlPas = "";

            if(empty($password)){
              
              $sqlPas  = $oldPss;
           
            }else{
  
              $sqlPas = sha1($password);
            }

            
            $stmt = $con->prepare("UPDATE `users` SET `FirstName` = '$firstName' , `LastName` = '$lastName' , `Phone` = '$phone' , `password` = '$sqlPas' , `Email` = '$email' WHERE `users`.`id` = '$id'  ");
            $stmt->execute();
     }
  

   include $tp . "/footer.php";   
  }
else {
    header("Location: login.php");
   }