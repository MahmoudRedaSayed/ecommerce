<?php
$pagetitle="catagory page";
include "init.php";
if($_SERVER["REQUEST_METHOD"]=='GET')
{
    $catid=$_GET['catid'];
    $catname=str_replace('-',' ',$_GET['catname']);
    ?>
    <div class="container">
        <div class=" newproducts">
            <div class='head text-center'>
                <p>our products</p>
            </div>
            <div class='products'>
                <?php
                $stmt=$con->prepare("SELECT * FROM items WHERE cat_id= $catid ");
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
        <div class=" newproducts">
    <div class='head'>
        <p>new products</p>
    </div>
    <div class='products'>
        <?php
        $stmt=$con->prepare("SELECT * FROM items WHERE cat_id=$catid ORDER BY itemDate DESC limit 4 ");
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
        $stmt=$con->prepare("SELECT * FROM items WHERE cat_id=$catid ORDER BY loves DESC limit 4 ");
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
        $stmt=$con->prepare("SELECT * FROM items WHERE cat_id=$catid ORDER BY rating DESC limit 4 ");
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
<?php
if(isset($_SESSION['userid'])&&$_SESSION['usergroupid']!=0) {
?>
<div class='Addproduct' >
    <a href="item.php?catid=<?php echo $catid;?>"> Add product</a>
</div>
<?php } ?>
</div>
    <?php
}
?>
<?php
include $tmp."/footer.php";