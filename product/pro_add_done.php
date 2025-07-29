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
            $pro_name=$_POST['name'];
            $pro_price=$_POST['price'];
            $pro_gazou_name=$_POST['gazou_name'];
            
            // 入力データに安全対策を施している（サニタイジング）
            $pro_name=htmlspecialchars($pro_name,ENT_QUOTES,'UTF-8');
            $pro_price=htmlspecialchars($pro_price,ENT_QUOTES,'UTF-8');

            // データベース接続
            $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
            $user = 'root';
            $password = '';
            $dbh = new PDO($dsn, $user, $password);
            $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // データベースへの命令（レコードを追加）
            $sql = 'INSERT INTO mst_product(name, price, gazou) VALUES(?, ?, ?)';
            $stmt = $dbh -> prepare($sql);
            $data[] = $pro_name;
            $data[] = $pro_price;
            $data[] = $pro_gazou_name;
            $stmt -> execute($data);

            // データベースから切断
            $dbh = null;

            // 追加した商品の表示
            print $pro_name;
            print 'を追加しました。<br />';
        }
        catch(Exception $e)
        {
            // データベースに障害が発生した場合、以下のプログラムが動く
            print 'ただいま障害により大変ご迷惑をおかけしております。<br />';
            print 'エラーが発生しました：' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
            exit();
        }        
        ?>

        <a href="pro_list.php">戻る</a>

    </body>
    </html>