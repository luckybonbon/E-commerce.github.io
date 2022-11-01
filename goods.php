<?php require_once('Connections/conn_db.php'); ?>
<?php (!isset($_SESSION)) ? session_start() : ""; ?>
<?php require_once('php_lib.php'); ?>
<!-- page.89 -->
<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <!-- 引入網頁標頭 -->
    <?php require_once("headfile.php"); ?>
    <!-- page.63 -->
    <link rel="stylesheet" href="fancybox-2.1.7/source/jquery.fancybox.css">
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
                    <!-- 建立breadcrumb level 2  page.16 
                         建立類別分項-->
                    <?php require_once("breadcrumb.php"); ?>
                    <!-- page.35 -->
                    <!-- 引入產品詳細資訊page.87 -->
                    <?php require_once("goods_content.php"); 
                    ?>
                    
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
    <!-- 引入javascript檔 -->
    <?php require_once("jsfile.php"); ?>
    <script type="text/javascript" src="fancybox-2.1.7/source/jquery.fancybox.js"></script>  <!-- page.63 -->
    <!-- 建立切換主圖功能 javascript page.61 -->
    <script type="text/javascript">
        $(function(){
            //定義在滑鼠滑過圖片檔名填入主圖src中 page.61
            $(".card .row.mt-2 .col-md-4 a").mouseover(function(){
                var imgsrc=$(this).children("img").attr("src");
                $("#showGoods").attr({"src":imgsrc});
            });
            //將子圖片放到lightbox展示 page.63
            $(".fancybox").fancybox();
        });
    </script>
    
    <script type="text/javascript">
        
    </script>
</body>

</html>
<?php
// function activeShow($num, $chkPoint)
// {
//     return (($num == $chkPoint) ? "active" : "");
// }
?>