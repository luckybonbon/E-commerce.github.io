<?php
//建立購物車資料庫查詢 page.17
$SQLstring = "SELECT * FROM cart,product,product_img WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "' AND orderid IS NULL AND cart.p_id=product_img.p_id AND cart.p_id=product.p_id AND product_img.sort=1 ORDER BY cartid DESC";
$cart_rs = mysqli_query($link, $SQLstring);
$pTotal = 0;   //設定累加變數$pTotal  page.21
?>
<!-- 建立購物車樣板 專案開發4-page4 -->
<h3>電商藥粧：購物車</h3>
<?php if ($cart_rs->num_rows != 0) { ?>
    <!-- 建立form表單 page.42 -->
    <form action="checkout.php" method="post" id="cartForm1">
        <!-- 回上一頁、繼續購物 page.38 -->
        <a href="index.php" id="btn01" name="btn01"><button type="button" id="btn01" class="btn btn-success">繼續購物</button></a>
        <button type="button" id="btn02" class="btn btn-danger" onclick="window.history.go(-1)">回到上一頁</button>
        <button type="button" id="btn03" class="btn btn-warning" onclick="btn_confirmLink('確定清空購物車?','shopcart_del.php?mode=2');">清空購物車</button>
        <!--清空購物車功能 page.31-->
        <button type="submit" id="btn04" name="btn04" class="btn btn-info">前往結帳</button>
        <!-- 建立響應是表格 專案開發4-page7 -->
        <div class="table-responsive-md">
            <table class="table table-hover mt-3">
                <thead>
                    <tr class="table-warning">
                        <td width="10%">產品編號</td>
                        <td width="10%">圖片</td>
                        <td width="25%">名稱</td>
                        <td width="15%">價格</td>
                        <td width="10%">數量</td>
                        <td width="15%">小計</td>
                        <td width="15%">下次再買</td>
                    </tr>
                </thead>
                <!-- 表格內容 專案開發4-page8 -->
                <tbody>
                    <!-- 表格內容1 page10 -->
                    <!-- 將查詢結果放入表格中 page18 -->
                    <?php while ($cart_data = mysqli_fetch_array($cart_rs)) { ?>
                        <tr>
                            <td><?php echo $cart_data['p_id']; ?></td>
                            <td><img src="product_img/<?php echo $cart_data['img_file']; ?>" alt="<?php echo $cart_data['p_name']; ?>" class="img-fluid"></td>
                            <td><?php echo $cart_data['p_name']; ?></td>
                            <td>
                                <h4 class="color_e600a0 pt-1">$<?php echo $cart_data['p_price']; ?></h4>
                            </td>
                            <td>
                                <div class="input-group">
                                    <!-- min,max,cartid page.43 -->
                                    <input type="number" class="form-control" id="qty[]" name="qty[]" min="1" max="49" value="<?php echo $cart_data['qty']; ?>" cartid="<?php echo $cart_data['cartid']; ?>" required>
                                </div>
                            </td>
                            <td>
                                <h4 class="color_e600a0 pt-1">$<?php echo $cart_data['p_price'] * $cart_data['qty']; ?></h4>
                            </td>
                            <td><button type="button" id="btn[]" name="btn[]" class="btn btn-danger" onclick="btn_confirmLink('確定刪除本資料?','shopcart_del.php?mode=1&cartid=<?php echo $cart_data['cartid']; ?>');">取消</button></td>
                            <!-- onclick page.27 -->
                        </tr>
                        <!-- 計算累計、運費、總計1 page.22  -->
                    <?php $pTotal += $cart_data['p_price'] * $cart_data['qty'];
                    } ?>
                    <!-- 表格內容2 page11 -->
                    <!-- <tr>
                                    <td>1</td>
                                    <td><img src="product_img/zoom-front-174388.webp" alt="Maybelline 媚比琳純淨礦物極效幻膚BB凝露 升級版 SPF 50/PA++++ 01白皙色" class="img-fluid"></td>
                                    <td>Maybelline 媚比琳純淨礦物極效幻膚BB凝露 升級版 SPF 50/PA++++ 01白皙色</td>
                                    <td>
                                        <h4 class="color_e600a0 pt-1">$125</h4>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="qty[]" name="qty[]" value="1">
                                        </div>
                                    </td>
                                    <td>
                                        <h4 class="color_e600a0 pt-1">$125</h4>
                                    </td>
                                    <td><button type="button" id="btn[]" name="btn[]" class="btn btn-danger">取消</button></td>
                                </tr> -->
                    <!-- 表格內容3 page13 -->
                    <!-- <tr>
                                    <td>1</td>
                                    <td><img src="product_img/zoom-front-2077811.webp" alt="SHISEIDO 資生堂ELIXIR怡麗絲爾奢潤進化晶亮防護露SPF50+ PA++++ 30ml" class="img-fluid"></td>
                                    <td>SHISEIDO 資生堂ELIXIR怡麗絲爾奢潤進化晶亮防護露SPF50+ PA++++ 30ml</td>
                                    <td>
                                        <h4 class="color_e600a0 pt-1">$125</h4>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="qty[]" name="qty[]" value="1">
                                        </div>
                                    </td>
                                    <td>
                                        <h4 class="color_e600a0 pt-1">$125</h4>
                                    </td>
                                    <td><button type="button" id="btn[]" name="btn[]" class="btn btn-danger">取消</button></td>
                                </tr> -->
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7">累計:<?php echo $pTotal; ?></td>
                    </tr>
                    <tr>
                        <td colspan="7">運費:100</td>
                    </tr>
                    <tr>
                        <td colspan="7" class="color_red">總計:<?php echo $pTotal + 100; ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </form>
    <!-- 加入購物車無資料回應 page.36 -->
<?php } else { ?>
    <div class="alert alert-warning" role="alert">
        抱歉!目前購物車沒有相關產品。
    </div>
<?php } ?>