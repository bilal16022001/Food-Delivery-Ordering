<nav class="navbar navbar-expand-lg bg-black">
  <div class="container">
    <a style="color:#fff" class="navbar-brand me-auto" href="home.php">Food Ordering System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="me-auto"></ul>
      <div  style="color:#fff">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

            <li class="nav-item">
              <a style="color:#fff" class="nav-link active" aria-current="page" href="home.php">Home</a>
            </li>
            <li class="nav-item">
              <a style="color:#fff" class="nav-link active" aria-current="page" href="#foodMenu">Food Menu</a>
            </li>
            <li class="nav-item">
            <?php
              if(isset($_SESSION['email_user'])){
                echo '<a style="color:red;font-weight: bold;" class="nav-link active" aria-current="page" href="myOrders.php">My Orders</a>';
              }else{
                     echo '<a style="color:#fff" class="nav-link active" aria-current="page" href="login.php">login</a>';
              }
              ?>
            </li>
            <li class="nav-item">
            <?php
              if(isset($_SESSION['email_user'])){
                echo '<a style="color:red;font-weight: bold;" class="nav-link active" aria-current="page" href="cart.php">Cart</a>';
              }else{
                     echo '<a style="color:#fff" class="nav-link active" aria-current="page" href="searchOrder.php">Tracker Order</a>';
              }
              ?>
            </li>
            <li class="nav-item position-relative">
            <a class="nav-link ad  dropdown-toggle linkDrp " dropdown-toggle href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">My Account</a>

            <ul class="dropdown-menu dropMenu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="profile.php"><i class="fa-solid fa-user"></i> Profile</a></li>
                <li><a class="dropdown-item" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> logout</a></li>
            </ul>
            
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>