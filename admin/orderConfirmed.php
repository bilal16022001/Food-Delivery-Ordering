<?php
  session_start();
  if(isset($_SESSION['email'])){
    $title="Order Confirmed";
    include "init.php";
    include "SideBar.php";
    $ordernumber = isset($_GET['cid']) && is_numeric($_GET['cid']) ? intval($_GET['cid']):0;
    ?>

    <div class="users">

    <?php
       $orderConfirmed = getdb("*","current_remark","WHERE","statut_id = 1");

    if(!empty($orderConfirmed)){
       
    ?>
    <h2 class="text-center mb-4">Detail Of Order Confirmed</h2>
    <div class="container">
                    <div class="table-responsive">
                        <table class="main-table text-center table table-bordered">
                            <tr>
                                 <td>#</td>
                                 <td>Order Number</td>
                                 <td>Order Date</td>
                                 <td>Action</td>
                            </tr>
                            <?php
                           foreach($orderConfirmed as $order){
                                  echo "<tr>";
                                      echo "<td>" . $order['id']  .  "</td>";
                                      echo "<td>" . $order['Order_number']  . "</td>";
                                      echo "<td>" . $order['time']   . "</td>";
                                      echo "<td>";

                                 echo ' <a href="orders.php?do=detail&id='. $order['Order_number'] .'" >Detail</a>';
                                  
                                      echo "</td>";
                                  echo "</tr>";


                                 }
                              }
                               
                                                          
                            ?>
                        </table>
                     <a class="btn btn-primary" href="orders.php">back</a>
                    </div>
                </div>
          </div>
     <?php 
          include $tp . "/footer.php";
      }