<?php
session_start();
// $pagetitle=$_SESSION["user"]." profile";
include "init.php";
if($_SERVER['REQUEST_METHOD']=='GET'&&isset($_GET['userid']))
{
    $row=getDataProfile($_GET["userid"]);
    $useritems=getuseritems($_GET["userid"]);
    $usercomments=getusercomments($_GET["userid"]);
    ?>
    <div class="container profile-page">
        <div class='images'>
            <div class='image1'>
                <div class='change_cover'>
                <a class='changeCover' id='changecover'>change cover image</a>
                    <form name='myForm1' class='change_cover_form' action="profile.php?do=insertcover&userid=<?php echo $_GET["userid"];?>" method='POST'enctype="multipart/form-data">
                        <input type="file"name='cover' id='changeinput'>
                        <input type="submit" name="post" value="post" id="post">
                    </form>
                </div>
                <img class='coverimage' src="<?php
                if(empty($row[0]['coverimg']))
                {
                    if($row[0]['gander']==1)
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
                    echo "uploads\cover\\".$row[0]['coverimg'] ;
                }
                ?>" alt="">
            </div>
            <div class="image2">
            <div class='change_profile'>
                    <a class='changeProfile' id='changeprofile'>change profile image</a>
                    <form name='myForm2' class='change_profile_form' action="profile.php?do=insertprofile&userid=<?php echo $_GET["userid"];?>" method='POST'enctype="multipart/form-data">
                        <input type="file"name='profile' id='changeinput'>
                        <input type="submit" name="post" value="post" id="post">
                    </form>
            </div>
            <img class='personalimage' src="<?php
                if(empty($row[0]['profileimg']))
                {
                    if($row[0]['gander']==1)
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
                    echo "uploads\profiles\\".$row[0]['profileimg'] ;
                }
                ?>" alt="">
            </div>
        </div>
        <div class='name-descripation'>
            <h2 class='h2-text'><?php echo $row[0]['fullname']; ?></h2> <hr>
            <!-- <p><?php echo $row['descripation'];  ?></p> -->
        </div>
        <div class='about'>
            <h3 class='h3'>about <?php echo $_SESSION['user']; ?> <i class="fa fa-arrow-circle-down up"></i> </h3><hr>
            <div class='about-content'>
                <h4>fullname : <span><?php echo $row[0]['fullname'];?></span></h4>
                <h4>trust stutes : <span><?php echo $row[0]['truststatus'];?></span></h4>
                <h4>join date : <span><?php echo $row[0]['userdate']; ?></h4>
            </div>
        </div>
        <?php
            if($row[0]['group_id']!=0)
            {
                ?>
        <div class="user-items"id='items'>
        <h3 class='h3'> the items of <?php echo $row[0]['fullname']; ?> <i class="fa fa-newspaper"></i> </h3><hr>
            <div class="items">
            <?php
                if(!empty($useritems))
                {
                    foreach($useritems as $item)
                    {
                        echo "<div class='item'>";
                        echo"<a class='btn btn-primary' href='catagories.php?catid=".$item["cat_id"]. "&catname=".$item["catagory_name"]."'>".$item["itemname"]."</a>";
                        if($item["approve"]!=1)
                        {
                            echo"<div class='unapproved'>unapproved yet</div>";
                        }
                        echo"<a class='btn btn-success' href='item.php?itemid=".$item["itemid"]."&itemname=".$item["itemname"]."'>".$item["itemname"]." page</a>";
                        echo"</div>";
                    }
                }
                else
                {
                    ?>
                    <div class="error404">
                        <h4>there is no items yet</h4>
                        <img src="error.png" alt="">
                    </div>
            </div>
            <?php
                }
                ?>
                </div>
                    <?php
                if(isset($_SESSION['userid']))
                {
                    if($_GET['userid'] == $_SESSION['userid'])
                    {
                        ?>
                        <a href="item.php" > <i class='fa fa-location-arrow'></i> Add item</a>
                        <?php
                    }
                }
            ?>
            <div class='rating'>
                    <div>
                    <i class="far fa-star" id='star'></i>
                    <i class="far fa-star" id='star'></i>
                    <i class="far fa-star" id='star'></i>
                    </div>
            </div>
            <?php
            }?>
        <div class="user-comments" id='comments'>
        <h3 class='h3'> the comments of <?php echo $row[0]['fullname']; ?> <i class="fa fa-comments"></i> </h3><hr>
            <?php
            if(!empty($usercomments))
            {
                foreach($usercomments as $comment)
                {
                    echo "<div class='comment'>";
                    echo"<a href='item.php?itemid=".$comment["itemid"]."#comments'>".$comment["itemname"]."</a>";
                    echo"<p>".$comment["comment"]."</p>";
                    echo"</div>";
                }
            }
            else
            {
                ?>
                <div class="error404">
                    <h4>there is no comments yet</h4>
                    <img src="error.png" alt="">
                </div>
                <?php
            }?>
        </div>
    <?php
}
elseif(isset($_GET['do'])&&$_GET['do']=='insertcover'&&$_SERVER['REQUEST_METHOD']=='POST'&&isset($_GET['userid']))
{
    $row=getDataProfile($_GET["userid"]);
    $oldimg=$row[0]['coverimg'];
    $newimg=$_FILES['cover'];
    print_r($newimg);
    if(!$newimg['error']==4)
    {
        //the data of the cover
        $cover_name=$newimg['name'];
        $cover_tmpname=$newimg['tmp_name'];
        $cover_size=$newimg['size'];
        $cover_type=$newimg['type'];
        // allow extations
        $array_ex=array('png','jpg','jpeg','gif');
        $cover_ex1=explode('.', $cover_name);
        $cover_ex2=end($cover_ex1);
        $cover_ex=strtolower($cover_ex2);
        if(!in_array($cover_ex,$array_ex))
            {
                $Error[]="<div class='alert alert-danger'>the extation of the cover is not allowed </div>";
            }
            if($cover_size>(3*4194304))
            {
                $Error[]="<div class='alert alert-danger'>the profile picture can not be more than 12MB</div>";
            }
            if(empty($Error))
            {
                // to ensure that the name of the img can not be repeated will use a random function
                $cover=rand(1,10000).$cover_name;
                move_uploaded_file($cover_tmpname,"uploads\cover\\".$cover);
                $stmt=$con->prepare("UPDATE users SET coverimg=? WHERE userid=?");
                $stmt->execute([$cover,$_GET["userid"]]);
            }
    }
    header('profile.php');
    exit();
}
elseif(isset($_GET['do'])&&$_GET['do']=='insertprofile'&&$_SERVER['REQUEST_METHOD']=='POST'&&isset($_GET['userid']))
{
    echo"welcome";
    $row=getDataProfile($_GET["userid"]);
    $oldimg=$row[0]['profileimg'];
    $newimg=$_FILES['profile'];
    if(!$newimg['error']==4)
    {
        //the data of the cover
        $cover_name=$newimg['name'];
        $cover_tmpname=$newimg['tmp_name'];
        $cover_size=$newimg['size'];
        $cover_type=$newimg['type'];
        // allow extations
        $array_ex=array('png','jpg','jpeg','gif');
        $cover_ex1=explode('.', $cover_name);
        $cover_ex2=end($cover_ex1);
        $cover_ex=strtolower($cover_ex2);
        if(!in_array($cover_ex,$array_ex))
            {
                $Error[]="<div class='alert alert-danger'>the extation of the cover is not allowed </div>";
            }
            if($cover_size>(3*4194304))
            {
                $Error[]="<div class='alert alert-danger'>the profile picture can not be more than 12MB</div>";
            }
            if(empty($Error))
            {
                // to ensure that the name of the img can not be repeated will use a random function
                $cover=rand(1,10000).$cover_name;
                move_uploaded_file($cover_tmpname,"uploads\profiles\\".$cover);
                $stmt=$con->prepare("UPDATE users SET profileimg=? WHERE userid=?");
                $stmt->execute([$cover,$_GET["userid"]]);
            }
    }
    header('location:profile.php?userid='.$_SESSION['userid']); 
}
else
{
    // header('location:login.php');
    exit();
}
echo "</div>";
include $tmp."/footer.php";

