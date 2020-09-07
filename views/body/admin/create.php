<div class="row my-3">
    <div class="offset-1 col-7">
        <h5 class="ml-3">
            新增商品
        </h5><hr>
        <div class="ml-3">
            <form>
                <div class="form-group">
                    <label for="productName">商品標題</label>
                    <input type="text" class="form-control" id="productName" name="productName" require>
                </div>
                <div class="form-group">
                    <label for="productPrice">商品價格</label>
                    <input type="text" class="form-control" id="productPrice" name="productPrice" require>
                </div>
                <div class="form-group">
                    <label for="productDesc">商品描述</label>
                    <textarea class="form-control" id="productDesc" name="productDesc" rows="3" maxlength="50"></textarea>
                </div>
                <div class="form-inline">
                    <label for="productImage">商品圖片</label>
                    <input type="file" class="form-control-file" name="productImage">
                </div>
                <div class="my-2">
                    <button id="uploadBtn" class="btn btn-primary" type="button">上傳圖片</button>
                    <span id="status">結果: 上傳成功</span>
                    <div id="progress" class="mt-1 progress">
                        <div id="progress-bar" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="my-2">
                    <button type="submit" class="float-right btn btn-success">新增商品</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-4">
        <div class="w-75">
            <h5>展示預覽</h5>
        </div>
        <div class="card my-2" style="width: 250px;">
            <img src="<?=Web::root?>exampleImg/example3.jpg" class="card-img-top" style="width: 250px; height: 200px"  alt="商品圖片">
            <div class="card-body">
                <h5 class="card-title"><a class="text-dark">商品標題</a></h5>
                <h5 class="card-text">價格</h5>
                <div class="d-flex justify-content-around">
                    <a class="cart btn btn-primary">加入購物車</a>
                    <a class="btn btn-danger">直接購買</a>
                </div>   
            </div>
        </div>
    </div>
</div>
<?php if(isset($data["script"])):?>
    <?php foreach( $data["script"] as $script ):?>
        <script src="<?=$script?>"></script>
    <?php endforeach; ?>
<?php endif;?>