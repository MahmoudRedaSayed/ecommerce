<?php
global $tmp;
$pagetitle="catagory page";
session_start();
if(isset($_SESSION["username"]))
{
    include "init.php";
    $do=(isset($_GET['do']))?$_GET['do']:'manage';
    if($do=='manage')
    {
        echo"<div class='container cata'>";
        echo"<h2 class='h2-text text-center'>manage page</h2> <hr>";
        $stmt=$con->prepare("SELECT * FROM catagories");
        $stmt->execute();
        $rows=$stmt->fetchAll();
        $count=$stmt->rowcount();
        if($count!=0)
        {
            ?>
            <div class='panel'>
                <div class="panel-heading ">
                    the catagories
                </div>
                <div class="panel-body">
                        <?php
                            foreach($rows as $row)
                            {
                                echo'<div class="catagory&title">';
                                echo '<div class="container title text-center">'. $row['catagory_name'].'</div><hr>';
                                echo'<div class="catagorytemp">';
                                echo"<div class='catagory'>";
                                echo"<div class='pros'>";
                                echo '<div> descripation: '. $row['catagory_descripation'] .'</div>';
                                echo '<div> order: '. $row['ordering'] .'</div>';
                                echo '<div>Allow comments: '. $row['allowcomments'] .'</div>';
                                echo '<div>visiability: '. $row['visiability'] .'</div>';
                                echo '<div>Allow Ads: '. $row['allowAds'] .'</div>';
                                echo "</div>";
                                ?>
                                <div class="buttons">
                                <a class='edit btn btn-success' href='catagory.php?do=edit&catagoryid=<?php echo $row['catagory_id'];?>'><i class='fas fa-edit'></i>Edit</a>
                                <?php if($row['visiability']==1||$row['allowcomments']==1||$row['allowAds']==1)
                                {
                                    echo "<a class= 'Active btn btn-primary' href='catagory.php?do=Active&catagoryid=".$row['catagory_id']."'><i class='fas fa-tags'></i>Activate</a>";
                                }
                                echo "<a class='delete btn btn-danger' href='catagory.php?do=delete&catagoryid=".$row['catagory_id']."'><i class='fas fa-trash-alt'></i>Delete</a>";
                                ?>
                                </div>
                                <?php
                                echo"</div></div></div>";
                            }
                        ?>
                </div>
            </div>
            <?php
        }
        else
        {
            echo "<h2 class='h2-text text-center'>there is no catagories to show </h2>";
        }
        echo"<a class='btn btn-success' href='catagory.php?do=Add'><i class='fas fa-location-arrow'></i>Add catagory</a>";
        echo'</div>';
    }
    elseif($do=='edit')
    {
        echo"<div class='container Add'>";
        if($_SERVER['REQUEST_METHOD']=='GET'&&isset($_GET['catagoryid'])&&is_numeric($_GET['catagoryid']))
        {
            $catagoryid=intval($_GET['catagoryid']);
            $name=checkprepare('catagory_id','catagories',$catagoryid);
            if($name>0){
                $stmt=$con->prepare("SELECT * FROM catagories WHERE catagory_id=$catagoryid");
                $stmt->execute();
                $row=$stmt->fetch();
            ?>
            <h2 class="text-center h2-text">edit Page</h2>
            <hr>
            <form class="container formreg" action="catagory.php?do=update&catagoryid=<?php echo $catagoryid;?>" method="POST">
                    <div class="catagory&name  row" >
                    <div class="  col-md col-lg col-sm-12 havespan">
                        <label  class="col-12 col-sm-12 text-center" id="catagoryname" for="catagoryname"></label>
                        <input class="col-12 col-sm-12 form-control"  type="text" value="<?php echo $row['catagory_name'];?>" name='catagoryname' id="catagoryname" placeholder="catagory name" autocomplete="off">
                    </div>
                    <div class=" col-md col-lg col-sm-12 havespan">
                        <label class="col-12 col-sm-12 text-center" for="descripation"></label>
                        <input class="col-12 col-sm-12 form-control"  type="text" value="<?php echo $row['catagory_descripation'];?>"  name='descripation' id="descripation" placeholder="descripation to catagory">
                    </div>
                </div>
                <div class="order&visibility row">
                <div class=" col-md col-lg col-sm-12 havespan">
                        <label class="col-12 col-sm-12 text-center" for="order"></label>
                        <input class="col-12 col-sm-12 form-control"   type="text" value="<?php echo $row['ordering'];?>"  name='order' id="order" placeholder="order the catagroy" >
                    </div>
                    <div class=" col-md col-lg col-sm-12 havespan">
                        <label class="col-12 col-sm-12 text-center" for="visibility">visibility</label>
                        <div class='row vis-box'>
                            <?php if($row['visiability']==0){ ?>
                            <div class="col text-center">
                                    <input type="radio" name='visibility' id='vis-yes' value='0' checked>
                                    <label for="vis-yes">yes</label>
                            </div>
                            <div class="col text-center">
                                    <input type="radio" name='visibility'id='vis-no' value='1'>
                                    <label for="vis-no">no</label>
                            </div>
                            <?php } 
                            elseif($row['visiability']==1){?>
                            <div class="col text-center">
                                    <input type="radio" name='visibility' id='vis-yes' value='0'>
                                    <label for="vis-yes">yes</label>
                            </div>
                            <div class="col text-center">
                                    <input type="radio" name='visibility'id='vis-no' value='1'  checked>
                                    <label for="vis-no">no</label>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class=" col-md col-lg col-sm-12 havespan">
                            <label class="col-12 col-sm-12 text-center" for="comments">comments</label>
                            <div class='row com-box'>
                            <?php if($row['allowcomments']==0){ ?>
                                <div class="col text-center">
                                        <input type="radio" name='comments' id='com-yes' value='0' checked>
                                        <label for="com-yes">yes</label>
                                </div>
                                <div class="col text-center">
                                        <input type="radio" name='comments'id='com-no' value='1'>
                                        <label for="com-no">no</label>
                                </div>
                                <?php } 
                            elseif($row['allowcomments']==1){?>
                            <div class="col text-center">
                                        <input type="radio" name='comments' id='com-yes' value='0' >
                                        <label for="com-yes">yes</label>
                                </div>
                                <div class="col text-center">
                                        <input type="radio" name='comments'id='com-no' value='1'checked>
                                        <label for="com-no">no</label>
                                </div>
                            <?php }?>
                            </div>
                    </div>
                    <div class=" col-md col-lg col-sm-12 havespan">
                            <label class="col-12 col-sm-12 text-center" for="ads">Ads</label>
                            <div class='row vis-box'>
                            <?php if($row['allowAds']==0){ ?>
                                <div class="col text-center">
                                        <input type="radio" name='ads' id='ads-yes' value='0' checked>
                                        <label for="ads-yes">yes</label>
                                </div>
                                <div class="col text-center">
                                        <input type="radio" name='ads'id='ads-no' value='1'>
                                        <label for="ads-no">no</label>
                                </div>
                                <?php } 
                            elseif($row['allowcomments']==1){?>
                            <div class="col text-center">
                                        <input type="radio" name='ads' id='ads-yes' value='0'>
                                        <label for="ads-yes">yes</label>
                                </div>
                                <div class="col text-center">
                                        <input type="radio" name='ads'id='ads-no' value='1'  checked>
                                        <label for="ads-no">no</label>
                                </div>
                            <?php }?>
                            </div>
                    </div>
                </div>
                <div class="save form-row button">
                    <input type="submit" class="btn btn-primary col-md-2" value="save">
                </div>
            </form>
            <?php
                }
                else
                {
                    echo "<div class='alert alert-danger'>there is no id such that</div>";
                    header('refresh:5;catagory.php?do=manage');
                }
        }
        else
        {
            Redirect("you can't browse this page directly",3);
        }
    }
    elseif($do=='update')
    {
        echo"<div class='container'>";
        if($_SERVER['REQUEST_METHOD'] =="POST")
        {
            $Error=array();
            $name=$_POST["catagoryname"];
            $des=$_POST["descripation"];
            $order=$_POST["order"];
            $vis=$_POST["visibility"];
            $com=$_POST["comments"];
            $ads=$_POST["ads"];
            $id=$_GET["catagoryid"];
            $namecount=checkprepare('catagory_name','catagories',$name);
            $ordering=checkprepare('ordering','catagories',$order);
            $catagory_descripation=checkprepare('catagory_descripation','catagories',$des);
            $Error=array();
                if(strlen($name)<5)
                {
                    $Error[]="the name must be more than <strong>5 chars</strong>";
                }
                if(!(isset($order)))
                {
                    $Error[]="the order must be inserted";
                }
                if(!(isset($vis)))
                {
                    $Error[]="the visiability must be yes or no";
                }
                if(!(isset($com)))
                {
                    $Error[]="the comments must be yes or no";
                }
                if(!(isset($ads)))
                {
                    $Error[]="the Ads must be yes or no";
                }
                if(empty($Error))
                {
                    $stmt=$con->prepare("UPDATE catagories 
                                    SET catagory_name=? ,   
                                    catagory_descripation=? ,
                                    ordering=?,
                                    visiability=? ,
                                    allowcomments=?,
                                    allowAds=? 
                                    WHERE catagory_id= $id");
                    $stmt->execute(array($name,$des,$order,$vis,$com,$ads));
                    echo "<div class='alert alert-success'>the catagory is updated</div>";
                }
                else
                {
                    foreach($Error as $error)
                    {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                }
        }
        else
        {
            Redirect("you can't browse this page directly",3);
        }
        header('refresh:5;catagory.php?do=manage');
        echo "</div>";
    }
    elseif($do=='delete')
    {
        if($_SERVER['REQUEST_METHOD']=='GET')
        {
            $id=$_GET["catagoryid"];
            $stmt=$con->prepare("SELECT * FROM catagories WHERE catagory_id=?");
            $stmt->execute([$id]);
            $rowcount=$stmt->rowcount();
            if($rowcount>0)
            {
                $stmt=$con->prepare("DELETE FROM catagories WHERE catagory_id=?");
                $stmt->execute([$id]);
                echo "<h1 class='text-center h2-text'>The Delete Page welcome " .$_SESSION['username']."</h1>";
                echo "<div class='alert alert-success'>the catagory is deleted</div>";
                header("Refresh:3;catagory.php");
                exit();
            }
            else
            {
                echo "<div class='alert alert-primary'>the catagory is not found</div>";
                header("Refresh:3;catagory.php");
            }
        }
        else
        {
            Redirect("you can't browse this page directly without id",3);
        }
        echo "<div/>";
    }
    elseif($do=='Active')
    {
        echo"<div class='container Activate'>";
        if($_SERVER['REQUEST_METHOD']=='GET')
        {
            $id=$_GET["catagoryid"];
            ?>
            <h2 class="h2-text text-center">Choose the thing that you like to activate it</h2>
            <hr>
            <div class="row">
                <a href="catagory.php?do=Activecom&catagoryid=<?php echo $id;?>" class="col-sm-12 col-lg-2 col-md-3 btn btn-success">Comments</a>
                <a href="catagory.php?do=Activevis&catagoryid= <?php echo $id;?> " class="col-sm-12 col-lg-2  col-md-3  btn btn-success">Visiability</a>
                <a href="catagory.php?do=ActiveAds&catagoryid= <?php echo $id;?>" class="col-sm-12 col-lg-2  col-md-3  btn btn-success">Ads</a>
            </div>
            <div class="row">
                <a href="catagory.php?do=ActiveAll&catagoryid=<?php echo $id;?>" class="col-sm-12 col-lg-6  col-md-9 btn btn-success">All</a>
            </div>
            <?php
        }
        else
        {
            Redirect("you can't browse this page directly",3);
        }
        echo"</div>";
    }
    elseif($do=='ActiveAll')
    {
        echo"<div class='container Activate'>";
        echo"<h2 class='h2-text text-center'>Active All page</h2> <hr>";
        if($_SERVER['REQUEST_METHOD']=='GET')
        {
            $id=$_GET["catagoryid"];
            if(isactive("*","catagory_id","catagories",$id,"All"))//it is impossible
            {
                $stmt=$con->prepare("UPDATE catagories SET visiability=0 , allowcomments=0 , allowAds=0 WHERE catagory_id=$id");
                $stmt->execute();
                echo"<div class='alert alert-success'>You have activated (visiability and comments and Ads)</div>";
            }
            else
            {
                echo"<div class='alert alert-primary'>the catagory is already active</div>";
            }
            
            header("refresh:3;catagory.php");
        }
        else
        {
            Redirect("you can't browse this page directly",3);
        }
        echo"</div>";
    }
    elseif($do=='Activecom')
    {
        echo"<div class='container Activate'>";
        echo"<h2 class='h2-text text-center'>Active comments page</h2> <hr>";
        if($_SERVER['REQUEST_METHOD']=='GET')
        {
            $id=$_GET["catagoryid"];
            if(isactive("*","catagory_id","catagories",$id,"com"))
            {
                $stmt=$con->prepare("UPDATE catagories SET allowcomments=0 WHERE catagory_id=$id");
                $stmt->execute();
                echo"<div class='alert alert-success'>You have activated the comments</div>";
            }
            else
            {
                echo"<div class='alert alert-primary'>the catagory is already active</div>";
            }
            header("refresh:3;catagory.php");
        }
        else
        {
            Redirect("you can't browse this page directly",3);
        }
        echo"</div>";
    }
    elseif($do=='ActiveAds')
    {
        echo"<div class='container Activate'>";
        echo"<h2 class='h2-text text-center'>Active Ads page</h2> <hr>";
        if($_SERVER['REQUEST_METHOD']=='GET')
        {
            $id=$_GET["catagoryid"];
            if(isactive("*","catagory_id","catagories",$id,"Ads"))
            {
                $stmt=$con->prepare("UPDATE catagories SET allowAds=0 WHERE catagory_id=$id");
                $stmt->execute();
                echo"<div class='alert alert-success'>You have activated the Ads</div>";
            }
            else
            {
                echo"<div class='alert alert-primary'>the catagory is already active</div>";
            }
            header("refresh:3;catagory.php");
        }
        else
        {
            Redirect("you can't browse this page directly",3);
        }
        echo"</div>";
    }
    elseif($do=='Activevis')
    {
        echo"<div class='container Activate'>";
        echo"<h2 class='h2-text text-center'>Active visiability page</h2> <hr>";
        if($_SERVER['REQUEST_METHOD']=='GET')
        {
            $id=$_GET["catagoryid"];
            if(isactive("*","catagory_id","catagories",$id,"vis"))
            {
                $stmt=$con->prepare("UPDATE catagories SET visiability=0 WHERE catagory_id=$id");
                $stmt->execute();
                echo"<div class='alert alert-success'>You have activated the visiability </div>";
            }
            else
            {
                echo"<div class='alert alert-primary'>the catagory is already active</div>";
            }
            header("refresh:3;catagory.php");
        }
        else
        {
            Redirect("you can't browse this page directly",3);
        }
        echo"</div>";
    }
    elseif($do=='Add')
    {
        echo"<div class='container Add'>";
        if($_SERVER['REQUEST_METHOD']=='GET')
        {
            ?>
            <h2 class="text-center h2-text">Add Page</h2>
            <hr>
            <form class="container formreg" action="catagory.php?do=insert" method="POST">
                    <div class="catagory&name  row" >
                    <div class="  col-md col-lg col-sm-12 havespan">
                        <label  class="col-12 col-sm-12 text-center" id="catagoryname" for="catagoryname"></label>
                        <input class="col-12 col-sm-12 form-control"  type="text" name='catagoryname' id="catagoryname" placeholder="catagory name" autocomplete="off" required="required">
                    </div>
                    <div class=" col-md col-lg col-sm-12 havespan">
                        <label class="col-12 col-sm-12 text-center" for="descripation"></label>
                        <input class="col-12 col-sm-12 form-control"  type="text" name='descripation' id="descripation" placeholder="descripation to catagory">
                    </div>
                </div>
                <div class="order&visibility row">
                <div class=" col-md col-lg col-sm-12 havespan">
                        <label class="col-12 col-sm-12 text-center" for="order"></label>
                        <input class="col-12 col-sm-12 form-control"   type="text" name='order' id="order" placeholder="order the catagroy" >
                    </div>
                    <div class=" col-md col-lg col-sm-12 havespan">
                        <label class="col-12 col-sm-12 text-center" for="visibility">visibility</label>
                        <div class='row vis-box'>
                            <div class="col text-center">
                                    <input type="radio" name='visibility' id='vis-yes' value='0' checked>
                                    <label for="vis-yes">yes</label>
                            </div>
                            <div class="col text-center">
                                    <input type="radio" name='visibility'id='vis-no' value='1'>
                                    <label for="vis-no">no</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class=" col-md col-lg col-sm-12 havespan">
                            <label class="col-12 col-sm-12 text-center" for="comments">comments</label>
                            <div class='row com-box'>
                                <div class="col text-center">
                                        <input type="radio" name='comments' id='com-yes' value='0' checked>
                                        <label for="vis-yes">yes</label>
                                </div>
                                <div class="col text-center">
                                        <input type="radio" name='comments'id='com-no' value='1'>
                                        <label for="vis-no">no</label>
                                </div>
                            </div>
                    </div>
                    <div class=" col-md col-lg col-sm-12 havespan">
                            <label class="col-12 col-sm-12 text-center" for="ads">Ads</label>
                            <div class='row vis-box'>
                                <div class="col text-center">
                                        <input type="radio" name='ads' id='ads-yes' value='0' checked>
                                        <label for="ads-yes">yes</label>
                                </div>
                                <div class="col text-center">
                                        <input type="radio" name='ads'id='ads-no' value='1'>
                                        <label for="ads-no">no</label>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="save form-row button">
                    <input type="submit" class="btn btn-primary col-md-2" value="save">
                </div>
            </form>
            <?php
        }
        else
        {
            Redirect("you can't browse this page directly",3);
        }
    }
    elseif($do=='insert')
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            echo"<div class='container'>";
            echo"<h2 class='h2-text text-center'>insert page</h2>";
            $catagoryname=$_POST['catagoryname'];
            $descripation=$_POST['descripation'];
            $order=$_POST['order'];
            $visibility=$_POST['visibility'];
            $comments=$_POST['comments'];
            $ads=$_POST['ads'];
            $name=checkprepare('catagory_name','catagories',$catagoryname);
            $ordering=checkprepare('ordering','catagories',$order);
            $catagory_descripation=checkprepare('catagory_descripation','catagories',$descripation);
            $Error=array();
            if($name!=0)
            {
                $Error[]="please enter another name becouse this catagory is exists";
            }
            elseif(strlen($catagoryname)<5)
            {
                $Error[]="please enter another name more than <strong>5 chars</strong> ";
            }
            if($ordering!=0)
            {
                $Error[]="please enter another order ";
            }
            if($catagory_descripation!=0)
            {
                $Error[]="please enter another descripation ";
            }
            if(empty($Error))
            {
                $stmt=$con->prepare('INSERT INTO catagories (catagory_name,catagory_descripation,ordering,visiability,allowcomments,allowAds) VALUES (?,?,?,?,?,?) ');
                $stmt->execute(array($catagoryname,$descripation,$order,$visibility,$comments,$ads));
                echo"<div class='alert alert-success'>the catagory is inserted</div>";
            }
            else
            {
                foreach($Error as $error)
                {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            }
        }
        else
        {
            Redirect("you can't browse this page directly",3);
        }
        header('refresh:2;catagory.php?do=manage');
        echo "</div>";
    }
    else
    {
        header('location:dashed.php');
    }
}
include $tmp.'/footer.php';