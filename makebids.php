<?php
    session_start();
    include_once 'commonFunctions.php';
    if(!(isset($_SESSION['email']) && ($_SESSION['email'] != ""))){
        header("location:index.php");
    }
    if( isset( $_SESSION['time'] ) && time() - $_SESSION['time'] > 120){
        header("location:index.php");
    }
    $_SESSION['time']=time();
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
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">Items</div>
                        <div class="panel-body">
                                
            
<?php
    //TODO scenario 1 - only display items that the loggedin user did not bid for earlier

    $email = $_SESSION['email'];
    $sqla = mysqli_query($con,"SELECT distinct item_id,item_name, start_price, image, bid_enddate FROM tbl_items where registered_by !='".$email."'");
    if(!$sqla ){
        die('Could not get select data: ' .mysqli_error($con));
    }
    while($rowa = mysqli_fetch_array($sqla)) { 
        
        $item_id = $rowa['item_id'];
        $item_name = $rowa['item_name'];
        $start_price = $rowa['start_price'];
        $bid_enddate = $rowa['bid_enddate'];
        $item_img = $rowa['image'];
        echo    '<div class="col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">'.$item_name.'</div>
                        <div class="panel-body">
                            <!--<img src='.$item_img.' width="120px" height="120px" style="cursor:pointer;" onclick="return image();">-->
                            <a href = "loadDetails.php?itemId='.$item_id.'"><img src='.$item_img.' width="120px" height="120px" style="cursor:pointer;"></a>
                        </div>
                        <div class="panel-heading">
                            <div class="form-group-lg" style="white-space: nowrap;margin:5px;">
                                <label for="price_tag" class="label label-default">Start Price:</label>
                                <input type="text" id="price_tag" value="'.$start_price.'" style="width:60px;" disabled>SEK
                            </div>
                            <div class="form-group-lg" style="white-space: nowrap">
                                <label for="end_date" class="label label-default">Bid End date:</label>
                                <input type="text" id="end_date" value="'.$bid_enddate.'" style="width:150px;" disabled>
                                <input type="hidden" id="item_id" value="'.$item_id.'">
                                <!--<input type="text" name = "price_given" id="price_given" style="width:95px;" placeholder="Your Price here">
                                <button class="btn btn-danger btn-sm"style="margin-top: 5px;" name = "bid_button">Bid</button>-->
                            </div>
                        </div>
                    </div>
                </div>';
    }
    mysqli_close($con);
?>
                            </div>
                        <div class="panel-footer">&copy; 2017</div>
                    </div>
                </div>
            </div>
        </div>	
    </body>
</html>

