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

            // 前画面からデータを受け取り、変数にコピー
            $post=sanitize($_POST);
            $pro_code=$post['code'];
            $pro_name=$post['name'];
            $pro_price=$post['price'];
            $pro_gazou_name_old=$post['gazou_name_old'];
            $pro_gazou_name=$_POST['gazou_name'];
            
            // 入力データに安全対策を施している（サニタイジング）
            $pro_code=htmlspecialchars($pro_code,ENT_QUOTES,'UTF-8');
            $pro_name=htmlspecialchars($pro_name,ENT_QUOTES,'UTF-8');
            $pro_price=htmlspecialchars($pro_price,ENT_QUOTES,'UTF-8');

            // データベース接続
            $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
            $user = 'root';
            $password = '';
            $dbh = new PDO($dsn, $user, $password);
            $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // データベースへの命令（レコードを更新）
            $sql = 'UPDATE mst_product SET name=?, price=?, gazou=? WHERE code =?';
            $stmt = $dbh -> prepare($sql);
            $data[] = $pro_name;
            $data[] = $pro_price;
            $data[] = $pro_gazou_name;
            $data[] = $pro_code;
            $stmt -> execute($data);

            // データベースから切断
            $dbh = null;

            // 選択された画像が同じである場合、画像に対する操作は何もしない
            if($pro_gazou_name_old != $pro_gazou_name)
            {
                // 新しい画像が選択された場合、古い画像を削除
                if($pro_gazou_name_old != '')
                {
                    unlink('./gazou/'.$pro_gazou_name_old);
                }
            }    

            // 修正した商品の表示
            print '修正しました。<br />';
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