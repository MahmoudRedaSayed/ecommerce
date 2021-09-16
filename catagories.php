<?php
include "init.php";
if($_SERVER["REQUEST_METHOD"]=='GET')
{
    $catid=$_GET['catid'];
    $catname=str_replace('-',' ',$_GET['catname']);
    ?>
    <div class="container">
        <h2 class='h2-text text-center'><?php echo $catname;?></h2> <hr>
        <?php
        $row=getcatitems($catid);
        if(!empty($row))
        {
            echo "<div class='container items'>";
            foreach($row as $catitems)
            {
                echo "<div class='item'>";
                echo "<div class='itemimage'><img src='0.png'/>";
                echo "<div class='user-item'>";
                echo "<p class='text-center'>published by </p>";
                echo "<a><i class='fa fa-user'></i>".$catitems['username']."</a>";
                echo "<a class='more-detials'> more detials </a>";
                echo"</div>";
                echo "</div>";
                echo"<div class='itemdata'>";
                echo "<h2 class='itemname'>".$catitems['itemname']."</h2><hr>";
                echo "<div class='itemslider'>";
                echo "<p class='itemcountry'> country made : ".$catitems['country_made']."</p>";
                echo "<p class='itemcountry'> stutes : ";
                if($catitems['stutes']==1)
                {
                    echo "New";
                }
                elseif($catitems['stutes']==2)
                {
                    echo 'Used';
                }
                else
                {
                    echo 'old';
                }
                echo"</p>";
                echo "<p class='itemcountry'> days ago : ";
                /////////////////////////////another way/////////////////////////////
                // $time=new DateTime(date('Y-m-d'));
                // $time2=new DateTime($catitems['itemDate']);
                // $time2=$time->diff($time2);
                // echo $time2->d;
                // echo date('d',$time2);
                /////////////////////////////////////////////////////////////////////
                $interval=date_diff(new DateTime(date('y-m-d')),new DateTime($catitems['itemDate']));
                echo $interval->d;
                echo"</p>";
                echo "<p class='itemprice'>".$catitems['price']."$</p>";
                echo"</div>";
                echo"</div>";
                echo"</div>";
            }
            echo"</div>";
        }
        else
        {
            echo"<h2 class='h2-text text-center'>there is no items in the catagory to show it</h2>";
        }
        ?>
    </div>
    <?php
}