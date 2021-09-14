<?php
/*
    this is the members page lead to Delet or Edit or Add
    and the insert page is just a temp page 
*/
$pagetitle="Members page";
global $tmp;
// the start of the session
session_start();
iF(isset($_SESSION["username"]))
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
        <a class='btn btn-success ' href="members.php?choose=Allmembers">ALL Members</a>
        <a class='btn btn-success ' href="members.php?choose=Unactivemembers">Unactive Members</a>
    </div>
    <div class="container manage">
            <?php
            $choose=(isset($_GET['choose']))?$_GET['choose']:'Allmembers';
                if($choose=='Allmembers'){
                     // preparing the data of the users expacting the admin by using the group_id
                     $stmt=$con->prepare("SELECT * from users WHERE group_id!=1");
                        $stmt->execute();
                     // fetch all data like array
                        $data=$stmt->fetchAll();
                        // to check if there is no users
                        $num=$stmt->rowcount();
                        if($num!=0)
                        {
                            ?>
                            <h2 class="text-center h2-text">The Data Of The All Members</h2>
                            <hr>    
                            <!-- the table to show the data of the users -->
                            <table class="table table-dark">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>username</th>
                                    <!-- <th>userpassword</th> -->
                                    <th>email</th>
                                    <th>fullname</th>
                                    <!-- <th>group_id</th>
                                    <th>trust_stutes</th>
                                    <th>regstutes</th> -->
                                    <th>Date</th>
                                    <th>manage</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                            //by using the for loop iterat on the array and fill the rows
                            foreach($data as $user)
                            {
                                echo"<tr>";
                                echo "<td>".$user['userid']."</td>";
                                echo "<td>".$user['username']."</td>";
                                // echo "<td>".$user['userpassword']."</td>";
                                echo "<td>".$user['email']."</td>";
                                echo "<td>".$user['fullname']."</td>";
                                // echo "<td>".$user['group_id']."</td>";
                                // echo "<td>".$user['truststatus']."</td>";
                                // echo "<td>".$user['regstatus']."</td>";
                                echo "<td>".$user['userdate']."</td>";
                                // the links the lead to the delet or edit pages
                                echo "<td class='row'><a class='edit btn btn-success col' href='members.php?do=edit&userid=".$user['userid']."'><i class='fas fa-user-edit'></i> Edit</a><a class='delete btn btn-danger col' id='delete' href='members.php?do=delete&userid=".$user['userid']."'><i class='fas fa-trash-alt'></i>Delete</a>";
                                if($user['regstatus']!=1)
                                {
                                    echo "<a class='edit btn btn-primary col' href='members.php?do=Active&userid=".$user['userid']."'><i class='fas fa-user-lock'></i> Active</a>";
                                }
                                echo "</td>";
                                echo"</tr>";
                            }
                            echo " </tbody></table>";
                        }
                        else
                        {
                            echo'<h2 class="text-center h2-text">There is no members</h2>';
                        }
                         // the link which leads to the add page 
                        echo "<a href='members.php?do=Add' class='btn btn-success'>Add member <i class='fas fa-user-plus'></i></a>";
                }
                elseif($choose=='Unactivemembers')
                {
                    // preparing the data of the users expacting the admin by using the group_id
                    $stmt=$con->prepare("SELECT * from users WHERE group_id!=1 AND regstatus!=1");
                    $stmt->execute();
                    // fetch all data like array
                    $data=$stmt->fetchAll();
                    $num=$stmt->rowcount();
                        if($num!=0)
                        {
                            ?>
                            <h2 class="text-center h2-text">The Data Of The Unactive Members</h2>
                            <hr>    
                            <!-- the table to show the data of the users -->
                            <table class="table table-dark">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>username</th>
                                    <!-- <th>userpassword</th> -->
                                    <th>email</th>
                                    <th>fullname</th>
                                    <!-- <th>group_id</th>
                                    <th>trust_stutes</th>
                                    <th>regstutes</th> -->
                                    <th>Date</th>
                                    <th>manage</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                    //by using the for loop iterat on the array and fill the rows
                            foreach($data as $user)
                            {
                                echo"<tr>";
                                echo "<td>".$user['userid']."</td>";
                                echo "<td>".$user['username']."</td>";
                            // echo "<td>".$user['userpassword']."</td>";
                                echo "<td>".$user['email']."</td>";
                                echo "<td>".$user['fullname']."</td>";
                            // echo "<td>".$user['group_id']."</td>";
                            // echo "<td>".$user['truststatus']."</td>";
                            // echo "<td>".$user['regstatus']."</td>";
                                echo "<td>".$user['userdate']."</td>";
                            // the links the lead to the delet or edit pages
                                echo "<td class='row'><a class='edit btn btn-success col' href='members.php?do=edit&userid=".$user['userid']."'><i class='fas fa-user-edit'></i> Edit</a><a class='delete btn btn-danger col' id='delete' href='members.php?do=delete&userid=".$user['userid']."'><i class='fas fa-trash-alt'></i>Delete</a>";
                                echo "<a class='edit btn btn-primary col' href='members.php?do=Active&userid=".$user['userid']."'><i class='fas fa-user-lock'></i> Active</a>";
                                echo "</td>";
                                echo"</tr>";
                            }
                            echo " </tbody></table>";
                        }
                        else
                        {
                            echo '<h2 class="text-center h2-text">There is no unactive members</h2>';
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
        $userid=(isset($_GET['userid'])&&is_numeric($_GET['userid']))?intval($_GET['userid']):0;
        $stmt=$con->prepare("SELECT * from users WHERE userid=? LIMIT 1 ");
        $stmt->execute(array($userid));
        $row=$stmt->fetch();
        $count=$stmt->rowcount();
        if($count>0)
        {?>
        <h2 class="text-center h2-text">Edite Page welcome <?php echo $_SESSION['username'];?></h2>
        <hr>
        <form class="container formreg" action="members.php?do=update" method="POST">
            <input type="hidden" name="userid" value="<?php echo $userid; ?>" />
            <div class="user&name  row" >
                <div class="  col-md col-lg col-sm-12 havespan">
                    <label  class="col-12 col-sm-12 text-center" id="usernamelabel" for="username"></label>
                    <input class="col-12 col-sm-12 form-control" value="<?php echo $row['username'];?>" type="text" name='username' id="usernamefield" placeholder="username" autocomplete="off" required="required">
                </div>
                <div class=" col-md col-lg col-sm-12 havespan">
                    <label class="col-12 col-sm-12 text-center" for="fullname"></label>
                    <input class="col-12 col-sm-12 form-control" value="<?php echo $row['fullname'];?>"  type="text" name='fullname' id="fullname" placeholder="fullname" autocomplete="off" required="required">
                </div>
            </div>
            <div class="password&email havespan row">
            <div class=" col-md col-lg col-sm-12 havespan">
                    <label class="col-12 col-sm-12 text-center" for="password"></label>
                    <input class="col-12 col-sm-12 form-control" value="<?php echo $row['userpassword'];?>"  type="hidden" name='oldpassword' id="password" placeholder="password" autocomplete="off">
                    <input class="col-12 col-sm-12 form-control" value=""  type="password" name='newpassword' id="password" placeholder="password" autocomplete="off">
                </div>
                <div class=" col-md col-lg col-sm-12 havespan">
                    <label class="col-6 col-sm-12 text-center" for="email"></label>
                    <input class="col-12 col-sm-12 form-control" value="<?php echo $row['email'];?>"  type="email" name='email' id="email" placeholder="email" autocomplete="off" required="required">
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
    //the start of the add page
    elseif($do=='Add')
    {   
        echo"<div class='container Add'>";
        if($_SERVER['REQUEST_METHOD']=='GET')
        {
            ?>
            <h2 class="text-center h2-text">Add Page</h2>
            <hr>
            <form class="container formreg" action="members.php?do=insert" method="POST">
                        <div class="user&name  row" >
                    <div class="  col-md col-lg col-sm-12 havespan">
                        <label  class="col-12 col-sm-12 text-center" id="usernamelabel" for="username"></label>
                        <input class="col-12 col-sm-12 form-control"  type="text" name='username' id="usernamefield" placeholder="username" autocomplete="off" required="required">
                    </div>
                    <div class=" col-md col-lg col-sm-12 havespan">
                        <label class="col-12 col-sm-12 text-center" for="fullname"></label>
                        <input class="col-12 col-sm-12 form-control"  type="text" name='fullname' id="fullname" placeholder="fullname" autocomplete="off" required="required">
                    </div>
                </div>
                <div class="password&email havespan row">
                <div class=" col-md col-lg col-sm-12 havespan">
                        <label class="col-12 col-sm-12 text-center" for="password"></label>
                        <input class="col-12 col-sm-12 form-control"   type="password" name='password' id="password" placeholder="password" autocomplete="off" required='required'>
                    </div>
                    <div class=" col-md col-lg col-sm-12 havespan">
                        <label class="col-12 col-sm-12 text-center" for="email"></label>
                        <input class="col-12 col-sm-12 form-control"  type="email" name='email' id="email" placeholder="email" autocomplete="off" required="required">
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
       
        echo "<div/>";
    }
    // the end of the add page
    // the start of the updata page
    elseif ($do=='update')
    {
        echo"<div class='container'>";
        if($_SERVER['REQUEST_METHOD'] =="POST")
        {   
            $username   =$_POST["username"];
            $fullname   =$_POST["fullname"];
            $email      =$_POST["email"];
            $password   ='';
            $userid     =$_POST["userid"];
            // the header of the page
            echo'<h2 class="text-center h2-text">UPDATE Page welcome '.$_SESSION['username'].'</h2>';
            // the array of the errors
            $Error=array();
            //check if the user want to change the pass or not
            if($_POST["newpassword"]=='')
            {
                $password=$_POST["oldpassword"];
            }
            else
            {
                $password=sha1($_POST["newpassword"]);
            }
            if(strlen($username)<5)
            {
                $Error[]="<div class='alert alert-danger'>the username must be more than 5chars </div>";
            }
            if($fullname=="")
            {
                $Error[]="<div class='alert alert-danger'>the fullname must be filled </div>";
            }
            if($email=="")
            {
                $Error[]="<div class='alert alert-danger'>the email must be filled </div>";
            }
            if(empty($Error))
            {
                    $stmt=$con->prepare("UPDATE users SET username=? , fullname=? , email=? , userpassword=? WHERE userid=?");
                    $stmt->execute([$username,$fullname,$email,$password,$userid]);
                    $row=$stmt->rowcount();
                    echo "<div class='alert alert-success'>$row updated</div>";
                    header('Refresh:5;members.php');
                    exit();
               
            }
            else
            {
                foreach($Error as $error)
                {
                    echo $error;
                }
            }
        }
        else
        {
            Redirect("you can't browse this page directly",3);
        }
        echo "</div>";
    }
    // the end of the updata page
    //the start of the insert page
    elseif ($do=='insert')
    {
        echo"<div class='container'>";
        if($_SERVER['REQUEST_METHOD'] =="POST")
        {  
            $username   =$_POST["username"];
            $fullname   =$_POST["fullname"];
            $email      =$_POST["email"];
            $password   =$_POST["password"];
            // the header of the page
            echo'<h1 class="text-center h2-text">insert Page welcome '.$_SESSION['username'].' </h1>';
            // the array of the errors
            $Error=array();
            //check if the user want to change the pass or not
            if(strlen($_POST["password"])<5)
            {
                $Error[]="<div class='alert alert-danger'>the password must be more than 5chars </div>";
            }
            if(strlen($username)<5)
            {
                $Error[]="<div class='alert alert-danger'>the username must be more than 5chars </div>";
            }
            if($fullname=="")
            {
                $Error[]="<div class='alert alert-danger'>the fullname must be filled </div>";
            }
            if($email=="")
            {
                $Error[]="<div class='alert alert-danger'>the email must be filled </div>";
            }
            if(empty($Error))
            {
                $CheckUserName=checkprepare('username','users',$username);
                $CheckUserPass=checkprepare('userpassword','users',sha1($password));
                if(($CheckUserName == 0 )&& ($CheckUserPass == 0))
                {
                    $stmt=$con->prepare("INSERT INTO users (username,userpassword,fullname,email,regstatus,userdate) VALUES (?,?,?,?,1,now())");
                    $stmt->execute([$username,sha1($password),$fullname,$email]);
                    echo "<div class='alert alert-success'>the member is inserted</div>";
                    header("Refresh:5;members.php");
                }
                else
                {
                    $arrError=array();
                    if($CheckUserName>0)
                    {
                        $arrError[]="Please,Enter another username";
                    }
                    if($CheckUserPass>0)
                    {
                        $arrError[]="Please,Enter another password";
                    }
                    foreach($arrError as $error)
                    {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                    header("Refresh:5;members.php?do=Add");
                    exit();
                }
                }
                else
                {
                    foreach($Error as $error)
                    {
                        echo $error;
                    }
                }
        }
        else
        {
            Redirect("you can't browse this page directly",3);
        }
        echo "</div>";
    }
    //the end of the insert page
    //the start of the delete page
    elseif ($do=='delete')
    {
        echo"<div class='container'>";
        if(isset($_GET['userid']))
        {
            $id=$_GET['userid'];
            $stmt=$con->prepare("SELECT * FROM users WHERE userid=?");
            $stmt->execute([$id]);
            $rowcount=$stmt->rowcount();
            if($rowcount>0)
            {
                $stmt=$con->prepare("DELETE FROM users WHERE userid=?");
                $stmt->execute([$id]);
                echo "<h1 class='text-center h2-text'>The Delete Page welcome " .$_SESSION['username']."</h1>";
                echo "<div class='alert alert-success'>the member is deleted</div>";
                header("Refresh:1;members.php");
                exit();
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
        if(isset($_GET['userid']))
        {
            $id=$_GET['userid'];
            $stmt=$con->prepare(" SELECT * FROM users WHERE userid=?");
            $stmt->execute([$id]);
            $rowcount=$stmt->rowcount();
            if($rowcount>0)
            {
                $stmt=$con->prepare("UPDATE users SET regstatus = '1' WHERE userid = ?;");
                $stmt->execute([$id]);
                echo "<h1 class='text-center h2-text'>The Active Page welcome " .$_SESSION['username']."</h1>";
                echo "<div class='alert alert-success'>the member is Active Now</div>";
                header("Refresh:5;members.php");
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