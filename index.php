<?php
session_start();
include "init.php";
$count=0;
echo "<div class='container homepage'>";
if(isset($_SESSION['user']))
{
    $nologin;
}
$items=getAllitems();
//     echo "<div class='container items'>";
//             foreach($items as $item)
//             {
//                 if($item['approve']==1)
//                 {
//                     echo "<div class='item'>";
//                 echo "<div class='itemimage'><img src='uploads\\";
//                 if(empty($item['itemimage']))
//                 {
//                     echo"default\\item.png";
//                 }
//                 else
//                 {
//                     echo"items\\".$item['itemimage'];
//                 }
//                 echo"'/>";
//                 echo "<div class='user-item'>";
//                 echo "<p class='text-center'>published by </p>";
//                 echo "<a href='profile.php?userid=".$item['userid']."'>";
                ?>
<!-- //                     <img class='profileimg' src="<?php
//                     if(empty($item['profileimg']))
//                     {
//                         if($item['gander']==1)
//                         {
//                             echo 'uploads\default\user-icon.png';
//                         }
//                         else
//                         {
//                             echo'uploads\default\user-icon-female.jpg';
//                         }
//                     }
//                     else
//                     {
//                         echo "uploads\cover\\".$item['profileimg'] ;
//                     }
//                     ?>
<!--                     " alt=""> -->           <?php
//                 if(isset($_SESSION['userid']))
//                 {
//                     if($item['userid']==$_SESSION['userid'])
//                     {
//                         echo "you";
//                     }
//                     else
//                     {
//                         echo $item['fullname'];
//                     }
//                 }
//                 else
//                 {
//                     echo $item['fullname'];
//                 }
//                 echo"</a>";
//                 echo "<a class='more-detials' href='item.php?itemid=";
//                 echo $item['itemid']."&itemname=".$item['itemname'];
//                 echo"'> more detials </a>";
//                 echo"</div>";
//                 echo "</div>";
//                 echo"<div class='itemdata'>";
//                 echo "<h2 class='itemname'>".$item['itemname']."</h2><hr>";
//                 echo "<div class='itemslider'>";
//                 echo "<p class='itemcountry'> country made : ".$item['country_made']."</p>";
//                 echo "<p class='itemcountry'> stutes : ";
//                 if($item['stutes']==1)
//                 {
//                     echo "New";
//                 }
//                 elseif($item['stutes']==2)
//                 {
//                     echo 'Used';
//                 }
//                 else
//                 {
//                     echo 'old';
//                 }
//                 echo"</p>";
//                 echo "<p class='itemcountry'> days ago : ";
//                 /////////////////////////////another way/////////////////////////////
//                 // $time=new DateTime(date('Y-m-d'));
//                 // $time2=new DateTime($catitems['itemDate']);
//                 // $time2=$time->diff($time2);
//                 // echo $time2->d;
//                 // echo date('d',$time2);
//                 /////////////////////////////////////////////////////////////////////
//                 $interval=date_diff(new DateTime(date('y-m-d')),new DateTime($item['itemDate']));
//                 echo $interval->d;
//                 echo"</p>";
//                 echo "<p class='itemprice'>".$item['price']."$</p>";
//                 echo"</div>";
//                 echo"</div>";
//                 echo"</div>";
//                 }
//                 else
//                 {
//                     $count++;
//                 }
//             }
//             echo"</div>";
//             if($count!=0)
//             {
//                 echo "<h2 class='h2-text'>there's ".$count." under control</h2>";
//             }
// echo"</div>";
?>
<div class='slider'>
    <div class='catagories_section'>
        <div>
            <div class='header'>
            <i class="fas fa-bars"></i> 
            <span>categories</span>
            </div>
        </div>
        <?php
            $stmt=$con->prepare("SELECT * FROM catagories ");
            $stmt->execute();
            $row=$stmt->fetchAll();
            if(!empty($row))
            {
                echo "<div>";
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
    <div class='sreach'>
        <div>
            <!-- form of sreach cata -->
            <form action="">
                <input type="text"class='sreach_field' placeholder='sreach'>
                <div class='button'>
                    <div class='categories'>
                        <div class='cataclick'> all categories</div>
                        <div class='dropdown'></div>
                    </div>
                    <button type='submit'><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- ////////////////////// -->
        </div>
        <div class='sliderimg'>
        <div class="descraption">
                <h1>spring <span>sale</span></h1>
                <p>explore it</p>
            </div>
            <img src="slider.jpg" alt="">
        </div>
    </div>
</div>
<!-- the start of the products -->
<div class=" newproducts">
    <div class='head'>
        <p>new products</p>
    </div>
    <div class='products'>
        <?php
        $stmt=$con->prepare("SELECT * FROM items ORDER BY itemDate DESC limit 4 ");
        $stmt->execute();
        $row=$stmt->fetchAll();
        if(!empty($row))
        {
            foreach($row as $product)
            {
                echo "<div class='product'>";
                echo "<img src='uploads\items\\".$product['itemimage']."' loading='lazy'>";
                echo "<p>".$product['itemname']."</p>";
                echo "<span>".$product['price']."</span>";
                echo "<a href='item.php?itemid=".$product['itemid']."' class='select'>select options</a>";
                echo"</div>";
            }
        }
        ?>
    </div>
</div>
<!-- the start of the popular  -->
<div class=" newproducts popular">
    <div class='head'>
        <p>popular products</p>
    </div>
    <div class='products'>
        <?php
        $stmt=$con->prepare("SELECT * FROM items ORDER BY loves DESC limit 4 ");
        $stmt->execute();
        $row=$stmt->fetchAll();
        if(!empty($row))
        {
            foreach($row as $product)
            {
                echo "<div class='product'>";
                echo "<img src='uploads\items\\".$product['itemimage']."' loading='lazy'>";
                echo "<p>".$product['itemname']."</p>";
                echo "<span>".$product['price']."</span>";
                echo "<div class='itemselection'><a href='item.php?itemid=".$product['itemid']."' class='select'>select options</a></div>";
                echo"</div>";
            }
        }
        ?>
    </div>
</div> 
<!-- the end of the popular  -->
<!-- the start of the bestrated -->
    <div class=" newproducts rated">
        <div class='head'>
            <p>best rated products</p>
        </div>
        <div class='products'>
            <?php
            $stmt=$con->prepare("SELECT * FROM items ORDER BY rating DESC limit 4 ");
            $stmt->execute();
            $row=$stmt->fetchAll();
            if(!empty($row))
            {
                foreach($row as $product)
                {
                    echo "<div class='product'>";
                    echo "<img src='uploads\items\\".$product['itemimage']."' loading='lazy'>";
                    echo "<p>".$product['itemname']."</p>";
                    echo "<span>".$product['price']."</span>";
                    echo "<div class='itemselection'><a href='item.php?itemid=".$product['itemid']."&itemname=".$product['itemname']."' class='select'>select options</a></div>";
                    echo"</div>";
                }
            }
            ?>
        </div>
    </div> 
</div> 
<!-- the end of the bestrated -->
<!-- the start of the media -->
<div class='advertisement'>
        <div class='text'>
            <h2>products have <span>sale</span></h2>
            <p>sale off <span> %50</span></p>
        </div>
</div>
<!-- the start of the media -->
<?php
include "includes/templates/footer.php";
?>