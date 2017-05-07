<?php
    include_once 'commonFunctions.php';
    $message = '';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>BID MANAGEMENT SYSTEM</title>
        <link rel = "stylesheet" href = "css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script src = "js/jquery-3.2.1.min.js"></script>
        <script src = "js/bootstrap.min.js"></script>
        <script src = "js/newUser.js"></script>
    </head>
<?php
    if((isset($_POST['firstname'])) && (isset($_POST['lastname']))&&(isset($_POST['password']))!="" && (isset($_POST['email'])) && (isset($_POST['phone']))&&(isset($_POST['city'])) && (isset($_POST['confirm_password']))) { 
        $firstname = sanitizeString($con,$_POST['firstname']);
        $lastname = sanitizeString($con,$_POST['lastname']);
        $phone = sanitizeString($con,$_POST['phone']);
        $city = sanitizeString($con,$_POST['city']);
        $email = sanitizeString($con,$_POST['email']);
        $password = sanitizeString($con,$_POST['password']);
        $confirm_password = sanitizeString($con,$_POST['confirm_password']);
        
        if($password === $confirm_password){
            $pass = md5($password);
            //print_r($pass);
            $sql = "INSERT INTO tbl_user(email,password, firstname, lastname, phone_no, city)"
                . "VALUES ('".$email."','".$pass."','".$firstname."', '".$lastname."','".$phone."', '".$city."')";
            $result = mysqli_query($con,$sql);
            if (!$result) {
                die('Error:can not insert to table tbl_user ' . mysqli_error($con));
            }
            else{
                $message = '<div class="alert alert-success">User added successfully</div>';
            }
        }
    }
    mysqli_close($con);
?>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class = container-fluid>
                <div class="navbar-header">
                    <a href="#" class="navbar-brand"></a>
                    <h1 style="color: white">Auction Management System</h1>
                </div>
                <ul class="nav navbar-nav navbar-right">
                        <!--<li style="top:25px;"><a href="index.php">Home</a>-->
                        <li style="top:25px;" class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Login<span class="caret"></span></a>
                            <ul class="dropdown-menu" id="login-dp">
                                <li>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form class="form" role="form" method="post" action="login" accept-charset="UTF-8" id="login-nav" name="loginform">

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
                                                    <button type="submit" class="btn btn-info btn-block" name="login">Sign in</button>
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
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <form action="" method="post" role="form" onSubmit="return validateUser();">
                        <fieldset>
                            <legend class="text-center">Registration Form:</legend>
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <?php echo $message; ?>    
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group"> 	 
                                    <label for="firstname" class="label-group"><span class="req">* </span > First name: </label>
                                    <input class="form-control" type="text" name="firstname" id = "firstname" /> <!--id="txt" onkeyup = "Validate(this)"-->
                                    <div class="errvalidation" id="errFirstname">Please fill first name field</div>  
                                </div>

                                <div class="form-group"> 	 
                                    <label for="lastname" class="label-group"><span class="req">* </span > Last name: </label>
                                    <input class="form-control" type="text" name="lastname" id = "lastname"/> <!--required-->
                                    <div class="errvalidation" id="errLastname">Please fill last name field</div>  
                                </div>

                                <div class="form-group">
                                    <label for="phone" class="label-group"><span class="req">* </span> Phone Number: </label> 
                                    <input class="form-control" type="tel" pattern="[0-9]{10-13}" name="phone" id = "phone" required=""/>
                                    <div class="errvalidation" id="errPhone">Please fill phone field</div>
                                </div>

                                <div class="form-group">
                                    <label for="city" class="label-group"><span class="req">* </span> City: </label> 
                                    <input class="form-control" type="text" name="city" id = "city"/>
                                    <div class="errvalidation" id="errCity">Please fill city field</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email" class="label-group"><span class="req">* </span> Email Address: </label> 
                                    <input class="form-control" type="text" name="email" id = "email" required/>
                                    <div class="errvalidation" id="errEmail">Please fill email field</div>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="label-group"><span class="req">* </span> Password: </label>
                                    <input type="password" name="password" id="password" class="form-control inputpass" minlength="6" maxlength="16"/>
                                    <div class="errvalidation" id="errPassword">Please fill password field</div>

                                    <label for="confirm_password" class="label-group"><span class="req">* </span> Password Confirm: </label>
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control inputpass" minlength="6" maxlength="16" placeholder="Enter password again to validate"/><!--onkeyup="checkPass(); return false;"-->
                                    <div class="errvalidation" id="errConfirmPassword">Please confirm the password</div>
                                    <span class="errvalidation" id="confirmPass">The Password provided and the confirm password do not match</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="submit" value="Register">
                            </div> 
                        </fieldset>
                    </form><!-- ends registration form -->
                </div>

            </div>
        </div>
    </body>    
</html>

