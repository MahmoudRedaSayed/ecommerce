<?php
// the title of the page
$pagetitle="dashed";
$limit=5;
session_start();
if($_SESSION['usergroupid']==1||$_SESSION['usergroupid']==2)
{
    include 'init.php';
    ?>
    <div class='row container  states'>
        <h2 class="text-center h2-text">dashed board</h2>
        <hr>
        <div class="col-sm-11 col-md-5 col-lg-2 state">
            total members<br> 
            <span><a href="members.php"><?php echo calcNums('userid','users')?></a></span>
        </div>
        <div class="col-sm-11 col-md-5 col-lg-2 state">
            panding members<br>
            <a href="members.php?choose=Unactivemembers"> <span><?php echo calcNums('userid','users',1);?></span></a>
        </div>
        <div class="col-sm-11 col-md-5 col-lg-2 state">
            total items<br>
            <span><a href="items.php"><?php echo calcNums('itemid','items',3)?></a></span>
        </div>
        <div class="col-sm-11 col-md-5 col-lg-2 state">
            total comments<br>
            <a href="comments.php"> <span><?php echo calcNums('c_id','comments');?></span></a>
        </div>
    </div>
    <div class='container row latest'>
        <div class='col-sm-12 col-md-12 col-lg-12'>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-users"></i> latest <?php echo $limit?> inserted users
                    <i class="fas fa-arrow-circle-down up"></i>
                </div>
                <div class="panel-body">
                    <ul>
                    <?php $row=getLatest('*','users',$limit,"userid");
                    foreach($row as $user)
                    {
                        echo "<li> ".$user['username'].
                        "<a href='members.php?do=edit&userid=".$user['userid']."'> 
                        <span class='btn btn-success pull-right'>Edit <i class='fa fa-edit'></i></span></a>
                        <a href='members.php?do=delete&userid=".$user['userid']."'> 
                        <span class='btn btn-danger pull-right delete'>Delete <i class='fa fa-delete'></i></span></a>
                        </li>";
                    }
                    ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class='col-sm-12 col-md-12 col-lg-12'>
            <div class="panel panel-default">
                <div class="panel-heading">
                <i class="far fa-newspaper"></i> latest <?php echo $limit?> items
                <i class="fas fa-arrow-circle-down up"></i>
                </div>
                <div class="panel-body">
                    <ul>
                <?php $row=getLatest('*','items',$limit,"itemid");
                    foreach($row as $item)
                    {
                        echo "<li> ".$item['itemname'].
                        "<a href='items.php?do=edit&itemid=".$item['itemid']."'> 
                        <span class='btn btn-success pull-right'>Edit <i class='fa fa-edit'></i></span></a>
                        <a href='items.php?do=delete&itemid=".$item['itemid']."'> 
                        <span class='btn btn-danger pull-right delete'>Delete <i class='fa fa-delete'></i></span></a>
                        </li>";
                    }
                    ?>
                    </ul>
                </div>
            </div>
        </div>
    <div class='col-sm-12 col-md-12 col-lg-12 comments'>
            <div class="panel panel-default">
                <div class="panel-heading">
                <i class="far fa-newspaper"></i> latest <?php echo $limit?> comments
                <i class="fas fa-arrow-circle-down up"></i>
                </div>
                <div class="panel-body">
                <?php
                    $stmt=$con->prepare("SELECT  comments.*,users.username
                                        FROM comments
                                        INNER JOIN users
                                        ON users.userid=comments.member_id
                                        ORDER by comments.c_id DESC
                                        LIMIT $limit ");
                    $stmt->execute();
                    // fetch all data like array
                    $row=$stmt->fetchAll();
                    $num=$stmt->rowcount();
                    if($num!=0)
                    {
                        foreach($row as $comment)
                        {
                            echo"<div class='com-data'>";
                            echo"<div>".$comment['username']."</div>";
                            echo "<div class='comment'> ".$comment['comment'];
                            echo" </div>";
                            echo"<div class='com-con'>
                            <a href='comments.php?do=edit&comid=".$comment['c_id']."'> 
                            <span class='btn btn-success pull-right'>Edit <i class='fa fa-edit'></i></span></a>
                            <a href='comments.php?do=delete&itemid=".$comment['c_id']."'> 
                            <span class='btn btn-danger pull-right delete'>Delete <i class='fa fa-delete'></i></span></a>
                            </div>";
                            echo"</div> <hr>";
                        }
                    }
                    else
                    {
                        echo"<div class='alert alert-info'>there is no comments to show</div>";
                    }?>
                </div>
            </div>
        </div>
        </div>
    <?php
    include $tmp."/footer.php";
}
else{
    echo 'error';
}