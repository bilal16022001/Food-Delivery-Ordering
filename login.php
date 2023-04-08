

<?php
    session_start();

    $title="login";
    include "init.php";

 
        if($_SERVER['REQUEST_METHOD']=== 'POST'){

          if(isset($_POST['login'])){
                $email = $_POST['email'];
                $pass = sha1($_POST['password']);

                $stmt = $con->prepare("SELECT * FROM `users` WHERE Email = ? AND password = ? AND Role != 1");
                $stmt->execute(array($email,$pass));
                $count = $stmt->rowCount();


            if($count > 0) {
              $_SESSION['email_user']=$email;
              header("Location: home.php");
              exit();

            }
         }


            else{
              $firstName = $_POST['firstName'];
              $lastName  = $_POST['lastName'];
              $Phone     = $_POST['Phone'];
              $password  = sha1($_POST['password']);
              $Email     = $_POST['Email'];
              $fromErrors= array();

                if(isset($firstName)){
                   $filterUser = filter_var($firstName,FILTER_SANITIZE_STRING);
                   if(strlen($filterUser) < 4){
                     $fromErrors[] = "Username must be larger than 4 character";
                   }
                }

      
                if(isset($Email)){
                  $filterEmail = filter_var($Email,FILTER_SANITIZE_EMAIL);
                  if(filter_var($filterUser,FILTER_SANITIZE_EMAIL) != true){
                      $fromErrors[] = "email is not valid";
                  }
                }

                if(empty($fromErrors)){
                   
                  $check = checkitem("*","users","WHERE","Email = '$Email' ");
    
                    if($check == 1){
                        $fromErrors[] = "this item is exit";

                    }
                     else{

                      $stmt = $con->prepare("INSERT INTO `users`(`FirstName`,`LastName`,`Phone`,`password`,`Email`,`Role`)VALUES('$firstName','$lastName','$Phone','$password','$Email',0) ");
                      $stmt->execute();
                      $count = $stmt->rowCount();
                      $_SESSION['count']=$count;
    
                  
                    }
                }
             
             
       
            }
          }
  
  
?>
 <div class="all">
  <div class="container">
    <?php
      // if(isset($_SESSION['count'])>0){
      //   echo "<div class='alert alert-success'>your signup successfuly</div>";
      // }
    ?>
    <h1 class="text-center mt-3 title">
      <span class="activeL">Login</span> | 
      <span class="">Sign up</span>
    </h1>
   <div class="frm">
    <!---start login--->
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="form_home login" method="POST">
      <input class="form-control" type="email" placeholder="your email" name="email" />
        <input class="form-control" type="password" placeholder="password"  name="password" />
          <input class="btn btn-primary" name="login" type="submit" value="login" />
        </form>
          <!---end login--->
            <!---start signup--->
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>"  class="form_home signup sh" method="POST">
          <input type="text" name="firstName" placeholder="first Name" required />
          <input type="text" name="lastName" placeholder="Last Name" required />
          <input type="text" name="Phone" placeholder="Number Phone" required/>
          <input type="password" name="password" minlength="4" placeholder="your password" required />
          <input type="text" name="Email" placeholder="Email" required />
          <input class="btn btn-primary" name="signup" type="submit" value="sign up" />
        </form>
          <!---end signup--->
   </div>
   <div class="text-center">
     <?php
       if(!empty($fromErrors)){
           foreach($fromErrors as $err){
              echo $err . "<br/>";
           }
       }
      ?>
   </div>
  </div>
      </div>
<?php    include $tp . "/Footer.php"; ?>

