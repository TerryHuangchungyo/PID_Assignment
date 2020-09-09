
<div class="row mt-3 vh-100">
    <div class="col-2">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" id="v-order-tab" data-toggle="pill" href="#v-pills-order" role="tab">訂單記錄</a>
            <a class="nav-link" id="v-setting-tab" data-toggle="pill" href="#v-pills-setting" role="tab" >帳戶設定</a>
            <a class="nav-link" id="v-changePassword-tab" data-toggle="pill" href="#v-pills-changePassword" role="tab">更改密碼</a>
        </div>
    </div>
    <div class="col-10">
        <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="v-pills-order" role="tabpanel" >
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
                                <td><a href="<?=Web::root."shop/order/".$order["orderId"]?>" class="text-info">查看</a></td>
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
            </div>
            <div class="tab-pane fade" id="v-pills-setting" role="tabpanel">
                <div class="container">
                    <h5>帳戶設定</h5><hr>
                    <div class="row my-2">
                        <div class="text-right col-2 pt-2">帳戶名稱:</div>
                        <div class="col-3">
                            <input type="text" class="form-control" id="userName">
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="text-right col-2 pt-2">生日:</div>
                        <div class="col-3">
                            <input type="date" class="form-control" id="userName">
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="text-right col-2 pt-2">信箱:</div>
                        <div class="col-3">
                            <input type="email" class="form-control" id="userName">
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="text-right col-2 pt-2">電話:</div>
                        <div class="col-3">
                            <input type="text" class="form-control" id="userName">
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="offset-2 col-3">
                        <button id="settingSubmit" type="submit" class="float-right btn btn-dark">提交修改</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="v-pills-changePassword" role="tabpanel" >
                <div class="container w-50">
                    <h5>更改密碼</h5><hr>
                    <h6 id="changePasswordSuccess" class="text-success">更改成功</h6>
                    <div class="form-group">
                        <label for="changedPassword">請輸入欲更改的密碼</label>
                        <input type="password" class="form-control" id="changedPassword">
                        <div id="changedPasswordFeedback" class="invalid-feedback">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="changedPasswordCheck">請再次輸入欲更改的密碼</label>
                        <input type="password" class="form-control" id="changedPasswordCheck">
                        <div id="changedPasswordCheckFeedback" class="invalid-feedback">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">請輸入原本的密碼</label>
                        <input type="password" class="form-control" id="password">
                        <div id="passwordFeedback" class="invalid-feedback">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="passwordCheck">請再次輸入原本的密碼</label>
                        <input type="password" class="form-control" id="passwordCheck">
                        <div id="passwordCheckFeedback" class="invalid-feedback">
                        </div>
                    </div>
                    <button id="changePasswordSubmit" type="submit" class="float-right btn btn-dark">提交修改</button>
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