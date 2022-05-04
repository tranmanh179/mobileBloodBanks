<!doctype html>
<html lang="en">
    <head>
        <meta name="robots" content="noindex">
        <meta name="googlebot" content="noindex">
        <meta name="googlebot-news" content="noindex" />
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="https://manmo.vn/app/Theme/ver2/images/icon.png">

        <title>Mini Game ManMo</title>

        <link rel="canonical" href="<?php echo $urlNow;?>">

        <script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
        
        <!-- Bootstrap core -->
        <link rel="stylesheet" href="https://manmo.vn/app/Theme/ver3/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/d63f9908a8.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <main class="container">
            <?php
                $listData= array();
                $listData[]= array( 'title'=>'Cờ caro',
                                    'image'=>'https://sharecode.vn/FilesUpload/Code/source-code-game-caro-bang-html5-va-jquery-173820.jpg',
                                    'content'=>'Khi tới lượt: người chơi phải tick vào một ô trên bàn cờ. Tick đủ 5 ô theo chiều dọc, chiều ngang hoặc đường chéo mà không bị chặn 2 đầu thì sẽ thắng.',
                                    'link'=>'https://manmo.vn/app/Plugin/manmoAPP/view/minigame/caro/index.html'
                            );
                if(!empty($listData)){
                    foreach($listData as $item){
                        echo '  <a href="'.$item['link'].'">
                                    <div class="row coupon">
                                        <div class="col-6 col-xs-6 col-sm-6 col-md-6">
                                            <img src="'.$item['image'].'" alt="" class="img-fluid">
                                        </div> 
                                        <div class="containerA col-6 col-xs-6 col-sm-6 col-md-6" style="background-color:white">
                                            <p style="font-size: 20px;"><b>'.$item['title'].'</b></p>
                                            '.$item['content'].'
                                        </div>
                                    </div>
                                </a>';
                    }
                }else{
                    echo '<center><b>Hiện tại không có trò chơi nào.</b></center>';
                }
            ?>
        </main>
    </body>

    <style type="text/css">
        .coupon {
          border: 5px dotted #bbb; /* Dotted border */
          border-radius: 15px; /* Rounded border */
          margin: 0 auto; /* Center the coupon */
          margin-bottom: 10px;
        }

        .containerA {
          padding: 10px 15px;
          background-color: #f1f1f1;
        }

        .promo {
          background: #ccc;
          padding: 3px;
        }

        .expire {
          color: red;
        }
    </style>

    
</html>