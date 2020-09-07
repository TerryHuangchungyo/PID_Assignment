<section class="container vh-100 vw-100">
    <div class="container row my-4">
        <h4>
            商品管理
        </h4>
        <a href="<?=Web::root."/admin/create"?>" class="ml-auto btn btn-primary">新增商品</a>
    </div>
    <table id="productTable" class="table table-hover">
        <thead>
            <tr>
                <th scope="col">商品編號</th>
                <th scope="col">商品名稱</th>
                <th scope="col">價格</th>
                <th scope="col">上架日期</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach( $data["products"] as $product ):?>
                <tr>
                    <th scope="row"><?=$product["productId"]?></th>
                    <td><a class="text-dark" href="<?=Web::root."admin/intro/".$product["productId"]?>"><?=$product["name"]?></a></td>
                    <td>NT $ <?=$product["price"]?></td>
                    <td><?=$product["createDate"]?></td>
                    <td scope="col"><a class="text-success">修改</a>|<?= $product["active"] == 0? "<a href='".Web::root."admin/shelf/".$product["productId"]."' class='text-warning'>上架</a>":"<a href='".Web::root."admin/unshelf/".$product["productId"]."' class='text-danger'>下架</a>" ?></td>
                </tr>
            <?php endforeach;?>
        </tbody>
        <tfoot>
    </table>
</section>