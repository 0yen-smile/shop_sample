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
        <title>削除実行</title>
    </head>
    <body>
        <?php 
        
        try
        {
            $pro_code = $_POST['code'];
            $pro_gazou_name = $_POST['gazou_name'];

            // データベース接続
            $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
            $user = 'root';
            $password = '';
            $dbh = new PDO($dsn, $user, $password);
            $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // データベースへの命令（レコードを追加）
            $sql = 'DELETE FROM mst_product WHERE code=?';
            $stmt = $dbh -> prepare($sql);
            $data[] = $pro_code;
            $stmt -> execute($data);

            // データベースから切断
            $dbh = null;

            if($pro_gazou_name != '')
            {
                unlink('./gazou/'.$pro_gazou_name);
            }

        }
        catch(Exception $e)
        {
            // データベースに障害が発生した場合、以下のプログラムが動く
            print 'ただいま障害により大変ご迷惑をおかけしております。';
            exit();
        }        
        ?>

        削除しました<br />
        <br />
        <a href="pro_list.php">戻る</a>

    </body>
    </html>