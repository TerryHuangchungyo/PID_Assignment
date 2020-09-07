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
                    <img src="<?=Web::root."productImg/".$data["product"]->image?>" style="width:250px; height: 200px;" class="mx-auto my-auto" alt="...">
                </div>
            </div>
            <div class="col-9">
                <h5 class="card-title"><strong><?=$data["product"]->name?></strong></h5>
                <h5 class="card-title">NT $ <?=$data["product"]->price?></h5>
                <p class="card-text"><?=$data["product"]->productDesc?></p>
                <p class="card-text">上架時間: <?=$data["product"]->createDate?></p>
                <a href="<?=Web::root.$data["lastPage"]?>" class="float-right btn btn-white">返回</a>
            </div>
        </div>
    </div>
</section>
<?php if(isset($data["script"])):?>
    <?php foreach( $data["script"] as $script ):?>
        <script src="<?=$script?>"></script>
    <?php endforeach; ?>
<?php endif;?>