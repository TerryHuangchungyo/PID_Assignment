<section class="container vw-100">
    <div class="container row mt-4">
        <h4>
            購買
        </h4>
        <a id="back" class="ml-auto btn btn-light mb-3">返回</a>
    </div>
    <table id="buyTable" class="table">
        <thead>
            <tr>
                <th scope="col">商品編號</th>
                <th scope="col">商品名稱</th>
                <th scope="col">價格</th>
                <th scope="col">數量</th>
                <th scope="col">合計</th>
            </tr>
        </thead>
        <?php if( isset($data["product"]) ): ?>
        <?php if( $data["confirm"]): ?>
            <form method="post" action="<?=Web::root."shop/commit"?>">
            <input type="hidden" name="productId" value="<?=$data["product"]["productId"]?>">
            <input type="hidden" name="value" value="<?=$data["product"]["value"]?>">
        <?php else: ?>
            <form method="post" action="#">
        <?php endif; ?>
        <tbody>
            <tr>
                <td scope="col"><?=$data["product"]["productId"]?></td>
                <?php if( $data["confirm"]): ?>
                    <td scope="col"><?=$data["product"]["name"]?></td>
                <?php else: ?>
                    <td scope="col"><a href="<?=Web::root."shop/intro/".$data["product"]["productId"]?>" class="text-dark"><?=$data["product"]["name"]?></a></td>
                <?php endif; ?>
                <td scope="col">$ <span id="price"><?=$data["product"]["price"]?></span></td>
                
                
                <?php if( $data["confirm"]): ?>
                    <td scope="col"><?=$data["product"]["value"]?></td>
                    <td scope="col">$ <span id="total"><?=$data["product"]["total"]?></span></td>
                <?php else: ?>
                    <td scope="col"><input type="number" name="value" value="1" min="1" step="1"></td>
                    <td scope="col">$ <span id="total"><?=$data["product"]["price"]?></span></td>
                <?php endif; ?>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td scope="col"></td>
                <td scope="col"></td>
                <td scope="col"></td>
                <td scope="col"></td>
                <th scope="col">
                    <?php if( $data["confirm"]): ?>
                        <button type="submit" class="btn btn-success">提交</button>
                    <?php else: ?>
                        <button type="submit" class="btn btn-link text-success">下訂單</button>
                    <?php endif; ?>
                </th>
            </tr>
        </tfoot>
        </form>
        <?php endif;?>
    </table>
</section>
<?php if(isset($data["script"])):?>
    <?php foreach( $data["script"] as $script ):?>
        <script src="<?=$script?>"></script>
    <?php endforeach; ?>
<?php endif;?>