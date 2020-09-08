<section class="container">
    <div class="container row mt-4 mx-auto d-flex justify-content-between">
        <h4>
            商品介紹
        </h4>
    </div><hr>
    <div class="mb-3">
    <div class="row no-gutters">
        <div class="col-3">
            <div style="overflow: hidden; width:250px; height: 200px;">
                <img src="<?=Web::root."productImg/".($data["product"]->image)?>" style="width:250px; height: 200px;" alt="...">
            </div>
        </div>
        <div class="col-9">
            <h5 class="card-title"><strong><?=$data["product"]->name?></strong></h5>
            <h5 class="card-title">NT $ <?=$data["product"]->price?></h5>
            <p class="card-text"><?=$data["product"]->productDesc?></p>
            <p class="card-text">上架時間: <?=$data["product"]->createDate?></p>
            <div class="d-flex justify-content-end">
                <a data-productId="<?=$data["product"]->productId?>" class="cart mr-3 btn btn-primary <?=isset($_SESSION["cart"][$data["product"]->productId])?"disabled":""?>"><?=isset($_SESSION["cart"][$data["product"]->productId])?"已加入":"加入購物車"?></a>
                <a class="btn btn-danger">直接購買</a>
            </div>
            <a id="back" class="float-right btn btn-white mt-4">返回</a>
        </div>
    </div>
    </div>
</section>
<?php if(isset($data["script"])):?>
    <?php foreach( $data["script"] as $script ):?>
        <script src="<?=$script?>"></script>
    <?php endforeach; ?>
<?php endif;?>