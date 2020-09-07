<section class="container vh-100 vw-100">
    <div class="container row my-4">
        <h4>
            會員管理
        </h4>
    </div>
    <table id="userTable" class="table">
        <thead>
            <tr>
                <th scope="col">會員帳號</th>
                <th scope="col">會員姓名</th>
                <th scope="col">電話</th>
                <th scope="col">信箱</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach( $data["users"] as $user ):?>
            <tr>
                <th scope="row"><a href="<?=Web::root."admin/order/".$user["userId"]?>" class="text-dark"><?=htmlspecialchars($user["userId"])?></a></th>
                <td><?=htmlspecialchars($user["name"])?></td>
                <td><?=htmlspecialchars($user["phone"])?></td>
                <td><?=htmlspecialchars($user["email"])?></td>
                <td><?=$user["active"] == 1  ? "<a href='".Web::root."admin/ban/".$user["userId"]."' class='text-danger'>禁用<a>": "<a href='".Web::root."admin/unban/".$user["userId"]."' class='text-success'>解除禁用<a>"?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</section>