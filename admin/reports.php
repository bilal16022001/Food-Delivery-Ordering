<?php
  session_start();
  if($_SESSION['email']){
    $title="Reports";
    include "init.php";
    include "SideBar.php";
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    if($do == "Manage"){
        
?>
 <h1>The page not found </h1>
<?php
   include $tp . "/footer.php";
    }
}