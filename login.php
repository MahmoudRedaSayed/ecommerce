<?php
include "init.php";
echo "<div class='container-page'>";
if($_SERVER["REQUEST_METHOD"]=="GET")
{
    $do=(isset($_GET['do']))?$_GET['do']:'login';
            if($do=='login')
            {?>
                <div class='formcontainer-login formcontainer'>
                <h2 class='text-center h2-text'>login</h2>
                <form action="">
                    <label for="email"></label>
                    <input type="email" name='email' class='form-control' id='email' placeholder='enter your emial' autocomlete='off'>
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
                <form action="">
                    <label for="fullname"></label>
                    <input type="text" name='fullname' class='form-control' id='fullname' placeholder='enter your fullname to appear in the profile page' autocomlete='off'>
                    <label for="username"></label>
                    <input type="text" name='username' class='form-control' id='username' placeholder='enter your username to use it in sign in' autocomlete='off'>
                    <label for="password"></label>
                    <input type="password" name='password' id='password' class='form-control password' placeholder='enter complex password' autocomlete='off'>
                    <label for="gmail"></label>
                    <input type="email" name='gmail' class='form-control' id='gmail' placeholder='enter your gmail ' autocomlete='off'>
                    <input type="submit" value="sign up"class="loginbutton">
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
                else
                {
                    echo"<div class='alert alert-danger'>there is no page like this</div>";
                }
                ?>
            <?php
}
else
{
    echo"<div class='alert alert-danger'>you can not browse this page dirct</div>";
}
echo"</div>";
include $tmp.'/footer.php';