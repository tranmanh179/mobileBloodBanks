<?php include $urlLocal['urlLocalPlugin'] . 'bloodbanks/view/header.php'; ?>

<section role="main" class="content-body" id="fullscreen">
    <header class="page-header">
        <h2>Blood Donation</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="/"><i class="fa fa-home"></i></a>
                </li>
                <li><span>Blood Donation</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->
    <section class="panel">
        <ul class="title_p list-inline">
            <li><a href="/"><i class="fa fa-home"></i> Home</a></li>
            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
            <li>Blood Donation</li>
        </ul>
        
        <div class="panel-body">           
            <div class="row" style="margin-bottom: 1em;">
                <div class="col-sm-12">
                    <div class="mb-md">
                        <a href="<?php echo $urlHomes; ?>addBloodDonation" class="btn btn-primary btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Add new</a>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover mb-none" id="">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Fullname</th>
                                <th>Birthday</th>
                                <th>Identify card</th>
                                <th>Type blood</th>
                                <th>Blood count</th>
                                <th colspan="3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($listData)) {
                                foreach ($listData as $data) {
                                    echo '
                                    <tr class="gradeX">
                                        <td>'.$data['Donation']['dateBloodDonation'].'</td>
                                        <td>'.$data['Donation']['fullname'].'</td>
                                        <td>'.$data['Donation']['birthday'].'</td>
                                        <td>'.$data['Donation']['identifyCard'].'</td>
                                        <td>'.$data['Donation']['typeBlood'].'</td>
                                        <td>'.$data['Donation']['bloodCount'].'ml</td>
                                        
                                        <td class="actions" align="center">
                                            <a title="View" href="'.$urlHomes . 'viewBloodDonation?id=' . $data['Donation']['id'].'" class="on-default edit-row"><i class="fa fa-info" aria-hidden="true"></i></a>
                                        </td>
                                        <td class="actions" align="center">
                                            <a title="Edit" href="'.$urlHomes . 'addBloodDonation?id=' . $data['Donation']['id'].'" class="on-default edit-row"><i class="fa fa-edit"></i></a>
                                        </td>
                                        <td class="actions" align="center">
                                            <a title="Delete" href="'.$urlHomes . 'deleteBloodDonation?id=' . $data['Donation']['id'].'" class="on-default remove-row" onclick="return confirm(\'Do you want to delete?\');"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>';
                                }
                            } else {
                                echo '<tr>
                                <td align="center" colspan="15">No data.</td>
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