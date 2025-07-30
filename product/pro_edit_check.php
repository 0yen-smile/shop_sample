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
        <title>確認画面</title>
    </head>
    <body>
        <?php
        //サニタイジング関数を呼び出し
        require_once('../common/common.php');

        // 前画面からデータを受け取り、変数にコピー
        $post=sanitize($_POST);
        $pro_code=$post['code'];
        $pro_name=$post['name'];
        $pro_price=$post['price'];
        $pro_gazou_name_old=$post['gazou_name_old'];
        $pro_gazou=$_FILES['gazou'];
        
        // 入力チェック（商品名）
        if($pro_name=='')
        {
            print '商品名が入力されていません<br />';
        }
        else
        {
            print '商品名：';
            print $pro_name;
            print '<br />';
        }

        //入力チェック（価格）
        if(preg_match('/\A[0-9]+\z/', $pro_price)==0)
        {
            print '価格が正しく入力されていません<br />';
        }
        else
        {
            print '価格：';
            print $pro_price;
            print '円<br />';
        }

        // 入力チェック（画像）
        if($pro_gazou['size'] > 0) //画像サイズが0より大きければ「画像あり」となる
        {
            if($pro_gazou['size'] > 1000000)
            {
                print '画像が大きすぎます';
            }
            else
            {
                move_uploaded_file($pro_gazou['tmp_name'],'./gazou/'.$pro_gazou['name']);
                print '<img src="./gazou/'.$pro_gazou['name'].'">';
                print '<br />';
            }
        }

        // 入力に問題があったときは、戻るボタンのみ表示
        if($pro_name==''||preg_match('/\A[0-9]+\z/', $pro_price)==0||$pro_gazou['size']>1000000)
        {
            print '<form>';
            print '<input type="button" onclick="history.back()" value="戻る">';
            print '</form>';
        }
        // 入力に問題なければ、OKボタンを表示
        else
        {
            print '上記のように変更します。<br />';
            print '<form method="post" action="pro_edit_done.php">';
            print '<input type="hidden" name="code" value="'.$pro_code.'">';
            print '<input type="hidden" name="name" value="'.$pro_name.'">';
            print '<input type="hidden" name="price" value="'.$pro_price.'">';
            
            print '<input type="hidden" name="gazou_name_old" value="'.$pro_gazou_name_old.'">';
            print '<input type="hidden" name="gazou_name" value="'.$pro_gazou['name'].'">';

            print '<br />';
            print '<input type="button" onclick="history.back()" value="戻る">';
            print '<input type="submit" value="OK">';
            print '</form>';
        }

        ?>
    </body>
    </html>