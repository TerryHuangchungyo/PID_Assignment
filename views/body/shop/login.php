<section class="container vw-75 vh-100 py-4 d-flex justify-content-center">
    <div id="#loginFormContainer" class="container mx-auto" style="width: 500px">
        <h4 class="text-center">會員登入</h4>
        <small id="userHelp" class="text-center text-muted">還沒有帳號? <a href="/PID_Assignment/shop/signup">註冊帳號</a></small>
        <hr>
        <div class="mx-auto p-4 mt-3">
            <form action="#" method="post">
                <div class="form-group">
                    <label for="userId">帳號</label>
                    <input type="text" class="form-control" id="userId" name="userId" placeholder="請輸入會員帳號" required>
                    <small id="userHelp" class="form-text text-muted">為了帳號安全，請不要將密碼透露給其他人</small>
                </div>
                <div class="form-group">
                    <label for="password">密碼</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="請輸入會員密碼" required>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="rememberCheckBox">
                    <label class="form-check-label" for="rememberCheckBox">記住我</label>
                </div>
                <button type="submit" class="float-right btn btn-dark" name="login">登入</button>
            </form>
        </div>
    </div>
</section>