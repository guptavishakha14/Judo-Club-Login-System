<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
    header("location: login.php");
}
?>

<html>  
<head>   
<title>  Thank you!  </title>
<style>
.p{
   text-align:center;
   font-size:66;
   color:red;
   background-color:aqua;
   border:3px solid black;
   padding:10px;
   width:76%;
   margin-left:140px;
}
div{ 
     border:5px solid black;
     width:30%;
     margin-left:5px;
     padding:10px;
 }
.a{ 
        font-size:18;
        color:white;
        margin-left:290px;
        cursor:pointer; 
         } 
body{
          background-image: url(thanks.jpg);
          background-size: cover;
          background-position: center;
 }
</style>  
</head> 
 
<body> <br><br><br><br><br><br><br><br><br>
<div>
<h1 class="p"> <b>Thank You!</b> </h1>  
<p style="text-align:center;font-size:26;color:red;margin-left:180px"> <b>Welcome to our Judo Club!</b> </p>
<a class="a" href="logout.php" >Logout</a>
</div>

</body>  
</html>  
