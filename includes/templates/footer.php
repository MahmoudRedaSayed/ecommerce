<footer>
    <div class='container'>
        <div>
            <h3>my account</h3>
            <ul>
                <?php if(isset($_SESSION['user'])){?>
                    <li><a href='logout.php'>logout</a></li>
                <?php
                }
                else{
                    ?>
                        <li><a href='login.php'>login|signup</a></li>
                <?php } ?>
                <li><a href='<?php if(isset($_SESSION['userid'])){echo"profile.php?userid=" .$_SESSION['userid']; }
                else {echo"login.php";}?>' >my cart</a></li>
                <li><a href='<?php if(isset($_SESSION['userid'])){echo"profile.php?userid=" .$_SESSION['userid']."#wishlist"; }
                else {echo"login.php";}?>'>wishlist</a></li>
                <li><a href='<?php if(isset($_SESSION['userid'])){echo"profile.php?userid=" .$_SESSION['userid']; }
                else {echo"login.php";}?>'>order history</a></li>
            </ul>
        </div>
        <div class='categories'>
        <h3>the categories</h3>
            <?php
            $stmt=$con->prepare("SELECT * FROM catagories ");
            $stmt->execute();
            $row=$stmt->fetchAll();
            if(!empty($row))
            {
                echo"<div>";
                echo"<ul>";
                foreach($row as $cata)
                {
                    echo"<li>";
                    echo "<a href='catagories.php?catid=". $cata['catagory_id']."&catname=".str_replace(' ','-',$cata['catagory_name'])."'>".$cata['catagory_name']."</a>";
                    echo"</li>";
                }
                echo"</ul>";
                echo"</div>";
            }
            ?>
        </div>
    </div>
</footer>
    <script src=  "<?php echo $js;?>/jquery.js?v=<?php echo time(); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
    <script src="<?php echo $js;?>/script.js?v=<?php echo time(); ?>"></script>
    <script src="<?php echo $js;?>/script2.js?v=<?php echo time(); ?>"></script>
    </body>
</HTML>