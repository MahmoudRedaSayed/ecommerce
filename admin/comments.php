<?php
/*
    this is the members page lead to Delet or Edit or Add
    and the insert page is just a temp page 
*/
$pagetitle="Comments page";
global $tmp;
// the start of the session
session_start();
iF(isset($_SESSION["username"])||$_SESSION["usergroupid"]==1)
{
    include "init.php";
    /*check if there is an get request or not to decide which 
    behaviour (Add,Delete,Edit) will be executed according to the variable ($do)
    and the defualt value of $do is 'manage'
    */
    $do=(isset($_GET['do'])? $_GET['do']:"manage");
    // the start of the manage page
    if($do=='manage')
    {?>
    <div class="container row mr-auto choose">
        <a class='btn btn-success ' href="comments.php?choose=Allcomments">ALL comments</a>
        <a class='btn btn-success ' href="comments.php?choose=Unactivecomments">Unactive comments</a>
    </div>
    <div class="container manage">
            <?php
            $choose=(isset($_GET['choose']))?$_GET['choose']:'Allcomments';
                if($choose=='Allcomments'){
                     // preparing the data of the users expacting the admin by using the group_id
                     $stmt=$con->prepare("SELECT comments.* , items.itemname , users.username
                                                FROM comments
                                                INNER JOIN items
                                                ON items.itemid=comments.item_id
                                                INNER JOIN users 
                                                ON users.userid=comments.member_id");
                        $stmt->execute();
                     // fetch all data like array
                        $data=$stmt->fetchAll();
                        // to check if there is no users
                        $num=$stmt->rowcount();
                        if($num!=0)
                        {
                            ?>
                            <h2 class="text-center h2-text">The Data Of The All comments</h2>
                            <hr>    
                            <!-- the table to show the data of the users -->
                            <table class="table table-dark">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>username</th>
                                    <th>comment</th>
                                    <th>item</th>
                                    <th>Date</th>
                                    <th>manage</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                            //by using the for loop iterat on the array and fill the rows
                            foreach($data as $comment)
                            {
                                echo"<tr>";
                                echo "<td>".$comment['c_id']."</td>";
                                echo "<td>".$comment['username']."</td>";
                                echo "<td>".$comment['comment']."</td>";
                                echo "<td>".$comment['itemname']."</td>";
                                echo "<td>".$comment['commentDate']."</td>";
                                // the links the lead to the delet or edit pages
                                echo "<td class='row'><a class='edit btn btn-success col' href='comments.php?do=edit&comid=".$comment['c_id']."'><i class='fas fa-user-edit'></i> Edit</a><a class='delete btn btn-danger col' id='delete' href='comments.php?do=delete&comid=".$comment['c_id']."'><i class='fas fa-trash-alt'></i>Delete</a>";
                                if($comment['Approve']!=1)
                                {
                                    echo "<a class='edit btn btn-primary col' href='comments.php?do=Active&comid=".$comment['c_id']."'><i class='fas fa-user-lock'></i> Active</a>";
                                }
                                echo "</td>";
                                echo"</tr>";
                            }
                            echo " </tbody></table>";
                        }
                        else
                        {
                            echo'<h2 class="text-center h2-text">There is no comments</h2>';
                        }
                         // the link which leads to the add page 
                }
                elseif($choose=='Unactivecomments')
                {
                    // preparing the data of the users expacting the admin by using the group_id
                    $stmt=$con->prepare("SELECT  comments.* , items.itemname , users.username
                                                    FROM comments
                                                    INNER JOIN items
                                                    ON items.itemid=comments.item_id
                                                    INNER JOIN users 
                                                    ON users.userid=comments.member_id
                                                    WHERE comments.Approve!=1");
                    $stmt->execute();
                    // fetch all data like array
                    $data=$stmt->fetchAll();
                    $num=$stmt->rowcount();
                        if($num!=0)
                        {
                            ?>
                            <h2 class="text-center h2-text">The Data Of The Unactive comments</h2>
                            <hr>    
                            <!-- the table to show the data of the comments -->
                            <table class="table table-dark">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>username</th>
                                    <th>comment</th>
                                    <th>item</th>
                                    <th>Date</th>
                                    <th>manage</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                    //by using the for loop iterat on the array and fill the rows
                            foreach($data as $comment)
                            {
                                echo"<tr>";
                                echo "<td>".$comment['c_id']."</td>";
                                echo "<td>".$comment['username']."</td>";
                                echo "<td>".$comment['comment']."</td>";
                                echo "<td>".$comment['itemname']."</td>";
                                echo "<td>".$comment['commentDate']."</td>";
                            // the links the lead to the delet or edit pages
                                echo "<td class='row'><a class='edit btn btn-success col' href='comments.php?do=edit&comid=".$comment['c_id']."'><i class='fas fa-user-edit'></i> Edit</a><a class='delete btn btn-danger col' id='delete' href='comments.php?do=delete&comid=".$comment['c_id']."'><i class='fas fa-trash-alt'></i>Delete</a>";
                                echo "<a class='edit btn btn-primary col' href='comments.php?do=Active&comid=".$comment['c_id']."'><i class='fas fa-user-lock'></i> Active</a>";
                                echo "</td>";
                                echo"</tr>";
                            }
                            echo " </tbody></table>";
                        }
                        else
                        {
                            echo '<h2 class="text-center h2-text">There is no unactive comments</h2>';
                        }
                    }
            ?>
    </div>
    <?php
    }
    // the end of the manage page
    // the start of the edit page
    elseif($do=='edit')
    {    
        echo"<div class='container edit'>";
        $comid=(isset($_GET['comid'])&&is_numeric($_GET['comid']))?intval($_GET['comid']):0;
        $stmt=$con->prepare("SELECT * from comments WHERE c_id=? LIMIT 1 ");
        $stmt->execute(array($comid));
        $row=$stmt->fetch();
        $count=$stmt->rowcount();
        if($count>0)
        {?>
        <h2 class="text-center h2-text">Edite Page welcome <?php echo $_SESSION['username'];?></h2>
        <hr>
        <form class="container formreg" action="comments.php?do=update" method="POST">
            <input type="hidden" name="comid" value="<?php echo $comid; ?>" />
            <div class="user&name  row" >
                <div class="  col-md col-lg col-sm-12 havespan">
                    <label  class="col-12 col-sm-12 text-center" id="comment" for="comment"></label>
                    <textarea class="col-12 col-sm-12 form-control"  type="text" name='comment' id="comment" placeholder="comment" autocomplete="off" ><?php echo $row['comment'];?></textarea>
                </div>
                <div class="  col-md col-lg col-sm-12 havespan">
                    <label  class="col-12 col-sm-12 text-center" id="Approve" for="Approve"></label>
                    <input class="col-12 col-sm-12 form-control" value="<?php echo $row['Approve'];?>" type="text" name='Approve' id="Approve" placeholder="Approve" autocomplete="off" >
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
            Redirect("You can't browse this page without id",3);
        }
        echo "<div/>";
    }
    // the end of the edit page
    // the start of the updata page
    elseif ($do=='update')
    {
        echo"<div class='container'>";
        if($_SERVER['REQUEST_METHOD'] =="POST")
        {   
            $comment        =$_POST["comment"];
            $approve        =$_POST["Approve"];
            $comid          =$_POST["comid"];
            // the header of the page
            echo'<h2 class="text-center h2-text">UPDATE Page welcome '.$_SESSION['username'].'</h2>';
            // the array of the errors
            $Error=array();
            //check if the user want to change the pass or not
                    $stmt=$con->prepare("UPDATE comments SET comment=?,Approve=?  WHERE c_id=?");
                    $stmt->execute([$comment,$approve,$comid]);
                    $row=$stmt->rowcount();
                    echo "<div class='alert alert-success'>$row updated</div>";
                    header('Refresh:5;comments.php');
                    exit();
        }
        else
        {
            Redirect("you can't browse this page directly",3);
        }
        echo "</div>";
    }
    // the end of the updata page
    //the start of the delete page
    elseif ($do=='delete')
    {
        echo"<div class='container'>";
        if($_SERVER["REQUEST_METHOD"]=='GET')
        {
            if(isset($_GET['comid']))
            {
                $id=$_GET['comid'];
                $stmt=$con->prepare("SELECT * FROM comments WHERE c_id=?");
                $stmt->execute([$id]);
                $rowcount=$stmt->rowcount();
                if($rowcount>0)
                {
                    $stmt=$con->prepare("DELETE FROM comments WHERE c_id=?");
                    $stmt->execute([$id]);
                    echo "<h1 class='text-center h2-text'>The Delete Page welcome " .$_SESSION['username']."</h1>";
                    echo "<div class='alert alert-success'>the comment is deleted</div>";
                    header("Refresh:3;comments.php");
                    exit();
                }
            }
        }
        else
        {
            Redirect("you can't browse this page directly without id",3);
        }
        echo "<div/>";
    }
    //the end of the delete page
    // the start of active page
    elseif($do=='Active')
    {
        echo"<div class='container'>";
        if(isset($_GET['comid']))
        {
            $id=$_GET['comid'];
            $stmt=$con->prepare(" SELECT * FROM comments WHERE c_id=?");
            $stmt->execute([$id]);
            $rowcount=$stmt->rowcount();
            if($rowcount>0)
            {
                $stmt=$con->prepare("UPDATE comments SET Approve = 1 WHERE c_id = ?;");
                $stmt->execute([$id]);
                echo "<h1 class='text-center h2-text'>The Active Page welcome " .$_SESSION['username']."</h1>";
                echo "<div class='alert alert-success'>the comment is Active Now</div>";
                header("Refresh:3;comments.php");
                exit();
            }
        }
        else
        {
            Redirect("you can't browse this page directly without id",3);
        }
        echo "<div/>";
    }
    else
    {
        header('location:index.php');
        exit();
    }
}
include $tmp."/footer.php";
    ?>