<section class="container">
    <div class="container row mt-4 mx-auto d-flex justify-content-between">
        <h4>
            商品列表
        </h4>
        <form class="form-inline my-2 my-lg-0 ml-auto">
            <input class="form-control mr-sm-2" type="search" placeholder="想要搜尋什麼商品呢?" aria-label="Search">
            <button class="btn btn-light my-2 my-sm-0" type="button">搜尋</button>
        </form>
    </div><hr>
    <div id="productList" class="container row d-flex justify-content-around mx-auto my-3">
        <?php foreach( $data["products"] as $row):?>
        <div class="card my-2" style="width: 250px;">
            <img src="<?=Web::root?>productImg/<?=$row["image"]?>" class="card-img-top" style="width: 250px; height: 200px" alt="商品圖片">
            <div class="card-body">
                <h5 class="card-title"><a href="<?=Web::root?>shop/intro/<?=$row["productId"]?>" class="text-dark"><?=htmlspecialchars($row["name"])?></a></h5>
                <h5 class="card-text">NT $<?=$row["price"]?></h5>
                <div class="d-flex justify-content-around">
                    <a data-productId="<?=$row["productId"]?>" class="cart btn btn-primary <?=isset($_SESSION["cart"][$row["productId"]])?"disabled":""?>"><?=isset($_SESSION["cart"][$row["productId"]])?"已加入":"加入購物車"?></a>
                    <a class="btn btn-danger">直接購買</a>
                </div>   
            </div>
        </div>
        <?php endforeach;?>
    </div>
</section>
<?php if(isset($data["script"])):?>
    <?php foreach( $data["script"] as $script ):?>
        <script src="<?=$script?>"></script>
    <?php endforeach; ?>
<?php endif;?>