<?php require_once('Connections/conn_db.php'); ?>
<?php (!isset($_SESSION)) ? session_start() : ""; ?>
<?php require_once('php_lib.php'); ?>
<!-- 強制登入使用者 -->
<?php
if (!isset($_SESSION['login'])) {
    $sPath = "login.php?sPath=checkout";
    header(sprintf("Location: %s", $sPath));
}
?>
<!-- page.89 -->
<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <!-- 引入網頁標頭 -->
    <?php require_once("headfile.php"); ?>
    <!-- 建立表格css設定 -->
    <style type="text/css">
        .table td,
        .table th {
            padding: 0.75rem;
            vertical-align: top;
            border-bottom: none;
            border-top: 1px solid #dee2e6;
        }
    </style>
</head>

<body>
    <section id="header">
        <!-- 引入導覽列 -->
        <?php require_once("navbar.php"); ?>
    </section>
    <section id="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2">
                    <!-- 引入產品類別 -->
                    <?php require_once("sidebar.php"); ?>
                    <!-- 引入熱銷商品 -->
                    <?php require_once("hot.php"); ?>
                </div>
                <div class="col-md-10">
                    <!-- 結帳主頁 -->
                    <?php //require_once('checkout_content.php');
                    ?>

                    <!-- 取得資料庫 收件者地址資料 專案5 page.55 -->
                    <?php
                    //取得收件者地址資料  setdefault='1' = 預設收件人
                    $SQLstring = sprintf("SELECT *,city.Name AS ctName,town.Name AS toName FROM addbook,city,town WHERE emailid='%d' AND setdefault='1' AND addbook.myzip=town.Post AND town.AutoNo=city.AutoNo", $_SESSION['emailid']);
                    $addbook_rs = mysqli_query($link, $SQLstring);  //$link->query($SQLstring) -> mysqli_query($link,$SQLstring) 寫法不一樣
                    ?>

                    <h3>店商藥妝：會員結帳作業</h3>
                    <!-- 建立收件人樣板 專案5 page.6 -->
                    <div class="row">
                        <div class="card" style="width: 30rem;">
                            <h4 class="card-header" style="color:#007bff;"><i class="fas fa-truck fa-flip-horizontal mr-1"></i>
                                配送資訊
                            </h4>
                            <div class="card-body pl-3 pt-2 pb-2">
                                <!-- 資料庫-收件人資料 page.56 -->
                                <?php while ($data = mysqli_fetch_array($addbook_rs)) { ?>
                                    <h5 class="card-title">收件人資訊：</h5>
                                    <h5 class="card-title">姓名：<?php echo $data['cname']; ?></h5>
                                    <p class="card-text">電話：<?php echo $data['mobile']; ?></p>
                                    <p class="card-text">郵遞區號：<?php echo $data['myzip'] . $data['ctName'] . $data['toName']; ?></p>
                                    <p class="card-text">地址：<?php echo $data['address']; ?></p>
                                    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal">選擇其他收件人</button>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- 建立付款方式樣板 專案5 page.8 -->
                        <div class="card ml-3" style="width: 50rem;">
                            <h4 class="card-header" style="color:#000;"><i class="far fa-credit-card mr-1"></i>
                                配送資訊
                            </h4>
                            <div class="card-body pl-3 pt-2 pb-2">
                                <!-- bootstrap navs -> Javascript behavior 使用javascript標籤插件，動態選項卡式介面
                                 data-target="" && aria-controls="" 按鍵錨點 -->
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true" style="color: #007bff !important;font-size:14pt;">貨到付款</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false" style="color: #007bff !important;font-size:14pt;">信用卡</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="contact-tab" data-toggle="tab" data-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false" style="color: #007bff !important;font-size:14pt;">銀行轉帳</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="contact-tab" data-toggle="tab" data-target="#epay" type="button" role="tab" aria-controls="epay" aria-selected="false" style="color: #007bff !important;font-size:14pt;">電子支付</button>
                                    </li>
                                </ul>
                                <!-- id="" && aria-labelledby="" 按鍵錨點 -->
                                <div class="tab-content" id="myTabContent">
                                    <!-- 貨到付款分頁 -->
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <?php //取得資料庫-付款收件人資料
                                        $addbook_rs = mysqli_query($link, $SQLstring);
                                        while ($data = mysqli_fetch_array($addbook_rs)) {
                                        ?>
                                            <h4 class="card-title pt-3">付款人資訊：</h4>
                                            <h5 class="card-title">姓名：<?php echo $data['cname']; ?></h5>
                                            <p class="card-text">電話：<?php echo $data['mobile']; ?></p>
                                            <p class="card-text">地址：<?php echo $data['myzip'] . $data['ctName'] . $data['toName'] . $data['address']; ?></p>
                                        <?php }
                                        ?>
                                    </div>
                                    <!-- 信用卡分頁 -->
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <h4 class="card-title pt-3">選擇付款帳戶：</h4>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">信用卡系統</th>
                                                    <th scope="col">發卡銀行</th>
                                                    <th scope="col">信用卡號</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row"><input type="radio" name="creditCard" id="creditCard[]" checked></th>
                                                    <td><img src="images/Visa_Inc._logo.svg" alt="visa" class="img-fluid"></td>
                                                    <td>玉山商業銀行</td>
                                                    <td>1234****</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row"><input type="radio" name="creditCard" id="creditCard[]" checked></th>
                                                    <td><img src="images/MasterCard_Logo.svg" alt="master" class="img-fluid"></td>
                                                    <td>玉山商業銀行</td>
                                                    <td>1234****</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row"><input type="radio" name="creditCard" id="creditCard[]" checked></th>
                                                    <td><img src="images/UnionPay_logo.svg" alt="unionpay" class="img-fluid"></td>
                                                    <td>玉山商業銀行</td>
                                                    <td>1234****</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <hr>
                                        <button type="button" class="btn btn-outline-success">使用新信用卡付款</button>
                                    </div>
                                    <!-- 銀行轉帳分頁 -->
                                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                        <h4 class="card-title pt-3">ATM匯款資訊：</h4>
                                        <img src="images/Cathay-bk-rgb-db.svg" alt="cathay" class="img-fluid">
                                        <h5 class="card-title">匯款銀行：國泰世華銀行 銀行代碼：013</h5>
                                        <h5 class="card-title">姓名：小小強</h5>
                                        <p class="card-text">匯款帳號：1234-4567-7890</p>
                                        <p class="card-text">備註：匯款完成後，需要1、2個工作天，待系統入款完成後，將以簡訊通知訂單完成付款</p>
                                    </div>
                                    <!-- 電子支付分頁 -->
                                    <div class="tab-pane fade" id="epay" role="tabpanel" aria-labelledby="epay-tab">
                                        <h4 class="card-title pt-3">選擇電子支付方式：</h4>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" width="5%">#</th>
                                                    <th scope="col" width="25%">電子支付系統</th>
                                                    <th scope="col" width="70%">電子支付公司</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row"><input type="radio" name="epay" id="epay[]" checked></th>
                                                    <td><img src="images/Apple_Pay_logo.svg" alt="applepay" class="img-fluid"></td>
                                                    <td>Apple Pay</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row"><input type="radio" name="epay" id="epay[]" checked></th>
                                                    <td><img src="images/Line_pay_logo.svg" alt="linepay" class="img-fluid"></td>
                                                    <td>Line Pay</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row"><input type="radio" name="epay" id="epay[]" checked></th>
                                                    <td><img src="images/JKOPAY_logo.svg" alt="jkopay" class="img-fluid"></td>
                                                    <td>JKO Pay</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <hr>
                                        <button type="button" class="btn btn-outline-success">使用新信用卡付款</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 建立結帳表格資料庫查詢 專案5 page.60 -->
                    <?php
                    $SQLstring = "SELECT * FROM cart,product,product_img where ip='" . $_SERVER['REMOTE_ADDR'] . "' AND orderid is NULL AND cart.p_id=product_img.p_id AND cart.p_id=product.p_id AND product_img.sort=1 ORDER BY cartid DESC";
                    $cart_rs = mysqli_query($link, $SQLstring);
                    $pTotal = 0; //設定累加變數$pTotal
                    ?>
                    <!-- 購物車 -->
                    <div class="row">
                        <div class="table-responsive-md" style="width:90%">
                            <table class="table table-hover mt-3">
                                <thead>
                                    <tr class="bg-primary" style="color:white;">
                                        <td width="10%">產品編號</td>
                                        <td width="10%">圖片</td>
                                        <td width="30%">名稱</td>
                                        <td width="15%">價格</td>
                                        <td width="15%">數量</td>
                                        <td width="20%">小計</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- 結帳表格跟 cart_content購物車 內容一樣 專案5 page.61 -->
                                    <?php while ($cart_data = mysqli_fetch_array($cart_rs)) { ?>
                                        <tr>
                                            <td><?php echo $cart_data['p_id']; ?></td>
                                            <td><img src="product_img/<?php echo $cart_data['img_file']; ?>" alt="<?php echo $cart_data['p_name']; ?>" class="img-fluid"></td>
                                            <td><?php echo $cart_data['p_name']; ?></td>
                                            <td>
                                                <h4 class="color_e600a0 pt-1">$<?php echo $cart_data['p_price']; ?></h4>
                                            </td>
                                            <td>
                                                <?php echo $cart_data['qty']; ?>
                                            </td>
                                            <td>
                                                <h4 class="color_e600a0 pt-1">$<?php echo $cart_data['p_price'] * $cart_data['qty']; ?></h4>
                                            </td>
                                        </tr>
                                        <!-- 計算累計、運費、總計1 page.22  -->
                                    <?php $pTotal += $cart_data['p_price'] * $cart_data['qty'];
                                    } ?>
                                </tbody>
                                <tfoot>
                                    <!-- 累計、運費、總計金額 專案5 page.64 -->
                                    <tr>
                                        <td colspan="7">累計:<?php echo $pTotal; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">運費:100</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="color_red">總計:<?php echo $pTotal + 100; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">
                                            <button type="button" id="btn04" name="btn04" class="btn btn-danger mr-2"><i class="fas fa-cart-arrow-down pr-2"></i>確認結帳</button>
                                            <button type="button" id="btn05" name="btn04" class="btn btn-warning" onclick="window.history.go(-1)"><i class="fas fa-undo-alt pr-2"></i>回上一頁</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="scontent">
        <!-- 引入服務說明 -->
        <?php require_once("scontent.php"); ?>
    </section>
    <section id="footer">
        <!-- 引入聯絡資訊 -->
        <?php require_once("footer.php"); ?>
    </section>
    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <!-- 引入聯絡資訊 -->
    <?php require_once("jsfile.php"); ?>

    <!-- 建立縣市碼後查詢鄉鎮市名稱放入 #myTown -->
    <script type="text/javascript">
        $(function() {
            // 選擇鄉鎮市
            $('#myCity').change(function() {
                var CNo = $('#myCity').val();
                $.ajax({
                    url: 'Town_ajax.php',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        CNo: CNo
                    },
                    success: function(data) {
                        if (data.c == true) {
                            $('#myTown').html(data.m); //鄉鎮市名稱 放入#myTown
                            // $('#myZip').val(""); //避免重新選擇縣市後郵遞區號還存在，所以在重新選擇縣市後郵遞區號欄位先清空
                        } else {
                            alert("Database reponse error:" + data.m);
                        }
                    },
                    error: function(data) {
                        alert("ajax request error");
                    }
                });
            });

            // 選擇鄉鎮市後，查詢郵遞區號放入#myZip,$zipcode page.94
            $('#myTown').change(function() {
                var AutoNo = $('#myTown').val();
                $.ajax({
                    url: 'Zip_ajax01.php',
                    type: 'get',
                    dataType: 'json',
                    data: {
                        AutoNo: AutoNo
                    },
                    success: function(data) {
                        if (data.c == true) {
                            $('#myzip').val(data.Post);
                            $('#add_label').html('郵遞區號：' + data.Post + data.Cityname + data.Name); //#zipcode 修改 #add_label
                        } else {
                            alert("Database reponse error:" + data.m);
                        }
                    },
                    error: function(data) {
                        alert("ajax request error");
                    }
                });
            });

            // 新增收件人"按鍵"處理程序 專案5 page.78
            $('#recipient').click(function() {
                var validate = 0,
                    msg = "";
                var cname = $("#cname").val();
                var mobile = $("#mobile").val();
                var myzip = $("#myzip").val();
                var address = $("#address").val();
                if (cname == "") {
                    msg = msg + "收件人不得為空白!;\n";
                    validate = 1;
                }
                if (mobile == "") {
                    msg = msg + "電話不得為空白!;\n";
                    validate = 1;
                }
                if (myzip == "") {
                    msg = msg + "郵遞區號不得為空白!;\n";
                    validate = 1;
                }
                if (address == "") {
                    msg = msg + "地址不得為空白!;\n";
                    validate = 1;
                }
                if (validate) {
                    alert(msg);
                    return false;
                }
                // 新增收件人寫入資料庫 專案5 page.80
                $.ajax({
                    url: 'addbook.php',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        cname: cname,
                        mobile: mobile,
                        myzip: myzip,
                        address: address,
                    },
                    success: function(data) {
                        if (data.c == true) {
                            alert(data.m);
                            window.location.reload();
                        } else {
                            alert("Database reponse error:" + data.m);
                        }
                    },
                    error: function(data) {
                        alert("ajax request error");
                    }
                });
            });

            // 更換收件人處理程序  專案5 page.85-87
            $('input[name=gridRadios]').change(function(){
                var addressid = $(this).val();
                $.ajax({
                    url: 'changeaddr.php',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        addressid:addressid,
                    },
                    success: function(data){
                        if(data.c == true){
                            alert(data.m);
                            window.location.reload();
                        } else{
                            alert("Database response error:" + data.m);
                        }
                    },
                    error: function(data){
                        alert("ajax request error");
                    }
                });
            });

            // 系統進行結帳處理程序 js 專案5 page.90
            $('#btn04').click(function(){
                let msg = "系統將進行結帳處理，請確認產品金額與收件人是否正確!";
                if(!confirm(msg)) return false;
                $("#loading").show();
                var addressid = $('input[name=gridRadios]:checked').val();
                debugger;
                $.ajax({
                    url: 'addorder.php',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        addressid:addressid,
                    },
                    success: function(data){
                        if(data.c == true){
                            alert(data.m);
                            window.location.href="index.php";
                        } else{
                            alert("Database response error:" + data.m);
                        }
                    },
                    error: function(data){
                        alert("ajax request error");
                    }
                });
            });
        });
    </script>

    <!-- *Modal  專案5 page.42 -->
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Launch demo modal
    </button>

    <!-- *Modal 模擬態 -->
    <?php
    // 取得資料庫所有收件人資料
    $SQLstring = sprintf("SELECT *,city.Name AS ctName,town.Name AS toName FROM addbook,city,town WHERE emailid='%d' AND addbook.myzip=town.Post AND town.AutoNo=city.AutoNo", $_SESSION['emailid']);
    $addbook_rs = mysqli_query($link, $SQLstring);
    ?>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <!-- modal-lg 版面設定 -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">收件人資訊</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col">
                                <input type="text" name="cname" id="cname" class="form-control" placeholder="收件者姓名">
                            </div>
                            <div class="col">
                                <input type="number" name="mobile" id="mobile" class="form-control" placeholder="收件者電話">
                            </div>
                            <div class="col">
                                <!-- javascript -> #myCity -->
                                <select name="myCity" id="myCity" class="form-control">
                                    <option value="">請選擇市區</option>
                                    <!-- 資料庫-選擇市區 -->
                                    <?php
                                    $city = "SELECT * FROM `city` where State=0";
                                    $city_rs = mysqli_query($link, $city);
                                    while ($city_rows = mysqli_fetch_array($city_rs)) {
                                    ?>
                                        <option value="<?php echo $city_rows['AutoNo']; ?>">
                                            <?php echo $city_rows['Name']; ?>
                                        </option>
                                    <?php }
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <!-- javascript -> #myTown -->
                                <select name="myTown" id="myTown" class="form-control">
                                    <option value="">請選擇地區</option>

                                </select><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input type="hidden" name="myzip" id="myzip" value="">
                                <!-- javascript -> #add_label -->
                                <label for="address" id="add_label" name="add_label">郵遞區號：</label>
                                <input type="text" name="address" id="address" class="form-control" placeholder="地址">
                            </div>
                        </div>
                        <div class="row mt-4 justify-content-center">
                            <div class="col-auto">
                                <!-- 新增收件人處理程序 專案5 page.77 -->
                                <button type="button" class="btn btn-success" id="recipient" name="recipient">新增收件人</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <!-- 收件人表格 -->
                    <div class="row">
                        <table class="table">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">收件者姓名</th>
                                    <th scope="col">電話</th>
                                    <th scope="col">地址</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- 資料庫-建立其他收件人資料取代 專案5 page.69 
                                     $data['setdefault']=預設收件人 -->
                                <?php while ($data = mysqli_fetch_array($addbook_rs)) { ?>
                                    <tr>
                                        <th scope="row"><input type="radio" name="gridRadios" id="gridRadios[]" value="<?php echo $data['addressid'] ?>" <?php echo ($data['setdefault']) ? 'checked' : ''; ?>></th>
                                        <td><?php echo $data['cname']; ?></td>
                                        <td><?php echo $data['mobile']; ?></td>
                                        <td><?php echo $data['myzip'] . $data['ctName'] . $data['toName'] . $data['address']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- 關閉按鈕 justify-content-center置中 -->
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- 建立登入時loading功能 專案四 page.70                                           -->
    <div id="loading" name="loading" style="display:none;position:fixed;width:100%;height:100%;top:0;left:0;background-color:rgba(255,255,255,.5);z-index:9999;"><i class="fas fa-spinner fa-spin fa-5x fa-fw" style="position:absolute;top:50%;left:50%;"></i></div>
</body>

</html>
<?php
// function activeShow($num, $chkPoint)
// {
//     return (($num == $chkPoint) ? "active" : "");
// }
?>