<?php
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
//function to get latest
function getLatest( $select, $table , $limit=5,$order ){
    global $con;
    $stmt=$con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit ");
    $stmt->execute();
    return $stmt->fetchAll();
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