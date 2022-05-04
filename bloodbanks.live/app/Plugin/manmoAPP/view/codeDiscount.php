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

        <title>Danh sách mã khuyến mại</title>

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
                if(!empty($listData)){
                    foreach($listData as $item){
                        echo '  <div class="row">
                                    <div class="coupon col-12">
                                        <img src="'.$item['Event']['image'].'" alt="" style="width: 100%;">
                                        <div class="containerA" style="background-color:white">
                                            <h2><b>'.$item['Event']['title'].'</b></h2>
                                            '.$item['Event']['content'].'
                                        </div>
                                        <div class="containerA">
                                            <p>Mã giảm giá: <span class="promo">'.$item['Event']['code'].'</span> <i class="fa fa-clone" aria-hidden="true" onclick="copyToClipboard(\''.$item['Event']['code'].'\')"></i> <span style="color:red;" id="mess'.$item['Event']['code'].'"></span></p>
                                            <p class="expire">Áp dụng từ '.$item['Event']['dateStart']['text'].' đến '.$item['Event']['dateEnd']['text'].'</p>
                                        </div>
                                    </div> 
                                </div>';
                    }
                }else{
                    echo '<center><b>Hiện tại không có mã khuyến mại nào khả dụng.</b></center>';
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

    <script type="text/javascript">
        function copyToClipboard(textCopy) {
            // Create a "hidden" input
            var aux = document.createElement("input");

            // Assign it the value of the specified element
            aux.setAttribute("value", textCopy);

            // Append it to the body
            document.body.appendChild(aux);

            // Highlight its content
            aux.select();

            // Copy the highlighted text
            document.execCommand("copy");

            // Remove it from the body
            document.body.removeChild(aux);

            // show mess
            $('#mess'+textCopy).html('Đã sao chép');
            setTimeout(function(){ $('#mess'+textCopy).html(''); }, 3000);
        }
    </script>
</html>