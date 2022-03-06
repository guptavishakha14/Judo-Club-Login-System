<?php
require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST['username']))){
        $username_err = "Username cannot be blank";
    }
    else{
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = trim($_POST['username']);

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $username_err = "This username is already taken"; 
                }
                else{
                    $username = trim($_POST['username']);
                }
            }
            else{
                echo "Something went wrong";
            }
        }
    }

    mysqli_stmt_close($stmt);

// Check for password
if(empty(trim($_POST['password']))){
    $password_err = "Password cannot be blank";
}
elseif(strlen(trim($_POST['password'])) < 5){
    $password_err = "Password cannot be less than 5 characters";
}
else{
    $password = trim($_POST['password']);
}

// Check for confirm password field
if(trim($_POST['password']) !=  trim($_POST['confirm_password'])){
    $password_err = "Passwords should match";
}

// If there were no errors, go ahead and insert into the database
if(empty($username_err) && empty($password_err) && empty($confirm_password_err))
{
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
        mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT);

        if (mysqli_stmt_execute($stmt))
        {
            header("location: login.php");
        }
        else{
            echo "Something went wrong... cannot redirect!";
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
}

?>


<html>  
<head>   
<title>  New User Registration form  </title>
<style>
.p{
   text-align:center;
   font-size:28;
   color:red;
   background-color:aqua;
   border:2px solid black;
   padding:10px;
   width:25%;
   margin-left:540px;
}
div{ 
     background-color:lightyellow;
     border:3px solid black;
     width:50%;
     margin-left:335px;
     padding:20px;
 }
button{ 
        background-color:green; 
        font-size:18;
        width:14%;
        color:white; 
        padding:3px; 
        margin:10px 0px; 
        border:2px solid black; 
        cursor:pointer; 
         } 
body{
          background-image: url(bgimg.jpg);
          background-size: cover;
          background-position: center;
         }
</style>  
</head> 
 
<body bgcolor="seashell"> <br><br><br>
<p class="p"> <b>◈ New User Registration ◈</b> </p>  

<form action="" method="post">  
<div>
<label> <b>Username :</b> </label>         
<input type="text" placeholder="Enter Username" name="username"> <br> <br>

<label> <b>Password : </b> </label>         
<input type="text" placeholder="Enter Password" name="password"><br> <br> 

<label> <b>Confirm Password :</b> </label>         
<input type="text" placeholder="Enter Confirm Password" name="confirm_password"> <br> <br>

<b>Email :</b>  
<input type="email" placeholder="Enter email address" id="email" name="email"> <br> <br> 

<button type="submit"> <b>Register</b> </button>
</div>
</form>  

</script>
</body>  
</html>  