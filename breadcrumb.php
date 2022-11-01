<?php
$level1Open = "";
$level2Open = "";
$level3Open = "";  //第三層  page.53
if(isset($_GET['p_id']) && $_GET['p_id']!=""){
    //使用p_id產品代碼取出資料
    //處理第一層
    $SQLstring = sprintf("SELECT * FROM product,pyclass,(SELECT classid as upclassid, level as uplevel,cname as upcname FROM pyclass WHERE level=1) as uplevel WHERE product.classid=pyclass.classid AND pyclass.uplink=uplevel.upclassid AND product.p_id=%d",$_GET['p_id']);
    $classid_rs = mysqli_query($link, $SQLstring);
    $data = mysqli_fetch_array($classid_rs);
    $level1Cname = $data['cname'];
    $level1Upclassid=$data['upclassid'];
    $level1=$data['uplevel'];
    $level1Open = '<li class="breadcrumb-item"><a href="drugstore.php?classid='.$level1Upclassid.'&level='.$level1.'">'.$level1Cname.'</a></li>';
    //處理第二層
    $level2Cname = $data['cname'];
    $level2Classid = $data['classid'];
    $level2Open = '<li class="breadcrumb-item"><a href="drugstore.php?classid='.$level2Classid.'">'.$level2Cname.'</a></li>';//'&level='.$level1.
    //處理第三層
    $level3Open='<li class="breadcrumb-item active" aria-current="page">'.$data['p_name'].'</li>';
}
if(isset($_GET['search_name'])){
    //使用關鍵字查詢 page.30
    $level1Open='<li class="breadcrumb-item active" aria-current="page">關鍵字查詢：'.$_GET['search_name'].'</li>';
}
elseif (isset($_GET['level']) && isset($_GET['classid'])) {
    //選擇第一層類別
    $SQLstring = sprintf("SELECT * FROM pyclass WHERE level=%d AND classid=%d", $_GET['level'], $_GET['classid']);
    $classid_rs = mysqli_query($link, $SQLstring);
    $data = mysqli_fetch_array($classid_rs);
    $level1Cname = $data['cname'];
    $level1Open = '<li class="breadcrumb-item active" aria-current="page">' . $level1Cname . '</li>';
} elseif (isset($_GET['classid'])) {
    //選擇第二層類別
    $SQLstring = sprintf("SELECT * FROM pyclass WHERE level=2 AND classid=%d", $_GET['classid']);
    $classid_rs = mysqli_query($link, $SQLstring);
    $data = mysqli_fetch_array($classid_rs);
    $level2Cname = $data['cname'];
    $level2Uplink = $data['uplink'];
    $level2Open = '<li class="breadcrumb-item active" aria-current="page">' . $level2Cname . '</li>';
    //無加處理上一層
    $SQLstring = sprintf("SELECT * FROM pyclass WHERE level=1 AND classid=%d", $level2Uplink);
    $classid_rs = mysqli_query($link, $SQLstring);
    $data = mysqli_fetch_array($classid_rs);
    $level1Cname = $data['cname'];
    $level1 = $data['level'];
    $level1Open = '<li class="breadcrumb-item"><a href="drugstore.php?classid=' . $level2Uplink . '&level=' . $level1 . '">' . $level1Cname . '</a></li>';
}
?>
<!-- bootstrap4.6.1 -> component -> (Breadcrumb) -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">首頁</a></li>
        <?php echo $level1Open . $level2Open . $level3Open; ?>
        <!-- <li class="breadcrumb-item"><a href="#">彩妝專區</a></li>
                            <li class="breadcrumb-item active" aria-current="page">隔離/防曬/飾底乳</li> -->
    </ol>
</nav>