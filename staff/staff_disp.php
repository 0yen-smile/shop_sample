<?php

session_start();
session_regenerate_id(true);
if(isset($_SESSION['login']) == false)
{
    print 'ログインされていません<br />';
    print '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
    exit();
}
else
{
    print $_SESSION['staff_name'];
    print 'さんログイン中<br />';
    print '<br />';
}

?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>参照画面</title>
    </head>
    <body>
        <?php 
        try
        {
            $staff_code = $_GET['staffcode'];

            // DBへの接続
            $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
            $user = 'root';
            $password = '';
            $dbh = new PDO($dsn, $user, $password);
            $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // DBへの命令
            $sql = 'SELECT name FROM mst_staff WHERE code = ?';
            $stmt = $dbh->prepare($sql);
            $data[] = $staff_code;
            $stmt -> execute($data);

            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            $staff_name = $rec['name'];

            // DBから切断
            $dbh = null;
        }
        catch(Exception $e)
        {
            // データベースに障害が発生した場合、以下のプログラムが動く
            print 'ただいま障害により大変ご迷惑をおかけしております。';
            exit();
        }
        
        ?>

        スタッフ参照画面<br />
        <br />
        スタッフコード<br />
        <?php print $staff_code;?>
        <br />
        スタッフ名<br />
        <?php print $staff_name;?>
        <br />
        <br />
        <form>
            <input type ="button" onclick="history.back()" value="戻る">
        </form>
        
    </body>
    </html>