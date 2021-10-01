<?php
$pagetitle="item page";
session_start();
include "init.php";
if(isset($_SESSION['user'])&&$_SERVER['REQUEST_METHOD']=='POST'&&!isset($_GET['do']))
{
    /////////////////////////////////////////////
    //coming to insert the item
    echo"<div class='container'>";
            echo"<h2 class='h2-text text-center'>insert item page welcome ".$_SESSION['user']."</h2> <hr>";
            $itemname           =FILTER_VAR($_POST['name'],FILTER_SANITIZE_STRING);
            $descripation       =FILTER_VAR($_POST['descripation'],FILTER_SANITIZE_STRING);
            $price              =FILTER_VAR($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
            $country            =FILTER_VAR($_POST['country'],FILTER_SANITIZE_STRING);
            $stutes             =$_POST['stutes'];
            $catid              =$_POST['cataname'];
            $itemimg            =$_FILES['itemimg'];
            //the data of the img
            $itemimg_name=$_FILES['itemimg']['name'];
            $itemimg_tmpname=$_FILES['itemimg']['tmp_name'];
            $itemimg_size=$_FILES['itemimg']['size'];
            $itemimg_type=$_FILES['itemimg']['type'];
            ///////////////////////////////////////////
            // allow extations
            $array_ex=array('png','jpg','jpeg','gif');
            // get the extantion
            $itemimg_ex1=explode('.', $itemimg_name);
            $itemimg_ex2=end($itemimg_ex1);
            $itemimg_ex=strtolower($itemimg_ex2);
            $name               =checkprepare('itemname','items',$itemname);
            $Error              =array();
            if($name!=0)
            {
                $Error[]="please enter another name becouse this item is exists";
            }
            if(strlen($itemname)<5)
            {
                $Error[]="please enter another name more than <strong>5 chars</strong> ";
            }
            if($price=='0'||!(is_numeric($price)))
            {
                $Error[]="please enter another price not 0  ";
            }
            if(strlen($descripation)<5)
            {
                $Error[]="please enter another descripation  more than 5 chars ";
            }
            if(($stutes)==0)
            {
                $Error[]="please enter the stutes ";
            }
            if(($catid)==0)
            {
                $Error[]="please enter the catagory name ";
            }
            if(!empty( $itemimg )&&!in_array($itemimg_ex,$array_ex))
            {
                $Error[]="<div class='alert alert-danger'>the extation of the item image is not allowed </div>";
            }
            if($itemimg_size>(3*4194304))
            {
                $Error[]="<div class='alert alert-danger'>the item picture can not be more than 12MB</div>";
            }
            if(empty($Error))
            {
                $item=rand(1,10000).$itemimg_name;
                move_uploaded_file($itemimg_tmpname,"uploads\items\\".$item);
                $stmt=$con->prepare('INSERT INTO items (itemname,descripation,price,country_made,stutes,cat_id,member_id,itemimage,itemDate) VALUES (?,?,?,?,?,?,?,?,Now()) ');
                $stmt->execute(array($itemname,$descripation,$price,$country,$stutes,$catid,$_SESSION['userid'],$item));
                echo"<div class='alert alert-success'>the item is inserted and under Approvement</div>";
                header("refresh:5;profile.php?userid=".$_SESSION['userid']."");
                exit();
            }
            else
            {
                foreach($Error as $error)
                {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
                header("refresh:3;".$_SERVER['HTTP_REFERER']);
                    exit();
            }
}
elseif(isset($_SESSION['user'])&&$_SERVER['REQUEST_METHOD']=='GET'&&isset($_GET['catid']))
{
    /////////////////////////////
    //coming to insert item from catagory
    echo"<div class='container Additem'>";
            ?>
            <h2 class="text-center h2-text">Add Page</h2>
            <hr>
            <form class="container formreg" action="item.php" method="POST" enctype="multipart/form-data">
                <input type="hidden"value=<?php echo $_GET['catid']; ?> name='cataname'>
                <div class="descripation&name  row" >
                    <div class="  col col col-sm-12 havespan">
                        <label  class="col-12 col-sm-12 text-center" id="name" for="name"></label>
                        <input class="col-12 col-sm-12 form-control"  type="text" name='name' id="name" placeholder="name of the item" autocomplete="off" required="required">
                    </div>
                    <div class=" col col col-sm-12 havespan">
                        <label class="col-12 col-sm-12 text-center" for="descripation"></label>
                        <input class="col-12 col-sm-12 form-control"  type="text" name='descripation' id="descripation" placeholder="descripation of the item" autocomplete="off" required="required">
                    </div>
                </div>
                <div class="price&country havespan row">
                    <div class=" col col col-sm-12 havespan">
                        <label class="col-12 col-sm-12 text-center" for="price"></label>
                        <input class="col-12 col-sm-12 form-control"   type="text" name='price' id="price" placeholder="price" autocomplete="off" required='required'>
                    </div>
                    <div class=" col col col-sm-12 havespan">
                        <label class="col-12 col-sm-12 text-center" for="country"></label>
                        <input class="col-12 col-sm-12 form-control"  type="text" name='country' id="country" placeholder="country of made" autocomplete="off" required="required">
                    </div>
                </div>
                <div class="row stutes">
                    <div class="  col col col-sm-12 havespan">
                    <label class="col-12 col-sm-12 text-center" for="stutes"></label>
                        <select class="col form-control" placeholder="stutes" id="stutes" name="stutes" required="required">
                            <option value="0">...</option>
                            <option value="1">new</option>
                            <option value="2">used</option>
                            <option value="3">old</option>
                        </select>
                    </div>
                </div>
                <div class='pictures havespan row'>
                    <div class=" col col col-sm-12 havespan">
                            <input class="col-12 col-sm-12 form-control"   type="file" name='itemimg' id="itemimg" placeholder="item image">
                    </div>
                </div>
                <div class=" form-row button">
                    <button type='submit' class='additem'>Add product</button>
                </div>
            </form>
            <?php
}
elseif($_SERVER['REQUEST_METHOD']=='GET'&&isset($_GET['itemid']))
{
    echo"<div class='container itempage'>";
    $itemid=$_GET['itemid'];
    $comments_row=getitemcomments($itemid);
    $catas_member_row=getitemcatagories($itemid);
    $accept=0;
    if(!empty($comments_row)||!empty($catas_member_row))
    {  if(isset($catas_member_row[0]['approve']))
        {
            if($catas_member_row[0]['approve']==1)
            {
                $accept=1;
            }
        }
        elseif(isset($comments_row[0]['approve']))
        {
            if($catas_member_row[0]['approve']==1)
            {
                $accept=1;
            }
        }
        if($accept==1)
        {
            if(!empty($catas_member_row))
            {
                    ?>
                        <div class='show_item_data'>
                            <h2 class=h2-text><?php echo $catas_member_row[0]['itemname'];?></h2>
                            <hr>
                            <div class="item-data">
                            <div class='the-data'>
                                <?php 
                                if(isset($_SESSION['userid']))
                                {
                                    if($catas_member_row[0]['userid']!=$_SESSION['userid'])
                                    {
                                        ?>
                                        <div><i class='fa fa-user'></i> published by : <a href='profile.php?userid=<?php echo $catas_member_row[0]['userid'];?>'><span>
                                        <img class='profileimg' src="<?php
                                        if(empty($catas_member_row[0]['profileimg']))
                                        {
                                            if($catas_member_row[0]['gander']==1)
                                            {
                                                echo 'uploads\default\user-icon.png';
                                            }
                                            else
                                            {
                                                echo'uploads\default\user-icon-female.jpg';
                                            }
                                        }
                                        else
                                        {
                                            echo "uploads\cover\\".$catas_member_row[0]['profileimg'] ;
                                        }
                                    ?>
                                    " alt="">
                                    <?php echo $catas_member_row[0]['fullname']?></span></a></div>
                                        <?php
                                    }
                                }
                                ?>
                                <div><i class="fas fa-tags"></i>catagories : <span><?php echo$catas_member_row[0]['catagory_name']?></span> </div>
                                <div> <i class="fas fa-audio-description"></i>item descripation : <span><?php echo$catas_member_row[0]['descripation'] ?></span></div>
                                <div> <i class="fas fa-globe-asia"></i>country made : <span><?php echo$catas_member_row[0]['country_made'] ?></span></div>
                                <div> <i class="fas fa-hand-holding-usd"></i> item price : <span>$<?php echo$catas_member_row[0]['price'] ?></span></div>
                                <div><i class="fas fa-calendar-week"></i>item date : <span><?php echo$catas_member_row[0]['itemDate'] ?></span></div>
                                <div><i class="fas fa-clock"></i> days ago : <span><?php
                                $interval=date_diff(new DateTime(date('y-m-d')),new DateTime($catas_member_row[0]['itemDate']));
                                echo $interval->d; 
                                ?> days</span></div>
                            </div>
                            <div class='itemimg'>
                                    <?php if(empty($catas_member_row[0]['itemimage']))
                                    {
                                        $path="default\\item.png";
                                    }
                                    else
                                    {
                                        $path="items\\".$catas_member_row[0]['itemimage'];
                                    } 
                                    ?>
                                    <img src="uploads\<?php echo $path;?>"alt="">
                            </div>
                            </div>
                        </div>
                    <?php
            }
                if(isset($_SESSION['userid']))
                {
                    if($catas_member_row[0]['userid']==$_SESSION['userid'])
                    {
                        ?>
                        <div class='buttons-item'>
                            <a class='btn btn-success' href="item.php?do=edit&itemid=<?php echo $catas_member_row[0]['itemid'];?>"><i class='fa fa-edit'></i> edit item</a>
                            <a class='btn btn-danger' href="item.php?do=delete&itemid=<?php echo $catas_member_row[0]['itemid'];?>"><i class='fas fa-trash-alt'></i> Delete item</a>
                        </div>
                        <?php
                    }
                    else
                    {
                        ?>
                        <div class='addorder'>
                            <form action="order.php?itemid=<?php echo $catas_member_row[0]['itemid'];?>&do=addorder" method='POST'>
                            <div>  
                                <input type="number" name='num' placeholder="1">
                            </div>
                                <button type='submit' ><i class="fas fa-cart-arrow-down"></i> Add Order</button>
                            </form>
                        </div>
                        <?php
                    }
                }
                if(!empty($comments_row))
                {
                    ?>
                    <div class="item-comments" id='comments'>
                    <h3 class='h3'> the comments on the item <i class="fa fa-comments"></i> </h3><hr>
                <?php
                    foreach($comments_row as $comment)
                    {
                        $row=getuserofcomment($comment['member_id'],"comments");
                        echo "<div class='comment'>";
                        echo "<a class='user' href='profile.php?userid=".$row[0]['userid']."'>".$row[0]['fullname']."</a>";
                        echo "<div class='commentdate'><i class='fas fa-calendar-week'></i>".$row[0]['commentDate']."</div>";
                        echo"<p>".$comment["comment"]."</p>";
                        if(isset($_SESSION['user'])&&$_SESSION['regstatus']==1)
                        {
                            echo "<div class='reply'><a class='btn btn-primary ' id='replybtn'>reply</a></div>";
                        }
                        echo "<a  id='repliesbtn'>show replies</a>";
                        echo"</div>";
                        ?>
                        <div class=' dontshow' id='replies'>
                            
                            <?php
                            $replies=getthereplies($comment['c_id'],$itemid);
                            $users=getDataProfile($comment['member_id']);
                            if(!empty($replies))
                            {
                                foreach($replies as $reply)
                                {
                                    $row=getuserofcomment($reply['member_id'],"replycomments");
                                    echo "<div class='replytocomment'>";
                                    echo "<a class='user' href='profile.php?userid=".$row[0]['userid']."'>".$row[0]['fullname']."</a>";
                                    echo "<div class='commentdate'><i class='fas fa-calendar-week'></i>".$row[0]['commentDate']."</div>";
                                    echo"<p><a class='mention' href='profile.php?userid=".$users[0]['userid']."'>".$users[0]['fullname']."</a>".$reply["reply"]."</p>";
                                    echo" </div>";
                                }
                            }
                            else
                            {
                                echo"<div class='replytocomment'>there is no replyies yet</div>";
                            }
                            
                            ?>
                        </div>
                        <div class='replycomment' id='replycomment'>
                        <form action="replycomments.php?itemid=<?Php echo $itemid;?>&comid=<?Php echo $comment['c_id'];?>" method='POST'>
                            <textarea name="reply" id="comment"  class='form-control'></textarea>
                            <input type="submit" class='btn btn-primary' value='post'>
                        </form>
                </div>
                        <?php
                    }
                    if($_SESSION['regstatus']==1)
                    {
                ?>
                <div class='addcomment-button'>
                        <form action="comment.php?itemid=<?Php echo $itemid ;?>" method='POST'>
                            <textarea name="comment" id="comment"  class='form-control'></textarea>
                            <input type="submit" class='btn' value='post'>
                        </form>
                </div>
            </div>
                    </div>
                    <?php
                    }
            }
            else
            {
                ?>
                <div class="nocomment-item">
                    <h4 class="nocomment-item">there is no comments yet</h4>
                    <img src="error.png" alt="">
                    <?php
                    if(isset($_SESSION['user']))
                        {
                            ?>
                </div>
                            <div class='addcomment-button'>
                                <form action="comment.php?itemid=<?Php echo $itemid ;?>" method='POST'>
                                    <textarea name="comment" id="comment"  class='form-control'></textarea>
                                    <input type="submit" class='btn' value='post'>
                                </form>
                            </div>
                        <?php
                        }
                        ?>
                    <?php
            }
        }
        else
        {
            echo "<div class='h2-text'>under approvement</div>";
        }
    }
    else
    {
        echo "<div class='alert alert-danger'>there is no item with this id</div>";
    }
        echo"</div>";
}
//the start of item edit

//the start of the update page
elseif(isset($_SESSION['user'])&&isset($_GET['do']))
{
    if($_GET['do']=='update')
    {
        echo"<div class='container'>";
        echo"<h2 class='h2-text text-center'>update page</h2> <hr>";
        if($_SERVER['REQUEST_METHOD'] =="POST")
        {
            $Error=array();
            $name       =FILTER_VAR($_POST["itemname"],FILTER_SANITIZE_STRING);
            $des        =FILTER_VAR($_POST["descripation"],FILTER_SANITIZE_STRING);
            $price      =FILTER_VAR($_POST["price"],FILTER_SANITIZE_NUMBER_INT);
            $country    =FILTER_VAR($_POST["country"],FILTER_SANITIZE_STRING);
            $stutes     =$_POST["stutes"];
            $cataid     =$_POST["cataname"];
            $id         =$_POST["itemid"];
            $olditem    =$_POST['theoldimg'];
            if(!($_FILES['itemimg']['error']==4))
            {
                $itemimg            =$_FILES['itemimg'];
                $itemimg_name=$_FILES['itemimg']['name'];
                $itemimg_tmpname=$_FILES['itemimg']['tmp_name'];
                $itemimg_size=$_FILES['itemimg']['size'];
                $itemimg_type=$_FILES['itemimg']['type'];
                ///////////////////////////////////////////
                // allow extations
                $array_ex=array('png','jpg','jpeg','gif');
                // get the extantion
                $itemimg_ex1=explode('.', $itemimg_name);
                $itemimg_ex2=end($itemimg_ex1);
                $itemimg_ex=strtolower($itemimg_ex2);
                if(!empty( $itemimg )&&!in_array($itemimg_ex,$array_ex))
                {
                    $Error[]="<div class='alert alert-danger'>the extation of the item image is not allowed </div>";
                }
                if($itemimg_size>(3*4194304))
                {
                    $Error[]="<div class='alert alert-danger'>the item picture can not be more than 12MB</div>";
                }
            }
            //the data of the img
            if(strlen($name)<5)
            {
                $Error[]="please enter another name more than <strong>5 chars</strong> ";
            }
            if($price=='0'||!(is_numeric($price)))
            {
                $Error[]="please enter another price not 0  ";
            }
            if(strlen($des)==0)
            {
                $Error[]="please enter another descripation ";
            }
            if(empty($Error))
            {
                if(!($_FILES['itemimg']['error']==4))
                {
                    $item=rand(1,10000).$itemimg_name;
                    move_uploaded_file($itemimg_tmpname,"uploads\items\\".$item);
                    $stmt=$con->prepare("UPDATE items 
                                    SET itemname=? ,   
                                    descripation=? ,
                                    price=?,
                                    stutes=? ,
                                    country_made=?,
                                    cat_id=?,
                                    itemimage=?
                                    WHERE itemid= $id");
                    $stmt->execute(array($name,$des,$price,$stutes,$country,$cataid,$item));
                    unlink($olditem);
                }
                else
                {
                    $stmt=$con->prepare("UPDATE items 
                                    SET itemname=? ,   
                                    descripation=? ,
                                    price=?,
                                    stutes=? ,
                                    country_made=?,
                                    cat_id=?,
                                    itemimage=?
                                    WHERE itemid= $id");
                    $stmt->execute(array($name,$des,$price,$stutes,$country,$cataid,$olditem));
                }
                echo "<div class='alert alert-success'>the item is updated</div>";
                    header("refresh:5;profile.php?userid=".$_SESSION['userid']."");
                    exit();
            }
            else
            {
                foreach($Error as $error)
                {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
                header('refresh:3;'. $_SERVER['HTTP_REFERER']);
                exit();
            }
        }
        else
        {
            Redirect("you can't browse this page directly",3);
        }
        header('refresh:1000;profile.php?userid='.$_SESSION['userid'].'');
        echo "</div>";
    }
    elseif($_SERVER['REQUEST_METHOD']=='GET'&&$_GET['do']=='edit'&&isset($_GET['itemid']))
    {
        echo"<div class='container Edititem'>";
        $itemid=$_GET['itemid'];
        $catas_member_row=getitemcatagories($itemid);
        //if the user open it in new tab
        if(!empty($catas_member_row))
        {
            ?>
            <h2 class="text-center h2-text">update Page</h2>
            <hr>
            <form class="container formreg" action="item.php?do=update" method="POST" enctype="multipart/form-data">
            <input type="hidden" name='theoldimg' value="<?php echo $catas_member_row[0]['itemimage']; ?>">
            <input type="hidden" name='itemid' value='<?php echo $itemid; ?>'>
                <div class="descripation&name  row" >
                    <div class="  col col col-sm-12 havespan">
                        <label  class="col-12 col-sm-12 text-center" id="itemname" for="itemname"></label>
                        <input class="col-12 col-sm-12 form-control"  type="text" value="<?php echo $catas_member_row[0]['itemname']; ?>" name='itemname' id="itemname" placeholder="name of the item" autocomplete="off" >
                    </div>
                    <div class="  col col col-sm-12 havespan">
                        <label class="col-12 col-sm-12 text-center" for="descripation"></label>
                        <input class="col-12 col-sm-12 form-control"  type="text" name='descripation' value="<?php echo $catas_member_row[0]['descripation']; ?>" id="descripation" placeholder="descripation of the item" autocomplete="off" >
                    </div>
                </div>
                <div class="price&country havespan row">
                    <div class="  col col col-sm-12 havespan">
                        <label class="col-12 col-sm-12 text-center" for="price"></label>
                        <input class="col-12 col-sm-12 form-control"   type="text" name='price' value="<?php echo $catas_member_row[0]['price']; ?>" id="price" placeholder="price" autocomplete="off" >
                    </div>
                    <div class="  col col col-sm-12 havespan">
                        <label class="col-12 col-sm-12 text-center" for="country"></label>
                        <input class="col-12 col-sm-12 form-control"  type="text" name='country' value="<?php echo $catas_member_row[0]['country_made']; ?>" id="country" placeholder="country of made" autocomplete="off" >
                    </div>
                </div>
                <div class="row stutes">
                <div class="  col col col-sm-12 havespan-select row">
                <label class="col-12 col-sm-12 text-center" for="stutes"></label>
                        <select class="col form-control" placeholder="stutes" name="stutes" >
                            <option <?php if ( $catas_member_row[0]['stutes']==1)echo "selected ";?>value='1' >new</option>
                            <option <?php if ( $catas_member_row[0]['stutes']==2)echo "selected ";?>value='2'>used</option>
                            <option  <?php if ( $catas_member_row[0]['stutes']==3)echo "selected ";?>value='3'>old</option>
                        </select>
                    </div>
                    <div class="  col col col-sm-12 havespan-select row">
                    <label class="col-12 col-sm-12 text-center" for="catagory name"></label>
                    <select class="col form-control" placeholder="catagory name" name="cataname" >
                        <?php
                        $stmt=$con->prepare('SELECT * FROM catagories');
                        $stmt->execute();
                        $cats=$stmt->fetchAll();
                        foreach($cats as $cat)
                        {
                            echo'<option value="'.$cat['catagory_id'].'"';
                            if($cat['catagory_id']==$catas_member_row[0]['cat_id']) echo "selected";
                            echo'>'.$cat['catagory_name'].'</option>';
                        }
                        ?>
                    </select>
                </div>
                </div>
                <div class='pictures havespan row'>
                    <div class="  col col col-sm-12 havespan">
                            <input class="col-12 col-sm-12 form-control"   type="file" name='itemimg'  id="itemimg" placeholder="item image">
                    </div>
                </div>
                <div class="save form-row button">
                    <button class='additem'>Edit product</button>
                </div>
            </form>
            <?php
        }
        else
        {
            echo"<div class='alert alert-danger'>there is no item with this id</div>";
        }
        echo"</div>";
    } 
    elseif($_SERVER['REQUEST_METHOD']=='GET'&&$_GET['do']=='delete'&&isset($_GET['itemid']))
    {
        echo"<div class='container'>";
            $id=$_GET["itemid"];
            $stmt=$con->prepare("SELECT * FROM items WHERE itemid=?");
            $stmt->execute([$id]);
            $rowcount=$stmt->rowcount();
            if($rowcount>0)
            {
                $stmt=$con->prepare("DELETE FROM items WHERE itemid=?");
                $stmt->execute([$id]);
                echo "<h1 class='text-center h2-text'>The Delete Page welcome " .$_SESSION['user']."</h1>";
                echo "<div class='alert alert-success'>the item is deleted</div>";
                header("Refresh:3;profile.php?userid=".$_SESSION['userid']."");
                exit();
            }
            else
            {
                echo "<div class='alert alert-primary'>the item is not found</div>";
                header("Refresh:3;profile.php?userid=".$_SESSION['userid']."");
                exit();
            }
        echo "<div/>";
    }
//the end of item edit
}
//the end of the update page
elseif(isset($_SESSION['user']))
{
    /////////////////////////////////////////////
    //coming from profile page
    echo"<div class='container Additem'>";
            ?>
            <h2 class="text-center h2-text">Add Page</h2>
            <hr>
            <form class="container formreg" action="item.php" method="POST" enctype="multipart/form-data">
                <div class="descripation&name  row" >
                    <div class="  col col col-sm-12 havespan">
                        <label  class="col-12 col-sm-12 text-center" id="name" for="name"></label>
                        <input class="col-12 col-sm-12 form-control"  type="text" name='name' id="name" placeholder="name of the item" autocomplete="off" required="required">
                    </div>
                    <div class=" col col col-sm-12 havespan">
                        <label class="col-12 col-sm-12 text-center" for="descripation"></label>
                        <input class="col-12 col-sm-12 form-control"  type="text" name='descripation' id="descripation" placeholder="descripation of the item" autocomplete="off" required="required">
                    </div>
                </div>
                <div class="price&country havespan row">
                    <div class=" col col col-sm-12 havespan">
                        <label class="col-12 col-sm-12 text-center" for="price"></label>
                        <input class="col-12 col-sm-12 form-control"   type="text" name='price' id="price" placeholder="price" autocomplete="off" required='required'>
                    </div>
                    <div class=" col col col-sm-12 havespan">
                        <label class="col-12 col-sm-12 text-center" for="country"></label>
                        <input class="col-12 col-sm-12 form-control"  type="text" name='country' id="country" placeholder="country of made" autocomplete="off" required="required">
                    </div>
                </div>
                <div class="row stutes">
                    <div class="  col col col-sm-12 havespan">
                    <label class="col-12 col-sm-12 text-center" for="stutes"></label>
                        <select class="col form-control" placeholder="stutes" id="stutes" name="stutes" required="required">
                            <option value="0">...</option>
                            <option value="1">new</option>
                            <option value="2">used</option>
                            <option value="3">old</option>
                        </select>
                    </div>
                    <div class="  col col col-sm-12 havespan">
                        <label class="col-12 col-sm-12 text-center" for="catagory name"></label>
                        <select class="col form-control" placeholder="catagory name" id="catagory name" name="cataname" required="required">
                            <option value="0">...</option>
                            <?php
                            $stmt=$con->prepare('SELECT * FROM catagories');
                            $stmt->execute();
                            $cats=$stmt->fetchAll();
                            foreach($cats as $cat)
                            {
                                echo'<option value="'.$cat['catagory_id'].'">'.$cat['catagory_name'].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class='pictures havespan row'>
                    <div class=" col col col-sm-12 havespan">
                            <label class="col-12 col-sm-12 text-center" for="itemimg"></label>
                            <input class="col-12 col-sm-12 form-control"   type="file" name='itemimg' id="itemimg" placeholder="item image">
                    </div>
                </div>
                <div class="save form-row button">
                    <button class='additem'>Add product</button>
                </div>
            </form>
            <?php
}
else
{
    echo "you can not browsw this page directly";
    header("refresh:2;index.php");
    exit();
}
echo"</div>";
include $tmp.'/footer.php';