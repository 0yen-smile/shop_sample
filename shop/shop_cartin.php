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
        <title>カートイン</title>
    </head>
    <body>
        <?php 
        try
        {
            $pro_code = $_GET['procode'];

            if(isset($_SESSION['cart'])==true)
            {
                $cart = $_SESSION['cart']; // 現在のカートの内容を$cartにコピー
                $kazu = $_SESSION['kazu']; // 現在のカート内の数量を$kazuにコピー
                if(in_array($pro_code,$cart)==true)
                {
                    print 'その商品はすでにカートに入っています。<br />';
                    print '<a href="shop_list.php">商品一覧に戻る</a>';
                    exit();
                }
            }
                $cart[] = $pro_code; // カートに商品を追加する
                $kazu[] = 1;
                $_SESSION['cart'] = $cart; // $_SESSIONにカートを保管する
                $_SESSION['kazu'] = $kazu;  // $_SESSIONに数量を保管する
        }
        catch(Exception $e)
        {
            // データベースに障害が発生した場合、以下のプログラムが動く
            print 'ただいま障害により大変ご迷惑をおかけしております。';
            print 'エラーが発生しました：' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
            exit();
        }
        
        ?>

        カートに追加しました<br />
        <br />
        <a href="shop_list.php">商品一覧に戻る</a>

        
    </body>
    </html>