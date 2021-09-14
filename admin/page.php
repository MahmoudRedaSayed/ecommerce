<?php
/*
    to manage the catagories
*/
$do=(isset($_GET['do'])? $_GET['do']:"manage");
if($do=="manage")
{
    echo"welcome to manage page";
}
elseif($do=="add")
{
    echo"welcome to add page";
}
elseif($do=="insert")
{
    echo"welcome to insert page";
}
else
{
    echo"welcome to manage page"; //the default value if the index is not correct
}
