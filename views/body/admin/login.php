<section class="container vw-75 py-4 d-flex justify-content-center">
    <div id="#loginFormContainer" class="container mx-auto" style="width: 500px">
        <h4 class="text-center">管理員登入</h4>
        <hr>
        <div class="mx-auto p-4 mt-3">
            <form action="#" method="post">
                <div class="form-group">
                    <label for="userId">帳號</label>
                    <input type="text" class="form-control" id="userId" name="userId" value="<?=isset($data["userId"])?$data["userId"]:""?>" placeholder="請輸入管理員帳號" required>
                </div>
                <div class="form-group">
                    <label for="password">密碼</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="請輸入會員密碼" required>
                </div>
                <div>
                <small class="text-danger"><?=isset($data["feedbacks"])?$data["feedbacks"]:""?></small>
                </div>
                <button type="submit" class="float-right btn btn-primary" name="login" value="login">登入</button>
            </form>
        </div>
    </div>
</section>