<?php
// the title of the page
$pagetitle="login";
// the var which will prevent the nav bar
$nonavbar=" ";
include "init.php";
session_start();
// if user coming from post
  if($_SERVER['REQUEST_METHOD']=='POST'){
    
    $username=$_POST['username'];
    $password=$_POST['password'];
    $hashedpass=sha1($password);
    // check the data from the database
    $stmt=$con->prepare("SELECT userid , username , userpassword , group_id FROM users WHERE userpassword=? AND username=? AND group_id=? LIMIT 1");
    $stmt->execute(array($hashedpass,$username,1));
    // to bring the data
    $row=$stmt->fetch();
    $count= $stmt->rowCount();
    if($count>0){
      $_SESSION['username']=$username;
      $_SESSION['userid']=$row['userid'];
      header('location:dashed.php');
    }
    }
?>
<section class="login-section">
  <form class="login" action="<?php echo $_SERVER["PHP_SELF"] ?>" method='POST'>
    <h4 class='text-center'>login</h4>
    <input type="text" name="username" class="form-control" autocomplate="off" placeholder="username"/>
    <input type="password" name="password" class="form-control" autocomplate="new-password" placeholder="password"/>
    <input type="submit" name="submit" value="login" class="btn btn-primary btn-block"/>
  </form>
</section>
<?php include $tmp."/footer.php";
?>