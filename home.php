<?php
    session_start();
    $title="home";
   include "init.php";
   $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

?>

<div class="bacimg">
    <?php
      //  $getImg = getdb("attach","system");
    ?>
    <img src="admin/uploads/attach/458624_thq.jpg"/>
   <div class="overlay"></div>
   <div class="title">
      <h2>Order Delivrey & Take-Out</h2>
      <p>Find your favourite hot food!</p>
      <input type="text" placeholder="I would like to eat..." />
      <button>Search Food</button>
   </div>
</div>

<?php 
   include "foodMenu.php";
   include "footer.php";
   include $tp . "/footer.php";
