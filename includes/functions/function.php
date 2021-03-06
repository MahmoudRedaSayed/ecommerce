<?php
include dirname(__FILE__).'/../../admin/connect.php';
// function to make the title of the page more dynamic  v 1.0
    function getTitle(){
        global $pagetitle ; //to be acced every where
        if(isset($pagetitle))
        {
            echo $pagetitle;
        }
        else
        {
            echo "Default";
        }
    }
///////////////////////////////////////////////''''
// the Rederict function to the home  page if the error is  v 1.0
function Redirect($Errormessage,$seconds)
{
    echo "<div class='alert alert-danger'>$Errormessage</div>";
    echo "<div class='alert alert-primary'>You Will Be Redirect To The Home Page After $seconds Seconds</div>";
    header("Refresh:$seconds;url=dashed.php");
    exit();
}
//function to check if the user is exist in the data base or not  v 1.0
function checkprepare($select,$from,$val)
{
    global $con;
    $stmt=$con->prepare("SELECT  $select  FROM  $from  WHERE $select = ?");
    $stmt->execute(array($val));
    $row=$stmt->rowcount();
    return $row;
}
//function to cal the number of the users
//function to cal the number of the not accepted yet
function calcNums ( $select, $table ,$flag=0 ){
    global $con;
    if($flag==0)
    {
        $stmt=$con->prepare("SELECT COUNT($select) FROM $table");
        $stmt->execute();
    }
    elseif($flag==1)
    {
        $stmt=$con->prepare("SELECT COUNT($select) FROM $table WHERE regstatus=0");
        $stmt->execute();
    }
    elseif($flag==2)
    {
        $stmt=$con->prepare("SELECT COUNT($select) FROM $table WHERE regstatus=0");
        $stmt->execute();
    }
    elseif($flag==3)
    {
        
        $stmt=$con->prepare("SELECT COUNT($select) FROM $table");
        $stmt->execute();
    }
    return $stmt->fetchColumn();
}
//function to check if the catagory is active or not
function isactive($select,$id,$from,$val,$flag)
{
    global $con;
    $stmt=$con->prepare("SELECT  $select  FROM  $from  WHERE $id = ?");
    $stmt->execute(array($val));
    $row=$stmt->fetch();
    if($flag=='All')
    {
        if($row["visiability"]||$row["allowcomments"]||$row["allowAds"])
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    if($flag=='com')
    {
        if($row["allowcomments"])
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    if($flag=='vis')
    {
        if($row["visiability"])
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    if($flag=='Ads')
    {
        if($row["allowAds"])
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
}
////////////////////////////////////////
// function to get the catagories
function getcat()
{
    global $con;
    $stmt=$con->prepare("SELECT * FROM catagories ORDER BY catagory_id DESC");
    $stmt->execute();
    return $stmt->fetchAll();
}
//////////////////////////
//function to get the items of the catagory
function getcatitems($catid)
{
    global $con;
    $stmt=$con->prepare("SELECT items.* ,users.*  FROM items INNER JOIN users ON users.userid=items.member_id  WHERE cat_id=? ");
    $stmt->execute([$catid]);
    return $stmt->fetchAll();
}
////////////////////////////////////////////////
// function to check if the user is active or not
function checkisactive($userid)
{
    global $con;
    $stmt=$con->prepare("SELECT * FROM users WHERE userid=$userid AND regstatus=1");
    $stmt->execute();
    return $stmt->rowcount();
}
///////////////////////////////////////////
//function to check if the user is admin
/////////////////////////////////
////////////////////////////////////////////
//function to get the data to profile page
function getDataProfile($userid)
{
    global $con;
    $stmt=$con->prepare("SELECT * FROM users WHERE userid=$userid LIMIT 1");
    $stmt->execute();
    return $stmt->fetchAll();
}
///////////////////////////////////////////////
// function to get the latest comments to the person
function getuseritems($userid)
{
    global $con;
    $stmt=$con->prepare("SELECT items.* , catagories.catagory_name FROM items   INNER JOIN catagories ON catagories.catagory_id=items.cat_id  WHERE items.member_id=$userid");
    $stmt->execute();
    return $stmt->fetchAll();
}
///////////////////////////////////////////////
//function to get the comments of the user
function getusercomments($userid)
{
    global $con;
    $stmt=$con->prepare("SELECT comments.* , items.* FROM comments   INNER JOIN items ON items.itemid=comments.item_id  WHERE comments.member_id=$userid");
    $stmt->execute();
    return $stmt->fetchAll();
}
/////////////////////////////////////////////////
//functions to get the data of the items to show it in item page
///i splite it to two function because the join will fial if the item has no comments
//function getuserofcomment to get the user who write the comment
function getitemcomments($itemid)
{
    global $con;
    $stmt=$con->prepare("SELECT items.* ,comments.comment ,comments.member_id , comments.c_id  FROM items    INNER JOIN comments ON comments.item_id=items.itemid   WHERE items.itemid=$itemid ");
    $stmt->execute();
    return $stmt->fetchAll();
}
/////////////////////////////////
//the second version of the function to deal with the comments and replies
function getuserofcomment($userid,$table)
{
    global $con;
    $stmt=$con->prepare("SELECT * FROM users    INNER JOIN $table ON $table.member_id=users.userid   WHERE $table.member_id=$userid limit 1");
    $stmt->execute();
    return $stmt->fetchAll();
}
function getitemcatagories($itemid)
{
    global $con;
    $stmt=$con->prepare("SELECT items.* , catagories.catagory_name , users.*   FROM items  INNER JOIN catagories ON catagories.catagory_id=items.cat_id INNER JOIN users ON users.userid=items.member_id  WHERE items.itemid=$itemid limit 1");
    $stmt->execute();
    return $stmt->fetchAll();
}
///////////////////////////////////////
//function to get the replyes of the comments
function getthereplies($com_id,$itemid)
{
    global $con;
    $stmt=$con->prepare("SELECT * FROM replycomments  WHERE item_id= ?AND com_id=?");
    $stmt->execute([$itemid,$com_id]);
    return $stmt->fetchAll();
}
///////////////////////////////////////
//function to get all items to home page
function getAllitems()
{
    global $con;
    $stmt=$con->prepare("SELECT items.* , users.* FROM items INNER JOIN users ON users.userid=items.member_id");
    $stmt->execute();
    return $stmt->fetchAll();
}
////////////////////////////////////////////////
//function to get the orders of the clients
function getorders($traderid)
{
    global $con;
    $stmt=$con->prepare("SELECT items.* , users.* , orders.* FROM orders INNER JOIN users ON users.userid=orders.client_id INNER JOIN items ON items.itemid=orders.item_id WHERE orders.trader_id=$traderid");
    $stmt->execute();
    return $stmt->fetchAll();
}
//////////////////////////////////////////// 

function getuserstatics($memberid,$table,$condtion){
    global $con;
    if($table=='orders')
    {
        $datenow=date("now");
        $datenow=strtotime($datenow);
        $stmt=$con->prepare("SELECT * FROM $table WHERE $condtion=$memberid  AND ArrivalDate>$datenow ");
    }
    else
    {
        $stmt=$con->prepare("SELECT * FROM $table WHERE $condtion=$memberid ");
    }
    $stmt->execute();
    return $stmt->rowcount();
}
///////////////////////////////////////////////////
function getuserorders($clientid,$type,$id){
    global $con;
    $stmt=$con->prepare("SELECT orders.* , items.* , users.*, users.username AS $type FROM orders INNER JOIN users ON users.userid=orders.$type INNER JOIN items ON items.itemid=orders.item_id WHERE orders.$id=$clientid");
    $stmt->execute();
    return $stmt->fetchAll();
}