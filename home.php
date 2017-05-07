<?php
    session_start();
    $message = '';
    include_once 'commonFUnctions.php';
    if(!(isset($_SESSION['email']) && ($_SESSION['email']!=""))){
        header("location:index.php");
    }
    if( isset( $_SESSION['time'] ) && time() - $_SESSION['time'] > 120){
        header("Location:index.php");
    }
    $_SESSION['time']=time();
?>
<html>
    <head>
        <meta charset = "UTF-8">
        <title>Bid Management System</title>
        <link rel = "stylesheet" href = "css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script src = "js/jquery-3.2.1.min.js"></script>
        <script src = "js/bootstrap.min.js"></script>
        <!--<script src = "js/main.js"></script>-->
    </head>
    <body  class="page">            
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

        <div class="info">
            <?php 
                $message = 'Welcome to Bid platform:'. ' '.$_SESSION['email'];
                    //echo "<b>you have successfully logged in: </b>"." " .$_SESSION['email'];
                echo $message;
            ?>
        </div>
        <br><br>
        <div class="container">
            <?php
                $bidder = $_SESSION['email'];
                $sql = mysqli_query($con,"SELECT distinct tbl_items.item_name,tbl_items.bid_enddate, tbl_items.start_price, tbl_bid.status, tbl_bid.bid_date,tbl_bid.bid_price FROM tbl_items,tbl_bid where tbl_items.item_id=tbl_bid.i_id and bidder='$bidder'");
                if(!$sql ){
                    die('Could not get data: ' . mysqli_error());
                }
                echo "<table class='table table-bordered table-striped table-responsive'>
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Bid Date</th>
                            <th>Bid End Date</th>
                            <th>Bid Start Price</th>
                            <th>Bid Price</th>
                            <th>Status</th>
                        </tr>
                    </thead><tbody>";
                    while($row = mysqli_fetch_array($sql)){
                        echo "<tr>";
                            echo "<td>".$row['item_name']."</td>" ;
                            echo "<td>".$row['bid_date']."</td>";
                            echo "<td>".$row['bid_enddate']."</td>";
                            echo "<td>".$row['start_price']."</td>";
                            echo "<td>".$row['bid_price']."</td>";
                            echo "<td>".$row['status']."</td>";//if image is needed add
                        echo "</tr>";
                    } 
                echo "</tbody></table>";
                mysqli_close($con);
            ?>
        </div>	
    </body>
</html>

