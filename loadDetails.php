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
    if(filter_input(INPUT_POST, 'bid_items') !== NULL ){// isset($_POST['bid_items'])//&& isset($_POST['item']) && isset($_POST['end_date']) && isset($_POST['start_price']) && isset($_POST['bid_price'])!== "" 
        $bidder = $_SESSION['email'];
        $item_id = $_REQUEST['itemId'];
        $bid_price = $_POST['bid_price'];
        //$bid_date = now();//'".$bid_date."'
        $status = 'Active';
        
        $sql = "INSERT INTO tbl_bid(i_id,bid_date,bid_price,bidder,status)"
                . "VALUES('".$item_id."',now(),'".$bid_price."','".$bidder."','".$status."')";
        $result = mysqli_query($con, $sql);
        if (!$result) {
            die('Error:can not insert into table tbl_bid ' . mysqli_error($con));
        }
        else{
            //echo "1 bid is added correctly";
            $sql_update = mysqli_query($con, "update tbl_items set status='".$status."' "
                    . "where registered_by !='".$bidder."' and item_id ='".$item_id."'");
            if (!$sql_update) {
                die('Error:can not update table tbl_items ' . mysqli_error());
            }
            $message = '<div class = "alert alert-success">Bid is added successfully</div>';
        } 
    }
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
        <script src="js/loadDetails.js"></script>
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
                    <form action="" method="post" role="form" name="itemsDetails" onSubmit="return validateForm();">
                        <fieldset>
                            <legend class="text-center">Item Details:</legend>
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <?php echo $message; ?>    
                                </div>
                            </div>
                            
<?php
    $email = $_SESSION['email'];
    $item_id = $_REQUEST['itemId'];
    $sqla = mysqli_query($con,"SELECT distinct item_name, start_price, bid_enddate FROM tbl_items where registered_by !='".$email."' and item_id='".$item_id."' ");
    if(!$sqla ){
        die('Could not get select data: ' .mysqli_error($con));
    }
    while($rowa = mysqli_fetch_array($sqla)) { 
        $item_name = $rowa['item_name'];
        $start_price = $rowa['start_price'];
        $bid_enddate = $rowa['bid_enddate'];
        echo    '<div class="col-lg-6">
                    <div class="form-group"> 	 
                        <label for="item" class="label-group control-label">Item name:</label>
                        <input class="form-control" type="text" name = "item" id="item" value="'.$item_name.'" disabled/>
                    </div>

                    <div class="form-group"> 	 
                        <label for="end_date" class="label-group control-label">Bid Ending Date:</label>
                        <input class="form-control" type="text" name = "end_date" id="end_date" value="'.$bid_enddate.'" disabled/>
                    </div>

                    <div class="form-group"> 	 
                        <label for="start_price" class="label-group control-label">Start Price:</label>
                        <input class="form-control" type="text" name = "start_price" id="start_price" value="'.$start_price.'" disabled/>
                    </div>     
                </div>';
    }
    mysqli_close($con);
?>
                            <div class="col-lg-6">
                                <div class="form-group"> 	 
                                    <label for="bid_price" class="label-group control-label"><span class="req">* </span>Bid Price:</label>
                                    <input class="form-control" type="text" name = "bid_price" id="bid_price"/>
                                    <div class="errvalidation" id="errBidPrice">Please fill bid price greater than the minimum start price</div>
                                </div>

                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" name="bid_items" value="Bid">
                                    <input class="btn btn-default" type="reset" name="cancel_items" value="Cancel">
                                </div> 
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>

