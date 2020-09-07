
<div class="row mt-3 vh-100">
    <div class="col-2">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">訂單記錄</a>
            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">帳戶設定</a>
            <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">更改密碼</a>
        </div>
    </div>
    <div class="col-10">
        <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
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
                            <tr>
                                <th scope="row">14</th>
                                <td>2020-08-26 12:00:16</td>
                                <td><a class="text-info">查看</a></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th scope="col">合計</th>
                                <th scope="col"></th>
                                <th scope="col">
                                    1 筆訂單
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                <div class="container">
                    <h5>帳戶設定</h5><hr>
                </div>
            </div>
            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                <div class="container">
                    <h5>更改密碼</h5><hr>
                </div>
            </div>
        </div>
    </div>
</div>