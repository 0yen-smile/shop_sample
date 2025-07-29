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
        <title>商品一覧</title>
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
            print '<form method ="post" action = "pro_branch.php">';

            while(true)
            {
                // $stmtからレコードを１行抜き出し、$recへ格納
                $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                // 抜き出すレコードがなくなれば、ループを脱出
                if($rec == false)
                {
                    break;
                }
                print '<input type="radio" name="procode" value="'.$rec['code'].'">'; //p.83
                print $rec['name'];
                print '<br />';
            }
            print '<br />';
            print '<input type="submit" name="disp" value="参照">';
            print '<input type="submit" name="add" value="追加">';
            print '<input type="submit" name="edit" value="修正">';
            print '<input type="submit" name="delete" value="削除">';
            print '</form>';

        }
        catch(Exception $e)
        {
            // データベースに障害が発生した場合、以下のプログラムが動く
            print 'ただいま障害により大変ご迷惑をおかけしております。';
            exit();
        }
        
        ?>

        <br />
        <a href="../staff_login/staff_top.php">トップメニューへ</a><br />

    </body>
    </html>