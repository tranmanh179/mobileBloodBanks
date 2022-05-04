<?php include $urlLocal['urlLocalPlugin'] . 'bloodbanks/view/header.php'; ?>

<section role="main" class="content-body" id="fullscreen">
    <header class="page-header">
        <h2>Blood Store</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="/"><i class="fa fa-home"></i></a>
                </li>
                <li><span>Blood Store</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->
    <section class="panel">
        <ul class="title_p list-inline">
            <li><a href="/"><i class="fa fa-home"></i> Home</a></li>
            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
            <li>Blood Store</li>
        </ul>
        
        <div class="panel-body">           
            <div class="row" style="margin-bottom: 1em;">
                <script type="text/javascript">
                    $('#piechart').width()= $('#tableInfo').width();
                </script>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                  google.charts.load('current', {'packages':['corechart']});
                  google.charts.setOnLoadCallback(drawChart);

                  function drawChart() {

                    var data = google.visualization.arrayToDataTable([
                      ['Type of blood', 'Number'],
                      ['Blood type A+',  <?php echo @(int) $listData['A+'];?>],
                      ['Blood type A-',  <?php echo @(int) $listData['A-'];?>],
                      ['Blood type B+',  <?php echo @(int) $listData['B+'];?>],
                      ['Blood type B-',  <?php echo @(int) $listData['B-'];?>],
                      ['Blood type O+',  <?php echo @(int) $listData['O+'];?>],
                      ['Blood type O-',  <?php echo @(int) $listData['O-'];?>],
                      ['Blood type AB+', <?php echo @(int) $listData['AB+'];?>],
                      ['Blood type AB-', <?php echo @(int) $listData['AB-'];?>],
                    ]);

                    var options = {
                      title: 'The amount of blood in store'
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                    chart.draw(data, options);
                  }
                </script>

                <div id="piechart" class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6" style="height: 500px;"></div>
                <div id="tableInfo" class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover mb-none">
                            <thead>
                                <tr> 
                                    <th>Blood type</th>
                                    <th>Number (ml) </th>
                                </tr> 
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($listData)) {
                                    foreach ($listData as $key => $number) {
                                        echo '  <tr> 
                                                    <td class="break_word" align="center">'.$key.'</td> 
                                                    <td class="break_word">'.number_format($number).'</td> 
                                                </tr> ';
                                    }
                                } else {
                                    echo '<tr>
                                            <td align="center" colspan="13">Empty warehouse</td>
                                        </tr>';
                                }
                                ?>                 
                            </tbody>
                        </table> 
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end: page -->
</section>

<?php include $urlLocal['urlLocalPlugin'] . 'bloodbanks/view/footer.php'; ?>