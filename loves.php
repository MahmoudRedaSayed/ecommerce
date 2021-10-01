<?php
$pagetitle='favorite page';
include "init.php";
if($_SERVER['REQUEST_METHOD']=='GET'&&isset($_GET['userid']))
{
    ?>
    <div class=' cartbackground'>
        <div>
            <a href="index.php">home></a><a href="<?php $_SERVER['PHP_SELF']?>">favorite</a>
        </div>
    </div>
    <div class='container'>
            <div class='orders'>
                <div class='title'>
                    <h1>wishes list</h1>
                </div>
                <?php
                ?>
            </div>
    </div>
    <?php
}
include $tmp."/footer.php";