    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
    </head>
    <body>
        <?php 
        
        require_once('../common/common.php');

        $seireki=$_POST['seireki'];

        $wareki=gengo($seireki);
        print $wareki;
        
        ?>
    </body>
    </html>