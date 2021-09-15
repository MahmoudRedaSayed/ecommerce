<?php
$pagetitle="catagory page";
session_start();
if(isset($_SESSION["username"]))
{
    include "init.php";
    $do=(isset($_GET['do']))?$_GET['do']:'manage';
    if($do=='manage')
    {
        echo"<div class='container item manage'>";
        echo"<h2 class='h2-text text-center'>manage page</h2> <hr>";
        ?>
        <div class="row mr-auto choose">
            <a class='btn btn-success' href="items.php?choose=all">All items</a>
            <a class='btn btn-success' href="items.php?choose=unapproved">unapproved items</a>
        </div>
        <?php
        $choose=(isset($_GET['choose']))?$_GET['choose']:'all';
        if($choose=='all')
        {
            $stmt=$con->prepare("SELECT items.* , catagories.catagory_name , users.username
                                FROM items
                                INNER JOIN catagories
                                ON  catagories.catagory_id=items.cat_id
                                INNER JOIN users
                                ON  users.userid=items.member_id");
            $stmt->execute();
            $rows=$stmt->fetchAll();
            $count=$stmt->rowcount();
            if($count!=0)
            {?>
                    <h2 class='h2-text text-center'>All items</h2>
                <table class="table table-dark">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>name</th>
                                    <th>price</th>
                                    <th>Added Date</th>
                                    <th>country made</th>
                                    <th>stutes</th>
                                    <th>manage</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                            //by using the for loop iterat on the array and fill the rows
                            foreach($rows as $row)
                            {
                                echo"<tr>";
                                echo "<td>".$row['itemid']."</td>";
                                echo "<td>".$row['itemname']."</td>";
                                echo "<td>".$row['price']."</td>";
                                echo "<td>".$row['itemDate']."</td>";
                                echo "<td>".$row['country_made']."</td>";
                                echo "<td>";
                                if($row['stutes']==1)
                                {
                                    echo "new";
                                }
                                elseif($row['stutes']==2)
                                {
                                    echo"used";
                                }
                                else
                                {
                                    echo "old";
                                }
                                echo"</td>";
                                // the links the lead to the delet or edit pages
                                echo "<td class='row'><a class='edit btn btn-success col' href='items.php?do=edit&itemid=".$row['itemid']."'><i class='fas fa-user-edit'></i> Edit</a><a class='delete btn btn-danger col' id='delete' href='items.php?do=delete&itemid=".$row['itemid']."'><i class='fas fa-trash-alt'></i>Delete</a>";
                                if($row['approve']!=1)
                                {
                                    echo "<a class='edit btn btn-primary col' href='items.php?do=approve&itemid=".$row['itemid']."'><i class='fas fa-check'></i> approve</a>";
                                }
                                echo "</td>";
                                echo"</tr>";
                            }
                            echo " </tbody></table>";
            }
            else
                {
                    echo"<h2 class='h2-text text-center'>there is no items</h2>";
                }
                echo"<a class='btn btn-success' href='items.php?do=Add'><i class='fas fa-location-arrow'></i>Add item</a>";
        }
       elseif($choose=='unapproved')
       {
        $stmt=$con->prepare("SELECT items.* , catagories.catagory_name , users.username
                            FROM items
                            INNER JOIN catagories
                            ON  catagories.catagory_id=items.cat_id
                            INNER JOIN users
                            ON  users.userid=items.member_id
                            WHERE items.approve=0");
        $stmt->execute();
        $rows=$stmt->fetchAll();
        $count=$stmt->rowcount();
            if($count!=0)
            {?>
                    <h2 class='h2-text text-center'>Unapproved items</h2>
                <table class="table table-dark">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>name</th>
                                    <th>price</th>
                                    <th>Added Date</th>
                                    <th>country made</th>
                                    <th>stutes</th>
                                    <th>manage</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                            //by using the for loop iterat on the array and fill the rows
                            foreach($rows as $row)
                            {
                                echo"<tr>";
                                echo "<td>".$row['itemid']."</td>";
                                echo "<td>".$row['itemname']."</td>";
                                echo "<td>".$row['price']."</td>";
                                echo "<td>".$row['itemDate']."</td>";
                                echo "<td>".$row['country_made']."</td>";
                                echo "<td>";
                                if($row['stutes']==1)
                                {
                                    echo "new";
                                }
                                elseif($row['stutes']==2)
                                {
                                    echo"used";
                                }
                                else
                                {
                                    echo "old";
                                }
                                echo"</td>";
                                // the links the lead to the delet or edit pages
                                echo "<td class='row'><a class='edit btn btn-success col' href='items.php?do=edit&itemid=".$row['itemid']."'><i class='fas fa-user-edit'></i> Edit</a><a class='delete btn btn-danger col' id='delete' href='items.php?do=delete&itemid=".$row['itemid']."'><i class='fas fa-trash-alt'></i>Delete</a>";
                                echo "<a class='edit btn btn-primary col' href='items.php?do=approve&itemid=".$row['itemid']."'><i class='fas fa-check'></i> approve</a>";
                                echo "</td>";
                                echo"</tr>";
                            }
                            echo " </tbody></table>";
                }
                else
                {
                    echo"<h2 class='h2-text text-center'>there is no unapproved items</h2>";
                }
        }
        else
        {
            echo "<h2 class='h2-text text-center'>there is no items to show </h2>";
        }
        echo'</div>';
    }
    elseif($do=='update')
    {
        echo"<div class='container'>";
        echo"<h2 class='h2-text text-center'>update page</h2> <hr>";
        if($_SERVER['REQUEST_METHOD'] =="POST")
        {
            $Error=array();
            $name=$_POST["itemname"];
            $des=$_POST["descripation"];
            $price=$_POST["price"];
            $country=$_POST["country"];
            $stutes=$_POST["stutes"];
            $userid=$_POST["username"];
            $cataid=$_POST["cataname"];
            $id=$_GET["itemid"];
            $Error=array();
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
                    $stmt=$con->prepare("UPDATE items 
                                    SET itemname=? ,   
                                    descripation=? ,
                                    price=?,
                                    stutes=? ,
                                    country_made=?,
                                    member_id=?,
                                    cat_id=?
                                    WHERE itemid= $id");
                    $stmt->execute(array($name,$des,$price,$stutes,$country,$userid,$cataid));
                    echo "<div class='alert alert-success'>the item is updated</div>";
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
        header('refresh:3;items.php?do=manage');
        echo "</div>";
    }
    elseif($do=='delete')
    {
        echo"<div class='container'>";
        if($_SERVER['REQUEST_METHOD']=='GET')
        {
            $id=$_GET["itemid"];
            $stmt=$con->prepare("SELECT * FROM items WHERE itemid=?");
            $stmt->execute([$id]);
            $rowcount=$stmt->rowcount();
            if($rowcount>0)
            {
                $stmt=$con->prepare("DELETE FROM items WHERE itemid=?");
                $stmt->execute([$id]);
                echo "<h1 class='text-center h2-text'>The Delete Page welcome " .$_SESSION['username']."</h1>";
                echo "<div class='alert alert-success'>the item is deleted</div>";
                header("Refresh:3;items.php");
                exit();
            }
            else
            {
                echo "<div class='alert alert-primary'>the item is not found</div>";
                header("Refresh:3;items.php");
            }
        }
        else
        {
            Redirect("you can't browse this page directly without id",3);
        }
        echo "<div/>";
    }
    elseif($do=='approve')
    {
        echo"<div class='container'>";
        if($_SERVER['REQUEST_METHOD']=='GET')
        {
            $id=$_GET["itemid"];
            $nums=calcNums("itemid","items");
            if($nums>0)
            {
                $stmt=$con->prepare("UPDATE items SET approve=1 WHERE itemid=?");
                $stmt->execute([$id]);
                echo "<h1 class='text-center h2-text'>The approve Page welcome " .$_SESSION['username']."</h1>";
                echo "<div class='alert alert-success'>the item is approved</div>";
                header("Refresh:3;items.php");
                exit();
            }
            else
            {
                echo "<div class='alert alert-primary'>the item is not found</div>";
                header("Refresh:3;items.php");
            }
        }
        else
        {
            Redirect("you can't browse this page directly without id",3);
        }
        echo "<div/>";
    }
    elseif($do=='Add')
    {
        echo"<div class='container Add'>";
        if($_SERVER['REQUEST_METHOD']=='GET')
        {
            ?>
            <h2 class="text-center h2-text">Add Page</h2>
            <hr>
            <form class="container formreg" action="items.php?do=insert" method="POST">
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
                <div class="stutes  row">
                <div class=" col-md-6 col-lg-6 col-sm-12 havespan-select row">
                <label class="col-12 col-sm-12 text-center" for="stutes"></label>
                    <select class="col form-control" placeholder="stutes" name="stutes" required="required">
                        <option value="0">...</option>
                        <option value="1">new</option>
                        <option value="2">used</option>
                        <option value="3">old</option>
                    </select>
                </div>
                <div class=" col-md-6 col-lg-6 col-sm-12 havespan-select row">
                    <label class="col-12 col-sm-12 text-center" for="username"></label>
                    <select class="col form-control" placeholder="user name" name="username" required="required">
                        <option value="0">...</option>
                        <?php
                        $stmt=$con->prepare('SELECT * FROM users WHERE group_id!=1');
                        $stmt->execute();
                        $users=$stmt->fetchAll();
                        foreach($users as $user)
                        {
                            echo '<option value="'.$user['userid'].'">'.$user['username'].'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class=" col-md-6 col-lg-6 col-sm-12 havespan-select row">
                    <label class="col-12 col-sm-12 text-center" for="catagory name"></label>
                    <select class="col form-control" placeholder="catagory name" name="cataname" required="required">
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
            echo"<h2 class='h2-text text-center'>insert page</h2> <hr>";
            $itemname=$_POST['name'];
            $descripation=$_POST['descripation'];
            $price=$_POST['price'];
            $country=$_POST['country'];
            $stutes=$_POST['stutes'];
            $catid=$_POST['cataname'];
            $username=$_POST['username'];
            $name=checkprepare('itemname','items',$itemname);
            $Error=array();
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
            if(($username)==0)
            {
                $Error[]="please enter the member name ";
            }
            if(empty($Error))
            {
                $stmt=$con->prepare('INSERT INTO items (itemname,descripation,price,country_made,stutes,cat_id,member_id,itemDate) VALUES (?,?,?,?,?,?,?,Now()) ');
                $stmt->execute(array($itemname,$descripation,$price,$country,$stutes,$catid,$username));
                echo"<div class='alert alert-success'>the item is inserted</div>";
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
        header('refresh:3;items.php?do=manage');
        echo "</div>";
    }
    elseif($do=='edit')
    {
        echo"<div class='container Add'>";
        if($_SERVER['REQUEST_METHOD']=='GET'&&isset($_GET['itemid'])&&is_numeric($_GET['itemid']))
        {
            $itemid=intval($_GET['itemid']);
            $stmt=$con->prepare("SELECT * FROM items WHERE itemid=$itemid");
            $stmt->execute();
            $row=$stmt->fetch();
            $count=$stmt->rowcount();
            if($count>0){
            ?>
            <h2 class="text-center h2-text">edit Page</h2>
            <hr>
            <form class="container formreg" action="items.php?do=update&itemid=<?php echo $itemid;?>" method="POST">
                <div class="des&name  row" >
                    <div class="  col-md col-lg col-sm-12 havespan">
                        <label  class="col-12 col-sm-12 text-center" id="itemname" for="itemname"></label>
                        <input class="col-12 col-sm-12 form-control"  type="text" value="<?php echo $row['itemname'];?>" name='itemname' id="itemname" placeholder="item name" autocomplete="off">
                    </div>
                    <div class=" col-md col-lg col-sm-12 havespan">
                        <label class="col-12 col-sm-12 text-center" for="descripation"></label>
                        <input class="col-12 col-sm-12 form-control"  type="text" value="<?php echo $row['descripation'];?>"  name='descripation' id="descripation" placeholder="descripation to item">
                    </div>
                </div>
                <div class="country&price row">
                    <div class=" col-md col-lg col-sm-12 havespan">
                            <label class="col-12 col-sm-12 text-center" for="price"></label>
                            <input class="col-12 col-sm-12 form-control"   type="text" value="<?php echo $row['price'];?>"  name='price' id="price" placeholder="price of the item" >
                        </div>
                        <div class=" col-md col-lg col-sm-12 havespan">
                            <label class="col-12 col-sm-12 text-center" for="country"></label>
                            <input class="col-12 col-sm-12 form-control"   type="text" value="<?php echo $row['country_made'];?>"  name='country' id="country" placeholder="country make of the item" >
                    </div>
                </div>
                <div class="stutes  row">
                    <div class=" col-md-6 col-lg-6 col-sm-12 havespan-select row">
                        <select class="col form-control" placeholder="stutes" name="stutes" required="required" >
                            <option <?php if ( $row['stutes']==1)echo "selected ";?>value='1' >new</option>
                            <option <?php if ( $row['stutes']==2)echo "selected ";?>value='2'>used</option>
                            <option  <?php if ( $row['stutes']==3)echo "selected ";?>value='3'>old</option>
                        </select>
                    </div>
                    <div class=" col-md-6 col-lg-6 col-sm-12 havespan-select row">
                        <label class="col-12 col-sm-12 text-center" for="username"></label>
                        <select class="col form-control" placeholder="user name" name="username" required="required">
                            <?php
                            $stmt=$con->prepare('SELECT * FROM users WHERE group_id!=1');
                            $stmt->execute();
                            $users=$stmt->fetchAll();
                            foreach($users as $user)
                            {
                                echo '<option value="'.$user['userid'].'"';
                                if($user['userid']==$row['member_id']) echo 'selected';
                                echo '>'.$user['username'].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                <div class=" col-md-6 col-lg-6 col-sm-12 havespan-select row">
                    <label class="col-12 col-sm-12 text-center" for="catagory name"></label>
                    <select class="col form-control" placeholder="catagory name" name="cataname" required="required">
                        <?php
                        $stmt=$con->prepare('SELECT * FROM catagories');
                        $stmt->execute();
                        $cats=$stmt->fetchAll();
                        foreach($cats as $cat)
                        {
                            echo'<option value="'.$cat['catagory_id'].'"';
                            if($cat['catagory_id']==$row['cat_id']) echo "selected";
                            echo'>'.$cat['catagory_name'].'</option>';
                        }
                        ?>
                    </select>
                </div>
                </div>
                <div class="save form-row button">
                    <input type="submit" class="btn btn-primary col-md-2" value="edit">
                </div>
            </form>
            <?php
                }
                else
                {
                    echo "<div class='alert alert-danger'>there is no id such that</div>";
                    header('refresh:5;items.php?do=manage');
                }
        }
        else
        {
            Redirect("you can't browse this page directly",3);
        }
    }
    else
    {
        header('location:dashed.php');
    }
}
include $tmp.'/footer.php';