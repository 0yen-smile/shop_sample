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

        // 前画面からデータを受け取り、変数にコピーし、サニタイジングを施している
        $post=sanitize($_POST);
        $staff_code=$post['code'];
        $staff_name=$post['name'];
        $staff_pass=$post['pass'];
        $staff_pass2=$post['pass2'];
       
        // 入力チェック（スタッフ名）
        if($staff_name=='')
        {
            print 'スタッフ名が入力されていません<br />';
        }
        else
        {
            print 'スタッフ名：';
            print $staff_name;
            print '<br />';
        }

        //入力チェック（パスワード）
        if($staff_pass=='')
        {
            print 'パスワードが入力されていません<br />';
        }

        if($staff_pass!=$staff_pass2)
        {
            print 'パスワードが一致しません<br />';
        }
        
        // 入力に問題があったときは、戻るボタンのみ表示
        if($staff_name==''||$staff_pass==''||$staff_pass!=$staff_pass2)
        {
            print '<form>';
            print '<input type="button" onclick="history.back()" value="戻る">';
            print '</form>';
        }
        // 入力に問題なければ、OKボタンを表示
        else
        {
            // MD5を用いてパスワード（$staff_pass）を暗号化
            $staff_pass=md5($staff_pass);
            print '<form method="post" action="staff_edit_done.php">';
            print '<input type="hidden" name="code" value="'.$staff_code.'">';
            print '<input type="hidden" name="name" value="'.$staff_name.'">';
            print '<input type="hidden" name="pass" value="'.$staff_pass.'">';
            print '<br />';
            print '<input type="button" onclick="history.back()" value="戻る">';
            print '<input type="submit" value="OK">';
            print '</form>';
        }
        ?>
    </body>
    </html>