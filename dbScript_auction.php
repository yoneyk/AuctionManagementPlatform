<?php
    $con = mysqli_connect("localhost","root","");
    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    // Create database
    $sql = "CREATE DATABASE auction_management_db";
    if (mysqli_query($con,$sql)) {
        echo "Database auction_management created successfully";
    } else {
        echo "Error creating database: " . mysqli_error($con);
    }
    mysqli_close($con);
    
    $con1 = mysqli_connect("localhost","root","","auction_management_db");
    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    // Create table
    $sql1 = "CREATE TABLE tbl_user(email VARCHAR(20) NOT NULL,PRIMARY KEY(email), password VARCHAR(20), firstname VARCHAR(20), lastname VARCHAR(20), "
            . "phone_no VARCHAR(20), city VARCHAR(20))";
    if (mysqli_query($con1,$sql1)) {
        echo "Table tbl_user created successfully";
    } else {
        echo "Error creating table: " . mysqli_error($con1);
    }

    $sql2 = "CREATE TABLE tbl_items(item_id INT NOT NULL AUTO_INCREMENT,PRIMARY KEY(item_id),registered_by VARCHAR(20)NOT NULL, FOREIGN KEY(registered_by)REFERENCES tbl_user(email),"
            . "item_name VARCHAR(20),registered_date DATETIME,start_price FLOAT, bid_enddate DATETIME, status VARCHAR(15), image VARCHAR(20))";
    if (mysqli_query($con1,$sql2)) {
        echo "Table tbl_items created successfully";
    } else {
        echo "Error creating table: " . mysqli_error($con1);
    }

    $sql3 = "CREATE TABLE tbl_bid(bid_id INT NOT NULL AUTO_INCREMENT,PRIMARY KEY(bid_id),i_id INT NOT NULL,FOREIGN KEY(i_id)REFERENCES tbl_items(item_id),"
            . "bid_date DATETIME, bid_price FLOAT, bidder VARCHAR(20), FOREIGN KEY(bidder)REFERENCES tbl_user(email), status VARCHAR(15))";
    if (mysqli_query($con1,$sql3)) {
        echo "Table tbl_bid created successfully";
    } else {
        echo "Error creating table: " . mysqli_error($con1);
    }
    
    /*$sql4 = "CREATE TABLE tbl_bidHistory(bidHistory_id INT NOT NULL AUTO_INCREMENT,PRIMARY KEY(bidHistory_id),i_id INT NOT NULL,FOREIGN KEY(i_id)REFERENCES tbl_items(item_id),"
            . "bid_date DATETIME, bid_price FLOAT, bidder CHAR(20, FOREIGN KEY(bidder)REFERENCES tbl_user(email), status VARCHAR(15))";
    //bidID foreign key assign it
    if (mysqli_query($con1,$sql4)) {
        echo "Table tbl_bidHistory created successfully";
    } else {
        echo "Error creating table: " . mysqli_error($con1);
    }*/
    
    $mysqli_close = mysqli_close($con1);



