<?php
  session_start();
  if($_SESSION['email']){
    $title="dashboard";
    include "init.php";
    include "SideBar.php";
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    if($do == "Manage"){
?>


 <div class="dashoard">
    <div>
        <h3>TOTAL ORDER</h3>
        <hr>
        <?php
              $stmt = $con->prepare("SELECT COUNT(id) FROM `orderplace`");
              $stmt->execute();
              $total = $stmt->fetch();
        ?>
        <span><?php echo $total[0] ?></span>
        <span>Total order</span>
    </div>
    <div>
        <h3>CONFIRMED ORDER</h3>
        <hr>
        <?php
              $stmt = $con->prepare("SELECT COUNT(id) FROM `current_remark` WHERE statut_id = 1");
              $stmt->execute();
              $total = $stmt->fetch();
        ?>
        <span><?php echo $total[0] ?></span>
        <span>confirmed order</span>
    </div>
    <div>
        <h3>FOOD BEING PREPARED Order</h3>
        <hr>
        <?php
              $stmt = $con->prepare("SELECT COUNT(id) FROM `current_remark` WHERE statut_id = 3");
              $stmt->execute();
              $total = $stmt->fetch();
        ?>
        <span><?php echo $total[0] ?></span>
        <span>food being prepared order</span>
    </div>
    <div>
        <h3>FOOD PICKUP</h3>
        <hr>
        <?php
              $stmt = $con->prepare("SELECT COUNT(id) FROM `current_remark` WHERE statut_id = 4");
              $stmt->execute();
              $total = $stmt->fetch();
        ?>
        <span><?php echo $total[0] ?></span>
        <span>food pickup</span>
    </div>
    <div>
        <h3>TOTAL FOOD DELIVER</h3>
        <hr>
        <?php
              $stmt = $con->prepare("SELECT COUNT(id) FROM `current_remark` WHERE statut_id = 5");
              $stmt->execute();
              $total = $stmt->fetch();
        ?>
        <span><?php echo $total[0] ?></span>
        <span>Total food deliver</span>
    </div>
    <div>
        <h3>CANCELLED ORDER</h3>
        <hr>
        <?php
              $stmt = $con->prepare("SELECT COUNT(id) FROM `current_remark` WHERE statut_id = 2");
              $stmt->execute();
              $total = $stmt->fetch();
        ?>
        <span><?php echo $total[0] ?></span>
        <span>cancelled order</span>
    </div>
    <div>
        <h3>TOTAL REGD USERS</h3>
        <hr>
        <?php
          $countItem = CountItem("id","users","WHERE Role = 0");
         ?>
        <span><?php echo $countItem  ?></span>
        <span>Total Regd User</span>
    </div>
 </div>

<?php 
  include $tp . "/footer.php";
 }
  }  else{
    header("Location: login.php");
  }
