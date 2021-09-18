<?php
session_start();
include "init.php";
if(isset($_SESSION['user']))
{
    if($_SERVER['REQUEST_METHOD']=="POST"&&isset($_GET['itemid'])&&isset($_GET['comid']))
    {
        echo $_GET['itemid'];
        echo $_GET['comid'];
        $reply=FILTER_VAR($_POST['reply'],FILTER_SANITIZE_STRING);
        $stmt=$con->prepare("INSERT INTO replycomments (member_id,item_id,com_id,reply,commentDate) VALUES (?,?,?,?,NOw())");
        $stmt->execute([$_SESSION['userid'], $_GET['itemid'], $_GET['comid'],$reply]);
        header("location:".$_SERVER['HTTP_REFERER']);
        exit();
    }
    else
    {
        echo "error";
    }
}
else
{
    echo "error";
}
include $tmp."/footer.php";