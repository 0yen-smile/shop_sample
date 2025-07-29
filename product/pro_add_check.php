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
        // 前画面からデータを受け取り、変数にコピー
        $pro_name=$_POST['name'];
        $pro_price=$_POST['price'];
        $pro_gazou=$_FILES['gazou'];

        // 入力データに安全対策を施している（サニタイジング）
        $pro_name=htmlspecialchars($pro_name,ENT_QUOTES,'UTF-8');
        $pro_price=htmlspecialchars($pro_price,ENT_QUOTES,'UTF-8');
        
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

        // 入力チェック（価格）
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
            print '上記の商品を追加します。<br />';
            print '<form method="post" action="pro_add_done.php">';
            print '<input type="hidden" name="name" value="'.$pro_name.'">';
            print '<input type="hidden" name="price" value="'.$pro_price.'">';
            print '<input type="hidden" name="gazou_name" value="'.$pro_gazou['name'].'">';
            print '<br />';
            print '<input type="button" onclick="history.back()" value="戻る">';
            print '<input type="submit" value="OK">';
            print '</form>';
        }

        ?>
    </body>
    </html>