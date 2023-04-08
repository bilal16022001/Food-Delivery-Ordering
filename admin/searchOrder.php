<?php
  session_start();
  if(isset($_SESSION['email'])){
    $title="Search Order";
    include "init.php";
    include "SideBar.php";
   
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $OrderNumber = $_POST['OrderNumber'];
        
        $orders = getdb("*","orderplace","WHERE","Order_number = '$OrderNumber'");
        $str="";
      if(empty($orders)){
        $str = "there is not order";
      }
    }

    ?>
    <div class="users search">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <label>Search by order number</label>
            <input type="text" name="OrderNumber" class="mb-2" required /><br/>
            <input class="btn btn-primary" type="submit" value="search" />
        </form>
        <?php
         if(!empty($orders)){
        ?>
        <h2 class="text-center mb-4"> Result against "<?php echo $OrderNumber ?>" keyword </h2>
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
                        //    if(!empty($orders)){
                            foreach($orders as $order){
                                echo "<tr>";
                                    echo "<td>" . $order['id']  .  "</td>";
                                    echo "<td>" . $order['Order_number']  . "</td>";
                                    echo "<td>" . $order['Order_date']   . "</td>";
                                    echo "<td>";

                               echo ' <a href="orders.php?do=detail&id='. $order['Order_number'] .'" >Detail</a>';
                                
                                    echo "</td>";
                                echo "</tr>";


                               }
                             
                           }
                             if(isset($str)){
                                echo $str;
                              }
                           
                                                          
                            ?>
                        </table>
                    </div>
                </div>
          </div>

    </div>
    
    <?php

     include $tp . "/footer.php";
  }   else{
    header("Location: login.php");
  }