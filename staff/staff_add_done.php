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