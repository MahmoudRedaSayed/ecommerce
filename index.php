<?php
session_start();
include "init.php";
if(isset($_SESSION['user']))
{
    $nologin;
}
include "includes/templates/footer.php";
?>