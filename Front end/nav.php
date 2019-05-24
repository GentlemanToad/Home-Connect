<?php
  $loggedIn = isset($_SESSION[C_SESSION_USER_ID_KEY]);
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">ABOUT</a>
      </li>
      
      <?php if($loggedIn){ ?>
        <li class="nav-item">
          <a class="nav-link" href="rental.php">RENTAL</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="chat.php">CHAT</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="maintenance.php">MAINTENANCE</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          REGISTER
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="#">Landlord</a>
            <a class="dropdown-item" href="#">Tennant</a>
            <a class="dropdown-item" href="#">Property</a>
          </div>
        </li>
      <?php } ?>

    </ul>

    <ul class="navbar-nav justify-content-end my-2 my-lg-0">
      <?php if($loggedIn){ ?>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
      <?php }else{ ?>
        <li class="nav-item">
          <a class="nav-link" href="signin.php">SignIn</a>
        </li>
      <?php } ?>
    </ul>
  </div>
</nav>