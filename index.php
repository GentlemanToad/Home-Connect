<!DOCTYPE html>
<html>
    
  <!-- Use style.css as stylesheet for Home Connect -->
     <link id='stylecss' type="text/css" rel="stylesheet" href="style.css">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<body>
    
<div id="myNav" class="overlay">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <div class="overlay-content">
    <a href="#">File Sharing</a>
    <a href="#">Profile</a>
    <a href="#">Settings</a>
    <a href="#">Logout</a>
  </div>
</div>

<span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; </span>

<script>
function openNav() {
  document.getElementById("myNav").style.width = "20%";
}

function closeNav() {
  document.getElementById("myNav").style.width = "0%";
}
</script>   

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  
</head>
<body>
<img src='../media/HomeConnectLogo.png' alt='HomeConnectLogo' height=80
 </div>  

<nav>
 <div class="navbar">
  <a href="#ABOUT">ABOUT</a>
  <a href="#RENTAL">RENTAL</a>
  <a href="#CHAT">CHAT</a>
 <div class="dropdown">
   <button class="dropbtn">MAINTENANCE 
   <i class="fa fa-caret-down"></i>
    </button>
   <div class="dropdown-content">
      <a href="#">Request maintenance</a>
      <a href="#">Schedule maintenance</a>
      <a href="#">View/Edit maintenance</a>
      <a href="#">Follow up request</a>
      <a href="#">Close request</a>
    </div>
</div>
  <div class="dropdown">
    <button class="dropbtn">REGISTER 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="#">Landlord</a>
      <a href="#">Tenant</a>
      <a href="#">Property</a>
    </div>
  </div> 

<!-- Image sourced for educational purposes only -->
    <div> <img src='../media/HomeConnect.jpg' alt='HomeConnect' height=900
<!-- div class="navbar">-->
 </div>  
 </nav>  

<script>
window.onscroll = function() {myFunction()};

var navbar = document.getElementById("navbar");
var sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}
</script>

<!-- Footer section - Team A -->
<footer> 
      <p>  </p> <hr>
      &copy; Home Connect by Team A - Building IT Systems
      <script>
     document.write(new Date().getFullYear());  
      </script>
      <p>   </p> 
</footer>
     
</body>
</html>
