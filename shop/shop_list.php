<?php

session_start();
session_regenerate_id(true);
if(isset($_SESSION['member_login']) == false)
{
    print 'ようこそゲスト様';
    print '<a href="member_login.html">会員ログイン</a> <br />';
    print '<br />';
}
else
{
    print 'ようこそ';
    print $_SESSION['member_name'];
    print '様';
    print '<a href="member_logout.php">ログアウト</a><br />';
    print '<br />';
}

?>

<!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>商品一覧（ユーザー向け）</title>
    </head>
    <body>
        <?php 
        try
        {
            // データベース接続
            $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
            $user = 'root';
            $password = '';
            $dbh = new PDO($dsn, $user, $password);
            $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // データベースへの命令（テーブル情報を全て$stmtへ格納）
            $sql = 'SELECT code, name, price FROM mst_product WHERE 1';
            $stmt = $dbh->prepare($sql);
            $stmt -> execute();

            //データベースから切断
            $dbh = null;

            print '商品一覧<br /><br />';

            while(true)
            {
                // $stmtからレコードを１行抜き出し、$recへ格納
                $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                // 抜き出すレコードがなくなれば、ループを脱出
                if($rec == false)
                {
                    break;
                }
                print '<a href="shop_product.php?procode='.$rec['code'].'">';
                print $rec['name'].'---';
                print $rec['price'].'円';
                print '</a>';
                print '<br />';
            }

            print '<br />';
            print '<a href="shop_cartlook.php">カートを見る</a><br />';
        }
        catch(Exception $e)
        {
            // データベースに障害が発生した場合、以下のプログラムが動く
            print 'ただいま障害により大変ご迷惑をおかけしております。';
            exit();
        }
        
        ?>

    </body>
    </html>