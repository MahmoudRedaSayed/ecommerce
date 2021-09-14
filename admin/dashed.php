<?php
// the title of the page
$pagetitle="dashed";
$limit=5;
session_start();
if(isset($_SESSION['username']))
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
            <span>200</span>
        </div>
    </div>
    <div class='container row latest'>
        <div class='col-sm-12 col-md-6 col-lg-6'>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-users"></i> latest <?php echo $limit?> inserted users
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
        <div class='col-sm-12 col-md-6 col-lg-6'>
            <div class="panel panel-default">
                <div class="panel-heading">
                <i class="far fa-newspaper"></i> latest <?php echo $limit?> items
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
    </div>
    <?php
    include $tmp."/footer.php";
}
else{
    echo 'error';
}