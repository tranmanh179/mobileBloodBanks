<?php include $urlLocal['urlLocalPlugin'] . 'bloodbanks/view/header.php'; ?>

<section role="main" class="content-body" id="fullscreen">
    <header class="page-header">
        <h2>Request Blood List</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="/"><i class="fa fa-home"></i></a>
                </li>
                <li><span>Request Blood List</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->
    <section class="panel">
        <ul class="title_p list-inline">
            <li><a href="/"><i class="fa fa-home"></i> Home</a></li>
            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
            <li>Request Blood List</li>
        </ul>
        
        <div class="panel-body">     
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover mb-none" id="">
                        <thead>
                            <tr>
                                <th>Time request</th>
                                <th>Hospital send request</th>
                                <th>Hospital takes request</th>
                                <th>Type blood</th>
                                <th>Blood count</th>
                                <th>Status</th>
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($listData)) {
                                foreach ($listData as $data) {
                                    echo '
                                    <tr class="gradeX">
                                        <td>'.date('H:i d/m/Y', $data['Request']['time']).'</td>
                                        <td>'.$listHospital[$data['Request']['idHospitalTo']]['Hospital']['name'].'</td>
                                        <td>'.$listHospital[$data['Request']['idHospitalFrom']]['Hospital']['name'].'</td>
                                        <td>'.$data['Request']['typeBlood'].'</td>
                                        <td>'.$data['Request']['bloodCount'].'ml</td>
                                        <td>'.$data['Request']['status'].'</td>';

                                        if($data['Request']['status']=='new' && $data['Request']['idHospitalFrom']!=$_SESSION['infoManager']['Hospital']['id']){
                                            echo '  <td class="actions" align="center">
                                                        <a title="Agree" href="'.$urlHomes . 'updateRequestBlood?id=' . $data['Request']['id'].'&status=agree" class="on-default edit-row"><i class="fa fa-check" aria-hidden="true"></i></a>
                                                    </td>
                                                    <td class="actions" align="center">
                                                        <a title="Cancel" href="'.$urlHomes . 'updateRequestBlood?id=' . $data['Request']['id'].'&status=cancel" class="on-default edit-row"><i class="fa fa-ban" aria-hidden="true"></i></a>
                                                    </td>';
                                        }else{
                                            echo '<td colspan="2"></td>';
                                        }

                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr>
                                <td align="center" colspan="15">No request.</td>
                                </tr>';
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-sm-12" style="margin-top: 1em;">
                <?php
                if($totalPage>0){
                    if ($page > 5) {
                        $startPage = $page - 5;
                    } else {
                        $startPage = 1;
                    }
                    
                    if ($totalPage > $page + 5) {
                        $endPage = $page + 5;
                    } else {
                        $endPage = $totalPage;
                    }
                    
                    echo '<a href="' . $urlPage . $back . '">Previous</a> ';
                    for ($i = $startPage; $i <= $endPage; $i++) {
                        echo ' <a href="' . $urlPage. $i . '">' . $i . '</a> ';
                    }
                    echo ' <a href="' . $urlPage. $next . '">Next</a> ';
                    
                    // echo 'Tổng số trang: ' . $totalPage;
                    echo 'Page view '.$page.'/'.$totalPage;
                }
                ?>
            </div>
        </div>

        

        
    </section>
    <!-- end: page -->
</section>

<?php include $urlLocal['urlLocalPlugin'] . 'bloodbanks/view/footer.php'; ?>