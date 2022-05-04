<?php include $urlLocal['urlLocalPlugin'] . 'bloodbanks/view/header.php'; ?>

<section role="main" class="content-body" id="fullscreen">
    <header class="page-header">
        <h2>View Blood Donation</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="/"><i class="fa fa-home"></i></a>
                </li>
                <li><span>View Blood Donation</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->
    <section class="panel">
        <ul class="title_p list-inline">
            <li><a href="/"><i class="fa fa-home"></i> Home</a></li>
            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
            <li>View Blood Donation</li>
        </ul>
        
        <div class="panel-body">           
            <div class="col-sm-6">
                <img class="img-responsive" src="<?php echo $data['Donation']['image'];?>" />
            </div>
            <div class="col-sm-6">
                <p><b>Date blood donation</b>: <?php echo $data['Donation']['dateBloodDonation'];?></p>
                <p><b>Fullname</b>: <?php echo $data['Donation']['fullname'];?></p>
                <p><b>Birthday</b>: <?php echo $data['Donation']['birthday'];?></p>
                <p><b>Identify card</b>: <?php echo $data['Donation']['identifyCard'];?></p>
                <p><b>Address</b>: <?php echo $data['Donation']['address'];?></p>
                <p><b>Type blood</b>: <?php echo $data['Donation']['typeBlood'];?></p>
                <p><b>Blood count</b>: <?php echo $data['Donation']['bloodCount'];?>ml</p>
                <p><b>Blood donation event</b>: <?php echo $data['Donation']['nameSchedule'];?></p>
            </div>
            
        </div>
    </section>
    <!-- end: page -->
</section>

<?php include $urlLocal['urlLocalPlugin'] . 'bloodbanks/view/footer.php'; ?>