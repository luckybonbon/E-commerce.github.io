<div class="card mb-3">
    <div class="row no-gutters">
        <!-- 建立圖片展示區 page.38 -->
        <div class="col-md-3">
            <?php
            //取得產品圖片檔名資料
            $SQLstring = sprintf("SELECT * FROM product_img WHERE product_img.p_id=%d ORDER BY sort", $_GET['p_id']);
            $img_rs = mysqli_query($link, $SQLstring);
            $imgList = mysqli_fetch_array($img_rs);
            ?>
            <img id="showGoods" name="showGoods" src="product_img/<?php echo $imgList['img_file']; ?>" alt="<?php echo $data['p_name']; ?>" title="<?php echo $data['p_name']; ?>" class="img-fluid">
            <div class="row mt-2">
                <?php do { ?>
                    <div class="col-md-4"><a href="product_img/<?php echo $imgList['img_file']; ?>" rel="group" class="fancybox" title="<?php echo $data['p_name']; //加入rel class page.64 
                                                                                                                                        ?>">
                            <img src="product_img/<?php echo $imgList['img_file']; ?>" title="<?php echo $data['p_name']; ?>" class="img-fluid"></a>
                    </div>
                <?php } while ($imgList = mysqli_fetch_array($img_rs)); ?>
                <!-- <div class="col-md-4"><a href="product_img/zoom2555552.webp">
                                            <img src="product_img/zoom2555552.webp" title="Biore 蜜妮淨嫩沐浴乳 浪漫櫻花香 水采保濕型 1000g" class="img-fluid"></a>
                                    </div>
                                    <div class="col-md-4"><a href="product_img/zoom2555553.webp">
                                            <img src="product_img/zoom2555553.webp" title="Biore 蜜妮淨嫩沐浴乳 浪漫櫻花香 水采保濕型 1000g" class="img-fluid"></a>
                                    </div> -->
            </div>
        </div>
        <!-- 建立產品說明區 page.42 -->
        <div class="col-md-4 pl-5">
            <div class="card-body mt-3">
                <h5 class="card-title"><?php echo $data['p_name']; ?></h5>
                <p class="card-text"><?php echo $data['p_intro']; ?></p>
                <h4 class="color_e600a0">$<?php echo $data['p_price']; ?></h4>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <span class="input-group-text color-success" id="inputGroup-sizing-lg">數量</span>
                            </div>
                            <input type="number" class="form-control" aria-label="Sizing example input" id="qty" name="qty" value="1" aria-describedby="inputGroup-sizing-lg">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!--  page.76  -->
                        <button name="button01" id="button01" type="button" class="btn btn-success btn-lg" onclick="addcart(<?php echo $data['p_id']; ?>)">加入購物車</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
//require_once('drop-box.php'); // 建立產品詳細內容 drop-box.php page.50 
echo $data['p_content'];   //php產品資料顯示 page.59
?>