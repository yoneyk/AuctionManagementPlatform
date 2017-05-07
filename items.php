<?php
    session_start();
    $message = '';
    include_once 'commonFunctions.php';
    if(!(isset($_SESSION['email']) && ($_SESSION['email']!=""))){
            header("location:index.php");
    }
    if( isset( $_SESSION['time'] ) && time() - $_SESSION['time'] > 120){
            header("location:index.php");
    }
    $_SESSION['time']=time();
?>
<?php
    if((isset($_POST["item_name"])) && (isset($_POST["start_price"]))!=="" && (isset($_POST["reg_date"])) && (isset($_POST["end_date"]))!=="" && (isset($_POST["bid_status"]))!=="") {//&& (isset($_POST["image"])) && (isset($_FILES["avatar"]))
	$email = $_SESSION['email']; //as username
        $item_name = sanitizeString($con,$_POST["item_name"]);
	$start_price = sanitizeString($con,$_POST["start_price"]);
        $reg_date = sanitizeString($con,$_POST["reg_date"]);
	$end_date = sanitizeString($con,$_POST["end_date"]);
        $bid_status = sanitizeString($con,$_POST["bid_status"]);
        
        //file properties
        $file = $_FILES['avatar'];
        $file_name = $file['name'];
        $file_size = $file['size'];
        $file_tmp = $file['tmp_name'];
        
        //to get file extensions
        $file_ext = explode('.', $file_name);
        $file_ext1 = strtolower(end($file_ext));
        $allowed_types = array('jpg','png');
        
        if(in_array($file_ext1, $allowed_types)) {//checks if extension exists with in allowed types
            if($file_size <= 2097152){//checks if the size is <= 2MB
                //$new_file_name = $file_ext[0] .uniqid('',true). '.' .$file_ext1; //assignes unique id for uploaded images
                $file_destination = "images/" . $file_name;
                if(move_uploaded_file($file_tmp, $file_destination)) {
                    $sql = "INSERT INTO tbl_items(registered_by,item_name,registered_date,start_price, bid_enddate, status, image)"
                            . "VALUES ('".$email."','".$item_name."','".$reg_date."','".$start_price."', '".$end_date."',"
                            . "'".$bid_status."','".$file_destination."')";
                    $result = mysqli_query($con,$sql);
                    if (!$result) {
                        die('Error:can not insert to table Item' . mysqli_error($con));
                    }
                    else {
                        $message = '<div class="alert alert-success">Item successfully added to the database</div>';
                    }
                }else {
                    $message = '<div class="alert alert-danger">Image is not uploaded to the specified folder</div>';
                }
            }else {
                $message = '<div class="alert alert-danger">Large Image size! Please upload image less than 2MB.</div>';
            } 
        }else {
            $message = '<div class="alert alert-danger">Incorrect file type, please select image file types</div>';
        } 
    }
	mysqli_close($con);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>BID MANAGEMENT SYSTEM/Items</title>
        <link rel = "stylesheet" href = "css/bootstrap.min.css">
        <link rel = "stylesheet" href="css/style.css">
        <script src = "js/jquery-3.2.1.min.js"></script>
        <script src = "js/bootstrap.min.js"></script>
        <script src = "js/items.js"></script>
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class = container-fluid>
                <div class="navbar-header">
                    <a href="#" class="navbar-brand"></a>
                    <h1 style="color: white">Auction Management System</h1>
                </div>
                <ul class="nav navbar-nav navbar-right">
                    <li style="top:25px;"><a href="home.php">Home</a>
                    <!--<li style="top:25px;"><a href="mybids.php">My Bids History</a><!--those not active -->
                    <li style="top:25px;"><a href="mygoods.php">My Goods</a>
                    <li style="top:25px;"><a href="items.php">Register Items</a>
                    <li style="top:25px;"><a href="makebids.php">Make Bid</a>
                    <li style="top:25px;"><a href="logout.php">Log out</a>
                </ul>
            </div>
        </div>
        <div class="jumbotron">

        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <form action="" method="post" role="form" name="items" enctype="multipart/form-data" onsubmit="return validateForm();"><!--enctype="multiport/form-data" onsubmit="return validateItems();"-->
                        <fieldset>
                            <legend class="text-center">Item Registration:</legend>
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <?php echo $message; ?>    
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group"> 	 
                                    <label for="item" class="label-group control-label"><span class="req">* </span > Item name: </label>
                                    <input class="form-control" type="text" name="item_name" id = "item"/><!--required remove all req fields for client validation-->
                                    <div class="errvalidation" id="errItemname">Please fill item name field</div>  
                                </div>

                                <div class="form-group">
                                    <label for="selectedDate" class="label-group"><span class="req">* </span> Registered Date: </label> 
                                    <input class="form-control" type="date" name="reg_date" id = "selectedDate"/>
                                    <div class="errvalidation" id="errRegDate">Please fill registered date field</div>
                                </div>
                            
                                <div class="form-group"> 	 
                                    <label for="endDate" class="label-group"><span class="req">* </span > End Date: </label>
                                    <input class="form-control" type="date" name="end_date" id = "endDate"/>
                                    <div class="errvalidation" id="errWrongEndDate">End date is before registered date, Please choose date after the registered date</div>
                                    <div class="errvalidation" id="errEndDate">Please fill end date field</div>  
                                </div>

                                <div class="form-group">
                                    <label for="price" class="label-group"><span class="req">* </span> Start Price: </label>
                                    <input class="form-control inputpass" type="text" name="start_price"  id="price"/>
                                    <div class="errvalidation" id="errStartPrice">Please fill start price field(decimal)</div>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="status" class="label-group"><span class="req">* </span> Status: </label> 
                                    <select class="form-control" name="bid_status" id="status">
                                        <option>Please select from the list</option>
                                        <option>Active</option>
                                        <option>Not yet Bid</option>
                                        <option>Done</option>
                                    </select>
                                    <div class="errvalidation" id="errSelectStatus">Please select from the drop down</div>
                                </div>
                            
                                <div class="form-group"> 	 
                                    <label for="avatar" class="label-group"><span class="req">* </span > Image: </label>
                                    <input class="form-control" type="file" name="avatar" id="avatar"/>
                                    <div class="errvalidation" id="errChooseFile">Please upload an image file</div>  
                                </div>
                            </div>

                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="reg_items" value="Save">
                                <input class="btn btn-default" type="reset" name="cancel_items" value="Cancel">
                            </div> 
                        </fieldset>
                    </form><!-- ends item registration form -->
                </div>

            </div>
        </div>
    </body>
</html>

