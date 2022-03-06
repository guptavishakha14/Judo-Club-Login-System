<?php
session_start();

// check if the user is already logged in
if(isset($_SESSION['username']))
{
    header("location: thanks.php");
    exit;
}
require_once "config.php";

$username = $password = "";
$err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty(trim($_POST['username'])) || empty(trim($_POST['password'])))
    {
        $err = "Please enter username + password";
    }
    else{
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }


if(empty($err))
{
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    $param_username = $username;
    
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt))
                    {
                        if(password_verify($password, $hashed_password))
                        {
                            // this means the password is corrct. Allow user to login
                            session_start();
                            $_SESSION["username"] = $username;
                            $_SESSION["id"] = $id;
                            $_SESSION["loggedin"] = true;

                            header("location: thanks.php");
                            
                        }
                    }

                }

    }
}    


}

?>


<html>
    <head>
        <title>   Login page </title>
        <style>
        .container{
        width:30%;
        border:5px solid black;
        margin-left:850px;
        padding:20px;
        }
        button{ 
        background-color:blue; 
        font-size:20;
        width:30%;
        color:white; 
        padding:5px; 
        margin:10px 0px; 
        border:2px solid black; 
        cursor:pointer; 
         } 
         body{
          background-image: url(judo.jpg);
          background-size: cover;
          background-position: center;
         }
        </style>
    </head>

    <body><br><br>
        <h2 style="font-size:34;color:red;background-color:aqua;border:2px solid black;width:10.8%;margin-left:1015px;"> <b>◈ Login ◈</b> </h2> 
        <h3 style="font-size:22;color:red;margin-left:985px"> <b>Welcome to the website!</h3> </p> 

        <form action="" method="post" >

        <div class="container" align="center">
          <label for="id1" style="font-size:17"> <b>Username:</b> </label>
          <input type="text" placeholder="Enter Username" name="username" id=id1> <br><br>
          
          <label for="pwd" style="font-size:17"> <b>Password :</b> </label> 
          <input type="password" placeholder="Enter Password" name="password" id="pwd"> <br><br>

          <button type="submit"> <b>Login</b> </button>
 
          <p style="font-size:19"> <b>New user ?</b> </p>
          <a href="register.php" style="font-size:17"> Create an account </a> 
        </div>
    
        </form>
     </body>
</html>