<div class="sidebar">
    <!-- 建立關鍵字查詢 page.28 -->
    <form action="drugstore.php" method="get" name="search" id="search">
        <div class="input-group">
            <input type="text" name="search_name" id="search_name" class="form-control" placeholder="Search..." value="<?php echo (isset($_GET['search_name']))? $_GET['search_name']:''; ?>"required>
            <span class="input-group-btn"><button class="btn btn-default" type="submit"><i class="fas fa-search fa-lg"></i></button></span>
        </div>
    </form>
</div>
<?php
//列出產品類別第一層,如果使用類別查詢需取得上一層類別
$SQLstring = "SELECT * FROM pyclass WHERE level=1 ORDER BY sort";
$pyclass01 = mysqli_query($link, $SQLstring);
$i = 1;  //控制編號順序
?>
<div class="accordion" id="accordionExample">
    <?php while ($pyclass01_Rows = mysqli_fetch_array($pyclass01)) { $i=$pyclass01_Rows['classid']; ?>
        <div class="card">
            <div class="card-header" id="headingOne<?php echo $i; ?>">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne<?php echo $i; ?>" aria-expanded="true" aria-controls="collapseOne<?php echo $i; ?>" style="font-size:x-large">
                        <i class="fas <?php echo $pyclass01_Rows['fonticon']; ?> fa-lg fa-fw"></i><?php echo $pyclass01_Rows['cname']; ?>
                    </button>
                </h2>
            </div>
            <?php
            //增加sidebar開啟位置page.74
            if(isset($_GET['p_id'])){   //如果使用產品查詢，需取得類別編號上一層類別
                $SQLstring="SELECT uplink FROM pyclass,product WHERE pyclass.classid=product.classid AND p_id=".$_GET['p_id'];
                $classid_rs=mysqli_query($link, $SQLstring);
                $data=mysqli_fetch_array($classid_rs);
                $ladder=$data['uplink'];
            }
            //使用第一層類別查詢                                     page.26
            elseif(isset($_GET['level']) && $_GET['level']==1){
                $ladder=$_GET['classid'];
            }
            //如果使用類別查詢需取得上一層類別         page.8解決sidebar不準確
            elseif(isset($_GET['classid'])){
                $SQLstring="SELECT uplink FROM pyclass WHERE level=2 AND classid=".$_GET['classid'];
                $classid_rs= mysqli_query($link,$SQLstring);
                $data= mysqli_fetch_array($classid_rs);
                $ladder= $data['uplink'];
            }
            else{
                $ladder=1;
            }
            //列印產品類別第二層
            $SQLstring = "SELECT * FROM pyclass WHERE level=2 and uplink= " . $pyclass01_Rows['classid'] . " ORDER BY sort";
            $pyclass02 = mysqli_query($link, $SQLstring);
            ?>
            <div id="collapseOne<?php echo $i; ?>" class="collapse <?php echo ($i == $ladder /* 1改$ladder */ ) ? 'show' : ''; ?>" aria-labelledby="headingOne<?php echo $i; ?>" data-parent="#accordionExample">
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <?php while ($pyclass02_Rows = mysqli_fetch_array($pyclass02)) { ?>
                                <tr>
                                    <td><em class="fa <?php echo $pyclass02_Rows['fonticon']; ?>"></em><a href="drugstore.php?classid=<?php echo $pyclass02_Rows['classid']; ?>"><?php echo $pyclass02_Rows['cname']; ?></a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php $i++;
    } ?>
</div>