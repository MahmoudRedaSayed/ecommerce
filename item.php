<?php
$pagetitle="item page";
session_start();
include "init.php";
if(isset($_SESSION['user'])&&$_SERVER['REQUEST_METHOD']=='POST')
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
                echo"<div class='alert alert-success'>the item is inserted</div>";
                header("refresh:5;profile.php");
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
    echo"<div class='container Additem'>";
            ?>
            <h2 class="text-center h2-text">Add Page</h2>
            <hr>
            <form class="container formreg" action="item.php" method="POST" enctype="multipart/form-data">
                <input type="hidden"value=<?php echo $_GET['catid']; ?> name='cataname'>
                <div class="descripation&name  row" >
                    <div class="  col-md col-lg col-sm-12 havespan">
                        <label  class="col-12 col-sm-12 text-center" id="name" for="name"></label>
                        <input class="col-12 col-sm-12 form-control"  type="text" name='name' id="name" placeholder="name of the item" autocomplete="off" required="required">
                    </div>
                    <div class=" col-md col-lg col-sm-12 havespan">
                        <label class="col-12 col-sm-12 text-center" for="descripation"></label>
                        <input class="col-12 col-sm-12 form-control"  type="text" name='descripation' id="descripation" placeholder="descripation of the item" autocomplete="off" required="required">
                    </div>
                </div>
                <div class="price&country havespan row">
                    <div class=" col-md col-lg col-sm-12 havespan">
                        <label class="col-12 col-sm-12 text-center" for="price"></label>
                        <input class="col-12 col-sm-12 form-control"   type="text" name='price' id="price" placeholder="price" autocomplete="off" required='required'>
                    </div>
                    <div class=" col-md col-lg col-sm-12 havespan">
                        <label class="col-12 col-sm-12 text-center" for="country"></label>
                        <input class="col-12 col-sm-12 form-control"  type="text" name='country' id="country" placeholder="country of made" autocomplete="off" required="required">
                    </div>
                </div>
                <div class="row stutes">
                    <div class="  col-md-6 col-lg-6 col-sm-12 havespan">
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
                    <div class=" col-md col-lg col-sm-12 havespan">
                            <input class="col-12 col-sm-12 form-control"   type="file" name='itemimg' id="itemimg" placeholder="item image">
                    </div>
                </div>
                <div class="save form-row button">
                    <input type="submit" class="btn btn-primary col-md-2" value="save">
                </div>
            </form>
            <?php
}
elseif(isset($_SESSION['user'])&&$_SERVER['REQUEST_METHOD']=='GET'&&isset($_GET['itemid'])&&isset($_GET['itemname']))
{
    echo"<div class='container'>";
    $itemid=$_GET['itemid'];
    $comments_row=getitemcomments($itemid);
    $catas_member_row=getitemcatagories($itemid);
    if(!empty($comments_row)||!empty($catas_member_row))
    {  
        if(!empty($catas_member_row))
        {
            ?>
                <div class='show_item_data'>
                    <h2 class=h2-text><?php echo $catas_member_row[0]['itemname'];?></h2>
                    <hr>
                    <div class="item-data">
                    <div class='the-data'>
                        <div><i class='fa fa-user'></i> published by : <span><?php echo $catas_member_row[0]['membername']?></span></div>
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
        if(!empty($comments_row))
        {
            ?>
            <div class="user-comments">
            <h3 class='h3'> the comments on the item <i class="fa fa-comments"></i> </h3><hr>
        <?php
        if(!empty($comments_row))
        {
            foreach($comments_row as $comment)
            {
                echo "<div class='comment'>";
                echo"<p>".$comment["comment"]."</p>";
                echo"</div>";
            }
        }
        ?>
    </div>
            </div>
            <?php
        }
        else
        {
            ?>
            <div class="nocomment-item">
                <h4 class="nocomment-item">there is no comments yet</h4>
                <img src="error.png" alt="">
            </div>
            <?php
        }
    }
    else
    {
        echo "<div class='alert alert-danger'>there is no item with this id</div>";
    }
    echo"</div>";
}
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
                    <div class="  col-md col-lg col-sm-12 havespan">
                        <label  class="col-12 col-sm-12 text-center" id="name" for="name"></label>
                        <input class="col-12 col-sm-12 form-control"  type="text" name='name' id="name" placeholder="name of the item" autocomplete="off" required="required">
                    </div>
                    <div class=" col-md col-lg col-sm-12 havespan">
                        <label class="col-12 col-sm-12 text-center" for="descripation"></label>
                        <input class="col-12 col-sm-12 form-control"  type="text" name='descripation' id="descripation" placeholder="descripation of the item" autocomplete="off" required="required">
                    </div>
                </div>
                <div class="price&country havespan row">
                    <div class=" col-md col-lg col-sm-12 havespan">
                        <label class="col-12 col-sm-12 text-center" for="price"></label>
                        <input class="col-12 col-sm-12 form-control"   type="text" name='price' id="price" placeholder="price" autocomplete="off" required='required'>
                    </div>
                    <div class=" col-md col-lg col-sm-12 havespan">
                        <label class="col-12 col-sm-12 text-center" for="country"></label>
                        <input class="col-12 col-sm-12 form-control"  type="text" name='country' id="country" placeholder="country of made" autocomplete="off" required="required">
                    </div>
                </div>
                <div class="row stutes">
                    <div class="  col-md col-lg col-sm-12 havespan">
                    <label class="col-12 col-sm-12 text-center" for="stutes"></label>
                        <select class="col form-control" placeholder="stutes" id="stutes" name="stutes" required="required">
                            <option value="0">...</option>
                            <option value="1">new</option>
                            <option value="2">used</option>
                            <option value="3">old</option>
                        </select>
                    </div>
                    <div class="  col-md col-lg col-sm-12 havespan">
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
                    <div class=" col-md col-lg col-sm-12 havespan">
                            <label class="col-12 col-sm-12 text-center" for="itemimg"></label>
                            <input class="col-12 col-sm-12 form-control"   type="file" name='itemimg' id="itemimg" placeholder="item image">
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
    echo "you can not browsw this page directly";
    header("refresh:2;index.php");
    exit();
}
include $tmp.'/footer.php';