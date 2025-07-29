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
        <title>登録画面</title>
    </head>
    <body>
        <?php 
        
        // データベース障害対策（エラートラップ）
        try
        {
            $staff_code = $_POST['code'];
            $staff_name = $_POST['name'];
            $staff_pass = $_POST['pass'];
            
            // 入力データの安全対策（サニタイジング）
            $staff_name = htmlspecialchars($staff_name,ENT_QUOTES,'UTF-8');
            $staff_pass = htmlspecialchars($staff_pass,ENT_QUOTES,'UTF-8');

            // データベース接続
            $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
            $user = 'root';
            $password = '';
            $dbh = new PDO($dsn, $user, $password);
            $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // データベースへの命令（レコードを追加）
            $sql = 'UPDATE mst_staff SET name =?, password=? WHERE code=?';
            $stmt = $dbh -> prepare($sql);
            $data[] = $staff_name;
            $data[] = $staff_pass;
            $data[] = $staff_code;
            $stmt -> execute($data);

            // データベースから切断
            $dbh = null;

        }
        catch(Exception $e)
        {
            // データベースに障害が発生した場合、以下のプログラムが動く
            print 'ただいま障害により大変ご迷惑をおかけしております。';
            exit();
        }        
        ?>

        修正しました<br />
        <br />
        <a href="staff_list.php">戻る</a>

    </body>
    </html>