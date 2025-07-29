    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
    </head>
    <body>
    <?php 
    
        $gakuen = $_POST['gakuen'];

        switch($gakuen)
        {
            case '1':
                $kousha = 'あなたの校舎は南校舎です。';
                $bukatsu = '部活動にはスポーツ系と文化系があります。';
                $mokuhyou = 'まずは学校に慣れましょう。';
                break;

            case '2':
                $kousha = 'あなたの校舎は西校舎です。';
                $bukatsu = '学園祭を目指して全力で取り組みましょう。';
                $mokuhyou = '今しかできないことを見つけましょう。';
                break;
            
            case '3':
                $kousha = 'あなたの校舎は東校舎です。';
                $bukatsu = '受験や就職に忙しくなります。';
                $mokuhyou = '将来への道をつくろう。';
                break;
            
            default:
                $kousha = 'あなたの校舎は3年生と同じです。';
                $bukatsu = '部活動はありません。';
                $mokuhyou = '早く卒業しましょう。';
                break;
        }

        print '校舎：'.$kousha.'<br />';
        print '部活：'.$bukatsu.'<br />';
        print '目標：'.$mokuhyou.'<br />';
    ?>
    </body>
    </html>