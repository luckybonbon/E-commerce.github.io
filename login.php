<?php require_once('Connections/conn_db.php'); ?>
<?php (!isset($_SESSION)) ? session_start() : ""; ?>
<?php require_once('php_lib.php'); ?>
<?php
// 取得要返回的php頁面 專案四 page.72
if (isset($_GET['sPath'])) {
    $sPath = $_GET['sPath'] . ".php";
} else {
    // 登入完成預設要進入首頁
    $sPath = "index.php";
}
// 檢查是否完成登入驗證
if (isset($_SESSION['login'])) {
    header(sprintf("location: %s", $sPath));
}
?>
<!-- page.89 -->
<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <!-- 引入網頁標頭 -->
    <?php require_once("headfile.php"); ?>
    <style type="text/css">
        /* 專案開發4 會員登入專用css設定1 page.67 */
        .col-md-10 {
            background-repeat: no-repeat;
            background-image: linear-gradient(rgbA(104, 145, 162), rgb(12, 97, 33));
        }

        .mycard.mycard-container {
            max-width: 400px;
            height: 450px;
        }

        .mycard {
            background-color: #f7f7f7;
            padding: 20px 25px 30px;
            margin: 0 auto 25px;
            margin-top: 50px;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            border-radius: 10px;
        }

        /* 專案開發4 會員登入專用css設定2 page.68 */
        .profile-img-card {
            margin: 0 auto 10px auto;
            display: block;
            width: 100px;
        }

        .profile-name-card {
            font-size: 20px;
            text-align: center;
        }

        .form-signin input[type="email"],
        .form-signin input[type="password"],
        .form-signin button {
            width: 100%;
            height: 44px;
            font-size: 16px;
            display: block;
            margin-bottom: 20px;
        }

        /* 專案開發4 會員登入專用css設定3 page.69 */
        .btn.btn-signin {
            font-weight: 700;
            background-color: rgb(104, 145, 162);
            color: white;
            height: 38px;
            transition: background-color 1s;
        }

        .btn.btn-signin:hover,
        .btn.btn-signin:active,
        .btn.btn-signin:focus {
            background-color: rgb(12, 97, 33);
        }

        .other a {
            color: rgb(104, 145, 162);
        }

        .other a:hover,
        .other a:active,
        .other a:focus {
            color: rgb(12, 97, 33);
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
                    <!-- 會員登入html頁面 專案4 page.66 -->
                    <div class="mycard mycard-container">
                        <img src="images/logo03.svg" class="profile-img-card" id="profile-img">
                        <p id="profile-name" class="profile-name-card">電商藥妝：會員登入</p>
                        <form action="" method="POST" class="form-signin" id="form1">
                            <input type="email" id="inputAccount" name="inputAccount" class="form-control" placeholder="Account" required autofocus>
                            <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
                            <button class="btn btn-signin mt-4" type="submit">Sign in</button>
                        </form>
                        <div class="other mt-5 text-center">
                            <!-- 註冊連結 -->
                            <a href="register.php">New user</a><a href="#">Forgot the password</a>
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
    <!-- 建立md5的密碼驗證 page.126 -->
    <script type="text/javascript" src="commlib.js"></script>

    <!-- 建立會員登入功能1 page.73-76                                                  -->
    <script type="text/javascript">
        $(function() {
            $("#form1").submit(function() {
                const inputAccount = $("#inputAccount").val();
                const inputPassword = $("#inputPassword").val();  // 建立md5的密碼驗證 page.126  //MD5($("#inputPassword").val()) 驗證有問題
                $("#loading").show();
                // 利用$ajax函數呼叫後台的auth_user.php驗證帳號密碼
                $.ajax({
                    url: 'auth_user.php',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        inputAccount: inputAccount,
                        inputPassword: inputPassword,
                    },
                    success: function(data) {
                        if (data.c == true) {
                            alert(data.m);
                            // window.location.reload();
                            window.location.href = "<?php echo $sPath; ?>";
                        } else {
                            alert(data.m);
                        }
                    },
                    error: function(date) {
                        alert("系統目前無法連接到後台資料庫");
                    }
                });
            });
        });
    </script>

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