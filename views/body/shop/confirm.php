<section class="container vw-100">
    <div class="container row mt-4">
        <h4>
            訂單確認
        </h4>
        <a href="<?=Web::root.$_SESSION["lastPage"]?>" class="ml-auto btn btn-light mb-3">返回</a>
    </div>
    <table id="cartTable" class="table">
        <thead>
            <tr>
                <th scope="col">商品編號</th>
                <th scope="col">商品名稱</th>
                <th scope="col">價格</th>
                <th scope="col">數量</th>
                <th scope="col">金額</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach( $data["cart"] as $item ): ?>
            <tr>
                <th scope="row"><?=$item["productId"]?></th>
                <td><a href="<?=Web::root?>shop/intro/<?=$item["productId"]?>" class="text-dark"><?=htmlspecialchars($item["name"])?></a></td>
                <td>NT $<?=$item["price"]?></td>
                <td><?=$_SESSION["cart"][$item["productId"]]?></td>
                <td>$ <?=$item["price"] * $_SESSION["cart"][$item["productId"]]?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th scope="col">合計</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col">
                    $ <?=$data["total"]?>
                </th>
            </tr>
            <tr>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col">
                    <form method="post" action="#">
                        <button class="btn btn-success">提交</button>
                    </form>
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