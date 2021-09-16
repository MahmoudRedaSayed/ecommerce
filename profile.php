<?php
session_start();
$pagetitle=$_SESSION["user"]." profile";
include "init.php";
$row=getDataProfile($_SESSION["userid"]);
$useritems=getuseritems($_SESSION["userid"]);
$usercomments=getusercomments($_SESSION["userid"]);
?>
<div class="container profile-page">
    <div class='images'>
        <div class='image1'>
            <img class='coverimage' src="0.png" alt="">
        </div>
        <div class="image2">
        <img class='personalimage' src="0.png" alt="">
        </div>
    </div>
    <div class='name-descripation'>
        <h2 class='h2-text'><?php echo $_SESSION['user']; ?></h2> <hr>
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
    <div class="user-items">
    <h3 class='h3'> the items of <?php echo $_SESSION['user']; ?> <i class="fa fa-newspaper"></i> </h3><hr>
    <div class="items">
        <?php
        if(!empty($useritems))
        {
            foreach($useritems as $item)
            {
                echo "<div class='item'>";
                echo"<a class='btn btn-primary' href='catagories.php?catid=".$item["cat_id"]. "&catname=".$item["catagory_name"]."'>".$item["itemname"]."</a>";
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
            <?php
        }
        ?>
        </div>
    </div>
    <div class="user-comments">
    <h3 class='h3'> the comments of <?php echo $_SESSION['user']; ?> <i class="fa fa-comments"></i> </h3><hr>
        <?php
        if(!empty($usercomments))
        {
            foreach($usercomments as $comment)
            {
                echo "<div class='comment'>";
                echo"<a>".$comment["itemname"]."</a>";
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
        }
        ?>
    </div>
</div>
<?php
include $tmp."/footer.php";