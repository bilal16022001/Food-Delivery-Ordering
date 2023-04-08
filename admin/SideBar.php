
<div class="home">
        <div class="s">
            <div class="sidebar">
                <div class="profile">
                    <img src="uploads/attach/person-3_ipa0mj.jpg" />
                       <a class="nav-link ad  dropdown-toggle  " dropdown-toggle href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Admin</a>

                        <ul class="dropdown-menu dropMenu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="profile.php"><i class="fa-solid fa-user"></i> My Account</a></li>
                            <li><a class="dropdown-item" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> logout</a></li>
            
                        </ul>
                </div>
                <hr>
                <ul class="MenuSidebar">
                    <li><i class="fa fa-gauge-high"></i><a href="dashboard.php">dashboard</a></li>
                    <li><i class="fa-sharp fa-solid fa-users"></i><a href="users.php">Reg Users</a></li>
                    <li>
                             <i class="fa-solid fa-list"></i>
                             <a href="category.php">Food Category</a>
                    </li>
                    <li><i class="fa-solid fa-list"></i><a href="menu.php">Food Menu</a></li>
                    <li><i class="fa-solid fa-copyright"></i><a href="orders.php">Orders</a></li>
                    <li> <i class="fa-sharp fa-solid fa-file"></i><a href="reports.php">Reports</a></li>
                    <li><i class="fa-sharp fa-solid fa-magnifying-glass"></i><a href="searchOrder.php">Search</a></li>
                </ul>
            </div>
        </div>
        <div class="h">
            <div class="header">
                <div class="row">
                  <div class="col-md-4">
                  <i class="fa-solid fa-bars bars"></i>
                  </div>
                  <div class="col-md-6">
                    <h3>Food ordering System</h3>
                  </div>
                  <div class="col-md-2 d-flex gap-4">
                      <div class="noti">
                         <a href="FoodOrView.php"><i class="fa-solid fa-bell"></i></a>
                         <?php
                           $stmt = $con->prepare("SELECT COUNT(id) FROM `orderplace`");
                           $stmt->execute();
                           $total = $stmt->fetch();
                         ?>
                         <span><?php echo $total[0]; ?></span>
                      </div>
                      <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
                  </div>
                </div>
            </div>