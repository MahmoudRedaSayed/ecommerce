<?php
session_start();
include "init.php";
if(isset($_SESSION['user']))
{
    if($_SERVER['REQUEST_METHOD']=='POST'&&isset($_GET['itemid']))
    {
        $comment    = FILTER_VAR($_POST['comment'],FILTER_SANITIZE_STRING);
        $itemid     =$_GET['itemid'];
        $stmt=$con->prepare("INSERT INTO comments (comment,item_id,member_id,commentDate) VALUES (?,?,?,now())");
        $stmt->execute([$comment,$itemid,$_SESSION['userid']]);
        header('location:'.$_SERVER['HTTP_REFERER']);
    }
    else
    {
        echo "error";
    }
}
else
{
    echo"you should login and than make a comment";
    header('refresh:5;login.php');
}

include $tmp."/footer.php";