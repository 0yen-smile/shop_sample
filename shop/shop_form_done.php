<?php 
    session_start();
    session_regenerate_id(true);
?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <title>Document</title>
</head>
<body>

<?php 

try
{
    require_once('../common/common.php');

    $post = sanitize($_POST);

    // 受け取ったデータを各変数に格納
    $onamae = $post['onamae'];
    $email = $post['email'];
    $postal1 = $post['postal1'];
    $postal2 = $post['postal2'];
    $address = $post['address'];
    $tel = $post['tel'];

    print $onamae.'様<br />';
    print 'ご注文ありがとうございました。<br />';
    print $email.'宛にメールをお送りしましたのでご確認ください。<br />';
    print '商品は以下の住所に発送させていただきます。<br />';
    print $postal1.'-'.$postal2.'<br />';
    print $address.'<br />';
    print $tel.'<br />';

    // 注文受付メールの作成
    $honbun = '';
    $honbun.= $onamae."様\n\nこの度はご注文ありがとうございました。\n";
    $honbun.= "\n";
    $honbun.= "ご注文商品\n";
    $honbun.= "----------------------------------------\n";

    $cart = $_SESSION['cart'];
    $kazu = $_SESSION['kazu'];
    $max = count($cart);

    // DBへの接続
    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    for($i =0; $i<$max; $i++){
        // DBへの命令
        $sql = 'SELECT name, price, gazou FROM mst_product WHERE code = ?';
        $stmt = $dbh->prepare($sql);
        $data[0] = $cart[$i];
        $stmt -> execute($data);

        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        $name = $rec['name'];
        $price = $rec['price'];
        $suryo = $kazu[$i];
        $shokei = $price * $suryo;

        $honbun.= $name.' ';
        $honbun.= $price.'円 × ';
        $honbun.= $suryo.'個 = ';
        $honbun.= $shokei."円\n";
    }

    // DBから切断
    $dbh = null;

    $honbun.= "送料は無料です。\n";
    $honbun.= "-----------------------------\n";
    $honbun.= "\n";
    $honbun.= "代金は以下の口座にお振り込みください。\n";
    $honbun.= "ロクまる銀行 やさい視点 普通口座 1234567\n";
    $honbun.= "\n";
    $honbun.= "□□□□□□□□□□□□□□□□□□□□□\n";
    $honbun.= "〜あんしん野菜のろくまる農園〜\n";
    $honbun.= "\n";
    $honbun.= "○○県六丸群六丸村123-4\n";
    $honbun.= "電話 090-6060-XXXX\n";
    $honbun.= "メール info@rokumarunouen.co.jp\n";
    $honbun.= "□□□□□□□□□□□□□□□□□□□□□\n";

    // test用
    // print '<br />';
    // print nl2br($honbun);

    // 顧客へメール送付
    $title = 'ご注文ありがとうございます。';
    $header = 'From: info@rokumarunouen.co.jp';
    $honun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
    mb_language('Japanese');
    mb_internal_encoding('UTF-8');
    mb_send_mail($email, $title, $honbun, $header);

    // 店舗にもメール送付
    $title = 'お客様から注文がありました。';
    $header = 'From: '.$email;
    $honun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
    mb_language('Japanese');
    mb_internal_encoding('UTF-8');
    mb_send_mail('info@rokumarunouen.co.jp', $title, $honbun, $header);

}
catch(Exception $e)
{
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    print 'エラーが発生しました：' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    exit();
}

?>


</body>
</html>

<?php 

/*
画面の仕様
１：画面に注文を受け付けた旨を表示する
２：お客様にお礼のメールを自動送信する
３：お店側には「注文あり」のメールを自動送信する
４：DBに注文データを保存する
*/

?>