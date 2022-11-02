<?php require_once('Connections/conn_db.php'); ?>
<?php (!isset($_SESSION)) ? session_start() : ""; ?>
<?php require_once('php_lib.php'); ?>
<!-- 使用者登入驗證 專案6 page.31 -->
<?php
if (!isset($_SESSION['login'])) {
    $sPath = "login.php?sPath=orderlist";
    header(sprintf("Location: %s", $sPath));
}
?>
<!-- page.89 -->
<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <!-- 引入網頁標頭 -->
    <?php require_once("headfile.php"); ?>
    <!-- 訂單查詢-超連結樣式 專案6 page.10 -->
    <style text="text/css">
        /* 超連結底線取消 */
        .card-header a {
            text-decoration: none;
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
                    <!-- 引入訂單查詢 -->
                    <?php //require_once("order_content.php"); 
                    ?>
                    <!-- 建立訂單查詢PHP 專案6 page.17 -->
                    <?php
                    //建立訂單查詢
                    $maxRows_rs = 1;  //分頁設定數量
                    $pageNum_rs = 0;  //起始頁=0
                    if (isset($_GET['pageNum_order_rs'])) {
                        $pageNum_rs = $_GET['pageNum_order_rs'];
                    }
                    $startRow_rs = $pageNum_rs * $maxRows_rs;
                    $queryFirst = sprintf("SELECT *,uorder.create_date as udate FROM uorder,addbook WHERE uorder.emailid='%d' AND uorder.addressid = addbook.addressid ORDER BY uorder.create_date DESC", $_SESSION['emailid']);
                    $query = sprintf("%s LIMIT %d, %d", $queryFirst, $startRow_rs, $maxRows_rs);
                    $order_rs = mysqli_query($link, $query);
                    $i = 1;  //控制第一筆訂單開啟
                    ?>
                    <!-- 訂單查詢樣板 bootstrap 4.6 -> collapse -> Accordion example 專案6 page.5-8 -->
                    <h3>電商藥妝：訂單查詢</h3>
                    <!-- 建立while結束處理 page.18 -->
                    <?php if (mysqli_fetch_array($order_rs) != 0) {
                        $order_rs = mysqli_query($link, $query);  //重置mysqli_fetch_array($order_rs)，解決指令造成第一個訂單找不到的問題
                    ?>
                        <div class="accordion" id="accordion_order">
                            <!-- 建立while結束處理 page.18 -->
                            <!-- 只有一筆資料時，抓不到資料，兩筆才可以..... !!!!!已解決!!!!!-->
                            <?php while ($data01 = mysqli_fetch_array($order_rs)) {  ?>
                                <div class="card">
                                    <!-- 修改 headingOne -> heading1 ; collapseOne -> collapse1  page.19 -->
                                    <div class="card-header" id="heading1<?php echo $i; ?>"><a data-toggle="collapse" href="#collapse1<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse1<?php echo $i; ?>">
                                            <div class="table-responsive-md">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <td width="10%">訂單編號</td>
                                                            <td width="20%">下單日期時間</td>
                                                            <td width="15%">付款方式</td>
                                                            <td width="15%">訂單狀態</td>
                                                            <td width="10%">收件人</td>
                                                            <td width="20%">地址</td>
                                                            <td width="10%">備註</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><?php echo $data01['orderid']; ?></td>
                                                            <td><?php echo $data01['udate']; ?></td>
                                                            <td><?php echo epayCode($data01['howpay']); ?></td>
                                                            <td><?php echo processCode($data01['status']); ?></td>
                                                            <td><?php echo $data01['cname']; ?></td>
                                                            <td><?php echo $data01['address']; ?></td>
                                                            <td><?php echo $data01['remark']; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </a>
                                    </div>

                                    <!-- 建立處理訂單詳細商品資料列表 專案6 page.23 -->
                                    <?php
                                    //處理訂單詳細商品資料列表
                                    $subQuery = sprintf("SELECT * FROM cart,product,product_img WHERE cart.orderid = '%s' AND cart.p_id = product.p_id AND product.p_id = product_img.p_id AND product_img.sort = '1' ORDER BY cart.create_date DESC", $data01['orderid']);
                                    $details_rs = mysqli_query($link, $subQuery);
                                    $ptotal = 0;
                                    ?>
                                    <!-- collapse下拉內容  修改collapseOne -> collapse1 ; headingOne -> heading1 ; #accordion_order page.23-->
                                    <div id="collapse1<?php echo $i; ?>" class="collapse <?php echo ($i == 1) ? 'show' : ''; ?>" aria-labelledby="heading1<?php echo $i; ?>" data-parent="#accordion_order">
                                        <div class="card-body">
                                            <!-- 複製table -->
                                            <div class="table-responsive-md">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr class="table-primary">
                                                            <td width="10%">產品編號</td>
                                                            <td width="20%">圖片</td>
                                                            <td width="15%">名稱</td>
                                                            <td width="15%">價格</td>
                                                            <td width="10%">數量</td>
                                                            <td width="20%">小計</td>
                                                            <td width="10%">狀態</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php while ($data02 = mysqli_fetch_array($details_rs)) { ?>
                                                            <tr>
                                                                <td><?php echo $data02['p_id']; ?></td>
                                                                <td><img src="product_img/<?php echo $data02['img_file']; ?>" alt="<?php echo $data02['p_name']; ?>" class="img-fluid"></td>
                                                                <td><?php echo $data02['p_name']; ?></td>
                                                                <td>
                                                                    <h4 class="color_e600a0 pt-1">$<?php echo $data02['p_price']; ?></h4>
                                                                </td>
                                                                <td>
                                                                    <h4 class="color_e600a0 pt-1"><?php echo $data02['qty']; ?></h4>
                                                                </td>
                                                                <td>
                                                                    <h4 class="color_e600a0 pt-1">$<?php echo $data02['p_price'] * $data02['qty']; ?></h4>
                                                                </td>
                                                                <td><?php echo processCode($data02['status']); ?></td>
                                                            </tr>
                                                        <?php
                                                            $ptotal += $data02['p_price'] * $data02['qty'];
                                                        }  ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="7">累計:<?php echo $ptotal; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="7">運費:100</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="7" class="color_red">總計:<?php echo $ptotal + 100; ?></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <!-- 建立while結束處理 page.18 -->
                            <?php $i++;
                            }  ?>
                        </div>
                        <div class="row mt-2"></div>
                        <!-- 建立分頁程式 專案6 page.29 start -->
                        <?php if ($order_rs->num_rows != 0) { ?>
                            <?php while ($order_rs_Rows = mysqli_fetch_array($order_rs)) {  ?>
                                <?php if ($i % 4 == 1) { ?><div class="row text-center"><?php } ?>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <a href="goods.php?p_id=<?php echo $order_rs_Rows['p_id']; ?>">
                                                <!--page.69-->
                                                <img src="product_img/<?php echo $order_rs_Rows['img_file']; ?>" class="card-img-top" alt="<?php echo $order_rs_Rows['p_name']; ?>" title="<?php echo $order_rs_Rows['p_name']; ?>">
                                            </a>
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo $order_rs_Rows['p_name']; ?></h5>
                                                <p class="card-text"><?php echo mb_substr($order_rs_Rows['p_intro'], 0, 30, "utf-8"); ?></p>
                                                <p>NT<?php echo $order_rs_Rows['p_price']; ?></p>
                                                <!-- page.69 -->
                                                <a href="goods.php?p_id=<?php echo $order_rs_Rows['p_id']; ?>" class="btn btn-primary">更多資訊</a>
                                                <!-- <a href="#" class="btn btn-success">放購物車</a> -->
                                                <!-- page.81 -->
                                                <button type="button" id="button01[]" name="button01[]" class="btn btn-success" onclick="addcart(<?php echo $order_rs_Rows['p_id']; ?>)">加入購物車</button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if ($i % 4 == 0 || $i == $order_rs->num_rows) { ?>
                                    </div><?php } ?>
                            <?php $i++;
                            } ?>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <?php    //建立分頁程式page.90
                                    //取得目前頁數
                                    if (isset($_GET['totalRows_order_rs'])) {
                                        $totalRows_rs = $_GET['totalRows_order_rs'];
                                    } else {
                                        $all_rs = mysqli_query($link, $queryFirst);
                                        $totalRows_rs = mysqli_num_rows($all_rs);
                                    }
                                    $totalPages_rs = ceil($totalRows_rs / $maxRows_rs) - 1;
                                    ?>
                                    <?php
                                    //呼叫分頁功能
                                    $prev_rs = "&laquo;";
                                    $next_rs = "&raquo;";
                                    $separator = "|";
                                    $max_links = 20;
                                    $pages_rs = buildNavigation($pageNum_rs, $totalPages_rs, $prev_rs, $next_rs, $separator, $max_links, true, 3, "order_rs");
                                    ?>
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-center">
                                            <?php echo $pages_rs[0] . $pages_rs[1], $pages_rs[2]; ?>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        <!-- 建立分頁程式 專案6 page.29 end -->
                        <?php } else { ?>
                            <!-- page.23 -->
                            <div class="alert alert-warning" role="alert">
                                抱歉!目前沒有相關的產品。
                            </div>
                        <?php } ?>
                        <!-- 建立while結束處理 page.18 -->
                    <?php  } else {  ?>
                        <div class="alert alert-info" role="alert">
                            抱歉!目前還沒有任何的訂單
                        </div>
                    <?php  }  ?>
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
</body>

</html>
<?php
function epayCode($sel = 1)   //建立epayCode function 專案6 page.23
{
    switch ($sel) {
        case '1':
            $msg = "貨到付款";
            break;
        case '2':
            $msg = "信用卡付款";
            break;
        case '3':
            $msg = "銀行轉帳";
            break;
        case '4':
            $msg = "電子支付";
            break;
    }
    return ($msg);
}
function processCode($mode = 1)   //建立processCode function
{
    switch ($mode) {
        case '1':
            $msg = "處理中";
            break;
        case '2':
            $msg = "運送中";
            break;
        case '3':
            $msg = "收貨完成";
            break;
        case '4':
            $msg = "退貨中";
            break;
    }
    return ($msg);
}
?>