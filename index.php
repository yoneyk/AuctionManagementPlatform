<?php
session_start(); 
$message = '';
include_once 'commonFunctions.php';
if(filter_input(INPUT_POST, 'login') !== NULL){//$_POST["login"]
    $email = sanitizeString($con,filter_input(INPUT_POST, 'username'));
    $password = sanitizeString($con,filter_input(INPUT_POST, 'password'));
    $pass=md5($password);
    
    $sql = "SELECT * FROM tbl_user where email='$email' and password='$pass' LIMIT 1";
    $result= mysqli_query($con,$sql);

    if(!$result){
        die('Could not get data: ' . mysqli_error());
    }
    else{
        if (mysqli_num_rows($result) != 0){
            $_SESSION["email"]= $email;
            $_SESSION["time"]= time();
            //$message = '<div class="alert alert-success">Successfully logged in</div>';
            header("location: home.php");
            exit();
        }
        else{
            $message = '<div class="alert alert-danger">invalid username or password</div>';
        }
    }
} 			
mysqli_close($con);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>BID MANAGEMENT SYSTEM</title>
        <link rel = "stylesheet" href = "css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script src = "js/jquery-3.2.1.min.js"></script>
        <script src = "js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class = container-fluid>
                <div class="navbar-header">
                    <a href="#" class="navbar-brand"></a>
                    <h1 style="color: white">Auction Management System</h1>
                </div>
                <ul class="nav navbar-nav navbar-right">
                        <li style="top:25px;" class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Login<span class="caret"></span></a>
                            <ul class="dropdown-menu" id="login-dp">
                                <li>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form class="form" role="form" method="post" action="login" accept-charset="UTF-8" id="login-nav" name="loginform">
                                                <div class="form-group">
                                                    <div class="col-sm-10 col-sm-offset-2">
                                                        <?php echo $message; ?>    
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="sr-only" for="username">Username/Email address:</label>
                                                    <input type="email" class="form-control" name="username" placeholder="Email address" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="sr-only" for="pswd">Password</label>
                                                    <input type="password" class="form-control" name="password" placeholder="Password" required>                                                      
                                                    <!--<div class="help-block text-right"><a href="">Forget the password ?</a></div>-->
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary btn-block" name="login">Sign in</button>
                                                </div>
                                                
                                         </form>
                                        </div>
                                        <div class="bottom text-center">
                                            You want to register ? <a href="newuser.php"><b>Sign Up</b></a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                </ul>
            </div>
        </div>
        <div class="jumbotron">
            
        </div>
        <!--<div class="alert alert-danger"> 
            /*<?=$_SESSION['message'] ?>*/
        </div>-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <p>A simple web based bid/auction management system/platform.</p> 
                    <p>It allows logged in users to register items with images and bid 
                        for items other users has put.</p> 
                    <p>It is also possible to track the status of the
                        bid the user made.</p>
                </div>
            </div>
        </div>
    </body>    
</html>
