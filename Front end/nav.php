<nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">ABOUT</a>
      </li>
      
      <!-- logged in user nav - starts -->
      <?php $_SESSION[C_SESSION_USER_ID_KEY] ?>
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
      <? } ?>

      <!-- logged in user nav - ends -->

    </ul>
  </div>
</nav>