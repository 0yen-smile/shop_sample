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
        <title>商品削除</title>
    </head>
    <body>
        <?php 
        try
        {
            $pro_code = $_GET['procode'];

            // DBへの接続
            $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
            $user = 'root';
            $password = '';
            $dbh = new PDO($dsn, $user, $password);
            $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // DBへの命令
            $sql = 'SELECT name, gazou FROM mst_product WHERE code = ?';
            $stmt = $dbh->prepare($sql);
            $data[] = $pro_code;
            $stmt -> execute($data);

            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            $pro_neme = $rec['name'];
            $pro_gazou_name = $rec['gazou'];

            // DBから切断
            $dbh = null;

             // もし画像ファイルがあれば画像表示のタグを準備(画像なしの場合×が表示されないようにする)
            if($pro_gazou_name == '')
            {
                $disp_gazou = '';
            }
            else
            {
                $disp_gazou = '<img src="./gazou/'.$pro_gazou_name.'">';
            }
        }
        catch(Exception $e)
        {
            // データベースに障害が発生した場合、以下のプログラムが動く
            print 'ただいま障害により大変ご迷惑をおかけしております。';
            exit();
        }
        
        ?>

        商品削除<br />
        <br />
        商品コード<br />
        <?php print $pro_code;?>
        <br />
        商品名<br />
        <?php print $pro_neme;?>
        <br />
        <?php print $disp_gazou;?>
        <br />
        この商品を削除してよろしいですか？<br />
        <br />
        <form method ="post" action="pro_delete_done.php">
            <input type ="hidden" name="code" value="<?php print $pro_code; ?>">
            <input type ="hidden" name="gazou_name" value="<?php print $pro_gazou_name; ?>">
            <input type ="button" onclick="history.back()" value="戻る">
            <input type="submit" value="OK">
        </form>
        
    </body>
    </html>