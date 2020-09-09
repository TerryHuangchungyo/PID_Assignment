<section class="container vh-100 vw-100">
    <div class="container row my-4">
        <h4>
            訂單管理
        </h4>
        <a id="back" class="ml-auto btn btn-light">返回</a>
    </div>
    <div class="container">
        <table id="cartTable" class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">訂單編號</th>
                    <th scope="col">日期</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach( $data["orders"] as $order): ?>
                <tr>
                    <th scope="row"><?=$order["orderId"]?></th>
                    <td><?=$order["date"]?></td>
                    <td><a href="<?=Web::root."admin/orderDetail/".$order["orderId"]?>" class="text-info">查看</a></td>
                </tr>
                <?php endforeach;?>
            </tbody>
            <tfoot>
                <tr>
                    <th scope="col">合計</th>
                    <th scope="col"></th>
                    <th scope="col">
                        <?=count($data["orders"])?>筆訂單
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
</section>
<?php if(isset($data["script"])):?>
    <?php foreach( $data["script"] as $script ):?>
        <script src="<?=$script?>"></script>
    <?php endforeach; ?>
<?php endif;?>