<section class="container vw-100">
    <div class="container row mt-4">
        <h4>
            購物車
        </h4>
        <a href="<?=Web::root."shop/cart/clear"?>" class="ml-auto btn btn-light mb-3">清空購物車</a>
    </div>
    <table id="cartTable" class="table">
        <thead>
            <tr>
                <th scope="col">商品編號</th>
                <th scope="col">商品名稱</th>
                <th scope="col">價格</th>
                <th scope="col">數量</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach( $data["cart"] as $item ): ?>
            <tr>
                <th scope="row"><?=$item["productId"]?></th>
                <td><a href="<?=Web::root?>shop/intro/<?=$item["productId"]?>" class="text-dark"><?=htmlspecialchars($item["name"])?></a></td>
                <td>NT $<?=$item["price"]?></td>
                <td><input type="number" value="<?=$_SESSION["cart"][$item["productId"]]?>" min="1" step="1"></td>
                <td><a class="cancel text-danger">取消</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th scope="col">共計<span id="cartCount"><?=count($_SESSION["cart"])?></span>項</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col">
                    <?php if( count($_SESSION["cart"]) > 0 ):?>
                        <a id="confirmBtn" href="<?=Web::root?>shop/confirm" class="text-success">下訂單</a>
                    <?php endif?>
                </th>
            </tr>
        </tfoot>
    </table>
</section>
<?php if(isset($data["script"])):?>
    <?php foreach( $data["script"] as $script ):?>
        <script src="<?=$script?>"></script>
    <?php endforeach; ?>
<?php endif;?>