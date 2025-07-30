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
            //サニタイジング関数を呼び出し
            require_once('../common/common.php');
            $post=sanitize($_POST);
            $staff_name = $post['name'];
            $staff_pass = $post['pass'];

            // データベース接続
            $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
            $user = 'root';
            $password = '';
            $dbh = new PDO($dsn, $user, $password);
            $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // データベースへの命令（レコードを追加）
            $sql = 'INSERT INTO mst_staff(name, password) VALUES(?, ?)';
            $stmt = $dbh -> prepare($sql);
            $data[] = $staff_name;
            $data[] = $staff_pass;
            $stmt -> execute($data);

            // データベースから切断
            $dbh = null;

            // 追加したスタッフの表示
            print $staff_name;
            print 'さんを追加しました。<br />';
        }
        catch(Exception $e)
        {
            // データベースに障害が発生した場合、以下のプログラムが動く
            print 'ただいま障害により大変ご迷惑をおかけしております。';
            exit();
        }        
        ?>

        <a href="staff_list.php">戻る</a>

    </body>
    </html>