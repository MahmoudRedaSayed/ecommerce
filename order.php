<?php
session_start();
include "init.php";
global $tmp;
if(isset($_SESSION['user'])&&$_SERVER['REQUEST_METHOD']=='POST'&&isset($_GET['itemid'])&&$_GET['do']=="addorder")
{
    $itemid=$_GET['itemid'];
    $number=$_POST['num'];
    //check if the item is exist or not
    $stmt=$con->prepare("SELECT * FROM items WHERE itemid=$itemid");
    $stmt->execute();
    $row=$stmt->fetchAll();
    $num=$stmt->rowcount();
    if($num!=0)
    {
        //function to get the location
        $query = @unserialize (file_get_contents('http://ip-api.com/php/'));
        if ($query && $query['status'] == 'success')
        {
        $location= $query['country'].'/' . $query['city'];
        echo $location;
        }
        ///////////////////////////
        $stmt=$con->prepare("INSERT INTO orders (client_id,trader_id,item_id,orderDate,userlocation,num) VALUES (?,?,?,NOW(),?,?) ");
        $stmt->execute([$_SESSION['userid'],$row[0]['member_id'],$itemid,$location,$number]);
        header('location:'.$_SERVER["HTTP_REFERER"]);
    }
    else
    {
        echo"there no item";
        header('location:'.$_SERVER["HTTP_REFERER"]);
    }
}
else
{
    echo "error";
    header('location:'.$_SERVER["HTTP_REFERER"]);
}
include $tmp."/footer.php";