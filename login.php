<?php
// session_start();
// if(isset($_SESSION['user']))
// {
//     header('location:index.php');
// }
include "init.php";
echo "<div class='container-page'>";
if($_SERVER["REQUEST_METHOD"]=="GET")
{
    $do=(isset($_GET['do']))?$_GET['do']:'login';
            if($do=='login')
            {?>
                <div class='formcontainer-login formcontainer'>
                <h2 class='text-center h2-text'>login</h2>
                <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method='POST'>
                    <label for="email"></label>
                    <input type="text" name='email' class='form-control' id='email' placeholder='enter your emial' autocomlete='off'>
                    <label for="password"></label>
                    <input type="password" name='password' id='password' class='form-control password' placeholder='enter your password' autocomlete='off'>
                    <input type="submit" value="login"class="loginbutton">
                </form>
                <a href="index.php"><h2 class='ecommerce'>ecommerce page <i class="fas fa-store"></i></h2></a>
                </div>
                <div class="controls">
                <span class="vid-btn active" data-scr="images/vid-1.mp4"></span>
                <span class="vid-btn" data-scr="vid-2.mp4"></span>
                <span class="vid-btn" data-scr="vid-3.mp4"></span>
                <span class="vid-btn" data-scr="vid-4.mp4"></span>
                <span class="vid-btn" data-scr="vid-5.mp4"></span>
                </div>
                <div class="vid-container">
                    <video src="vid-1.mp4" id="video" autoplay muted loop></video>
                </div>
            <?php
            }
            elseif($do =='signup')
            {
                ?>
                <div class='formcontainer-signup formcontainer'>
                    <h2 class='text-center h2-text'>sign up</h2>
                <form action='<?php if(empty($errors)) echo $_SERVER["PHP_SELF"] ."'method='POST'"; ?> >
                    <label for="fullname"></label>
                    <input type="text" name='fullname' class='form-control' id='fullname' placeholder='enter your fullname to appear in the profile page' autocomlete='off'>
                    <label for="username"></label>
                    <input type="text" name='username' class='form-control' id='username' placeholder='enter your username to use it in sign in' autocomlete='off'>
                    <label for="password"></label>
                    <input type="password" name='password' id='password' class='form-control password' placeholder='enter complex password' autocomlete='off'>
                    <label for="gmail"></label>
                    <input type="email" name='gmail' class='form-control' id='gmail' placeholder='enter your gmail ' autocomlete='off'>
                    <input <?php if(empty($errors)) echo 'type="submit"'?> value="sign up"class="loginbutton">
                </form>
                        <a href="index.php"><h2 class='ecommerce'>ecommerce page <i class="fas fa-store"></i></h2></a>
                    </div>
                    <div class="controls">
                    <span class="vid-btn active" data-scr="images/vid-1.mp4"></span>
                    <span class="vid-btn" data-scr="vid-2.mp4"></span>
                    <span class="vid-btn" data-scr="vid-3.mp4"></span>
                    <span class="vid-btn" data-scr="vid-4.mp4"></span>
                    <span class="vid-btn" data-scr="vid-5.mp4"></span>
                    </div>
                    <div class="vid-container">
                        <video src="vid-1.mp4" id="video" autoplay muted loop></video>
                    </div>
                    <div class='errors-alert'>
                        <?php
                        foreach($errors as $error)
                        {
                           echo"<div class='alert alert-danger'>".$error."</div>";
                        }
                        ?>
                    </div>
                
            <?php 
                }
                else
                {
                    echo"<div class='alert alert-danger'>there is no page like this</div>";
                }
                ?>
            <?php
}
elseif($_SERVER['REQUEST_METHOD']='POST')
{
    echo "<div class='container'>";
    if(!(isset($_POST['fullname'])))
    {
        $username       =$_POST['email'];
        $password       =$_POST['password'];
        $hashedpass=sha1($password);
        $stmt=$con->prepare("SELECT userid , username , userpassword , group_id FROM users WHERE userpassword=? AND username=?");
        $stmt->execute(array($hashedpass,$username));
        // to bring the data
        $row=$stmt->fetch();
        $count= $stmt->rowCount();
        if($count>0)
        {
            $_SESSION['user']=$row['username'];
            $_SESSION['userid']=$row['userid'];
            $_SESSION['usergroupid']=$row['group_id'];
            header('location:index.php');
            exit();
        }
        else
        {
            echo"<div class='alert alert-danger'>the user is not found</div>";
            header('refresh:3;index.php');
            exit();
        }
    }
    else
    {
        $fullname=FILTER_VAR($_POST['fullname'],FILTER_SANITIZE_STRING);
        $username=FILTER_VAR($_POST['username'],FILTER_SANITIZE_STRING);
        $password=$_POST['password'];
        $gmail=FILTER_VAR($_POST['gmail'],FILTER_SANITIZE_EMAIL);
        echo $fullname;
        echo$username;
        echo $password;
        echo$gmail;
        $errors=array();
        if(strlen($username)<5)
        {
           $errors[]="the username must be more than 5 chars";
        }
        if($password=="")
        {
            $errors[]="the password must'n be empty";
        }
        $hashedpass=sha1($password);
        $CheckUserPass=checkprepare('userpassword','users',$hashedpass);
        if(($CheckUserPass == 0))
        {
            $stmt=$con->prepare("INSERT INTO users (username,userpassword,fullname,email,userdate) VALUES (?,?,?,?,now())");
            $stmt->execute([$username,sha1($password),$fullname, $gmail]);
            echo "<div class='alert alert-success'> your are under activate now</div>";
            header("Refresh:3;index.php");
        }
    }
    echo"</div>";
}
echo"</div>";
include $tmp.'/footer.php';