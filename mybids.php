<?php
    session_start();
    include_once 'commonFunctions.php';
    if(!(isset($_SESSION['email']) && ($_SESSION['email']!=""))){
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
        <title>BID MANAGEMENT SYSTEM/My Bids</title>
        <link rel = "stylesheet" href = "css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script src = "js/jquery-3.2.1.min.js"></script>
        <script src = "js/bootstrap.min.js"></script>
        
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
<?php
    $bidder=$_SESSION['email'];
    $sql = mysqli_query($con,"SELECT distinct tbl_items.item_name,tbl_bid.ins_date,tbl_bid.bid_price FROM tbl_items,tbl_bid where tbl_items.item_id=tbl_bid.i_id and bidder='$bidder'");
    if(!$sql ){
      die('Could not get data: ' . mysqli_error());
    }
    echo "<table border='1'>
            <caption><b>My Bid Transaction</b></caption><br>
            <tr>
                <th>Item Name</th>
                <th>Insertion Date</th>
                <th>Bid Amount</th>
            </tr>";
    while($row = mysqli_fetch_array($sql)){
            echo "<tr>";
                echo "<td>".$row['item_name']."</td>" ;
                echo "<td>".$row['ins_date']."</td>";
                echo "<td>".$row['bid_price']."</td>";
            echo "</tr>";
    } 
        echo "</table>";
    mysqli_close($con);
?>
	
    </body>
</html>

