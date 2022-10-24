<!doctype html>
<html lang="en">
<head>
    <title>Spourt Tech Test Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="canonical" href="assets/bootstrap/css/bootstrap-grid.css">
    
   
</head>
<?php
include("classes/cart.php");
$cart = new cart();
$cart->createSession();
?>
<body class="body">
    <div class="container">
        <h1>Sprout Tech Test</h1>
        <div class="row">
            <div class="col-md-8 border border-success rounded-3 me-1">
                <div class="row">
                    <h2>Products</h2>
                    <?php 
                    $prods = $cart->getProducts();
                    foreach ($prods as $product)
                    {
                        ?>
                        <div class="col-md-4 border border-success rounded-3">
                            <?php echo $product['product_name']?><BR />
                            $<?php echo $product['product_price']?><BR />
                            <button class="mb-1 btn btn-sm btn-success addToCart" data="<?php echo $product['product_code']?>">
                            Add To Cart
                            </button>
                        </div>
                    <?php }?>
                </div>
            </div>
            
            <div class="col-md-3 border border-success rounded-3 me-1">
            <h2>Cart</h2>
                <div id="cartDiv"></div>
                <button id="checkout" class="btn btn-primary chechout">Check out</button>
            </div>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function LoadCart(){
        $.ajax({
            url:"ajax.php?action=loadcart",
            type:"GET",
            success:function(result){
                $("#cartDiv").html(result)
            }

        })
    }
    
    $(".addToCart").on("click", function(){
        var code = $(this).attr("data");
        $.ajax({
            url:"ajax.php?action=addToCart",
            data:{'code':code},
            type:"POST",
            success:function(){
                LoadCart();
            }
        });
        
    });
    $("#checkout").on("click", function(){
        $.ajax({
            url:"ajax.php?action=checkOut",
            type:"Get",
            success:function(){
                LoadCart();
            }
        });
        
    })
    LoadCart();
</script>