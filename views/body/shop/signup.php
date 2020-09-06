<section class="container vw-75 py-4 d-flex justify-content-center">
    <div id="#signupFormContainer" class="container mx-auto" style="width: 470px">
        <h4>註冊會員</h4>
        <small id="userHelp" class="form-text text-muted">為了帳號安全，請不要將密碼透露給其他人</small>
        <hr>
        <div class="mx-auto p-2 mt-3">
            <form action="#" method="post">
                <div class="form-row d-flex justify-content-between">
                    <div class="form-group">
                        <label for="userId">帳號</label>
                        <input type="text" class="<?=isset($data["feedbacks"]["userId"]) ? "is-invalid":""?> form-control" id="userId" name="userId" placeholder="請輸入會員帳號" required>
                        <div class="invalid-feedback">
                            <?=isset($data["feedbacks"]["userId"]) ? $data["feedbacks"]["userId"]:""?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="userId">姓名</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="請輸入使用者姓名" required>
                    </div>
                </div>
                <div class="form-row d-flex justify-content-between">
                    <div class="form-group">
                        <label for="userId">生日</label>
                        <input type="date" class="form-control" id="birthDate" name="birthDate">
                    </div>
                    <div class="form-group">
                        <label for="userId">電話號碼</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="請輸入電話號碼" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">信箱</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@domain.com" required>
                </div>
                <div class="form-group">
                    <label for="password">密碼</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="請輸入會員密碼" required>
                </div>
                <div class="form-group">
                    <label for="password">密碼確認</label>
                    <input type="password" class="<?=isset($data["feedbacks"]["passwordCheck"])?"is-invalid" :""?> form-control" id="passwordCheck" name="passwordCheck" placeholder="請再次輸入會員密碼" required>
                    <div class="invalid-feedback">
                        <?=isset($data["feedbacks"]["passwordCheck"]) ? $data["feedbacks"]["passwordCheck"]:""?>
                    </div>
                </div>
                <button type="submit" class="float-right btn btn-dark" name="signup" value="signup">註冊</button>
            </form>
        </div>
    </div>
</section>